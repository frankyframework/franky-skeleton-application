<?php
use Franky\Core\validaciones;
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Catalog\entity\CatalogsubcategoryproductEntity;
use Catalog\model\CatalogsubcategoryproductModel;
use Base\entity\redireccionesEntity;
use Franky\Filesystem\File;
use Franky\Haxor\Tokenizer;


$Tokenizer = new Tokenizer();
$CatalogproductsModel        = new CatalogproductsModel();
$CatalogproductsEntity       = new CatalogproductsEntity($MyRequest->getRequest());
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$CatalogproductsEntity->id($Tokenizer->decode($MyRequest->getRequest('id')));
$id = $CatalogproductsEntity->id();
$category  = $MyRequest->getRequest('category');
$subcategory  = $MyRequest->getRequest('subcategory');


$error = false;

if($CatalogproductsEntity->url_key() === "")
{
    $CatalogproductsEntity->url_key(getFriendly($CatalogproductsEntity->name()));
}
else{
    $CatalogproductsEntity->url_key(getFriendly($CatalogproductsEntity->url_key()));
}


$album = $MySession->GetVar('addProduct');

$validaciones =  new validaciones();


 $valid = $validaciones->validRules($CatalogproductsEntity->setValidation());


if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_PRODUCTS_CATALOG))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if(empty($category))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("catalog_empty_category"));
    $error = true;
}
if(empty($subcategory))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("catalog_empty_subcategory"));
    $error = true;
}

if(!$error)
{
    $subcategorias = getCatalogSubcategorys(null,'sql');
    $category_subcategory = [];
    foreach($subcategorias as $cat => $subcat)
    {
        if(in_array($cat,$category))
        {
            $category_subcategory[$cat] = array(); 
            foreach($subcat as $id_sub => $label)
            {
                if(in_array($id_sub,$subcategory))
                {
                    $category_subcategory[$cat][] = $id_sub; 
                }
            }
        }
        
    }
    $CatalogproductsEntity->category(json_encode($category_subcategory));

    $CatalogproductsEntity->images(json_encode($_SESSION['album_'.$album]));
    
    if(empty($id))
    {

        $CatalogproductsEntity->createdAt(date('Y-m-d H:i:s'));
        $CatalogproductsEntity->status(1);
    }
    else
    {
        $CatalogproductsEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $result = $CatalogproductsModel->save($CatalogproductsEntity->getArrayCopy());
    
   
    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {

            $dir = $MyConfigure->getServerUploadDir()."/catalog/products/$album/";
            rename($dir,str_replace($album,$CatalogproductsModel->getUltimoID(),$dir));


            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        }
        else
        {

             $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_CATALOG_PRODUCTS));

        $MySession->UnsetVar('album_'.$album);
        $MySession->UnsetVar('addProduct');


    }
    elseif($result == REGISTRO_ERROR)
    {

        if(empty($id))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
        }
        $location = $MyRequest->getReferer();
    }
    else
    {
        $MyFlashMessage->setMsg("error",$result);
        $location = $MyRequest->getReferer();
    }
}
else
{
    $location = $MyRequest->getReferer();
}


$MyRequest->redirect($location);
?>
