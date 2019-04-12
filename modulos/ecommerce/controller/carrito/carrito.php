<?php
use \modulos\ecommerce\vendor\model\carrito;
use modulos\ecommerce\vendor\model\carrito_producto;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyCarritoCompras =  new carrito();
$MyCarritoProducto =  new carrito_producto();
$productos =  OBJETO_PRODUCTOS;
$MyProducto =  new $productos();
$lista_cupones = array();
$MyCarritoProducto->setTampag(100);
$MyCarritoProducto->setOrdensql("id");



    $registro = $MyCarritoCompras->getRows();
    $id_carrito =  getMyIdCarrito();

    if($MyCarritoProducto->getData("", $id_carrito) == REGISTRO_SUCCESS)
    {
        while($registro = $MyCarritoProducto->getRows())
        {
            $MyProducto->getInfoProdcuto($registro["id_producto"]);
            $_registro = $MyProducto->getRows();

            $imagen = json_decode($_registro["imagen"],true);
            $imagen = $MyConfigure->getUploadDir()."/".DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE."/".$registro["id_producto"]."/".(is_array($imagen) ? $imagen[0] : $imagen);

            if(!file_exists(PROJECT_DIR.$imagen))
            {
              $imagen = getImg('ecommerce/producto_default.jpg');
            }


            $carrito_compras[] = array(
                "id"                => $Tokenizer->token("productos",$registro["id"]),
                "id_producto"       =>  $Tokenizer->token("productos", $registro["id_producto"]),
                "id_producto_ori"       =>  $registro["id_producto"],
                "caracteristicas"   => "",
                "qty"               => $registro["qty"],
                "precio"            => $_registro["precio"],
                "iva"               => $_registro["iva"],
                "nombre"            => $_registro["nombre"],
                "link"              => $MyRequest->url(DETALLE_PRODUCTOS_ECOMMERCE,$_registro),
                "imagen"            => $imagen

            );
        }

    }

?>
