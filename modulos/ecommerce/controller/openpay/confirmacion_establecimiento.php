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
use vendor\core\ObserverManager;


if($MySession->GetVar('establecimiento_pay') == "" ||  $MyRequest->getRequest('establecimiento_pay') == "")
{
    $MyRequest->redirect();
}

if($MySession->GetVar('establecimiento_pay') != $MyRequest->getRequest('establecimiento_pay'))
{
    $MyRequest->redirect();
}

$MySession->UnsetVar('establecimiento_pay');

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
         $MyRequest->redirect();
}

foreach($productos_comprados['productos'] as $producto)
{
    $items[] = array("name" => $producto["nombre"],"unit_price" => $producto["precio"]*100,"quantity" => $producto["qty"]);
}

/*Aqui openpay*/


try{
$order_id = md5(time().$MySession->GetVar('id'));
$openpay = Openpay::getInstance((getCoreConfig('ecommerce/openpay/sandbox') == 1 ? getCoreConfig('ecommerce/openpay/idsandbox') :  getCoreConfig('ecommerce/openpay/id')),
 (getCoreConfig('ecommerce/openpay/sandbox') == 1 ? getCoreConfig('ecommerce/openpay/secretsandbox') :  getCoreConfig('ecommerce/openpay/secret')));

Openpay::setProductionMode((getCoreConfig('ecommerce/openpay/sandbox') == 1 ? false : true));

 $customer = $openpay->customers->get(getCustomerOpenpay($MySession->GetVar('id')));

 $limit = explode(" ",date('Y-m-d H:i:s', strtotime("+3 days")));
    $order = $customer->charges->create(
      array(
        'method' => 'store',
         'amount' => $productos_comprados['gran_total'],
         'currency' => 'MXN',
         'description' => 'Cargo a establecimiento',
         'order_id' => $order_id,
         'due_date' => $limit[0].'T'.$limit[1],
      )
    );


} catch (\OpenpayApiError $e) {
  $MyFlashMessage->setMsg("error",$e->getMessage());
  $MyRequest->redirect($MyRequest->getReferer());

}
$referencia =
        ['id' => $order->id,
        'status' => $order->status,
        'order_id' => $order->order_id,
        'amount' => $order->amount,
        'due_date' => $limit[0].' '.$limit[1],
        'payment_method' => [
          'reference' => $order->payment_method->reference,
          'barcode_url' => $order->payment_method->barcode_url,

        ]
        ];
$status_pago = normalizeStatusTransaccion($order->status);
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
$MyPedidoEntity->setMetodo_pago("openpay_establecimiento");
$MyPedidoEntity->setMetodo_envio(0);
$MyPedidoEntity->setMonto_compra($productos_comprados['gran_total']);
$MyPedidoEntity->setSubtotal($productos_comprados['subtotal']);
$MyPedidoEntity->setIva($productos_comprados['iva_total']);
$MyPedidoEntity->setMonto_pagado(0);
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
   'gran_total' => getFormatoPrecio($productos_comprados['gran_total']),'metodo_pago' =>'Pago en Establecimiento','status' => getStatusTransaccion($status_pago),'referencia' => $referencia);

    $campos['ticket_establecimiento'] = render(PROJECT_DIR.'/modulos/ecommerce/diseno/email/ticket_establecimiento.phtml',
            [ 'due_date' => $limit[0].' '.$limit[1],'productos_comprados' =>$productos_comprados,'referencia' => $referencia,'MyRequest' => $MyRequest,'MySession' => $MySession]);

    $TemplateemailModel    = new \modulos\base\vendor\model\TemplateemailModel;
    $SecciontransaccionalEntity    = new \modulos\base\vendor\entity\SecciontransaccionalEntity;
    $SecciontransaccionalEntity->frinedly('nueva-orden-de-compra-establecimiento-openpay');
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


$MyMetatag->setTitulo(_ecommerce("Confirmacion de pedido establecimiento"));
$MyMetatag->setDescripcion(_ecommerce("Confirmacion de pedido establecimiento"));
$MyMetatag->setkeywords("");

?>
