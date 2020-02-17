<?php
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Franky\Haxor\Tokenizer;
use Base\Form\contactanosForm;


$Tokenizer = new Tokenizer();

$CatalogproductsModel  = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$categorys = getCatalogCategorys('sql');
$subcategorys = getCatalogSubcategorys(null,'sql');


$friendly		= $MyRequest->getUrlParam('friendly');
$categoria		= $MyRequest->getUrlParam('categoria');

$CatalogproductsEntity->url_key($friendly);
$CatalogproductsEntity->status(1);

if($CatalogproductsModel->getData($CatalogproductsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
{

  $data_detalle = $CatalogproductsModel->getRows();
  $data_detalle["videos"] = json_decode($data_detalle["videos"],true);
  $data_detalle["images"] = json_decode($data_detalle["images"],true);
  $data_detalle["tags"] = explode(",",$data_detalle["meta_keyword"]);
  $data_detalle["id_categoria"] = json_decode($data_detalle["category"],true);
  
  
 

  $MyMetatag->setTitulo($data_detalle['meta_title']);
  $MyMetatag->setDescripcion($data_detalle['meta_description']);
  $MyMetatag->setKeywords($data_detalle['meta_keywords']);
  $MyMetatag->setCode('<link rel="canonical" href="'. $MyRequest->url(CATALOG_VIEW,['friendly' => $friendly],true).'" />');

}
else{
    $MyRequest->redirect($MyRequest->url(CATALOG_SEARCH),"301");
}
$data_detalle['link'] = $MyRequest->url(CATALOG_VIEW,['friendly' => $data_detalle['url_key']]);
  
$data_detalle['id_ori'] =$data_detalle['id'];
$data_detalle['id_wishlist'] = $Tokenizer->token('wishlist',$data_detalle["id"]);

$data_detalle['id'] = $Tokenizer->token('catalog_products', $data_detalle['id']);

$contactanosForm = new contactanosForm("frmContacto");
$contactanosForm->setMobile($Mobile_detect->isMobile());

$contactanosForm->setData($MyFlashMessage->getResponse());
$contactanosForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('cantactanos_xsrf', time()));
$contactanosForm->setAtributoInput('asunto', 'value','SKU'.$data_detalle['sku'].': '.$data_detalle['name']);
$contactanosForm->setAtributoBase('asunto', 'type','hidden');
$contactanosForm->setAtributoBase('asunto', 'atributos',array(
  'class'       => 'required',
  'maxlength' => 200,
  'minlength' => 5,
));


//print_r($data_detalle);