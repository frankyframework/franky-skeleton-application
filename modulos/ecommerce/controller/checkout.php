<?php
use Ecommerce\Form\checkoutForm;
use Ecommerce\Form\pickupForm;
use Ecommerce\Form\direccionesForm;
use Ecommerce\Form\conektaForm;
use Ecommerce\Form\openpayForm;

$productos =  OBJETO_PRODUCTOS;
$MyProducto =  new $productos();

$productos_comprados = getCarrito();
if(empty($productos_comprados['productos']))
{
    $MyRequest->redirect($MyRequest->url(CARRITO_COMPRAS));
}


$direcciones_facturacion = makeHTMLDireccion("facturacion",$MySession->GetVar("id"));
$direcciones_facturacion["no_requiere"] = "No requiere factura";
$direcciones_facturacion["otra"] = "Nueva direccion";
$DireccionCheckoutForm = new checkoutForm("frm_direccion");
$DireccionCheckoutForm->addDirecionFacturacion($direcciones_facturacion);
$DireccionCheckoutForm->setAtributoInput("id_facturacion", "value", "no_requiere");
$DireccionCheckoutForm->addSubmit();

$direcciones_envio = [];
if(getCoreConfig('ecommerce/pick-up/enabled') == 1)
{
    $direcciones_envio["pick-up"] = getCoreConfig('ecommerce/pick-up/titulo');
    $pickupForm = new pickupForm("frmpickup");
    $pickuppoints = getPickUpPoints();
    $pickupForm->addPickuppoints($pickuppoints);
    $pickupForm->addSubmit();
}

$_direcciones_envio = makeHTMLDireccion("envio",$MySession->GetVar("id"));
$direcciones_envio = array_merge($direcciones_envio,$_direcciones_envio);
if(!empty($direcciones_envio))
{
  $direcciones_envio["otra"] = 'Nueva dirección';
  $DireccionEnvioCheckoutForm = new checkoutForm("frm_direccion_envio");
  $DireccionEnvioCheckoutForm->addDirecionEnvio($direcciones_envio);
  $DireccionEnvioCheckoutForm->addSubmit();

}


$direccionesForm = new direccionesForm("frmdirecciones");
$direccionesForm->addOtroTelefono();
$direccionesForm->addEntrecalles();
$direccionesForm->addInstrucciones();
$direccionesForm->addSubmit();

$direccionesFacturacionForm = new direccionesForm("frmdirecciones_facturacion");
$direccionesFacturacionForm->addRFC();
$direccionesFacturacionForm->addSubmit();
$MySession->UnsetVar('checkout');
$cupon = $MySession->GetVar('cupon_checkout');
if($cupon != false)
{
    $valida_cupo = validaCuponEcommerce($cupon['cupon']);
    if($valida_cupo['error'] == true){
        $MySession->UnsetVar('cupon_checkout');
    }
}
?>
