<?php
/******************************* AJAX ADMIN *********************************/

function EliminarUser($id,$status)
{

        $MyUser             = new \Base\model\USERS();
        $MyUserEntity    = new \Base\entity\users();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        global $MyFlashMessage;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_OTROS_USUARIOS))
        {
            $MyUserEntity->setId(addslashes($Tokenizer->decode($id)));
            $MyUserEntity->setStatus(addslashes($status));
            if($MyUser->save($MyUserEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

            }
            else
            {
		            $respuesta[] = array("message" => $MyMessageAlert->Message("delete_suscriptor_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function EliminarTemplate($id,$status)
{
        $TemplateemailModel    = new\Base\model\TemplateemailModel;
        $TemplateemailEntity    = new\Base\entity\TemplateemailEntity;
          $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        $TemplateemailEntity->status(addslashes($status));
        $TemplateemailEntity->id(addslashes($Tokenizer->decode($id)));
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_EMAIL_TEMPLATE))
        {
            if($TemplateemailModel->save($TemplateemailEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}
function EliminarCMSTemplate($id,$status)
{

	$MyCMS = new \Base\model\CMS;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CMS_TEMPLATE))
        {
            if($MyCMS->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

function EliminarDispositivo($password,$id,$status)
{
        global $MySession;
        $UserdeviceModel = new \Base\model\UserdeviceModel;
        $UserdeviceEntity = new \Base\entity\UserdeviceEntity;
        $MyUser         = new \Base\model\USERS();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if(password_verify($password,$MySession->GetVar('contrasena')))
        {
          if($MyAccessList->MeDasChancePasar(ADMINISTRAR_DEVICES))
          {

            $UserdeviceEntity->id(addslashes($Tokenizer->decode($id)));
              if($UserdeviceModel->delete($UserdeviceEntity->getArrayCopy()) == REGISTRO_SUCCESS)
              {


              }
              else
              {
                    $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
              }
          }
          else
          {
               $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
          }

        }
        else {

          $respuesta[] = array("message" => $MyMessageAlert->Message("error_pass_actual"));

        }

	return $respuesta;
}


function BloquearDispositivo($password,$id,$status)
{
      global $MySession;
	     $UserdeviceModel = new \Base\model\UserdeviceModel;
         $UserdeviceEntity = new \Base\entity\UserdeviceEntity;
       $MyUser         = new \Base\model\USERS();
       $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;

        if(password_verify($password,$MySession->GetVar('contrasena')))
        {
          if($MyAccessList->MeDasChancePasar(ADMINISTRAR_DEVICES))
          {

            $UserdeviceEntity->id(addslashes($Tokenizer->decode($id)));
            $UserdeviceEntity->status(addslashes($status));
              if($UserdeviceModel->save($UserdeviceEntity->getArrayCopy()) == REGISTRO_SUCCESS)
              {


              }
              else
              {
                    $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
              }
          }
          else
          {
               $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
          }

        }
        else {

          $respuesta[] = array("message" => $MyMessageAlert->Message("error_pass_actual"));

        }

	return $respuesta;
}



function EliminarComentario($id,$status)
{

	$ContactoModel = new Base\model\Contacto;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CONTACTANOS))
        {
            if($ContactoModel->delete(addslashes($id)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function _getFiles($path,$file='file')
{
	//echo $path;
  $File = new \Franky\Filesystem\File;
        $files = $File->getFiles(PROJECT_DIR.$path,$file);

        if(count($files) > 0)
        {
            foreach($files as $file)
            {
                $respuesta["file"][] =  $file;
            }
        }
        else
        {
            $respuesta[] = array("message" => "error");
        }

	return $respuesta;
}



function registrarEmail($email)
{
    $Select = new \Franky\Database\Mysql\Select();
    $Insert = new \Franky\Database\Mysql\Insert();
    $From = new \Franky\Database\Mysql\From();
    $Where = new \Franky\Database\Mysql\Where();
    $validaciones = new \Franky\Core\validaciones();
    $ObserverManager = new \Franky\Core\ObserverManager();



    $error = false;
    $From->addTable("mailing");
    $Where->addAnd('email',$email,'=');

    if($validaciones->ValidaMail($email))
    {

        if($Select->execute($From->get(), array("id"), $Where->get(), "", "id ASC")== CONSULTAS_SUCCESS)
        {
            $respuesta["message"] = "duplicate";
        }
        else
        {
            if($Insert->execute($From->get(), array("email"=> $email,"fecha" => date('Y-m-d')." ".date("H:i:s"))) == CONSULTAS_SUCCESS)
            {
                $respuesta["message"] = "success";
                $ObserverManager->dispatch('register_news',[$email]);
            }
            else
            {
                $respuesta["message"] = "error";
            }
        }
    }
    else
    {
        $respuesta["message"] = "bad";

    }
        return $respuesta;
}



function setExplorador()
{
    $_SESSION["explorador"] = true;
    return $respuesta;

}

function EliminarUrlIternacional($id,$status)
{
        global $MyAccessList;
        global $MyMessageAlert;

        $UrlInternacionalModel              = new \Base\model\UrlInternacionalModel();
        $UrlInternacionalEntity              = new \Base\entity\UrlInternacionalEntity();

        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_URLINTERNACIONAL))
        {
            $UrlInternacionalEntity->id(addslashes($Tokenizer->decode($id)));
            $UrlInternacionalEntity->status(addslashes($status));
            if($UrlInternacionalModel->save($UrlInternacionalEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

            }
            else
            {
		 $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

/******************************** EJECUTA *************************/
$MyAjax->register("EliminarUser");
$MyAjax->register("EliminarTemplate");
$MyAjax->register("EliminarCMSTemplate");
$MyAjax->register("EliminarComentario");
$MyAjax->register("_getFiles");
$MyAjax->register("registrarEmail");
$MyAjax->register("setExplorador");
$MyAjax->register("EliminarUrlIternacional");
$MyAjax->register("BloquearDispositivo");
$MyAjax->register("EliminarDispositivo");

?>
