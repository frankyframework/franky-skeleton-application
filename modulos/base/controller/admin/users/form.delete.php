<?php
use Base\model\USERS;
use Base\Form\deleteForm;

$MyUser = new USERS();
$result	 = $MyUser->getData($MySession->GetVar('id'));
$registro = $MyUser->getRows();	
$id		= $registro["id"];
$contrasena_db	= $registro["contrasena"];

$adminForm = new deleteForm("userspass");
if(!empty($contrasena_db)):
    $adminForm->addContrasenaAnterior();
endif;
$title_form = "Eliminar mi cuenta";

?>