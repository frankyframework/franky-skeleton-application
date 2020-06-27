<?php
use Base\model\USERS;
use Base\entity\users as entityUser;
use Franky\Core\ObserverManager;

$MyUser             = new USERS();
$MyLogin = new \Franky\Core\LOGIN("users",array("usuario","email"),"contrasena",array("status" => "1"));


$usuario	= $MyRequest->getRequest('usuario');
$contrasena	= $MyRequest->getRequest('contrasena');
$callback	= $MyRequest->getRequest('callback');

$error = false;


if(empty($usuario))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("empty_login"));
    $error = true;
}
if(empty($contrasena))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("empty_login"));
    $error = true;
}
if($error == false)
{

    if( $MyLogin->setLogin($usuario, $contrasena) == LOGIN_SUCCESS)
    {

        $inputs = $MyLogin->getInputs();
        foreach($inputs as $k)
        {
            $MySession->SetVar($k,   	$MyLogin->{$k});
        }

        $MyUserEntity    = new entityUser();
        $MyUserEntity->setId($MyLogin->id);
        $MyUserEntity->setUltimoAcceso( date('Y-m-d'));

        $MyUser->save($MyUserEntity->getArrayCopy());



        $MySession->SetVar('is_login',    true);
        $_SESSION["token_login"] = array();

        //$location = $_SESSION["url_location"];
        $ObserverManager = new ObserverManager;


        $ObserverManager->dispatch('login_user');
        $ObserverManager->dispatch('login_user_'.$MyLogin->nivel,[$MyLogin->id]);


        if(!empty($callback))
        {
            $location = $callback;
        }
        else
        {
            $location =$MyRequest->url(ADMIN);
        }
    }
    else
    {

        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("error_login"));

        $location = $MyRequest->getReferer();
    }
}
else
{
    $location = $MyRequest->getReferer();
}



$MyRequest->redirect($location);
?>
