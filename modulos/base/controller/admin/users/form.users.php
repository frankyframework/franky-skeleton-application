<?php
use Base\Form\registroForm;
use Base\model\USERS;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser             = new USERS();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTROS_USUARIOS))
{

	$id= $MySession->GetVar('id');
}

$adminForm = new registroForm("users");
$adminForm->setMobile($Mobile_detect->isMobile());
$adminForm->setAtributo("action","/admin/users/submit.users.php");

$title = "Alta";

if(!empty($id))
{
    $title = "Edición";

        $MyUser->getData($id);

	$data = $MyUser->getRows();
        $data['id'] = $Tokenizer->token('users', $data['id']);
        $adminForm->addId();

}
else
{
    $adminForm->addUsuario();
}
$adminForm->addGeneral();
if($MyAccessList->MeDasChancePasar(ADMINISTRAR_OTROS_USUARIOS)):
    $adminForm->addNivel();
    $adminForm->setOptionsInput("nivel",$_Niveles_usuarios);
endif;
//$adminForm->addBiografia();
$adminForm->addGuardar();
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$adminForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('users_xsrf', time()));


$title_form = "$title de usuario";
