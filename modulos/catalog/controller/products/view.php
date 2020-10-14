<?php
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Franky\Haxor\Tokenizer;
use Base\Form\contactanosForm;
use Catalog\model\CatalogproductrelatedModel;
use Catalog\entity\CatalogproductrelatedEntity;
use Catalog\schema\productSchema;
use Catalog\schema\offerSchema;


$offerSchema =  new offerSchema();
$productSchema = new productSchema();
$Tokenizer = new Tokenizer();

$CatalogproductsModel  = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$CatalogproductrelatedModel =  new CatalogproductrelatedModel();
$CatalogproductrelatedEntity =  new CatalogproductrelatedEntity();

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
  
    $data_detalle['thumb_resize'] =  "";
    $img = "";
    $_img = getCoreConfig('catalog/product/placeholder');
    if($_img != "" && file_exists(PROJECT_DIR.$_img))
    {
        $data_detalle['thumb_resize'] = imageResize($_img,500,500, false);
    }
    

    if(!empty($data_detalle['images']))
    {
        foreach($data_detalle["images"] as $foto)
        {

            if($foto['principal'] == 1)
            {

                if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/products/".$data_detalle["id"].'/'.$foto['img']))
                {

                        $data_detalle['thumb_resize'] = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$data_detalle["id_"].'/'.$foto['img'],500,500, false);

                }
            }

        }
    }

    $custom_attr = getDataCustomAttribute($data_detalle['id'],'catalog_products');
  
  $offerSchema->setPriceCurrency('MXN');
  $offerSchema->setPrice($data_detalle['price']);
  $productSchema->setName($data_detalle['name']);
  $productSchema->setUrl($MyRequest->url(CATALOG_SEARCH_CATEGORY,['friendly' => $friendly],true));
  $productSchema->setImage($MyRequest->link($data_detalle['thumb_resize'] ,false,true));
  $productSchema->setOffers(json_decode($offerSchema->get(false),true));
  $productSchema->setSku($data_detalle['sku']);
  $productSchema->setDescription($data_detalle['meta_description']);


  
  $MyMetatag->setTitulo($data_detalle['meta_title']);
  $MyMetatag->setDescripcion($data_detalle['meta_description']);
  $MyMetatag->setKeywords($data_detalle['meta_keywords']);
  $MyMetatag->setCode('<link rel="canonical" href="'. $MyRequest->url(CATALOG_SEARCH_CATEGORY,['friendly' => $friendly],true).'" />');

}
else{
    $MyRequest->redirect($MyRequest->url(CATALOG_SEARCH),"301");
}
$data_detalle['link'] = $MyRequest->url(CATALOG_SEARCH_CATEGORY,['friendly' => $data_detalle['url_key']]);
  
$data_detalle['id_ori'] =$data_detalle['id'];
$data_detalle['id_wishlist'] = $Tokenizer->token('wishlist',$data_detalle["id"]);

$data_detalle['id'] = $Tokenizer->token('catalog_products', $data_detalle['id']);

$contactanosForm = new contactanosForm("frmContacto");
$contactanosForm->setMobile($Mobile_detect->isMobile());

$contactanosForm->setData($MyFlashMessage->getResponse());
$contactanosForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('cantactanos_xsrf', time()));
$contactanosForm->setAtributoInput('asunto', 'value','SKU'.$data_detalle['sku'].': '.$data_detalle['name']);
$contactanosForm->setAtributoBase('asunto', 'type','hidden');
$contactanosForm->setAtributoInput('asunto', 'placeholder','');

$MyFrankyMonster->setPHPFile(getVista("products/view.phtml"));
//print_r($data_detalle);

$CatalogproductsEntity->exchangeArray([]);
$CatalogproductrelatedEntity->id_parent($data_detalle['id_ori']);
$CatalogproductrelatedModel->setTampag(10000);
$CatalogproductrelatedModel->setOrdensql('RAND()');
$CatalogproductsEntity->status(1);
$CatalogproductrelatedModel->setDataProduct($CatalogproductsEntity->getArrayCopy());
$lista_relacionados_data =[];
if($CatalogproductrelatedModel->getData($CatalogproductrelatedEntity->getArrayCopy()) == REGISTRO_SUCCESS)
{

    while($registro = $CatalogproductrelatedModel->getRows())
    {
        
        $registro['link'] = $MyRequest->url(CATALOG_SEARCH_CATEGORY,['friendly' => $registro['url_key']]);
        
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

                    if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/products/".$registro["id_product"].'/'.$foto['img']))
                    {

                          $registro['thumb_resize'] = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$registro["id_product"].'/'.$foto['img'],500,500, false);

                    }
                }

            }
        }

        $registro['id_wishlist'] = $Tokenizer->token('wishlist',$registro["id_product"]);

        $registro['id'] = $Tokenizer->token('catalog_products',$registro["id_product"]);
        $lista_relacionados_data[] = $registro;
      
    }
}
