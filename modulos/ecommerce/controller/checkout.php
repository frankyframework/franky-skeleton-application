<?php
use Ecommerce\Form\checkoutForm;
use Ecommerce\Form\direccionesForm;
use Ecommerce\Form\conektaForm;
use Ecommerce\Form\openpayForm;


$productos_comprados = getCarrito();
if(empty($productos_comprados['productos']))
{
    $MyRequest->redirect($MyRequest->url(CARRITO_COMPRAS));
}


if($productos_comprados['gran_total'] > 0)
{
    if(getCoreConfig('ecommerce/paypal/enabled') == 1)
    {
        $MyMetatag->setCode('<script src="https://www.paypalobjects.com/api/checkout.js"></script>');
    }
    if(getCoreConfig('ecommerce/conekta/enabled') == 1)
    {
        if(in_array('conekta_tarjeta',getCoreConfig('ecommerce/conekta/methods')))
        {
            $cardForm = new conektaForm("card-form");
            $MyMetatag->setCode('<script  src="https://cdn.conekta.io/js/latest/conekta.js"></script>');
            $MyMetatag->setCode('<script > Conekta.setPublicKey(\''.(getCoreConfig('ecommerce/conekta/sandbox') == 1 ? getCoreConfig('ecommerce/conekta/publicsandbox') : getCoreConfig('ecommerce/conekta/public')).'\'); </script>');
        }
    }
    if(getCoreConfig('ecommerce/openpay/enabled') == 1)
    {
        if(in_array('openpay_tarjeta',getCoreConfig('ecommerce/openpay/methods')))
        {
            $cardForm = new openpayForm("card-form");
            $MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>');
            $MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>');
        }
    }
}

$direcciones_facturacion = makeHTMLDireccion("facturacion",$MySession->GetVar("id"));
$direcciones_facturacion["no_requiere"] = "No requiere factura";
$direcciones_facturacion["otra"] = "Nueva direccion";
$DireccionCheckoutForm = new checkoutForm("frm_direccion");
$DireccionCheckoutForm->addDirecionFacturacion($direcciones_facturacion);
$DireccionCheckoutForm->setAtributoInput("id_facturacion", "value", "no_requiere");
$DireccionCheckoutForm->addSubmit();


$direcciones_envio = makeHTMLDireccion("envio",$MySession->GetVar("id"));
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


?>
