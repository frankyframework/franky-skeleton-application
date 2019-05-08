<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Seo\model\SeoModel;
use Seo\entity\SeoEntity;
use Base\entity\OrganosEntity;


$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"nombre"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));


$lang_b	= $MyRequest->getRequest('lang_b',$_SESSION['lang'] );
$busca_b	= $MyRequest->getRequest('busca_b');

$idioma_base = getCoreConfig('base/theme/baselang');
$idiomas_disponibles = getCoreConfig('base/theme/langs');


$lang_b = (empty($lang_b) ? $idioma_base: $lang_b);

$OrganosEntity = new OrganosEntity();
$SeoEntity = new SeoEntity();
$SeoEntity->lang($lang_b);

$MySeo = new SeoModel();

$MySeo->setPage($MyPaginacion->getPage());
$MySeo->setTampag($MyPaginacion->getTampageDefault());
$MySeo->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$result	= $MySeo->getData($SeoEntity->getArrayCopy(),$OrganosEntity->getArrayCopy(),$busca_b);
$MyPaginacion->setTotal($MySeo->getTotal());

$lista_admin_data = array();
if($MySeo->getTotal() > 0)
{
	$iRow = 0;

	while($registro = $MySeo->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

                 $lista_admin_data[] = array_merge($registro,array(
                "thisClass"     => $thisClass,
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
foreach($idiomas_disponibles as $idioma)
{
    $idiomas[$idioma] = $idioma;
}

$MyFiltrosForm->setOptionsInput("lang_b", $idiomas);
$MyFiltrosForm->setData($MyRequest->getRequest());
$MyFiltrosForm->setAtributoInput("lang_b","value",$SeoEntity->lang());

$title_grid = "SEO";
$class_grid = "cont_seo";
$error_grid = "No hay metatags registrados";
$deleteFunction = "EliminarSeo";
$frm_constante_link = FRM_SEO;
$titulo_columnas_grid = array("nombre" => "Nombre","titulo" => "Título", "descripcion" =>  "Descripción", "keywords" => "Keywords");
$value_columnas_grid = array("nombre","titulo" , "descripcion" , "keywords" );

$css_columnas_grid = array("nombre" => "w-xxxx-2" ,"titulo" => "w-xxxx-2", "descripcion" => "w-xxxx-3","keywords" => "w-xxxx-3" );
$permisos_grid = ADMINISTRAR_SEO;


?>
