<?php
use Franky\Core\validaciones;
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Catalog\entity\CatalogsubcategoryproductEntity;
use Catalog\model\CatalogsubcategoryproductModel;
use Base\entity\redireccionesEntity;
use Franky\Filesystem\File;
use Franky\Haxor\Tokenizer;
use Base\model\CustomattributesModel;
use Base\entity\CustomattributesEntity;
use Base\model\CustomattributesvaluesModel;
use Base\entity\CustomattributesvaluesEntity;
use Franky\Core\ObserverManager;

$Tokenizer = new Tokenizer();
$CatalogsubcategoryproductEntity    = new CatalogsubcategoryproductEntity();
$CatalogsubcategoryproductModel     = new CatalogsubcategoryproductModel();
$CatalogproductsModel               = new CatalogproductsModel();
$CatalogproductsEntity              = new CatalogproductsEntity($MyRequest->getRequest());
$CustomattributesModel              = new CustomattributesModel();
$CustomattributesEntity             = new CustomattributesEntity();
$CustomattributesvaluesModel              = new CustomattributesvaluesModel();
$CustomattributesvaluesEntity             = new CustomattributesvaluesEntity();



$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$CatalogproductsEntity->id($Tokenizer->decode($MyRequest->getRequest('id')));
$id = $CatalogproductsEntity->id();
$category  = $MyRequest->getRequest('category');
$subcategory  = $MyRequest->getRequest('subcategory');
$description  = $MyRequest->getRequest('description','',true);
$principal  = $MyRequest->getRequest('principal');
$CatalogproductsEntity->description($description);
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



$custom_imputs = [];
$CustomattributesEntity->entity("catalog_products");
$CustomattributesEntity->status(1);
$CustomattributesModel->setTampag(100);
$CustomattributesModel->getData($CustomattributesEntity->getArrayCopy());
while($data_attrs = $CustomattributesModel->getRows()){
    
    $custom_imputs[] = ['id' => $data_attrs['id'],'name' => $data_attrs['name']];
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

    
    if(isset($_SESSION['album_'.$album]) && !empty($_SESSION['album_'.$album]))
    {

        foreach($_SESSION['album_'.$album]  as $k => $foto)
        {
            if(md5($foto['img']) == $principal)
            {
                $_SESSION['album_'.$album][$k]['principal'] = 1;
            }
            else{
                $_SESSION['album_'.$album][$k]['principal'] = 0;
            }
        }
    }
    
 
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

        $ObserverManager = new ObserverManager;

        if(empty($id))
        {
            $id = $CatalogproductsModel->getUltimoID();
          
            $dir = $MyConfigure->getServerUploadDir()."/catalog/products/$album/";
            rename($dir,str_replace($album,$id,$dir));
            $CatalogproductsEntity->id($id);
            
            $ObserverManager->dispatch('save_catalog_product',['data' => $CatalogproductsEntity->getArrayCopy()]);
        
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        }
        else
        {
            $ObserverManager->dispatch('edit_catalog_product',['data' => $CatalogproductsEntity->getArrayCopy()]);
        
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }
        $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_CATALOG_PRODUCTS));
       
       
        $CatalogsubcategoryproductEntity->id_product($id);
        $CatalogsubcategoryproductModel->remove($CatalogsubcategoryproductEntity->getArrayCopy());     
        foreach($category_subcategory as $cat => $subcat)
        {
            foreach($subcat as $id_sub)
            {  
                $CatalogsubcategoryproductEntity->id_subcategory($id_sub);
                $CatalogsubcategoryproductModel->save($CatalogsubcategoryproductEntity->getArrayCopy());   
            }
        }

        $CustomattributesvaluesEntity->id_ref($id);
        $CustomattributesvaluesEntity->entity("catalog_products");
        $CustomattributesvaluesModel->remove($CustomattributesvaluesEntity->getArrayCopy());

        foreach($custom_imputs as $input)
        {
            $CustomattributesvaluesEntity->id_attribute($input['id']);
            $name = str_replace("[]", "", $input['name']);
            $value = (is_array($MyRequest->getRequest($name)) ? json_encode($MyRequest->getRequest($name)) : $MyRequest->getRequest($name));
            $CustomattributesvaluesEntity->value($value);
            $CustomattributesvaluesModel->save($CustomattributesvaluesEntity->getArrayCopy());
        }


        
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
