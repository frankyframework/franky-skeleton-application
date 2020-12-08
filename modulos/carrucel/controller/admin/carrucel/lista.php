<?php
use Base\Form\filtrosForm;
use Carrucel\model\CarrucelcarrucelesModel;
use Carrucel\entity\CarrucelcarrucelesEntity;
use Franky\Core\paginacion;
use Franky\Haxor\Tokenizer;

$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"createdAt"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));		
$busca_b	= $MyRequest->getRequest('busca_b');	


$CarrucelcarrucelesModel =  new CarrucelcarrucelesModel();
$CarrucelcarrucelesEntity =  new CarrucelcarrucelesEntity();
$CarrucelcarrucelesModel->setPage($MyPaginacion->getPage());
$CarrucelcarrucelesModel->setTampag($MyPaginacion->getTampageDefault());
$CarrucelcarrucelesModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$result	 = $CarrucelcarrucelesModel->getData([]);
$MyPaginacion->setTotal($CarrucelcarrucelesModel->getTotal());

$lista_admin_data = array();
if($CarrucelcarrucelesModel->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $CarrucelcarrucelesModel->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
                

		$lista_admin_data[] = array_merge($registro,array(
                "id" => $Tokenizer->token("carrucel", $registro["id"]),
                "callback" => $Tokenizer->token("carrucel", $MyRequest->getURI()),    
                "createdAt" 	=> getFechaUI($registro["createdAt"]),
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                ));
                $iRow++;
        }
}



//$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Carruceles";
$class_grid = "cont_sliders";
$error_grid = "No hay carruceles registrados";
$deleteFunction = "carrucel_DeleteCarrucel";
$frm_constante_link = ADMIN_CARRUCEL_FORM;
$titulo_columnas_grid = array("createdAt" => "Fecha","nombre" => "Nombre","code" => "Code");
$value_columnas_grid = array("createdAt", "nombre","code" );

$css_columnas_grid = array("createdAt" => "w-xxxx-3" ,"nombre" => "w-xxxx-3" ,"code" => "w-xxxx-3" );

$permisos_grid = ADMINISTRAR_CARRUCEL;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
?>