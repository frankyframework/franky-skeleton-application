<?php
use \Ecommerce\model\carrito;
use Ecommerce\model\carrito_producto;
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
            $MyProducto->getInfoProducto($registro["id_producto"]);
            $_registro = $MyProducto->getRows();

            $imagen = "";
            $_img = getCoreConfig('ecommerce/product/placeholder');
            if($_img != "" && file_exists(PROJECT_DIR.$_img))
            {
              $imagen = imageResize($_img,50,50, true);
            }
           
            if(!empty($_registro["imagen"]))
            {
                $_imagen = json_decode($_registro["imagen"],true);
                if(is_array($_imagen))
                {
                    if(!empty($_imagen)){
                    
                        foreach($_imagen as $foto)
                        {
                            if($foto['principal'] == 1)
                            {
                                if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/".DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE.'/'.$registro["id_producto"].'/'.$foto['img']))
                                {
                                    $imagen = imageResize($MyConfigure->getUploadDir()."/".DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE."/".$registro["id_producto"].'/'.$foto['img'],50,50, true);  
                                }
                            }
                        }
                    }
                }
                else{
                    $imagen = imageResize($MyConfigure->getUploadDir()."/".DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE."/".$registro["id_producto"].'/'.$_registro['imagen'],50,50, true);
                }
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
