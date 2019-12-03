<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Catalog\model\CatalogwhishlistModel;
use Catalog\entity\CatalogwhishlistEntity;
use Catalog\entity\CatalogexperienciaEntity;
use Franky\Haxor\Tokenizer;


$Tokenizer = new Tokenizer();
$MyPaginacion = new paginacion();
$CatalogexperienciaEntity = new CatalogexperienciaEntity();


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"Catalog_whishlist.fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');
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

$CatalogwhishlistModel = new CatalogwhishlistModel();
$CatalogwhishlistEntity = new CatalogwhishlistEntity();

$CatalogwhishlistModel->setPage($MyPaginacion->getPage());
$CatalogwhishlistModel->setTampag($MyPaginacion->getTampageDefault());
$CatalogwhishlistModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$CatalogwhishlistEntity->uid($MySession->GetVar('id'));

$result	 = $CatalogwhishlistModel->getData($CatalogwhishlistEntity->getArrayCopy(),$CatalogexperienciaEntity->getArrayCopy(),$busca_b,$rango);
$MyPaginacion->setTotal($CatalogwhishlistModel->getTotal());


$lista_admin_data = array();
$data_new_group = array();
if($CatalogwhishlistModel->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $CatalogwhishlistModel->getRows())
	{
		  $thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");


      $lista_admin_data[] = array_merge($registro,array(
        "id" => $Tokenizer->token("whishist", $registro["id"]),
      "fecha"         => getFechaUI($registro["fecha"]),
      "link"          => $MyRequest->url(CATALOG_VIEW,['friendly' => $registro['url_key']]),
      "thisClass"     => $thisClass,
      "nuevo_estado"  =>  "desactivar"
      ));

      $iRow++;
    }

}

$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();

$deleteFunction ="Catalog_EliminarWhislist";
$MyFiltrosForm->addFecha('rango_inicial');
$MyFiltrosForm->addFecha('rango_final');
$MyFiltrosForm->addSubmit();
$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
$MyFiltrosForm->setAtributoInput("rango_inicial", "value",$rango_inicial);
$MyFiltrosForm->setAtributoInput("rango_final", "value",$rango_final);
$MyFiltrosForm->setAtributoInput("rango_inicial", "placeholder","Desde");
$MyFiltrosForm->setAtributoInput("rango_final", "placeholder","Hasta");

?>
