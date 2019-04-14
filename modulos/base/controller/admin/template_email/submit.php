<?php
use Franky\Core\validaciones;
use Base\model\TemplateemailModel;
use Base\entity\TemplateemailEntity;
use Franky\Haxor\Tokenizer;
use Franky\Filesystem\File;

$Tokenizer = new Tokenizer();

$TemplatemmailModel    = new TemplateemailModel;
$TemplatemmailEntity    = new TemplateemailEntity($MyRequest->getRequest());


$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$TemplatemmailEntity->id($Tokenizer->decode($MyRequest->getRequest('id')));

$destinatario = json_encode(explode(",",$MyRequest->getRequest('destinatario')));
$cc = json_encode(explode(",",$MyRequest->getRequest('cc')));
$bcc = json_encode(explode(",",$MyRequest->getRequest('bcc')));
$TemplatemmailEntity->bcc($bcc);
$TemplatemmailEntity->cc($cc);
$TemplatemmailEntity->destinatario($destinatario);
$TemplatemmailEntity->html($MyRequest->getRequest('html','',true));
$id = $TemplatemmailEntity->id();
$error = false;

$File = new File();
$File->mkdir($MyConfigure->getServerUploadDir()."/email_template/");

$validaciones =  new validaciones();
$valid = $validaciones->validRules($TemplatemmailEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if($TemplatemmailModel->existe($nombre,$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("nombre_template_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_EMAIL_TEMPLATE))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}



if($error == false)
{
      if(empty($id))
      {
        $TemplatemmailEntity->fecha(date('Y-m-d H:i:s'));
        $TemplatemmailEntity->status(1);
      }

      $result = $TemplatemmailModel->save($TemplatemmailEntity->getArrayCopy());

      if($result == REGISTRO_SUCCESS)
      {
          if(empty($id))
          {

              $dir_blog = $MyConfigure->getServerUploadDir()."/email_template/".$MySession->GetVar('path_img_blog')."/";
              rename($dir_blog,str_replace($MySession->GetVar('path_img_blog'),$TemplatemmailModel->getUltimoID(),$dir_blog));

              $template = str_replace($MySession->GetVar('path_img_blog'),$TemplatemmailModel->getUltimoID(),$TemplatemmailEntity->html());
              $TemplatemmailEntity->id($TemplatemmailModel->getUltimoID());
              $TemplatemmailEntity->html($template);
              $TemplatemmailModel->save($TemplatemmailEntity->getArrayCopy());

              $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
          }
          else
          {
               $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
          }

          $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_EMAIL_TEMPLATE));

      }
      elseif($result == REGISTRO_ERROR)
      {

          if(empty($id))
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
