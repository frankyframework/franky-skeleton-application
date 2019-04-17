<?php
use {modulo}\\Form\\{form};
use {modulo}\\model\\{modelo};
use {modulo}\\entity\\{entidad};
use Franky\\Haxor\\Tokenizer;

$Tokenizer = new Tokenizer();
${modelo}             = new {modelo}();
${entidad}             = new {entidad}();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

$adminForm = new {form}("");

$title = "Nuevo";
if(!empty($id))
{
	${entidad}->id($id);
        ${modelo}->getData(${entidad}->getArrayCopy());

	$data = ${modelo}->getRows();
	$data['id'] = $Tokenizer->token('{seccion}', $data['id']);
        $adminForm->addId();
        $title = "Editar";
}

$adminForm->addSubmit();
$adminForm->setData($data);

$adminForm->setAtributoInput("callback","value", urldecode($callback));

$title_form = "$title";
