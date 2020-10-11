<?php
use Franky\Core\validaciones;
use Base\model\USERS;
use Base\entity\users as entityUser;
use Base\model\AvataresModel;
use Base\entity\AvataresEntity;
use Base\model\Emails;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$Emails = new Emails();
$MyUser             = new USERS();
$MyUserEntity    = new entityUser($MyRequest->getRequest());
$AvataresModel = new AvataresModel();
$AvataresEntity = new AvataresEntity();
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));


if($Tokenizer->decode($MyRequest->getRequest('id')) != false)
{
    $MyUserEntity->setId($Tokenizer->decode($MyRequest->getRequest('id')));
}
$id_user = $MyUserEntity->getId();

$biografia	= $MyRequest->getRequest('biografia',true,array("<br>,<a>,<p>"));
$fecha_nacimiento	= $MyRequest->getRequest('fecha_nacimiento','0000-00-00');
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

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTROS_USUARIOS))
{
    $MyUserEntity->setNivel($MySession->GetVar('nivel'));
    $MyUserEntity->setUsuario($MySession->GetVar('usuario'));
    $MyUserEntity->setId($MySession->GetVar('id'));
    $id_user = $MyUserEntity->getId();
}



$validaciones =  new validaciones();
$valid = $validaciones->validRules($MyUserEntity->setValidationadmin());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

$usuario = $MyUserEntity->getUsuario();
if(!empty($usuario) && $MyUser->findUser($MyUserEntity->getUsuario(),$MyUserEntity->getId()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("username_duplicate",$MyUserEntity->getUsuario()));
    $error = true;
}
if($MyUser->findEmail($MyUserEntity->getEmail(),$MyUserEntity->getId()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("email_duplicate",$MyUserEntity->getEmail()));
    $error = true;
}


if($MyUserEntity->getTelefono() != "" && $MyUser->findTelefono($MyUserEntity->getTelefono(),$MyUserEntity->getId()) == REGISTRO_SUCCESS)
{

    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("telefono_duplicate",$MyUserEntity->getTelefono()));
    $error = true;
}




if(!$error)
{


    $varificado = 1;
    if($Emails->getMailV($MyUserEntity->getEmail()) != REGISTRO_SUCCESS)
    {
        $varificado = 0;
    }

    $contrasena = substr(md5(time()),0,8);

    $MyUserEntity->setVerificado($varificado);

    if(empty($id_user))
    {
        $MyUserEntity->setContrasena(password_hash($contrasena,PASSWORD_DEFAULT));
        $MyUserEntity->setFecha(date('Y-m-d H:i:s'));
    }
    if($MyUserEntity->getNivel() == "" || !in_array($MyUserEntity->getNivel(),  array_keys($_Niveles_usuarios)))
    {
        $MyUserEntity->setNivel(NIVEL_USERSUSCRIPTOR);
    }

    $MyUserEntity->setFecha_nacimiento($fecha_nacimiento);


    $result = $MyUser->save($MyUserEntity->getArrayCopy());

    if($result == REGISTRO_SUCCESS)
    {


        if(empty($id_user))
        {

            $AvataresEntity->id_user($MyUser->getUltimoID());
            $AvataresEntity->name('gravatar');
            $AvataresEntity->url("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $MyUserEntity->getEmail() ) ) ));
            $AvataresEntity->status(0);
            $AvataresModel->save($AvataresEntity->getArrayCopy());


            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));

              $campos = array(    'usuario'           =>	$MyUserEntity->getUsuario(),
                            'contrasena'        =>	$contrasena,
                            'email'             =>	$MyUserEntity->getEmail(),
                            'fecha'             =>	date('Y-m-d'),
                             'nombre_web'       =>  $MyRequest->getSERVER(),
                             'url_web'          =>  URL_WEB
            );

            $TemplateemailModel    = new \Base\model\TemplateemailModel;
            $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
            $SecciontransaccionalEntity->friendly('registro-de-usuario-backend');
            $TemplateemailModel->setOrdensql('id DESC');
            $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

            $registro  = $TemplateemailModel->getRows();

            sendEmail($campos,$registro);
        }
        else
        {
            $AvataresEntity->id_user($id_user);
            $AvataresEntity->name($provider);


            if($AvataresModel->getData($AvataresEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {
                $registro = $AvataresModel->getRows();
                $AvataresEntity->id($registro["id"]);
            }
            $AvataresEntity->url("https://www.gravatar.com/avatar/" . md5( strtolower( trim( $MyUserEntity->getEmail() ) ) ));
            $AvataresModel->save($AvataresEntity->getArrayCopy());

            if($Emails->getMailV($MyUserEntity->getEmail()) != REGISTRO_SUCCESS)
            {
              $VerificacionesPendientes             = new \Base\model\VerificacionesPendientes();
              $token = $Tokenizer->token('validar_email', time());
              $VerificacionesPendientes->addVerifica($MySession->GetVar('id'),  $token);

              $campos = array( 'token'=> $token,'usuario' => $MySession->GetVar('usuario'), "url" => $MyRequest->getSERVER(),"email" => $MyUserEntity->getEmail());

              $TemplateemailModel    = new \Base\model\TemplateemailModel;
              $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
              $SecciontransaccionalEntity->friendly('confirmacion-de-email');
              $TemplateemailModel->setOrdensql('id DESC');
              $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

              $registro  = $TemplateemailModel->getRows();

              sendEmail($campos,$registro);
            }

            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_OPERADORES));

        if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_OTROS_USUARIOS))
        {
            $location = $MyRequest->url(ADMIN);
        }



    }
    elseif($result == REGISTRO_ERROR)
    {
        $id_user = $MyUserEntity->getId();
        if(empty($id_user))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
        }
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


$MyRequest->redirect($location);
?>
