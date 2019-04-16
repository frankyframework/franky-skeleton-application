<?php
use Base\model\USERS;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser             = new USERS();

$email		=	$MyRequest->getRequest('email');
$id		=	$Tokenizer->decode($MyRequest->getRequest('id'));	
if($MyUser->findEmail($email,$id) == REGISTRO_SUCCESS)
{
   
    echo "false";
}  
else
{
    echo "true";
}
?>