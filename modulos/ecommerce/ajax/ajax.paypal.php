<?php
function pago_paypal()
{
        global $MyMessageAlert;
        global $MySession;
        global $MyRequest;
        $productos =  OBJETO_PRODUCTOS;
        $MyProducto =  new $productos();

        $MyCarritoCompras =  new \Ecommerce\model\carrito();
        $MyCarritoProducto =  new \Ecommerce\model\carrito_producto();
        $ObserverManager = new \Franky\Core\ObserverManager;
        
        $ObserverManager->dispatch('prepara_orden_ajax_ecommerce',[]);

        $respuesta = array("error" => false,"html" => "");


        $productos_comprados = getCarrito();
        if(!empty($productos_comprados['productos']))
        {
            if($MySession->LoggedIn())
            {
                $respuesta["html"] = render(PROJECT_DIR.'/modulos/ecommerce/diseno/paypal/paypal.button.phtml');

                $respuesta["js"] = 'paypalCheckout(\''.getCoreConfig('ecommerce/paypal/sandbox').'\',\''.getCoreConfig('ecommerce/paypal/keysandbox').'\',\''.getCoreConfig('ecommerce/paypal/key').'\',\''.$productos_comprados['gran_total'].'\')';
            }
            else
            {
                $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
                $respuesta["error"] = true;
            }
	         }
        else{
           $respuesta["message"] = $MyMessageAlert->Message("ecommerce_carrito_vacio");
           $respuesta["error"] = true;
        }
	return $respuesta;
}
/******************************** EJECUTA *************************/
$MyAjax->register("pago_paypal");
?>
