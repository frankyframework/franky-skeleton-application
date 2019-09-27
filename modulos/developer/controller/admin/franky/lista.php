<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Developer\model\ORGANOS;

$OrganosCorporales  = new ORGANOS();
$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"nombre"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));			
$busca_b	= $MyRequest->getRequest('busca_b');	

$OrganosCorporales->setBusca($busca_b);
$OrganosCorporales->setPage($MyPaginacion->getPage());
$OrganosCorporales->setTampag($MyPaginacion->getTampageDefault());
$OrganosCorporales->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());
$result	= $OrganosCorporales->getData('', "","","");
$MyPaginacion->setTotal($OrganosCorporales->getTotal());

$lista_admin_data = array();
if($OrganosCorporales->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $OrganosCorporales->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
		
                 $lista_admin_data[] = array_merge($registro,array(
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar")
                ));
                $iRow++;
        }
}


$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Administrar páginas";
$class_grid = "cont_paginas";
$error_grid = "No hay paginas creadas";
$deleteFunction = "EliminarPagina";
$frm_constante_link = FRM_PAGINAS;
$titulo_columnas_grid = array("nombre" => "Nombre","url" => "Url", "constante" =>  "Constante", "php" => "PHP");
$value_columnas_grid = array("nombre","url" , "constante", "php");
$css_columnas_grid = array("nombre" =>"w-xxxx-2","url"  =>"w-xxxx-2", "constante" =>"w-xxxx-3", "php" =>"w-xxxx-3");
$permisos_grid = ADMINISTRAR_FRANKY;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>