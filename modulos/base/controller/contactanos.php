<?php
use Base\Form\contactanosForm;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$contactanosForm = new contactanosForm("frmContacto");
$contactanosForm->setData($MyFlashMessage->getResponse());
$contactanosForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('cantactanos_xsrf', time()));
?>
