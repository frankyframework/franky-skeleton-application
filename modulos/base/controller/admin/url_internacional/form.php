<?php
use modulos\base\Form\UrlInternacionalForm;
use modulos\base\vendor\model\UrlInternacionalModel;
use modulos\base\vendor\entity\UrlInternacionalEntity;
use vendor\haxor\Tokenizer;

$Tokenizer = new Tokenizer;
$UrlInternacionalModel              = new UrlInternacionalModel();
$UrlInternacionalEntity  = new UrlInternacionalEntity($MyRequest->getRequest());
$adminForm = new UrlInternacionalForm("frminternacional");

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$UrlInternacionalEntity->id($id);
$callback	= $MyRequest->getRequest('callback');

$data = $MyFlashMessage->getResponse();

if(!empty($id))
{
        $result	 = $UrlInternacionalModel->getData($UrlInternacionalEntity->getArrayCopy());
	$data = $UrlInternacionalModel->getRows();
  $data['id'] = $Tokenizer->token('url_internacional', $data['id']);
        $adminForm->addId();
}

$paginas = selectPagina();

$idiomas = array();
$idiomas_disponibles = getCoreConfig('base/theme/baselang');
foreach($idiomas_disponibles as $idioma)
{
    $idiomas[$idioma] = $idioma;
}


$adminForm->setOptionsInput("id_franky", $paginas);
$adminForm->setOptionsInput("lang", $idiomas);
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));

$title_form = "URL Internacional";
?>
