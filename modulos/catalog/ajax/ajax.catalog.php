<?php
function DeleteCatalogCategory($id,$status)
{
    global $MySession;
    $CatalogcategoryModel =  new \Catalog\model\CatalogcategoryModel();
    $CatalogcategoryEntity =  new \Catalog\entity\CatalogcategoryEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CATEGORY_CATALOG))
    {
        $CatalogcategoryEntity->id(addslashes($Tokenizer->decode($id)));
        $CatalogcategoryEntity->status($status);

        if($CatalogcategoryModel->save($CatalogcategoryEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("catalog_category_error_delete");
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


function DeleteCatalogSubcategory($id,$status)
{
    global $MySession;
    $CatalogsubcategoryModel =  new \Catalog\model\CatalogsubcategoryModel();
    $CatalogsubcategoryEntity =  new \Catalog\entity\CatalogsubcategoryEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CATEGORY_CATALOG))
    {
        $CatalogsubcategoryEntity->id(addslashes($Tokenizer->decode($id)));
        $CatalogsubcategoryEntity->status($status);

        if($CatalogsubcategoryModel->save($CatalogsubcategoryEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("catalog_subcategory_error_delete");
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


function DeleteCatalogProduct($id,$status)
{
    global $MySession;
    $CatalogproductsModel =  new \Catalog\model\CatalogproductsModel();
    $CatalogproductsEntity =  new \Catalog\entity\CatalogproductsEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_PRODUCTS_CATALOG))
    {
        $CatalogproductsEntity->id(addslashes($Tokenizer->decode($id)));
        $CatalogproductsEntity->status($status);

        if($CatalogproductsModel->save($CatalogproductsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("catalog_products_error_delete");
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



function setOrdenImagesProducts($album, $orden)
{
	
	$MyFoto = new Galeria\model\fotos();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_PRODUCTS_CATALOG))
        {
           
        
            $orden = explode(",",str_replace("foto_","",$orden));

            $v = "";
            $new_order = [];
          
            if(isset($_SESSION['album_'.$album]) && !empty($_SESSION['album_'.$album]))
            {
        
                
            
                foreach($orden as $key => $val)
                {
                    $v .= ($key)." -> $val,";
                    
                    foreach($_SESSION['album_'.$album]  as $foto)
                    {
                        if(md5($foto['img']) == $val)
                        {
                            $new_order[$key] = $foto;
                        }
                    
                    }
                }
               
                $_SESSION['album_'.$album] = $new_order;
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}



function eliminarFotoCatalogProduct($token,$status)
{

        global $MySession;
        global $MyConfigure;
        global $MyMessageAlert;
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $respuesta =null;

        $album = $MySession->GetVar('addProduct');
        foreach($_SESSION['album_'.$album] as $k => $image)
        {
            if($image['token'] == $token)
            {
              $id = $k;
              $img = $image['img'];
            }
        }

        $dir = $MyConfigure->getServerUploadDir()."/catalog/products/".$album."/$img";
        if(file_exists($dir))
        {
            //unlink($dir);

            //if(!file_exists($dir))
            //{
              unset($_SESSION['album_'.$album][$id]);
              $respuesta[] = array("message" => "success","id" => $token);
            //}

        }
        else{
            $respuesta[] = array("message" =>  $MyMessageAlert->Message("eliminar_generico_error"));
        }

	return $respuesta;
}



function catalog_addWishlist($id,$status)
{
	    $CatalogwishlistModel = new Catalog\model\CatalogwishlistModel;
        $CatalogwishlistEntity = new Catalog\entity\CatalogwishlistEntity;
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        global $MySession;
        global $MyRequest;
        $respuesta = null;

        $CatalogwishlistEntity->product_id($Tokenizer->decode($id));
 

        if(!$MySession->LoggedIn())
        {
            $CatalogwishlistEntity->status($status);
            $MySession->SetVar('catalog_eventos_pendientes',['wishlist' => $CatalogwishlistEntity->getArrayCopy()]);

            $respuesta[] = array("message" => "login","path" => $MyRequest->url(LOGIN)."?callback=".urlencode($MyRequest->getReferer()));
        }
        else {
            if($status == 1)
            {
              $CatalogwishlistEntity->status($status);

              $CatalogwishlistEntity->uid($MySession->GetVar('id'));

              if($CatalogwishlistModel->getData($CatalogwishlistEntity->getArrayCopy()) != REGISTRO_SUCCESS)
              {
                  $CatalogwishlistEntity->fecha(date('Y-m-d H:i:s'));
                  $result = $CatalogwishlistModel->save($CatalogwishlistEntity->getArrayCopy());
              }

            }
            else{

              $CatalogwishlistEntity->uid($MySession->GetVar('id'));
              $result = $CatalogwishlistModel->delete($CatalogwishlistEntity->getArrayCopy());
            }


        }

        return $respuesta;
}

function catalog_EliminarWhislist($id,$status)
{

	    $CatalogwishlistModel = new Catalog\model\CatalogwishlistModel;
        $CatalogwishlistEntity = new Catalog\entity\CatalogwishlistEntity;
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CATALOG_WISHLIST))
        {
            $CatalogwishlistEntity->id($Tokenizer->decode($id));
            if($CatalogwishlistModel->delete($CatalogwishlistEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		        $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function catalog_getWishlist()
{

    $CatalogwishlistModel = new Catalog\model\CatalogwishlistModel;
    $CatalogwishlistEntity = new Catalog\entity\CatalogwishlistEntity;
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;
    global $MySession;
    global $MyRequest;
    $respuesta = null;


    if($MySession->LoggedIn())
    {

         $CatalogwishlistEntity->status(1);

         $CatalogwishlistEntity->uid($MySession->GetVar('id'));
         $CatalogwishlistModel->setTampag(1000);
         if($CatalogwishlistModel->getData($CatalogwishlistEntity->getArrayCopy()) == REGISTRO_SUCCESS)
         {
            $respuesta = [];
              while($registro = $CatalogwishlistModel->getRows())
              {
                  $respuesta[] = $Tokenizer->token('catalog_products',$registro['product_id']);
              }
         }
       }

    return $respuesta;
}


function catalog_addProductoCarrito($producto,$qty=1,$caracteristicas=array())
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


/******************************** EJECUTA *************************/
$MyAjax->register("DeleteCatalogCategory");
$MyAjax->register("DeleteCatalogSubcategory");
$MyAjax->register("DeleteCatalogProduct");
$MyAjax->register("setOrdenImagesProducts");
$MyAjax->register("eliminarFotoCatalogProduct");
$MyAjax->register("catalog_addWishlist");
$MyAjax->register("catalog_EliminarWhislist");
$MyAjax->register("catalog_getWishlist");
$MyAjax->register("catalog_addProductoCarrito");
?>
