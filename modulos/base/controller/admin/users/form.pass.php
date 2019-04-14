<?php
use Base\Form\contrasenaForm;
use Base\model\USERS;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser             = new USERS();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTRA_CONTRASENA) || empty($id))
{
	$id= $MySession->GetVar('id');
}
	
if(!empty($id))
{
	
        $result	 		= $MyUser->getData($id);

	$registro = $MyUser->getRows();	
	$id		= $Tokenizer->token('users',$registro["id"]);
	$contrasena_db	= $registro["contrasena"];
	
	
}

$adminForm = new contrasenaForm("userspass");
if(!empty($contrasena_db) && !$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTRA_CONTRASENA)):
    $adminForm->addContrasenaAnterior();
endif; 
$adminForm->addSubmit();
$adminForm->setAtributoInput("id","value", $id);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$title_form = "Cambiar contraseña";
?>