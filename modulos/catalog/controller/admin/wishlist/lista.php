<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Catalog\model\CatalogwishlistModel;
use Catalog\entity\CatalogwishlistEntity;
use Catalog\entity\CatalogproductsEntity;
use Franky\Haxor\Tokenizer;


$Tokenizer = new Tokenizer();
$MyPaginacion = new paginacion();
$CatalogproductsEntity = new CatalogproductsEntity();


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"catalog_wishlist.fecha"));
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

$CatalogwishlistModel = new CatalogwishlistModel();
$CatalogwishlistEntity = new CatalogwishlistEntity();

$CatalogwishlistModel->setPage($MyPaginacion->getPage());
$CatalogwishlistModel->setTampag($MyPaginacion->getTampageDefault());
$CatalogwishlistModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$CatalogwishlistEntity->uid($MySession->GetVar('id'));

$result	 = $CatalogwishlistModel->getData($CatalogwishlistEntity->getArrayCopy(),$CatalogproductsEntity->getArrayCopy(),$busca_b,$rango);
$MyPaginacion->setTotal($CatalogwishlistModel->getTotal());


$lista_admin_data = array();
$data_new_group = array();
if($CatalogwishlistModel->getTotal() > 0)
{

	$iRow = 0;

	while($registro = $CatalogwishlistModel->getRows())
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

$deleteFunction ="catalog_EliminarWhislist";
$MyFiltrosForm->addFecha('rango_inicial');
$MyFiltrosForm->addFecha('rango_final');
$MyFiltrosForm->addSubmit();
$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
$MyFiltrosForm->setAtributoInput("rango_inicial", "value",$rango_inicial);
$MyFiltrosForm->setAtributoInput("rango_final", "value",$rango_final);
$MyFiltrosForm->setAtributoInput("rango_inicial", "placeholder","Desde");
$MyFiltrosForm->setAtributoInput("rango_final", "placeholder","Hasta");

?>
