<?php
use modulos\ecommerce\Form\direccionesForm;
use modulos\ecommerce\vendor\model\direcciones_facturacion;

$MyDirecciones             = new direcciones_facturacion();

$id		= $MyRequest->getRequest('id');
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

$adminForm = new direccionesForm("frmdirecciones_facturacion");

$adminForm->setAtributo("action", "/public/php/ecommerce/admin/direcciones_facturacion/submit.php");
if(!empty($id))
{
	
        $MyDirecciones->getData($id,$MySession->GetVar('id'));

	$data = $MyDirecciones->getRows();	
        $adminForm->addId();
        
}

$adminForm->addRFC();
$adminForm->addSubmit();
$adminForm->setData($data);

$adminForm->setAtributoInput("callback","value", urldecode($callback));

$title_form = "Administrar direcciones de facturacion";