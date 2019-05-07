<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Base\model\USERS;
use Franky\Haxor\Tokenizer;
$MyUser             = new USERS();
$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"usuario"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');
$nivel_b	= $MyRequest->getRequest('nivel_b');
$rango_inicial  = $MyRequest->getRequest("rango_inicial","");
$rango_final    = $MyRequest->getRequest("rango_final","");

$rango = array();

if(!empty($rango_inicial) && !empty($rango_final))
{
    $rango = [$rango_inicial,$rango_final];
}
if(!empty($rango_inicial) && empty($rango_final))
{
    $rango = [$rango_inicial,date('Y-m-d')];
}
if(empty($rango_inicial) && !empty($rango_final))
{
    $rango = ['1900-01-01',$rango_final];
}
$MyUser->setRango($rango);

$MyUser->setPage($MyPaginacion->getPage());
$MyUser->setTampag($MyPaginacion->getTampageDefault());
$MyUser->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());
$result	 		= $MyUser->getData('', $busca_b,$nivel_b,'');
$MyPaginacion->setTotal($MyUser->getTotal());
$lista_admin_data = array();
if($MyUser->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $MyUser->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");


                $lista_admin_data[] = array_merge($registro,array(
                "thisClass"     => $thisClass,
                "id" => $Tokenizer->token("users", $registro["id"]),
                "callback" => $Tokenizer->token("users", $MyRequest->getURI()),
                "nivel"         => $_Niveles_usuarios[$registro["nivel"]],
                "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
                "fecha"         => getFechaUI($registro["fecha"]),
                ));

                $iRow++;
        }


}


$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addFecha('rango_inicial');
$MyFiltrosForm->addFecha('rango_final');
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();
$MyFiltrosForm->addNivel();
$MyFiltrosForm->setOptionsInput("nivel_b", $_Niveles_usuarios);
$MyFiltrosForm->setAtributoInput("nivel_b", "value", $nivel_b);
$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
$MyFiltrosForm->setAtributoInput("rango_inicial", "value",$rango_inicial);
$MyFiltrosForm->setAtributoInput("rango_final", "value",$rango_final);
$MyFiltrosForm->setAtributoInput("rango_inicial", "placeholder","Desde");
$MyFiltrosForm->setAtributoInput("rango_final", "placeholder","Hasta");
?>
