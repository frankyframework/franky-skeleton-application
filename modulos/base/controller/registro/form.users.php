<?php
use modulos\base\Form\registroForm;
use vendor\haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$callback	= $MyRequest->getRequest('callback');
$registroForm = new registroForm("users");


$registroForm->addUsuario();
$registroForm->addContrasena();
$registroForm->addContrasena1();
$registroForm->addGeneral();
$registroForm->addAcepto();
$registroForm->addGuardar();
$registroForm->setData($MyFlashMessage->getResponse());
$registroForm->setAtributoInput('callback', 'value',$callback);
$registroForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('users_xsrf', time()));

?>
