<?php
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Catalog\model\CatalogcategoryModel;
use Catalog\entity\CatalogcategoryEntity;
use Franky\Haxor\Tokenizer;
use Franky\Core\paginacion;

$q = $MyRequest->getRequest('q');
$categoria      = $MyRequest->getUrlParam('categoria',$MyRequest->getRequest('categoria'));
$precio	= $MyRequest->getRequest('precio');


$MyPaginacion = new paginacion();
$CatalogproductsModel = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$CatalogcategoryModel = new CatalogcategoryModel();
$CatalogcategoryEntity = new CatalogcategoryEntity();
$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();

if(!empty($categoria))
{
    $CatalogproductsModel->setCategoriaArray($categoria);
}


if(!empty($precio))
{
    $precio = explode("-", $precio);
    if(is_array($precio))
    {

        $precio[0] = intval(preg_replace('/[^0-9]+/', '',  $precio[0]), 10);
        $precio[1] = intval(preg_replace('/[^0-9]+/', '', $precio[1]), 10);

      $CatalogproductsModel->setPrecioArray($precio);
    }
}


$por = $MyRequest->getRequest('por',"catalog_products.name");
if(empty($por))
{
  $por= "catalog_products.name";
}

$order = $MyRequest->getRequest('order',"ASC");
if(empty($por))
{
  $order= "ASC";
}
$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($por);
$MyPaginacion->setOrden($MyRequest->getRequest('order',$order));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',12));
$MyPaginacion->setTamanosValidos([12,24,48]);

$CatalogproductsModel->setPage($MyPaginacion->getPage());
$CatalogproductsModel->setTampag($MyPaginacion->getTampageDefault());
$CatalogproductsModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$CatalogproductsEntity->status(1);
$CatalogproductsModel->setBusca($q);
$resultados_pagina = array();
if($CatalogproductsModel->getDataSearch($CatalogproductsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
{
    $MyPaginacion->setTotal($CatalogproductsModel->getTotal());

    if($CatalogproductsModel->getTotal() > 0)
    {
    	while($registro = $CatalogproductsModel->getRows())
    	{



          $registro['link'] = $MyRequest->url(CATALOG_VIEW,['friendly' => $registro['url_key']]);
            $registro['thumb_resize'] =  "";
          $img = "";
          $_img = getCoreConfig('catalog/product/placeholder');
          if($_img != "" && file_exists(PROJECT_DIR.$_img))
          {
            $registro['thumb_resize'] = imageResize($_img,400,400, true);
          }
          $registro["images"] = json_decode($registro["images"],true);
          
          if(!empty($registro['images']))
          {
              foreach($registro["images"] as $foto)
              {
               
                  if($foto['principal'] == 1)
                  {
                   
                      if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img']))
                      {
                   
                            $registro['thumb_resize'] = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img'],400,400, true);
                          
                      }
                  }
  
              }
          }
          $registro['id'] = $Tokenizer->token('catalog_products',$registro["id"]);
       


          $resultados_pagina[] = $registro;
      }
  }
}

if($MyRequest->isAjax())
{
  echo render(PROJECT_DIR.'/modulos/catalog/diseno/products/lista.phtml');
  die;
}

?>
