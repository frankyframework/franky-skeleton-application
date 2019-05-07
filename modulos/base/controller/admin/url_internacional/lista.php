<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Base\model\UrlInternacionalModel;
use Base\entity\UrlInternacionalEntity;
use Base\entity\OrganosEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer;

$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"nombre"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));


$lang_b	= $MyRequest->getRequest('lang_b',$_SESSION['lang'] );
$busca_b	= $MyRequest->getRequest('busca_b');

$idioma_base = getCoreConfig('base/theme/baselang');
$lang_b = (empty($lang_b) ? $idioma_base: $lang_b);

$OrganosEntity = new OrganosEntity();
$UrlInternacionalEntity = new UrlInternacionalEntity();
$UrlInternacionalEntity->lang($lang_b);

$UrlInternacionalModel = new UrlInternacionalModel();

$UrlInternacionalModel->setPage($MyPaginacion->getPage());
$UrlInternacionalModel->setTampag($MyPaginacion->getTampageDefault());
$UrlInternacionalModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$result	= $UrlInternacionalModel->getData($UrlInternacionalEntity->getArrayCopy(),$OrganosEntity->getArrayCopy(),$busca_b);
$MyPaginacion->setTotal($UrlInternacionalModel->getTotal());

$lista_admin_data = array();
if($UrlInternacionalModel->getTotal() > 0)
{
	$iRow = 0;

	while($registro = $UrlInternacionalModel->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

                 $lista_admin_data[] = array_merge($registro,array(
                "thisClass"     => $thisClass,
								"id" => $Tokenizer->token('url_internacional',$registro["id"]),
								"callback" => $Tokenizer->token('url_internacional',$MyRequest->getURI()),
                "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar")
                ));
                $iRow++;
        }
}


$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addLang();
$MyFiltrosForm->addSubmit();

$idiomas = array();
$idiomas_disponibles = getCoreConfig('base/theme/langs');
foreach($idiomas_disponibles as $idioma)
{
    $idiomas[$idioma] = $idioma;
}

$MyFiltrosForm->setOptionsInput("lang_b", $idiomas);
$MyFiltrosForm->setData($MyRequest->getRequest());
$MyFiltrosForm->setAtributoInput("lang_b","value",$UrlInternacionalEntity->lang());

$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = "URL Internacional";
$class_grid = "cont_urlinternacional";
$error_grid = "No hay URLs registrados";
$deleteFunction = "EliminarUrlIternacional";
$frm_constante_link = FRM_URL_INTERNACIONAL;
$titulo_columnas_grid = array("nombre" => "Nombre","urli" => "URL", "url" =>  "URL Internacional");
$value_columnas_grid = array("nombre","urli" , "url");

$css_columnas_grid = array("nombre" => "w-xxxx-4" ,"urli" => "w-xxxx-3", "url" => "w-xxxx-3");
$permisos_grid = ADMINISTRAR_URLINTERNACIONAL;
//exit;

?>
