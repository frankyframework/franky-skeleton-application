<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Franky\Haxor\Tokenizer;



$CatalogproductsModel = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$Tokenizer = new Tokenizer();

$MyPaginacion = new paginacion();


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"catalog_products.createdAt"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');


$alias = ['_id' => "catalog_products.id"];
if(isset($alias[$MyRequest->getRequest('por')]))
{

  $orden = $alias[$MyRequest->getRequest('por')];
}
else{
    $orden = $MyPaginacion->getCampoOrden();
}

if(getCoreConfig('catalog/product/showdelete') == 0){
    $CatalogproductsEntity->status(1);
}

$CatalogproductsModel->setPage($MyPaginacion->getPage());
$CatalogproductsModel->setTampag($MyPaginacion->getTampageDefault());
$CatalogproductsModel->setOrdensql($orden." ".$MyPaginacion->getOrden());
$CatalogproductsModel->setBusca($busca_b);
$result	 		= $CatalogproductsModel->getData($CatalogproductsEntity->getArrayCopy());
$MyPaginacion->setTotal($CatalogproductsModel->getTotal());
$lista_admin_data = array();


if($CatalogproductsModel->getTotal() > 0)
{

    $iRow = 0;

    while($registro = $CatalogproductsModel->getRows())
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
                     if(!empty($foto["img"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img']))
                    {
                        $img = imageResize($MyConfigure->getUploadDir()."/catalog/products/".$registro["id"].'/'.$foto['img'],50,50, true);
                        $img = makeHTMLImg($img,50,50,$registro['name']);
                    }
                }

            }
        }
       
        $lista_admin_data[$iRow] = array_merge($registro,array(
                "thisClass"     => $thisClass,
                "id" => $Tokenizer->token('catalog_products',$registro["id"]),
                "_id" => $registro["id"],
                "callback" => $Tokenizer->token('catalog_products',$MyRequest->getURI()),
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                "images"     => $img,
        ));


        $iRow++;
    }
}
//$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Productos";
$class_grid = "products";
$error_grid = "No hay productos registrados";
$deleteFunction = "DeleteCatalogProduct";

$frm_constante_link = FRM_CATALOG_PRODUCTS;

$titulo_columnas_grid = array("_id" => "ID","images" => "Thumb", "name" =>  "Nombre","sku" => "SKU");
$value_columnas_grid = array("_id" ,"images", "name","sku");

$css_columnas_grid = array("_id" => "w-xxxx-1" ,"images" => "w-xxxx-2" , "name" => "w-xxxx-4", "sku" => "w-xxxx-1");


$permisos_grid = ADMINISTRAR_PRODUCTS_CATALOG;

$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
