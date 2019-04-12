<?php
use \modulos\ecommerce\vendor\model\producto_pedidoModel;
use \modulos\ecommerce\vendor\model\carrito;
use \modulos\ecommerce\vendor\model\pedidos as pedidos_model;
use \modulos\ecommerce\vendor\entity\pedidos;
use \modulos\ecommerce\vendor\entity\producto_pedido;
use modulos\ecommerce\vendor\entity\direcciones_facturacion as DireccionesFacturacionEntity;
use modulos\ecommerce\vendor\model\direcciones_facturacion;
use modulos\ecommerce\vendor\entity\direcciones as DireccionesEnvioEntity;
use modulos\ecommerce\vendor\model\direcciones;
use Franky\Core\ObserverManager;


$productos =  OBJETO_PRODUCTOS;
$MyProducto =  new $productos();

$paymentID = $MyRequest->getRequest('paymentID');
$payerID = $MyRequest->getRequest('payerID');
$token = $MyRequest->getRequest('token');

$referencia = array("paymentID" => $paymentID,"payerID" =>$payerID,"token" => $token);

$MyCarritoCompras =  new carrito();
$MyPedido = new pedidos_model();
$MyPedidoEntity = new pedidos();
$MyPedidoProducto = new producto_pedidoModel();
$MyPedidoProductoEntity = new producto_pedido();


if(!empty($paymentID) && !empty($payerID) && !empty($token))
{
    $productos_comprados = getCarrito();
}

$paypalCheck=paypalCheck($paymentID);

$status_pago = normalizeStatusTransaccion($paypalCheck->state);
$total = $paypalCheck->transactions[0]->amount->total;
$currency = $paypalCheck->transactions[0]->amount->currency;
//$subtotal = $paypalCheck->transactions[0]->amount->details->subtotal;
$recipient_name = $paypalCheck->transactions[0]->item_list->shipping_address->recipient_name;


if($status_pago == "pending" || $status_pago == "paid")
{

    if($MyPedido->getData("",$MySession->GetVar('id'),"","",json_encode($referencia)) == REGISTRO_SUCCESS)
    {
        $registro = $MyPedido->getRows();
        $MyPedidoEntity->setId($registro["id"]);
        $MyPedidoEntity->setStatus($status_pago);
        $MyPedido->save($MyPedidoEntity->getArrayCopy());
    }
    else
    {

        if(!empty($productos_comprados['productos']))
        {

            if($status_pago == "paid")
            {
                $status_pago = ($productos_comprados['gran_total'] > $total ? "pago_incompleto" : $status_pago);
            }

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
            $MyPedidoEntity->setMetodo_pago("paypal");
            $MyPedidoEntity->setMetodo_envio(0);
            $MyPedidoEntity->setMonto_compra($productos_comprados['gran_total']);
            $MyPedidoEntity->setSubtotal($productos_comprados['subtotal']);
            $MyPedidoEntity->setIva($productos_comprados['iva_total']);
            $MyPedidoEntity->setMonto_pagado($total);
            $MyPedidoEntity->setMonto_envio(0);
            $MyPedidoEntity->setReferencia(json_encode($referencia));

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
                 'gran_total' => getFormatoPrecio($productos_comprados['gran_total']),'metodo_pago' =>'PayPal','status' => getStatusTransaccion($status_pago));


                $TemplateemailModel    = new \modulos\base\vendor\model\TemplateemailModel;
                $SecciontransaccionalEntity    = new \modulos\base\vendor\entity\SecciontransaccionalEntity;
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
        else{
             $MyRequest->redirect();
        }
    }
    $MyMetatag->setTitulo("Confirmacion de pedido paypal");
    $MyMetatag->setDescripcion("Confirmacion de pedido paypal");
    $MyMetatag->setkeywords("");

}

?>
