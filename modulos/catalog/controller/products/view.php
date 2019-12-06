<?php
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Franky\Haxor\Tokenizer;

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
  $data_detalle["galeria"] = json_decode($data_detalle["images"],true);
  $data_detalle["tags"] = explode(",",$data_detalle["meta_keyword"]);
  $data_detalle["id_categoria"] = json_decode($data_detalle["category"],true);
 
  $img = "";
  $_img = getCoreConfig('catalog/product/placeholder');
  if($_img != "" && file_exists(PROJECT_DIR.$_img))
  {
    $data_detalle["thumb"] = imageResize($_img,271,176, true);
  }
 
  if(!empty($data_detalle["galeria"]))
  {
      foreach($data_detalle["galeria"] as $foto)
      {
          if($foto['principal'] == 1)
          {
               if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img']))
              {
                $data_detalle["thumb"]  = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img'],271,176, true);
              }
          }

      }

    }
  $MyMetatag->setTitulo($data_detalle['meta_title']);
  $MyMetatag->setDescripcion($data_detalle['meta_description']);
  $MyMetatag->setKeywords($data_detalle['meta_keywords']);

}
else{
    $MyRequest->redirect($MyRequest->url(CATALOG_SEARCH),"301");
}

$data_detalle['id_ori'] =$data_detalle['id'];
$data_detalle['id'] = $Tokenizer->token('catalog_products', $data_detalle['id']);


//print_r($data_detalle);