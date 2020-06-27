<?php
use Franky\Core\validaciones;
use Base\model\USERS;
use Base\entity\users as entityUser;

$MyUser             = new USERS();
$contrasena_ant	= $MyRequest->getRequest('contrasena_ant');
$error = false;


$result	 = $MyUser->getData($MySession->GetVar('id'));
$registro = $MyUser->getRows();
$id		= $registro["id"];
$contrasena_db	= $registro["contrasena"];


if(!empty($contrasena_db))
{
    $rules["Contraseña actual"] = array("valor" => $contrasena_ant, "required");


    $validaciones =  new validaciones();
    $valid = $validaciones->validRules($rules);
    if(!$valid)
    {
        $MyFlashMessage->setMsg("error",$validaciones->getMsg());
        $error = true;
    }

    if(!password_verify($contrasena_ant,$contrasena_db))
    {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("error_pass_actual"));
        $error = true;
    }
}
if($error == false)
{
    $MyUserEntity    = new entityUser();
    $MyUserEntity->setStatus(0);
    $MyUserEntity->setId($id);
    $result = $MyUser->save($MyUserEntity->getArrayCopy());
    if($result == REGISTRO_SUCCESS)
    {
        $MySession->EndSession();
        $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("delete_suscriptor_success"));
        $location = "/";
    }
    else {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("delete_suscriptor_error"));
        $location = $MyRequest->url(PERFIL);
    }
}
else
{
      $location = $MyRequest->getReferer();
}

$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($location);
?>
