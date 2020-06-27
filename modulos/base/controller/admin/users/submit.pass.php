<?php
use Franky\Core\validaciones;
use Base\model\USERS;
use Base\entity\users as entityUser;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser         = new USERS();
$callback	= $Tokenizer->decode($MyRequest->getRequest('callback'));
$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$contrasena	= $MyRequest->getRequest('contrasena');
$contrasena1	= $MyRequest->getRequest('contrasena1');
$contrasena_ant	= $MyRequest->getRequest('contrasena_ant');

$error = false;

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTRA_CONTRASENA))
{
	$id= $MySession->GetVar('id');
}

$result     = $MyUser->getData($MySession->GetVar('id'));
$registro   = $MyUser->getRows();
$usuario_db = $registro["usuario"];
$contrasena_db = $registro["contrasena"];

$rules = array();


if(!empty($contrasena_db) && !$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTRA_CONTRASENA))
{
    $rules["Contraseña anterior"] = array("valor" => $contrasena_ant, "required");
}

$rules["Contraseña"] = array("valor" => $contrasena, "required","password" => getCoreConfig('base/user/passwordlevel'),"length" => array("min" => getCoreConfig('base/user/passwordlength'),"max" => "15"));
$rules["Confirmar contraseña"] = array("valor" => $contrasena1, "required","password" => getCoreConfig('base/user/passwordlevel'),"length" => array("min" => getCoreConfig('base/user/passwordlength'),"max" => "15"));



$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if($contrasena != $contrasena1)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("comparar_contrasenas"));
    $error = true;
}

if(!empty($contrasena_db))
{
    if(!password_verify($contrasena_ant,$contrasena_db))
    {
        if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTRA_CONTRASENA)):
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("error_pass_actual"));
        else:
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("error_pass_admin"));
        endif;
        $error = true;
    }
}




if(!$error)
{

    $MyUserEntity    = new entityUser($MyRequest->getRequest());
    $MyUserEntity->setContrasena(password_hash($contrasena,PASSWORD_DEFAULT));
    $MyUserEntity->setId($id);
    $result = $MyUser->save($MyUserEntity->getArrayCopy());


    if($result == REGISTRO_SUCCESS)
    {
        $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_password_success"));


        $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_OPERADORES));

        if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTRA_CONTRASENA))
        {
            $location = $MyRequest->url(ADMIN);
        }

    }
    else
    {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_password_error"));
        $location = $MyRequest->getReferer();

    }
}
else {

    $location = $MyRequest->getReferer();
}


$MyRequest->redirect($location);
?>
