<?php
use modulos\base\vendor\model\USERS;
use vendor\haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$MyUser             = new USERS();				
$usuario		=	$MyRequest->getRequest('usuario');
$id		=	$Tokenizer->decode($MyRequest->getRequest('id'));	

if($MyUser->findUser($usuario,$id) == REGISTRO_SUCCESS)
{
   
    echo "false";
}  
else
{
    echo "true";
}
?>