<?php
use Seo\Form\redireccion301Form;

$id		= $MyRequest->getRequest('id');
$callback	= $MyRequest->getRequest('callback');
$data           = $MyFlashMessage->getResponse();

$adminForm = new redireccion301Form("frmredireccion");


if(!empty($id))
{
        $result	 = $MyRedireccion->getData($id);
	$data = $MyRedireccion->getRows();
        $adminForm->addId();
}


$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));



$title_form = "Redirecciones 301";
$MyFrankyMonster->setPHPFile(getVista("admin/template/form.phtml"));