<?php
use modulos\base\Form\filtrosForm;
use Franky\Core\paginacion;
use modulos\base\vendor\model\UserdeviceModel;
use modulos\base\vendor\entity\UserdeviceEntity;
use Franky\Haxor\Tokenizer;
$MyPaginacion = new paginacion();
$UserdeviceModel = new UserdeviceModel();
$UserdeviceEntity = new UserdeviceEntity();
$Tokenizer = new Tokenizer();


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"access_last"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));

$UserdeviceModel->setPage($MyPaginacion->getPage());
$UserdeviceModel->setTampag($MyPaginacion->getTampageDefault());
$UserdeviceModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$result	 = $UserdeviceModel->getData($UserdeviceEntity->getArrayCopy());
$MyPaginacion->setTotal($UserdeviceModel->getTotal());


$lista_admin_data = array();
if($UserdeviceModel->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $UserdeviceModel->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

                $lista_admin_data[] = array_merge($registro,array(
								"id" => $Tokenizer->token("devices", $registro["id"]),
                "access_last"         => getFechaUI($registro["access_last"]),
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
                "delete"  =>  "desactivar"
		));

                $iRow++;
        }
}


$MyFiltrosForm = new filtrosForm('paginar');
$deleteFunction ="BloquearDispositivo";
?>
