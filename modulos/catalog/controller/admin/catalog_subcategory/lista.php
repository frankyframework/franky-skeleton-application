<?php
use Catalog\Form\filtrosForm;
use Catalog\model\CatalogsubcategoryModel;
use Catalog\entity\CatalogsubcategoryEntity;
use Franky\Core\paginacion;
use Franky\Haxor\Tokenizer;

$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();

$alias = [
        'createdAt' => 'catalog_subcategory.createdAt',
        'name' => 'catalog_subcategory.name',
        'image' => 'catalog_subcategory.image',
        'categoria' => 'catalog_category.name',

];

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"createdAt"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));		

$busca_b	= $MyRequest->getRequest('busca_b');	
$category_b	= $MyRequest->getRequest('id_category');

$catalog_categorias = getCatalogCategorys('sql');

$CatalogsubcategoryModel = new CatalogsubcategoryModel();
$CatalogsubcategoryEntity = new CatalogsubcategoryEntity();

$CatalogsubcategoryModel->setPage($MyPaginacion->getPage());
$CatalogsubcategoryModel->setTampag($MyPaginacion->getTampageDefault());
$CatalogsubcategoryModel->setOrdensql($alias[$MyPaginacion->getCampoOrden()]." ".$MyPaginacion->getOrden());

$CatalogsubcategoryModel->setBusca($busca_b);
if(!empty($category_b))
{
        $CatalogsubcategoryEntity->id_category($category_b);
}

$result	 = $CatalogsubcategoryModel->getData($CatalogsubcategoryEntity->getArrayCopy());
$MyPaginacion->setTotal($CatalogsubcategoryModel->getTotal());


$lista_admin_data = array();
if($CatalogsubcategoryModel->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $CatalogsubcategoryModel->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
                $img = "";
                if(!empty($registro["image"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/category/".$registro["image"]))
                {
                    $img = imageResize($MyConfigure->getUploadDir()."/catalog/category/".$registro["image"],50,50, true);
                    $img = makeHTMLImg($img,50,50,$registro['name']);
                }


		$lista_admin_data[] = array_merge($registro,array(
                "id" => $Tokenizer->token("subcategory", $registro["id"]),
                "callback" => $Tokenizer->token("subcategory", $MyRequest->getURI()),    
                "createdAt" 	=> getFechaUI($registro["createdAt"]),
                "thisClass"     => $thisClass,
                "image"     => $img,
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                ));
                $iRow++;
        }
}



$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Subcategorias";
$class_grid = "cont_subcategorias_catalog";
$error_grid = "No hay sucategorias registradas";
$deleteFunction = "DeleteCatalogSubcategory";
$frm_constante_link = FRM_CATALOG_SUBCATEGORY;
$titulo_columnas_grid = array("createdAt" => "Fecha","name" => "Nombre","categoria" => "Categoria","image" => "Imagen");
$value_columnas_grid = array("createdAt", "name","categoria","image" );

$css_columnas_grid = array("createdAt" => "w-xxxx-2" ,"name" => "w-xxxx-3" ,"categoria" => "w-xxxx-3" ,"image" => "w-xxxx-2" );

$permisos_grid = ADMINISTRAR_CATEGORY_CATALOG;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addCategory();
$MyFiltrosForm->addSubmit();
$MyFiltrosForm->setOptionsInput("id_category", $catalog_categorias);

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
$MyFiltrosForm->setAtributoInput("id_category", "value",$category_b);

?>