<?php
function EliminarDireccionEcommerce($id,$status)
{
    global $MySession;
    $MyDireccion =  new \Ecommerce\model\direcciones();
    $MyDireccionEntity =  new \Ecommerce\entity\direcciones();
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_DIRECCIONES_ECOMMERCE))
    {
        $MyDireccionEntity->setId(addslashes($id));
        $MyDireccionEntity->setStatus($status);
        $MyDireccionEntity->setUid($MySession->GetVar('id'));
        if($MyDireccion->save($MyDireccionEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("ecommerce_direccion_error_delete");
              $respuesta["error"] = true;
        }
    }
    else
    {
         $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
         $respuesta["error"] = true;
    }

    return $respuesta;
}


function EliminarTarjetaEcommerce($id,$status)
{
    global $MySession;
    $CardsModel =  new \Ecommerce\model\CardsModel();
    $CardsEntity =  new \Ecommerce\entity\CardsEntity();
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_TARJETAS_ECOMMERCE))
    {
        $CardsEntity->id(addslashes($id));
        $CardsEntity->status($status);
        $CardsEntity->uid($MySession->GetVar('id'));
        if($CardsModel->save($CardsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            $CardsModel->getData($CardsEntity->getArrayCopy());
            $registro = $CardsModel->getRows();
            if(getCoreConfig('ecommerce/conekta/enabled') == 1)
            {
                deleteCardConekta($registro['conekta'],$registro['uid']);
            }
            elseif(getCoreConfig('ecommerce/openpay/enabled') == 1)
            {
                deleteCardOpenpay($registro['conekta'],$registro['uid']);
            }
             $respuesta["message"] = "success";
        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("ecommerce_tarjeta_error_delete");
              $respuesta["error"] = true;
        }
    }
    else
    {
         $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
         $respuesta["error"] = true;
    }

    return $respuesta;
}


function EliminarDireccionFacturacionEcommerce($id,$status)
{
    global $MySession;
    $MyDireccion =  new \Ecommerce\model\direcciones_facturacion();
    $MyDireccionEntity =  new \Ecommerce\entity\direcciones_facturacion();
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_DIRECCIONES_ECOMMERCE))
    {
        $MyDireccionEntity->setId(addslashes($id));
        $MyDireccionEntity->setStatus($status);
        $MyDireccionEntity->setUid($MySession->GetVar('id'));
        if($MyDireccion->save($MyDireccionEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("ecommerce_direccion_error_delete");
              $respuesta["error"] = true;
        }
    }
    else
    {
         $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
         $respuesta["error"] = true;
    }

    return $respuesta;
}


function eliminarProductoCarrito($id)
{
    $MyCarritoProducto =  new \Ecommerce\model\carrito_producto();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = array("error" => false);

    if($MyAccessList->MeDasChancePasar(CARRITO_ECOMMERCE))
    {
        if($MyCarritoProducto->delete(addslashes($Tokenizer->decode($id)),getMyIdCarrito()) == REGISTRO_SUCCESS)
        {
               $respuesta = getInfoCarrito();
        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("ecommerce_carrito_error_delete");
              $respuesta["error"] = true;
        }
    }
    else
    {
         $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
         $respuesta["error"] = true;
    }

    return $respuesta;
}


function getInfoCarrito()
{
    $MyCarritoProducto =  new \Ecommerce\model\carrito_producto();
    $MyCarritoCompras =  new \Ecommerce\model\carrito();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyConfigure;

    $productos =  OBJETO_PRODUCTOS;
    $MyProducto =  new $productos();


    $registro = $MyCarritoCompras->getRows();
    $id_carrito = getMyIdCarrito();


    $respuesta = array("qty" => 0,"subtotal" => 0,"total"=> 0);
    $MyCarritoProducto->setTampag(100);
    if($MyCarritoProducto->getData("", $id_carrito) == REGISTRO_SUCCESS)
    {

        while($registro = $MyCarritoProducto->getRows())
        {

            $MyProducto->getInfoProdcuto($registro["id_producto"]);
            $_registro = $MyProducto->getRows();

            $imagen = $_registro["imagen"];
            if(file_exists($MyConfigure->getServerUploadDir()."/".DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE."/".$registro["id_producto"]."/". $imagen))
            {
              $imagen = imageResize($MyConfigure->getUploadDir()."/".DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE."/".$registro["id_producto"]."/".$imagen,50,50);
            }
            else{
              $imagen = imageResize(getImg('ecommerce/producto_default.jpg'),50,50);
            }
            $respuesta["qty"] += $registro["qty"];

            $respuesta["subtotal"] += $_registro["precio"] * $registro["qty"];

            $respuesta["productos"][] = array("id" => $Tokenizer->token("productos",$registro["id"]),"nombre" => $_registro["nombre"],"precio" => getFormatoPrecio($_registro["precio"]),"qty" =>  $registro["qty"],"img" => $imagen,"subtotal" => getFormatoPrecio($registro["qty"]*$_registro["precio"]));

        }

        $parse_precio =  getCarrito();
        $respuesta["total"] = getFormatoPrecio($parse_precio['gran_total']);
        $respuesta["subtotal"] = getFormatoPrecio($parse_precio['subtotal']);
        $respuesta["iva"] = getFormatoPrecio($parse_precio['iva_total']);

    }

    return $respuesta;
}


function addProductoCarrito($producto,$qty=1,$caracteristicas=array())
{
        $MyCarritoEntity =  new \Ecommerce\entity\carrito();
        $MyCarritoCompras =  new \Ecommerce\model\carrito();
        $MyCarritoProducto =  new \Ecommerce\model\carrito_producto();
        $MyCarritoProductoEntity =  new \Ecommerce\entity\carrito_producto();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        global $MySession;
        global $MyRequest;

        $respuesta = array("error" => false);

        if($MyAccessList->MeDasChancePasar(CARRITO_ECOMMERCE))
        {
            $id_carrito = getMyIdCarrito();
            if($id_carrito == 0)
            {
                $MyCarritoEntity->setCookie_id(session_id());
                if($MySession->LoggedIn())
                {
                    $MyCarritoEntity->setUid($MySession->GetVar("id"));

                }
                $MyCarritoCompras->save($MyCarritoEntity->getArrayCopy());
                $id_carrito = $MyCarritoCompras->getUltimoID();
            }
            //echo $id_carrito;
            if($MyCarritoProducto->getData("", $id_carrito,$Tokenizer->decode($producto),$caracteristicas) == REGISTRO_SUCCESS)
            {
                $registro = $MyCarritoProducto->getRows();

                $qty += $registro["qty"];
                $MyCarritoProductoEntity->setId($registro["id"]);


            }

            $MyCarritoProductoEntity->setId_producto($Tokenizer->decode($producto));
            $MyCarritoProductoEntity->setQty($qty);
            $MyCarritoProductoEntity->setCaracteristicas($caracteristicas);
            $MyCarritoProductoEntity->setId_carrito($id_carrito);

            if($MyCarritoProducto->save($MyCarritoProductoEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

                $respuesta = getInfoCarrito();

            }
            else
            {
                $respuesta["message"] = $MyMessageAlert->Message("ecommerce_carrito_error_add");
                $respuesta["error"] = true;

            }
        }
        else
        {
             $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
             $respuesta["error"] = true;
        }

	return $respuesta;
}

function setQTYProductoCarrido($id,$qty)
{
        $MyCarritoProdcutoEntity =  new \Ecommerce\entity\carrito_producto();
	       $MyCarritoProducto =  new \Ecommerce\model\carrito_producto();
         $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        global $MySession;
        $respuesta = array("error" => false,"total" => 0, "iva" => 0, "subtotal" => 0);

        if($MyAccessList->MeDasChancePasar(CARRITO_ECOMMERCE))
        {
            $id_carrito = getMyIdCarrito();
            if($MyCarritoProducto->getData($Tokenizer->decode($id), $id_carrito) == REGISTRO_SUCCESS)
            {
                $MyCarritoProdcutoEntity->setId($Tokenizer->decode($id));
                $MyCarritoProdcutoEntity->setQty($qty);
                $MyCarritoProdcutoEntity->setId_carrito($id_carrito);

                if($MyCarritoProducto->save($MyCarritoProdcutoEntity->getArrayCopy())  == REGISTRO_SUCCESS)
                {

                   $respuesta = getInfoCarrito();

                }
                else
                {
                    $respuesta["message"] = $MyMessageAlert->Message("ecommerce_carrito_error_cantidad");
                    $respuesta["error"] = true;
                }
            }
            else{
                $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
                $respuesta["error"] = true;
            }
        }
        else
        {
            $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
            $respuesta["error"] = true;
        }

	return $respuesta;
}




function setconfigPago($id_pago)
{

    $MyCarritoModel = new \Ecommerce\model\carrito();
    $MyCarritoEntity = new \Ecommerce\entity\carrito();
    global $MyAccessList;
    global $MySession;
    global $MyMessageAlert;

    $respuesta = array("error" => false);

    if($MyAccessList->MeDasChancePasar(CARRITO_ECOMMERCE))
    {

        if($MyCarritoModel->getData("", $MySession->GetVar("id") ) == REGISTRO_SUCCESS)
        {

            $data = $MySession->GetVar('checkout');
            $data["id_pago"] = $id_pago;
            $MySession->SetVar('checkout',$data);

            /*$registro = $MyCarritoModel->getRows();
            $id_carrito = $registro["id"];
            $MyCarritoEntity->setId($id_carrito);
            $MyCarritoEntity->setId_envio($id_envio);
            $MyCarritoEntity->setId_facturacion($id_facturacion);
            $MyCarritoEntity->setId_pago($id_pago);
            //$MyCarritoEntity->setId_metodo_envio($id_metodo_envio);

            $MyCarritoModel->save($MyCarritoEntity->getArrayCopy());
            */

        }
        else
        {
            $respuesta["message"] = $MyMessageAlert->Message("ecommerce_carrito_vacio");
            $respuesta["error"] = true;
        }
    }
    else
    {
        $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
        $respuesta["error"] = true;
    }

    return $respuesta;
}

function setDireccionCheckout($id_envio)
{
    global $MySession;
    $data = array("id_envio" => $id_envio);
    $MyDireccion = new Ecommerce\model\direcciones();

    $MyDireccion->setTampag(1000);
    $MyDireccion->setOrdensql("fecha ASC");
    $MyDireccion->getData("",$MySession->GetVar('id'));
    $total	= $MyDireccion->getTotal();



    if($total > 0)
    {

        while($direccion_envio = $MyDireccion->getRows())
        {
            if($direccion_envio['id'] == $id_envio)
            {

                  $data['resumen_envio'] =   render(PROJECT_DIR.'/modulos/ecommerce/diseno/checkout/resumen.envio.phtml',['direccion_envio' =>$direccion_envio]);
            }

        }
    }
    $MySession->SetVar('checkout',$data);

    return $data;
}


function setNuevaDireccionCheckout($data)
{
    global $MySession;
    $data2 = array();
    $data = json_decode($data,true);
    foreach($data as $node){
        $data2[$node["name"]] = $node["value"];
    }

    $data = array("direccion_envio" => $data2,
        'resumen_envio' =>   render(PROJECT_DIR.'/modulos/ecommerce/diseno/checkout/resumen.envio.phtml',['direccion_envio' =>$data2])
);
    $MySession->SetVar('checkout',$data);

    return $data;
}

function setFacturacionCheckout($id_facturacion)
{
    global $MySession;

    $data = $MySession->GetVar('checkout');
    $data["id_facturacion"] = $id_facturacion;

    $MyDireccion = new Ecommerce\model\direcciones_facturacion();

    $MyDireccion->setTampag(1000);
    $MyDireccion->setOrdensql("fecha ASC");
    $MyDireccion->getData("",$MySession->GetVar('id'));
    $total	= $MyDireccion->getTotal();



    if($total > 0)
    {

        while($direccion_facturacion = $MyDireccion->getRows())
        {
            if($direccion_facturacion['id'] == $id_facturacion)
            {

                  $data['resumen_facturacion'] =   render(PROJECT_DIR.'/modulos/ecommerce/diseno/checkout/resumen.facturacion.phtml',['direccion_facturacion' =>$direccion_facturacion]);
            }

        }
    }
    if($id_facturacion == 'no_requiere')
    {
         $data['resumen_facturacion'] =   render(PROJECT_DIR.'/modulos/ecommerce/diseno/checkout/resumen.nofacturacion.phtml');

    }


    $MySession->SetVar('checkout',$data);

    return $data;
}


function setNuevaFacturacionCheckout($data)
{
    global $MySession;
    $data2 = $MySession->GetVar('checkout');
    $data = json_decode($data,true);
    $data3 = array();
    foreach($data as $node){
        $data3[$node["name"]] = $node["value"];
    }

    $data2["direccion_facturacion"] = $data3;
    $data2['resumen_facturacion'] =   render(PROJECT_DIR.'/modulos/ecommerce/diseno/checkout/resumen.facturacion.phtml',['direccion_facturacion' =>$data3]);
    $MySession->SetVar('checkout',$data2);

    return $data2;
}

function SetStatusPagoEcommerce($id,$status,$nota,$monto)
{
    global $MyAccessList;
    global $MySession;
    global $MyMessageAlert;
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    $pedidosModel    = new \Ecommerce\model\pedidos();
    $pedidosEntity   = new \Ecommerce\entity\pedidos();
    $TemplateemailModel    = new \Base\model\TemplateemailModel;
    $USERS = new \Base\model\USERS();
    $EcommercelogstatusModel    = new \Ecommerce\model\EcommercelogstatusModel();
    $EcommercelogstatusEntity   = new \Ecommerce\entity\EcommercelogstatusEntity();
    $ObserverManager = new \Franky\Core\ObserverManager;


    $respuesta = array("error" => false);

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_PEDIDOS))
    {
        $pedidosEntity->setId($Tokenizer->decode($id));

        $pedidosModel->getData($pedidosEntity->getArrayCopy());

        $pedido = $pedidosModel->getRows();

        $data = json_encode(['nota' => $nota,"monto" => $monto]);

        $pedidosEntity->setStatus($status);

        if($pedidosModel->save($pedidosEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
              $respuesta["message"] = $MyMessageAlert->Message("ecommerce_cambiar_status_pedido_success");
              $respuesta["status"] = getStatusTransaccion($status);

              $EcommercelogstatusEntity->status($status);
              $EcommercelogstatusEntity->auto(0);
              $EcommercelogstatusEntity->id_user($MySession->GetVar('id'));
              $EcommercelogstatusEntity->fecha(date('Y-m-d H:i:s'));
              $EcommercelogstatusEntity->id_pedido($Tokenizer->decode($id));
              $EcommercelogstatusEntity->info($data);
              $EcommercelogstatusModel->save($EcommercelogstatusEntity->getArrayCopy());

              $detalle_pedido = getPedido($Tokenizer->decode($id));

              if($USERS->getData($detalle_pedido['uid'])==REGISTRO_SUCCESS)
              {

                $dataUser = $USERS->getRows();

                $productos_html = render(PROJECT_DIR.'/modulos/ecommerce/diseno/email/productos.phtml',['items' =>$detalle_pedido['productos']]);


                $campos = array("orden" => $Tokenizer->decode($id),"nombre" =>$detalle_pedido['nombre'],'productos' =>$productos_html,"email" => $dataUser['email'],
                'gran_total' => getFormatoPrecio($detalle_pedido['monto_compra']),'metodo_pago' =>$detalle_pedido['metodo_pago'],"status" => getStatusTransaccion($status));


                $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
                $SecciontransaccionalEntity->frinedly('cambio-status-pedido');
                $TemplateemailModel->setOrdensql('id DESC');
                $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

                $registro  = $TemplateemailModel->getRows();

                sendEmail($campos,$registro);

                $ObserverManager->dispatch('change_status_pago',[$Tokenizer->decode($id)]);


              }
        }
        else
        {
            $respuesta["message"] = $MyMessageAlert->Message("ecommerce_cambiar_status_pedido_error");
            $respuesta["error"] = true;
        }
    }
    else
    {
        $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
        $respuesta["error"] = true;
    }


    return $respuesta;
}

function pay_free()
{

        global $MyMessageAlert;
        global $MySession;
        global $MyRequest;
        $respuesta = array("error" => false,"html" => "");

        if($MySession->LoggedIn())
        {
           $token = getToken("pay_free");
           $MySession->SetVar('pay_free',$token);
          $html = "<a class=\"_btn _primary_checkout\" href=\"".$MyRequest->url(CONFIRMACION_PAY_FREE)."\">Terminar compra</a>";

            $respuesta["html"] = $html;
        }
        else
        {
            $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
            $respuesta["error"] = true;
        }

	return $respuesta;
}
/******************************** EJECUTA *************************/
$MyAjax->register("EliminarDireccionEcommerce");
$MyAjax->register("EliminarDireccionFacturacionEcommerce");
$MyAjax->register("EliminarTarjetaEcommerce");
$MyAjax->register("eliminarProductoCarrito");
$MyAjax->register("addProductoCarrito");
$MyAjax->register("setQTYProductoCarrido");
$MyAjax->register("setconfigPago");
$MyAjax->register("getInfoCarrito");
$MyAjax->register("setDireccionCheckout");
$MyAjax->register("setNuevaDireccionCheckout");
$MyAjax->register("setFacturacionCheckout");
$MyAjax->register("setNuevaFacturacionCheckout");
$MyAjax->register("SetStatusPagoEcommerce");
$MyAjax->register("pay_free");
?>
