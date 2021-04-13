<?php
use Base\Form\filtrosForm;
use Blog\model\categoriasBlog;
use Franky\Core\paginacion;
$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));		
$busca_b	= $MyRequest->getRequest('busca_b');	

$MyCategoriaBlog = new categoriasBlog();


if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $lang_b	= $MyRequest->getRequest('lang_b',$_SESSION['lang'] );
    $idiomas_disponibles = getCoreConfig('base/theme/langs');
    $MyCategoriaBlog->setLang($lang_b);

}




$MyCategoriaBlog->setPage($MyPaginacion->getPage());
$MyCategoriaBlog->setTampag($MyPaginacion->getTampageDefault());
$MyCategoriaBlog->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$status_b = "";
if(getCoreConfig('blog/registers/showdelete') == 0){
        $status_b = 1;
}

$result	 = $MyCategoriaBlog->getData('',$status_b,$busca_b);
$MyPaginacion->setTotal($MyCategoriaBlog->getTotal());

$lista_admin_data = array();
if($MyCategoriaBlog->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $MyCategoriaBlog->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
	
		$lista_admin_data[] = array_merge($registro,array(
                "fecha" 	=> getFechaUI($registro["fecha"]),
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                ));
                $iRow++;
        }
}



//$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Categorias";
$class_grid = "cont_categorias_blog";
$error_grid = "No hay categorias registradas";
$deleteFunction = "EliminarCategoriaBlog";
$frm_constante_link = ADMIN_FRM_CATEGORIAS_BLOG;
$titulo_columnas_grid = array("fecha" => "Fecha","nombre" => "Nombre");
$value_columnas_grid = array("fecha", "nombre" );

$css_columnas_grid = array("fecha" => "w-xxxx-5" ,"nombre" => "w-xxxx-5" );

$permisos_grid = ADMINISTRAR_CATEGORIAS_BLOG;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());


if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $idiomas = array();
    foreach($idiomas_disponibles as $idioma)
    {
        $idiomas[$idioma] = $idioma;
    }
    $MyFiltrosForm->addLang();
    $MyFiltrosForm->setOptionsInput("lang_b", $idiomas);
    $MyFiltrosForm->setAtributoInput("lang_b","value",$lang_b);

}


$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>