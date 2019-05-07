<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Base\model\TemplateemailModel;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer;
$MyPaginacion = new paginacion();
$TemplateemailModel    = new TemplateemailModel;


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');


$TemplateemailModel->setPage($MyPaginacion->getPage());
$TemplateemailModel->setTampag($MyPaginacion->getTampageDefault());
$TemplateemailModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$result	 = $TemplateemailModel->getData([],[], $busca_b);
$MyPaginacion->setTotal($TemplateemailModel->getTotal());
$lista_admin_data = array();
if($TemplateemailModel->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $TemplateemailModel->getRows())
	{
            $thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

            $lista_admin_data[] = array(
							"id" => $Tokenizer->token('templates',$registro["id"]),
							"callback" => $Tokenizer->token('templates',$MyRequest->getURI()),
                "fecha"        => getFechaUI($registro["fecha"]),
								  "templates_email.nombre"        => $registro["nombre"],
									  "secciones_transaccionales.nombre"        => $registro["seccion"],
                "thisClass"     => $thisClass,
                "nuevo_estado"  =>  ($registro["status"] == 1 ? "desactivar" : "activar"),
            );
            $iRow++;
        }
}


$title_grid = "E-mails transaccionales";
$class_grid = "cont_transaccionales";
$error_grid = "No hay templates de email registrados";
$deleteFunction = "EliminarTemplate";
$frm_constante_link = FRM_EMAIL_TEMPLATE;
$titulo_columnas_grid = array("fecha" => "Fecha", "templates_email.nombre" =>  "Nombre","secciones_transaccionales.nombre" =>  "Sección");
$value_columnas_grid = array("fecha" , "templates_email.nombre","secciones_transaccionales.nombre" );

$css_columnas_grid = array("fecha" => "w-xxxx-2" , "templates_email.nombre" => "w-xxxx-4" ,"secciones_transaccionales.nombre" => "w-xxxx-4" );

$permisos_grid = ADMINISTRAR_EMAIL_TEMPLATE;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
