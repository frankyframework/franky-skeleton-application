<?php
use Base\Form\registroForm;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$callback	= $MyRequest->getRequest('callback');
$registroForm = new registroForm("users");
$registroForm->setMobile($Mobile_detect->isMobile());

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
