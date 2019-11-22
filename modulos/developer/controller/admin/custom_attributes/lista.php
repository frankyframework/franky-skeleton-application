<?php
use Developer\Form\filtrosForm;
use Developer\model\CustomattributesModel;
use Developer\entity\CustomattributesEntity;
use Franky\Core\paginacion;
use Franky\Haxor\Tokenizer;

$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"createdAt"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));		
$busca_b	= $MyRequest->getRequest('busca_b');	
$entity_b	= $MyRequest->getRequest('entity_b');	


$CustomattributesModel = new CustomattributesModel();
$CustomattributesEntity = new CustomattributesEntity();

if(!empty($entity_b))
{
      $CustomattributesEntity->entity($entity_b);  
}

$CustomattributesModel->setPage($MyPaginacion->getPage());
$CustomattributesModel->setTampag($MyPaginacion->getTampageDefault());
$CustomattributesModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$CustomattributesModel->setBusca($busca_b);
$result	 = $CustomattributesModel->getData($CustomattributesEntity->getArrayCopy());
$MyPaginacion->setTotal($CustomattributesModel->getTotal());

$lista_admin_data = array();
if($CustomattributesModel->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $CustomattributesModel->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
        
		$lista_admin_data[] = array_merge($registro,array(
                "id" => $Tokenizer->token("custom_attributes", $registro["id"]),
                "callback" => $Tokenizer->token("custom_attributes", $MyRequest->getURI()),    
                "createdAt" 	=> getFechaUI($registro["createdAt"]),
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                ));
                $iRow++;
        }
}



$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Atributos presonalizados";
$class_grid = "cont_custom_attributes";
$error_grid = "No hay atributos registrados";
$deleteFunction = "DeleteCustomAttributes";
$frm_constante_link = FRM_CUSTOM_ATTRIBUTES;
$titulo_columnas_grid = array("createdAt" => "Fecha","name" => "Nombre","entity" => "Entidad");
$value_columnas_grid = array("createdAt", "name","entity" );

$css_columnas_grid = array("createdAt" => "w-xxxx-4" ,"name" => "w-xxxx-3" ,"entity" => "w-xxxx-3" );

$permisos_grid = ADMINISTRAR_CUSTOM_ATTRIBUTES;

$entidades = ['users' => "Usuarios"];
$modulos = getModulos();
if(in_array('catalog',$modulos))
{
    $entidades = ['users' => "Usuarios","catalog_products" => "Productos"];
}


$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addEntity();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setOptionsInput("entity", $entidades);


$MyFiltrosForm->setAtributoInput("entity", "value",$entity_b);
$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>