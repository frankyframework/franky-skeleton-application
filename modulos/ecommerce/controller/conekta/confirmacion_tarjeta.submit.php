<?php
use \Ecommerce\model\producto_pedidoModel;
use \Ecommerce\model\carrito;
use \Ecommerce\model\pedidos as pedidos_model;
use \Ecommerce\entity\pedidos;
use \Ecommerce\entity\producto_pedido;
use Ecommerce\entity\direcciones_facturacion as DireccionesFacturacionEntity;
use Ecommerce\model\direcciones_facturacion;
use Ecommerce\entity\direcciones as DireccionesEnvioEntity;
use Ecommerce\model\direcciones;
use Franky\Core\validaciones;
use Ecommerce\model\CardsModel;
use Ecommerce\entity\CardsEntity;
use Franky\Core\ObserverManager;

$CardsModel        = new CardsModel();
$CardsEntity       = new CardsEntity();

$id_tarjeta = $MyRequest->getRequest('id_tarjeta');
$error = false;
if($MySession->GetVar('tarjeta_conekta') == "" )
{
  $error = true;
}
$MySession->UnsetVar('tarjeta_conekta');

if(empty($id_tarjeta))
{



  $validaciones =  new validaciones();
  $valid = $validaciones->validRules($CardsEntity->setValidation());
  if(!$valid)
  {
      $MyFlashMessage->setMsg("error",$validaciones->getMsg());
      $error = true;
  }


  if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_TARJETAS_ECOMMERCE))
  {
      $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
      $error = true;
  }




  if(!$error)
  {



   $data = $MyRequest->getRequest("card");

    $CardsEntity->uid($MySession->GetVar('id'));
    $CardsEntity->status(1);

    $CardsEntity->numero(substr($data["number"],-4));

    if($CardsModel->getData($CardsEntity->getArrayCopy())!= REGISTRO_SUCCESS)
    {


      $source = addCardConekta($MyRequest->getRequest("token"),$MySession->GetVar('id'));


      $CardsEntity->nombre($data["name"]);
      $CardsEntity->fecha(date('Y-m-d H:i:s'));
      $CardsEntity->token($source['id']);
      $id_tarjeta = $source['id'];

      $result = $CardsModel->save($CardsEntity->getArrayCopy());

      if($result == REGISTRO_SUCCESS)
      {


      }
      elseif($result == REGISTRO_ERROR)
      {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
        $error = true;
      }
      else
      {
          $error = true;
      }
    }
    else{
      $registro = $CardsModel->getRows();
       $id_tarjeta = $registro["token"];
    }
  }

}
else
{
    $CardsEntity->id($id_tarjeta);
    $CardsEntity->status(1);
    $CardsEntity->uid($MySession->GetVar('id'));
    $CardsModel->getData($CardsEntity->getArrayCopy());
    $registro = $CardsModel->getRows();
    $id_tarjeta = $registro["token"];
}
if(!$error)
{
  $productos =  OBJETO_PRODUCTOS;
  $MyProducto =  new $productos();

  $MyCarritoCompras =  new carrito();
  $MyPedido = new pedidos_model();
  $MyPedidoEntity = new pedidos();
  $MyPedidoProducto = new producto_pedidoModel();
  $MyPedidoProductoEntity = new producto_pedido();

  $productos_comprados = getCarrito();
  $items = array();


  if(empty($productos_comprados)){
         $error = true;
  }

  foreach($productos_comprados['productos'] as $producto)
  {
      $items[] = array("name" => $producto["nombre"],"unit_price" => $producto["precio"]*100,"quantity" => $producto["qty"]);
  }
}

/*Aqui conecta*/

if(!$error)
{
    try{
          $order = \Conekta\Order::create(
          array(
            "line_items" => $items,
            "currency" => "MXN",
            "customer_info" => array(
                    "customer_id" => getCustomerConekta($MySession->GetVar('id'))
            ),
            "charges" => array(
                array(
                    "payment_method" => array(
                             "type" => "card",
                              "payment_source_id" => $id_tarjeta
                    )
                )
            )
          )
        );

    } catch (\Conekta\ErrorList $e) {
        $MyFlashMessage->setMsg("error",$e->getMessage());
        $MyRequest->redirect($MyRequest->getReferer());

    }
    catch (\Conekta\ParameterValidationError $e) {
        $MyFlashMessage->setMsg("error",$e->getMessage());
        $MyRequest->redirect($MyRequest->getReferer());

    }

    $referencia = json_encode(['id' => $order->id]);
    $status_pago = normalizeStatusTransaccion($order->payment_status);

       $MySession->SetVar('status_pago',$status_pago);
    $data = $MySession->GetVar('checkout');

    if(isset($data["id_facturacion"]))
    {
        if(is_numeric($data["id_facturacion"]))
        {
            $id_direccion_facturacion = $data["id_facturacion"];
        }
    }
    else {
        if(isset($data["direccion_facturacion"]))
        {
            $direcciones_facturacion = new direcciones_facturacion();
            $DireccionesFacturacionEntity = new DireccionesFacturacionEntity($data["direccion_facturacion"]);
            $DireccionesFacturacionEntity->setUid($MySession->GetVar('id'));
            $DireccionesFacturacionEntity->setFecha(date('Y-m-d H:i:s'));
            $DireccionesFacturacionEntity->setStatus(1);
            $direcciones_facturacion->save($DireccionesFacturacionEntity->getArrayCopy());
            $id_direccion_facturacion = $direcciones_facturacion->getUltimoID();

        }
    }

    if(isset($data["id_envio"]))
    {
        $direccion_envio = $data["id_envio"];

    }
    else {
        if(isset($data["direccion_envio"]))
        {
            $direcciones_envio = new direcciones();
            $DireccionesEnvioEntity= new DireccionesEnvioEntity($data["direccion_envio"]);
            $DireccionesEnvioEntity->setUid($MySession->GetVar('id'));
            $DireccionesEnvioEntity->setFecha(date('Y-m-d H:i:s'));
            $DireccionesEnvioEntity->setStatus(1);
            $direcciones_envio->save($DireccionesEnvioEntity->getArrayCopy());
            $direccion_envio = $direcciones_envio->getUltimoID();
        }
    }
    $MySession->SetVar('checkout',array());
    $MyPedidoEntity->setId_direccion_envio($direccion_envio);
    $MyPedidoEntity->setId_direccion_facturacion($id_direccion_facturacion);
    $MyPedidoEntity->setFecha(date('Y-m-d H:i:s'));
    $MyPedidoEntity->setUid($MySession->GetVar('id'));
    $MyPedidoEntity->setStatus($status_pago);
    $MyPedidoEntity->setMetodo_pago("conekta_tarjeta");
    $MyPedidoEntity->setMetodo_envio(0);
    $MyPedidoEntity->setMonto_compra($productos_comprados['gran_total']);
    $MyPedidoEntity->setMonto_pagado($productos_comprados['gran_total']);
    $MyPedidoEntity->setSubtotal($productos_comprados['subtotal']);
    $MyPedidoEntity->setIva($productos_comprados['iva_total']);
    $MyPedidoEntity->setMonto_envio(0);
    $MyPedidoEntity->setReferencia($referencia);

    if($MyPedido->save($MyPedidoEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
        $pedido = $MyPedido->getUltimoID();

        foreach($productos_comprados['productos'] as $producto)
        {
            $MyPedidoProductoEntity->setCaracteristicas($producto["caracteristicas"]);
            $MyPedidoProductoEntity->setId_pedido($pedido);
            $MyPedidoProductoEntity->setId_producto($producto["id"]);
            $MyPedidoProductoEntity->setQty($producto["qty"]);
            $MyPedidoProductoEntity->setPrecio($producto["precio"]);

            $MyPedidoProducto->save($MyPedidoProductoEntity->getArrayCopy());
        }


        $productos_html = render(PROJECT_DIR.'/modulos/ecommerce/diseno/email/productos.phtml',['items' =>$productos_comprados['productos']]);


        $campos = array("orden" => $pedido,"nombre" =>$MySession->GetVar('nombre'),"email" =>$MySession->GetVar('email'),'productos' =>$productos_html,'subtotal' => getFormatoPrecio($productos_comprados['subtotal']),
        'iva' => getFormatoPrecio($productos_comprados['iva_total']),
       'gran_total' => getFormatoPrecio($productos_comprados['gran_total']),'metodo_pago' =>'Pago con tarjeta','status' => getStatusTransaccion($status_pago));


        $TemplateemailModel    = new \Base\model\TemplateemailModel;
        $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
        $SecciontransaccionalEntity->frinedly('nueva-orden-de-compra');
        $TemplateemailModel->setOrdensql('id DESC');
        $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

        $registro  = $TemplateemailModel->getRows();

        sendEmail($campos,$registro);

         $ObserverManager = new ObserverManager;

        $ObserverManager->dispatch('finalizar_orden_ecommerce',[$pedido]);

    }
    else {
        // hubo un error al guardar.
    }

    $MyCarritoCompras->delete(getMyIdCarrito());
}

if($error)
{
  $MyRequest->redirect($MyRequest->getReferer());
}
$MyRequest->redirect($MyRequest->url(CONFIRMACION_CONEKTA_TARJETA));
?>
