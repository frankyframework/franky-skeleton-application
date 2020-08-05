<?php
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Catalog\model\CatalogcategoryModel;
use Catalog\entity\CatalogcategoryEntity;
use Franky\Haxor\Tokenizer;
use Franky\Core\paginacion;
use Catalog\schema\productSchema;
use Catalog\schema\offerSchema;
use Catalog\schema\itemListSchema;



$itemListSchema =  new itemListSchema();

$q = $MyRequest->getRequest('q');

$precio	= $MyRequest->getRequest('precio');

$image_category = '';
if($MyFrankyMonster->MySeccion() == CATALOG_SEARCH_CATEGORY)
{
    $categoria      = $MyRequest->getUrlParam('friendly',$MyRequest->getRequest('categoria'));
    $image_category = getImageCategorys($categoria);   
}
elseif($MyFrankyMonster->MySeccion() == CATALOG_SEARCH_SUBCATEGORY)
{
    $categoria      = $MyRequest->getUrlParam('categoria',$MyRequest->getRequest('categoria'));
    $subcategoria      = $MyRequest->getUrlParam('friendly',$MyRequest->getRequest('subcategoria'));
    $image_category = getImageSubcategorys($subcategoria);   
}
else{
    $categoria      = $MyRequest->getRequest('categoria');
    $subcategoria = $MyRequest->getRequest('subcategoria');
}




$CatalogproductsModel = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$CatalogcategoryModel = new CatalogcategoryModel();
$CatalogcategoryEntity = new CatalogcategoryEntity();
$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();

if(!empty($categoria))
{
  if(is_array($categoria))
  {
    $CatalogproductsModel->setCategoriaArray($categoria);

  }else {
    $CatalogproductsModel->setCategoriaArray([$categoria]);
  }

}

if(!empty($subcategoria))
{
  if(is_array($subcategoria))
  {
    $CatalogproductsModel->setSubcategoriaArray($subcategoria);

  }else {
    $CatalogproductsModel->setSubcategoriaArray([$subcategoria]);
  }

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
    $itemListSchema->setNumberOfItems($CatalogproductsModel->getTotal());
    $itemListSchema->setUrl($MyRequest->link($MyRequest->getURI().'?'.$MyRequest->getQuery(),false,true));
    if($CatalogproductsModel->getTotal() > 0)
    {
    	while($registro = $CatalogproductsModel->getRows())
    	{


        if(in_array($MyFrankyMonster->MySeccion(),[CATALOG_SEARCH_CATEGORY])):

          $registro['link'] = $MyRequest->url(CATALOG_SEARCH_SUBCATEGORY,['categoria'  =>$categoria, 'friendly' => $registro['url_key']]);
        elseif(in_array($MyFrankyMonster->MySeccion(),[CATALOG_SEARCH_SUBCATEGORY])):

            $registro['link'] = $MyRequest->url(CATALOG_VIEW_SUBCAT,['categoria'  =>$categoria,'subcategoria'  =>$subcategoria, 'friendly' => $registro['url_key']]);

        else:
          $registro['link'] = $MyRequest->url(CATALOG_SEARCH_CATEGORY,['friendly' => $registro['url_key']]);

        endif;
          $registro['thumb_resize'] =  "";
          $img = "";
          $_img = getCoreConfig('catalog/product/placeholder');
          if($_img != "" && file_exists(PROJECT_DIR.$_img))
          {
            $registro['thumb_resize'] = imageResize($_img,500,500, false);
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

                            $registro['thumb_resize'] = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img'],500,500, false);

                      }
                  }

              }
          }
         
           $registro['id_wishlist'] = $Tokenizer->token('wishlist',$registro["id"]);

            $registro['id'] = $Tokenizer->token('catalog_products',$registro["id"]);

          $resultados_pagina[] = $registro;

          $offerSchema =  new offerSchema();
          $productSchema = new productSchema();

          $offerSchema->setPriceCurrency('MXN');
          $offerSchema->setPrice($registro['price']);
          $productSchema->setName($registro['name']);
          $productSchema->setUrl($MyRequest->link($registro['link'],false,true));
          $productSchema->setImage($MyRequest->link($registro['thumb_resize'],false,true));
          $productSchema->setOffers(json_decode($offerSchema->get(false),true));
          $productSchema->setDescription($registro['meta_description']);
          $productSchema->setSku($registro['sku']);
          $itemListSchema->setItemListElement(json_decode($productSchema->get(false),true));

          
      }
  }
}
$MyFrankyMonster->setPHPFile(getVista("products/lista.phtml"));
if($MyRequest->isAjax())
{
  echo render(PROJECT_DIR.'/modulos/catalog/diseno/products/lista.phtml');
  die;
}

?>
