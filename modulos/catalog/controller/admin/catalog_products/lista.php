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


$alias = ['createdAt' => "catalog_products.cias.createdAt"];
if(isset($alias[$MyRequest->getRequest('por')]))
{

  $MyPaginacion->setCampoOrden($alias[$MyRequest->getRequest('por')]);
}


$CatalogproductsModel->setPage($MyPaginacion->getPage());
$CatalogproductsModel->setTampag($MyPaginacion->getTampageDefault());
$CatalogproductsModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());
$result	 		= $CatalogproductsModel->getData($CatalogproductsEntity->getArrayCopy(),$busca_b);
$MyPaginacion->setTotal($CatalogproductsModel->getTotal());
$lista_admin_data = array();


if($CatalogproductsModel->getTotal() > 0)
{

    $iRow = 0;

    while($registro = $CatalogproductsModel->getRows())
    {
        $thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

       
        $lista_admin_data[$iRow] = array_merge($registro,array(
                "thisClass"     => $thisClass,
                "id" => $Tokenizer->token('catalog_products',$registro["id"]),
                "callback" => $Tokenizer->token('catalog_products',$MyRequest->getURI())
        ));


        $iRow++;
    }
}
$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Productos";
$class_grid = "products";
$error_grid = "No hay productos registrados";
$deleteFunction = "DeleteCatalogProduct";

$frm_constante_link = FRM_CATALOG_PRODUCTS;

$titulo_columnas_grid = array("createdAt" => "Fecha", "name" =>  "Nomre");
$value_columnas_grid = array("createdAt" , "name");

$css_columnas_grid = array("createdAt" => "w-xxxx-2" , "name" => "w-xxxx-4");


$permisos_grid = ADMINISTRAR_PRODUCTS_CATALOG;

$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
