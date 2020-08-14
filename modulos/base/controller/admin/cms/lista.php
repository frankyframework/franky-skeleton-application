<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');

$MyCMS = new \Base\model\CMS;

$MyCMS->setPage($MyPaginacion->getPage());
$MyCMS->setTampag($MyPaginacion->getTampageDefault());
$MyCMS->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$result	 		= $MyCMS->getData('', $busca_b);
$MyPaginacion->setTotal($MyCMS->getTotal());


$lista_admin_data = array();
if($MyCMS->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $MyCMS->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

                $lista_admin_data[] = array_merge($registro,array(
                    "fecha"        => getFechaUI($registro["fecha"]),
                    "friendly"     => '<a href="'.$MyRequest->link($registro['friendly']).'" target="_blank">'.$registro['titulo'].'</a>',
                    "thisClass"     => $thisClass,
                    "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar")
                ));
                $iRow++;
        }
}



$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "CMS";
$class_grid = "cont_cms";
$error_grid = "No hay CMS registrados";
$deleteFunction ="EliminarCMSTemplate";
$frm_constante_link = FRM_CMS_TEMPLATE;
$titulo_columnas_grid = array("id" => "ID","fecha" => "Fecha", "titulo" =>  "Titulo",'friendly' => "URL");
$value_columnas_grid = array("id" ,"fecha" , "titulo", "friendly");

$css_columnas_grid = array("id" => "w-xxxx-1" ,"fecha" => "w-xxxx-2" , "titulo" => "w-xxxx-3" , "friendly" => "w-xxxx-3" );

$permisos_grid = ADMINISTRAR_CMS_TEMPLATE;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
