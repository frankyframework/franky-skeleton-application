<?php
use Base\\Form\filtrosForm;
use Franky\\Core\\paginacion;
use {modulo}\\model\\{modelo};
use Franky\\Haxor\\Tokenizer;

${modelo}             = new {modelo}();
$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');



${modelo}->setPage($MyPaginacion->getPage());
${modelo}->setTampag($MyPaginacion->getTampageDefault());
${modelo}->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());
$result	 		= ${modelo}->getData();
$MyPaginacion->setTotal(${modelo}->getTotal());
$lista_admin_data = array();


if(${modelo}->getTotal() > 0)
{

	$iRow = 0;

	while($registro = ${modelo}->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");


                $lista_admin_data[] = array_merge($registro,array(
                "thisClass"     => $thisClass,
								"id" => $Tokenizer->token("{seccion}", $registro["id"]),
								"callback" => $Tokenizer->token("{seccion}", $MyRequest->getURI()),
               "nuevo_estado"  =>($registro["status"] == 1 ?"desactivar" : "activar")
                ));

                $iRow++;
        }


}



$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "";
$class_grid = "";
$error_grid = "";
$deleteFunction = "";
$frm_constante_link = "";
$titulo_columnas_grid = array();
$value_columnas_grid = array();
$css_columnas_grid = array();
$permisos_grid = "";

$MyFiltrosForm = new filtrosForm('paginar');

$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
