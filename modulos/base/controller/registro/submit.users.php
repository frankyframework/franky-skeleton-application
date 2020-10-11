<?php
use Franky\Core\validaciones;
use Franky\Core\Plantilla;
use Base\model\USERS;
use Base\entity\users as entityUser;
use Base\model\AvataresModel;
use Base\entity\AvataresEntity;
use Base\model\VerificacionesPendientes;
use Base\model\Emails;
use Franky\Core\ObserverManager;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$Emails = new Emails();
$MyUser             = new USERS();
$MyUserEntity    = new entityUser($MyRequest->getRequest());
$AvataresModel = new AvataresModel();
$AvataresEntity = new AvataresEntity();
$callback	= $MyRequest->getRequest('callback');

$contrasena1	= $MyRequest->getRequest('contrasena1');
$fecha_nacimiento	= $MyRequest->getRequest('fecha_nacimiento');
if(empty($fecha_nacimiento))
{
    $fecha_nacimiento = "0000-00-00";
}


$error = false;

if(!$Tokenizer->decode($MyRequest->getRequest('token_xsrf')))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("bad_request"));
    $error = true;
}

$validaciones =  new validaciones();
$valid = $validaciones->validRules($MyUserEntity->setValidation($contrasena1,getCoreConfig('base/user/passwordlength'),getCoreConfig('base/user/passwordlevel')));
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if($MyUserEntity->getContrasena() != $contrasena1)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("comparar_contrasenas"));
    $error = true;
}
if($MyUser->findUser($MyUserEntity->getUsuario()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("username_duplicate",$MyUserEntity->getUsuario()));
    $error = true;
}
if($MyUser->findEmail($MyUserEntity->getEmail()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("email_duplicate",$MyUserEntity->getEmail()));
    $error = true;
}
if($MyUserEntity->getTelefono() != "" && $MyUser->findTelefono($MyUserEntity->getTelefono()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("telefono_duplicate",$MyUserEntity->getTelefono()));
    $error = true;
}

    $plantilla	= new Plantilla();

    if(!$error)
    {

        $varificado = 1;
        if($Emails->getMailV($MyUserEntity->getEmail()) != REGISTRO_SUCCESS)
        {
            $varificado = 0;
        }

        $MyUserEntity->setNivel(NIVEL_USERSUSCRIPTOR);
        $MyUserEntity->setContrasena(password_hash($MyUserEntity->getContrasena(),PASSWORD_DEFAULT));
        $MyUserEntity->setVerificado($varificado);
        $MyUserEntity->setFecha(date('Y-m-d H:i:s'));
        $MyUserEntity->setUltimoAcceso(date('Y-m-d'));
        $MyUserEntity->setFecha_nacimiento($fecha_nacimiento);


        $result = $MyUser->save($MyUserEntity->getArrayCopy());
        if($result == REGISTRO_SUCCESS)
        {
            $token = getToken("registro");
            $id_user = $MyUser->getUltimoID();


            $AvataresEntity->id_user($id_user);
            $AvataresEntity->name('gravatar');
            $AvataresEntity->url("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $MyUserEntity->getEmail() ) ) ));
            $AvataresEntity->status(0);
            $AvataresModel->save($AvataresEntity->getArrayCopy());



            $VerificacionesPendientes   = new VerificacionesPendientes();
            $VerificacionesPendientes->addVerifica($id_user, $token );

            $MyLogin = new \Franky\Core\LOGIN("users",array("usuario","email"),1,array("status" => "1"));
            $MyLogin->setLogin($MyUserEntity->getUsuario(), 1);


            $inputs = $MyLogin->getInputs();
            foreach($inputs as $k)
            {
                $MySession->SetVar($k,   	$MyLogin->{$k});
            }


            $MySession->SetVar('is_login',    true);
            $_SESSION["token_login"] = array();



            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("regtistro_user_success"));

            $ObserverManager = new ObserverManager;
            $ObserverManager->dispatch('register_new_user',[$MyLogin->id]);
            if(!empty($callback))
            {
                $location = $callback;
            }
            else
            {
                $location =$MyRequest->url(ADMIN);
            }


            $campos = array(   'usuario'           =>	$MyUserEntity->getUsuario(),
                                    'url'               =>      $MyRequest->getSERVER(),
                                    'token'             =>	$token,
                                    'contrasena'	=>	$contrasena1,
                                    'email'		=>	$MyUserEntity->getEmail(),
                                    'fecha'		=>	date('Y-m-d'),
                                    'nombre_web'        =>      $MyRequest->getSERVER(),

                            );

                            $TemplateemailModel    = new \Base\model\TemplateemailModel;
                            $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
                            $SecciontransaccionalEntity->friendly('registro-de-usuario-frontend');
                            $TemplateemailModel->setOrdensql('id DESC');
                            $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

                            $registro  = $TemplateemailModel->getRows();

                            sendEmail($campos,$registro);


        }
        elseif($result == REGISTRO_ERROR)
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("regtistro_user_error"));
            $location = $MyRequest->getReferer();
        }
        else
        {
            $MyFlashMessage->setMsg("error",$result);
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
        $location = $MyRequest->getReferer();
    }

$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($location);
?>
