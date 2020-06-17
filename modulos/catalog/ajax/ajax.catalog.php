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

function ajax_products_agregarProductoRelacionado($id_parent,$id){
    
    global $MyAccessList;
    global $MyMessageAlert;
    $respuesta =[];
    
    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_PRODUCTS_CATALOG))
    {
        $CatalogproductrelatedModel =  new \Catalog\model\CatalogproductrelatedModel();
        $CatalogproductrelatedEntity =  new \Catalog\entity\CatalogproductrelatedEntity();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $CatalogproductrelatedEntity->id_parent($Tokenizer->decode($id_parent));
        $CatalogproductrelatedEntity->id_product($Tokenizer->decode($id));
        
        
        if($CatalogproductrelatedModel->save($CatalogproductrelatedEntity->getArrayCopy()) != REGISTRO_SUCCESS)
        {
            $respuesta["error"] = true;
            $respuesta["message"] = $MyMessageAlert->Message("catalog_products_error_relacionar");
        }
    }
    else
    {
        $respuesta["error"] = true;
        $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
    }
    return $respuesta;
}


function ajax_products_quitarProductoRelacionado($id_parent,$id){
    
    global $MyAccessList;
    global $MyMessageAlert;
    $respuesta =[];
    
    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_PRODUCTS_CATALOG))
    {
        $CatalogproductrelatedModel =  new \Catalog\model\CatalogproductrelatedModel();
        $CatalogproductrelatedEntity =  new \Catalog\entity\CatalogproductrelatedEntity();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $CatalogproductrelatedEntity->id_parent($Tokenizer->decode($id_parent));
        $CatalogproductrelatedEntity->id_product($Tokenizer->decode($id));
        
        
        if($CatalogproductrelatedModel->eliminar($CatalogproductrelatedEntity->getArrayCopy()) != REGISTRO_SUCCESS)
        {
            $respuesta["error"] = true;
            $respuesta["message"] = $MyMessageAlert->Message("catalog_products_error_relacionar_eliminar");
        }
    }
    else
    {
        $respuesta["error"] = true;
        $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
    }
    return $respuesta;
}

function ajax_products_cargarProductosRelacionados($id)
{
    global $MyAccessList;
    global $MyMessageAlert;
    global $MyConfigure;
    $respuesta =[];
    
    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_PRODUCTS_CATALOG))
    {
        $CatalogproductrelatedModel =  new \Catalog\model\CatalogproductrelatedModel();
        $CatalogproductrelatedEntity =  new \Catalog\entity\CatalogproductrelatedEntity();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $CatalogproductrelatedEntity->id_parent($Tokenizer->decode($id));
        $CatalogproductrelatedModel->setTampag(10000);
        $lista_admin_data =[];
        if($CatalogproductrelatedModel->getData($CatalogproductrelatedEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            $iRow = 0;
            while($registro = $CatalogproductrelatedModel->getRows())
            {
                $thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");


                $img = "";
                $_img = getCoreConfig('catalog/product/placeholder');
                if($_img != "" && file_exists(PROJECT_DIR.$_img))
                {
                    $img = makeHTMLImg(imageResize($_img,50,50, true),50,50,$registro['name']);
                }
                $registro["images"] = json_decode($registro["images"],true);
                if(!empty($registro['images']))
                {
                    foreach($registro["images"] as $foto)
                    {
                        if($foto['principal'] == 1)
                        {
                            if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/products/".$registro["id_product"].'/'.$foto['img']))
                            {
                                $img = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$registro["id_product"].'/'.$foto['img'],50,50, true);
                                $img = makeHTMLImg($img,50,50,$registro['name']);
                            }
                        }

                    }
                }

                $lista_admin_data[$iRow] = array_merge($registro,array(
                        "thisClass"     => $thisClass,
                        "id" => $Tokenizer->token('catalog_products',$registro["id_product"]),
                        "_id" => $registro["id_product"],
                        "images"     => $img,
                ));


                $iRow++;
            }
            
        }
        $respuesta['lista_admin_data_relacionados'] = ($lista_admin_data);
        $titulo_columnas_grid = array("_id" => "ID","images" => "Thumb", "name" =>  "Nombre","sku" => "SKU");
        $value_columnas_grid = array("_id" ,"images", "name","sku");

        $css_columnas_grid = array("_id" => "w-xxxx-2" ,"images" => "w-xxxx-2" , "name" => "w-xxxx-4", "sku" => "w-xxxx-2");


       

        $respuesta['html'] = render(PROJECT_DIR.'/modulos/catalog/diseno/admin/catalog_products/widget.relacionados.phtml',
                ['titulo_columnas_grid' =>$titulo_columnas_grid,
                 'value_columnas_grid' => $value_columnas_grid,
                 'css_columnas_grid' => $css_columnas_grid
                ]
        );
    }
    else
    {
        $respuesta["error"] = true;
        $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
    }
    return $respuesta;
}
/******************************** EJECUTA *************************/
$MyAjax->register("DeleteCatalogCategory");
$MyAjax->register("DeleteCatalogSubcategory");
$MyAjax->register("DeleteCatalogProduct");
$MyAjax->register("setOrdenImagesProducts");
$MyAjax->register("eliminarFotoCatalogProduct");
$MyAjax->register("ajax_products_agregarProductoRelacionado");
$MyAjax->register("ajax_products_quitarProductoRelacionado");
$MyAjax->register("ajax_products_cargarProductosRelacionados");

?>
