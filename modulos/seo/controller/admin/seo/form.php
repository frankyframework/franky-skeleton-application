<?php
use Seo\Form\SEOForm;
use Seo\model\SeoModel;
use Seo\entity\SeoEntity;

$MySeo              = new SeoModel();
$SeoEntity  = new SeoEntity($MyRequest->getRequest());
$adminForm = new SEOForm("frmseo");

$id		= $MyRequest->getRequest('id');
$callback	= $MyRequest->getRequest('callback');

$data = $MyFlashMessage->getResponse();
$data_extra_metats = [];
if(!empty($id))
{
        $result	 = $MySeo->getData($SeoEntity->getArrayCopy());
        $data = $MySeo->getRows();
        $data_extra_metats = json_decode($data['extra'],true);
        $adminForm->addId();
}

$paginas = selectPagina();

$idiomas = array();

$idiomas_disponibles = getCoreConfig('base/theme/langs');
foreach($idiomas_disponibles as $idioma)
{
    $idiomas[$idioma] = $idioma;
}


$adminForm->setOptionsInput("id_franky", $paginas);
$adminForm->setOptionsInput("lang", $idiomas);
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));

$title_form = "SEO";
?>
