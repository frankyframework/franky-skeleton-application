<?php
use Franky\Core\validaciones;
use Base\model\USERS;
use Base\entity\users as entityUser;

$MyUser             = new USERS();
$MyLogin = new \Franky\Core\LOGIN("users","email","1",array("status" => "1"));

$email  	= $MyRequest->getRequest('email');
$error = false;


$rules = array("E-mail" => array("valor" => $email,"email","required"));


$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($error == false)
{
    $result = $MyLogin->setLogin($email, 1);
    if($result  != LOGIN_BADLOGIN && $result != LOGIN_DBFAILURE)
    {
        $password	=	substr(md5(uniqid()),0,10);

        $MyUserEntity    = new entityUser();
        $MyUserEntity->setContrasena(password_hash($password,PASSWORD_DEFAULT));
        $MyUserEntity->setId($MyLogin->id);
        $result = $MyUser->save($MyUserEntity->getArrayCopy());


        $TemplateemailModel    = new \Base\model\TemplateemailModel;
        $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
        $SecciontransaccionalEntity->friendly('recuperar-contrasena');
        $TemplateemailModel->setOrdensql('id DESC');
        $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

        $registro  = $TemplateemailModel->getRows();
        $campos =  array("email" => $email,"usuario" => (empty($MyLogin->usuario) ? $email : $MyLogin->usuario),"password" => $password, "nombre_web" => $MyRequest->getSERVER(), "url_web" => $MyRequest->getSERVER());

        sendEmail($campos,$registro);

        $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("forgot_password_confirmation"));
        $location =$MyRequest->url(LOGIN);
    }
    else
    {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("email_no_register"));

        $location =$MyRequest->url(FORGOT);
    }
}
else
{
    $location =$MyRequest->url(FORGOT);
}

$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($location);
?>
