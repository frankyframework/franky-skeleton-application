<?php
use \Base\model\CoreConfig;
use Ecommerce\Form\checkoutForm;
use Ecommerce\Form\direccionesForm;

use Ecommerce\Form\conektaForm;
use Ecommerce\Form\openpayForm;
use Ecommerce\model\carrito;
use Ecommerce\model\carrito_producto;

$MyCarritoProducto =  new carrito_producto();
$MyCarritoModel = new carrito();

$CoreConfig           = new CoreConfig();
$core_config = $CoreConfig->getMap('ecommerce');
foreach($core_config as $key_config => $val_config):

    foreach($val_config['config'] as $key =>$config):
          if($config['path'] == "ecommerce/conekta/methods"):
              $metodos_conekta = $config['data'];
          endif;
          if($config['path'] == "ecommerce/openpay/methods"):
              $metodos_openpay = $config['data'];
          endif;
    endforeach;
endforeach;


$id_carrito = getMyIdCarrito();

if(!empty($id_carrito))
{

    if($MyCarritoProducto->getData("", $id_carrito) != REGISTRO_SUCCESS)
    {
        $MyRequest->redirect($MyRequest->url(CARRITO_COMPRAS));
    }
}
else
{
    $MyRequest->redirect($MyRequest->url(CARRITO_COMPRAS));
}

$metodos_de_pago = array();

$MyCarritoCompras =  new carrito();
$productos_comprados = getCarrito();
$total = 0;
foreach($productos_comprados['productos'] as $producto)
{
    $total +=  $producto["precio"];
}
if($total > 0)
{
    if(getCoreConfig('ecommerce/paypal/enabled') == 1)
    {

        $metodos_de_pago["pago_paypal"] = "payPal";

        $MyMetatag->setCode('<script src="https://www.paypalobjects.com/api/checkout.js"></script>');
    }
    if(getCoreConfig('ecommerce/conekta/enabled') == 1)
    {
        $cardForm = new conektaForm("card-form");
        $metodos = getCoreConfig('ecommerce/conekta/methods');
        if(!empty($metodos)):
            foreach($metodos as $k)
            {
              $metodos_de_pago[$k] = $metodos_conekta[$k];
            }

        endif;

        $MyMetatag->setCode('<script  src="https://cdn.conekta.io/js/latest/conekta.js"></script>');
        $MyMetatag->setCode('<script > Conekta.setPublicKey(\''.(getCoreConfig('ecommerce/conekta/sandbox') == 1 ? getCoreConfig('ecommerce/conekta/publicsandbox') : getCoreConfig('ecommerce/conekta/public')).'\'); </script>');
    }
    if(getCoreConfig('ecommerce/openpay/enabled') == 1)
    {
        $cardForm = new openpayForm("card-form");
        $metodos = getCoreConfig('ecommerce/openpay/methods');
        if(!empty($metodos)):
            foreach($metodos as $k)
            {
              $metodos_de_pago[$k] = $metodos_openpay[$k];
            }

        endif;

        $MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>');
    		$MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>');
    }
}
else{
    $metodos_de_pago["pay_free"] = "No requiere pago";
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


$MetodoEnvioCheckoutForm = new checkoutForm("frm_metodo_envio");
$MetodoEnvioCheckoutForm->addMetodoEnvio();
$MetodoEnvioCheckoutForm->addSubmit();


$PagoCheckoutForm = new checkoutForm("frm_pago");
$PagoCheckoutForm->addMetodoPago($metodos_de_pago);
if($precio <= 0)
{
  $PagoCheckoutForm->setAtributoInput('id_pago','value','pay_free');
}
$PagoCheckoutForm->addSubmit();


$direccionesForm = new direccionesForm("frmdirecciones");
$direccionesForm->addOtroTelefono();
$direccionesForm->addEntrecalles();
$direccionesForm->addInstrucciones();
$direccionesForm->addSubmit();

$direccionesFacturacionForm = new direccionesForm("frmdirecciones_facturacion");
$direccionesFacturacionForm->addRFC();
$direccionesFacturacionForm->addSubmit();


?>
