<?php
use Base\model\USERS;
use Franky\Haxor\Tokenizer;

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