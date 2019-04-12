<?php
use modulos\base\Form\filtrosForm;
use Franky\Core\paginacion;
use modulos\ecommerce\vendor\model\direcciones;

$MyDirecciones             = new direcciones();
$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));			
$busca_b	= $MyRequest->getRequest('busca_b');	
	


$MyDirecciones->setPage($MyPaginacion->getPage());
$MyDirecciones->setTampag($MyPaginacion->getTampageDefault());
$MyDirecciones->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());
$result	 		= $MyDirecciones->getData('', $MySession->GetVar('id'),"",$busca_b);
$MyPaginacion->setTotal($MyDirecciones->getTotal());
$lista_admin_data = array();


if($MyDirecciones->getTotal() > 0)
{
	
	$iRow = 0;	

	while($registro = $MyDirecciones->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
                
                
                $lista_admin_data[] = array_merge($registro,array(
                "thisClass"     => $thisClass,
               "nuevo_estado"  =>($registro["status"] == 1 ?"desactivar" : "activar")
                ));
                
                $iRow++;
        }
        
        
}


$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "Mis direcciones de envio";
$class_grid = "cont_direcciones";
$error_grid = "No hay direcciones registradas";
$deleteFunction = "EliminarDireccionEcommerce";
$frm_constante_link = FRM_DIRECCIONES_ECOMMERCE;
$titulo_columnas_grid = array("nombre" => "Nombre","calle" => "Direccion");
$value_columnas_grid = array("nombre","calle");
$permisos_grid = ADMINISTRAR_DIRECCIONES_ECOMMERCE;

$MyFiltrosForm = new filtrosForm('paginar');

$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>