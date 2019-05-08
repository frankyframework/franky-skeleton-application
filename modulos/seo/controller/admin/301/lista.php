<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');

$MyRedireccion->setPage($MyPaginacion->getPage());
$MyRedireccion->setTampag($MyPaginacion->getTampageDefault());
$MyRedireccion->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$result	 = $MyRedireccion->getData("",$busca_b);
$MyPaginacion->setTotal($MyRedireccion->getTotal());


$lista_admin_data = array();
if($MyRedireccion->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $MyRedireccion->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

                $p = explode(" ", $registro["fecha"]);
                $f = explode("-", $p[0]);
                $fecha = $f[2] . " " . $_Months[$f[1]] . " " . $f[0] . " " . substr($p[1], 0, -3) . " Hrs.";


                $lista_admin_data[] = array_merge($registro,array(
                "fecha"         => $fecha,
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar")
		));


                $iRow++;
        }
}




$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Redirecciones 301";
$class_grid = "cont_301";
$deleteFunction = "EliminarRedireccion";
$error_grid = "No hay redireccionamientos registrados";
$frm_constante_link = FRM_REDIRECCIONES_301;
$titulo_columnas_grid = array("fecha" => "Fecha","url" => "Url", "redireccion" =>  "Redirección");
$value_columnas_grid = array("fecha" ,"url" , "redireccion");


$css_columnas_grid = array("fecha" => "w-xxxx-2" ,"url" => "w-xxxx-4", "redireccion" => "w-xxxx-4" );

$permisos_grid = ADMINISTRAR_REDIRECCIONES_301;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
