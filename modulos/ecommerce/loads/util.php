<?php
function _ecommerce($txt)
{
    return dgettext("ecommerce",$txt);
}

function normalizeStatusTransaccion($status){

  $array_paid = ['paid','approved','completed','processed'];
  $array_canceled = ['canceled','reversed'];
  $array_pending = ['pending','pending_payment','transfer_pending','in_progress'];
  if(in_array($status,$array_paid))
  {
      return 'paid';
  }

  if(in_array($status,$array_canceled))
  {
      return 'canceled';
  }

  if(in_array($status,$array_pending))
  {
      return 'pending';
  }
}

function getStatusTransaccion($status)
{
    switch (strtolower($status))
    {
        case "paid":
            $_status = _ecommerce("Pagado");
        break;
        case "canceled-reversal":
            $_status = _ecommerce("Cancelacion anulada");
        break;
        case "canceled":
            $_status = _ecommerce("Cancelado");
        break;
        case "denied":
            $_status = _ecommerce("Denegado");
        break;
        case "expired":
            $_status = _ecommerce("Expirado");
        break;
        case "in-progress":
            $_status = _ecommerce("En progreso");
        break;
        case "pending":
            $_status = _ecommerce("Pendiente");
        break;
        case "partially-refunded":
            $_status = _ecommerce("Reenvolso parcial");
        break;
        case "refunded":
            $_status = _ecommerce("Reenvolso total");
        break;
        case "voided":
            $_status = _ecommerce("Transaccion anulada");
        break;
        case "pago_incompleto":
            $_status = _ecommerce("Pago incompleto");
        break;
        case "request_refunded":
            $_status = _ecommerce("Solicita reenvolso");
        break;
    }


    return $_status;
}


function getMyIdCarrito()
{
    global $MySession;
    $MyCarritoCompras =  new \Ecommerce\model\carrito();

    if($MyCarritoCompras->getData("", ($MySession->LoggedIn() ? $MySession->GetVar("id") : ""),  session_id()) == REGISTRO_SUCCESS)
    {
        $registro = $MyCarritoCompras->getRows();

        return $registro["id"];
    }
    return 0;
}

function makeHTMLCards($uid = "")
{
    $CardsModel = new Ecommerce\model\CardsModel();
    $CardsEntity = new \Ecommerce\entity\CardsEntity();
    $CardsEntity->uid($uid);
    $CardsEntity->status(1);
    $CardsModel->setTampag(50);
    $CardsModel->setOrdensql("nombre ASC");
    $CardsModel->getData($CardsEntity->getArrayCopy());
    $total	= $CardsModel->getTotal();
    $cards = array();


    if($total > 0)
    {

        while($registro = $CardsModel->getRows())
        {
                $cards[$registro['id']] = $registro["nombre"].": XXXX-XXXX-XXXX-".$registro["numero"];
	}
    }


    return $cards;
}

function makeHTMLDireccion($type="envio",$uid = "")
{

    if($type =="envio")
    {
        $MyDireccion = new Ecommerce\model\direcciones();
        $direccion = "%s: calle %s #%s, Colonia %s, municipio %s,%s C.P. %d";
    }
    if($type == "facturacion")
    {
        $MyDireccion = new Ecommerce\model\direcciones_facturacion();
        $direccion = "%s: calle %s #%s, Colonia %s, municipio %s,%s C.P. %d";
    }
    $MyDireccion->setTampag(1000);
    $MyDireccion->setOrdensql("fecha ASC");
    $MyDireccion->getData("",$uid);
    $total	= $MyDireccion->getTotal();
    $direcciones = array();


    if($total > 0)
    {

        while($registro = $MyDireccion->getRows())
        {
            if($type =="envio")
            {
                $direcciones[$registro['id']] = sprintf($direccion,$registro["nombre"],$registro["calle"],$registro["numero"],$registro["colonia"],$registro["municipio"],$registro["estado"],$registro["cp"]);
            }
            if($type =="facturacion")
            {
                $direcciones[$registro['id']] = sprintf($direccion,$registro["nombre"],$registro["calle"],$registro["numero"],$registro["colonia"],$registro["municipio"],$registro["estado"],$registro["cp"]);
            }
	}
    }


    return $direcciones;
}

/*
function getCustomer($id)
{
    $CustomerModel = new \Ecommerce\model\CustomersModel();
    $CustomerEntity = new \Ecommerce\entity\CustomersEntity();
    $CustomerEntity->id_user($id);

    if($CustomerModel->getData($CustomerEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
        $registro = $CustomerModel->getRows();

        return $registro["id"];
    }
    return false;
}
*/
function getCarrito()
{
  $productos =  OBJETO_PRODUCTOS;
  $MyProducto =  new $productos();
  $MyCarritoProducto =  new \Ecommerce\model\carrito_producto();

  $MyCarritoProducto->setTampag(100);
  $MyCarritoProducto->getData("", getMyIdCarrito());

  $productos_comprados = array('productos' => []);

  $gran_total = 0;
  $subtotal = 0;
  $iva_total = 0;

  while($registro = $MyCarritoProducto->getRows())
  {

      $MyProducto->getInfoProducto($registro["id_producto"]);
      $_registro = $MyProducto->getRows();


      $data_precio = parsePrecio($_registro["precio"] * $registro["qty"],$_registro["iva"],$_registro["incluye_iva"]);
      $iva_total += $data_precio['iva'];
      $gran_total += $data_precio['total'];
      $subtotal += $data_precio['subtotal'];

      $productos_comprados['productos'][] = array("id" => $registro["id_producto"],
          "qty" => $registro["qty"],
          "nombre" => $_registro["nombre"],
          "caracteristicas" => $registro["caracteristicas"],
          "precio" => $_registro["precio"]
      );
  }

  $productos_comprados['gran_total'] = $gran_total;
  $productos_comprados['subtotal'] = $subtotal;
  $productos_comprados['iva_total'] = $iva_total;



  return $productos_comprados;
}




function getPedido($id,$uid=""){

    $pedidosModel             = new \Ecommerce\model\pedidos();
    $producto_pedidoModel             = new \Ecommerce\model\producto_pedidoModel();
    $producto_pedidoEntity          = new \Ecommerce\entity\producto_pedido();
    $MyDirecciones = new \Ecommerce\model\direcciones_facturacion;


    $productos =  OBJETO_PRODUCTOS;
    $MyProducto =  new $productos();

    $result	 		= $pedidosModel->getData($id,$uid);
    $detalle_pedido = array();
    if($pedidosModel->getTotal() > 0)
    {
        $detalle_pedido = $pedidosModel->getRows();
      
        $detalle_pedido["envio"] = json_decode($detalle_pedido["id_direccion_envio"],true);
        $detalle_pedido["facturacion"] = json_decode($detalle_pedido["id_direccion_facturacion"],true);

    }

    $producto_pedidoEntity->setId_pedido($detalle_pedido['id']);
    $producto_pedidoModel->setTampag(100);
    $producto_pedidoModel->getData($producto_pedidoEntity->getArrayCopy());


    while($registro = $producto_pedidoModel->getRows())
    {

        $MyProducto->getInfoProducto($registro["id_producto"]);
        $_registro = $MyProducto->getRows();

        $detalle_pedido['productos'][] = array("id" => $registro["id_producto"],
            "qty" => $registro["qty"],
            "nombre" => $_registro["nombre"],
            "caracteristicas" => json_decode($registro["caracteristicas"],true),
            "precio" => $registro["precio"],
            "imagen" => $_registro["imagen"]
        );
    }



    return $detalle_pedido;

}

function redondeado ($numero, $decimales)
{
   $factor = pow(10, $decimales);
   return (round($numero*$factor)/$factor);
 }

function parsePrecio($precio,$iva,$incluye_iva)
{
    $piva = $iva;
  if($incluye_iva == 0)
  {
      $subtotal = $precio;
      $iva = ($subtotal*$iva)/100;
      $total = $subtotal + $iva;
  }
  else {
      $subtotal = $precio/(1+($iva/100));
      $iva = $precio-$subtotal;
      $total = $precio;
  }

  return array('subtotal' => redondeado($subtotal,2),'piva' =>$piva,'iva' =>redondeado($iva,2),'total' => redondeado($total,2),'incluye_iva' => $incluye_iva);
}

function setCarritoUser(){

    global $MySession;
  if(!$MySession->LoggedIn())
  {
      return false;
  }


  $MyCarritoCompras =  new \Ecommerce\model\carrito();
  $MyCarritoComprasEntity =  new \Ecommerce\entity\carrito();
  if($MyCarritoCompras->getData("","", session_id()) == REGISTRO_SUCCESS)
  {


      while($registro = $MyCarritoCompras->getRows())
      {

          $MyCarritoComprasEntity->setId($registro["id"]);
          $MyCarritoComprasEntity->setUid($MySession->GetVar("id"));

          if($MyCarritoCompras->save($MyCarritoComprasEntity->getArrayCopy())==REGISTRO_SUCCESS)
          {
            return true;
          }

      }


  }

  return false;


}
?>
