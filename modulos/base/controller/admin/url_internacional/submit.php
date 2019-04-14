<?php
use Franky\Core\validaciones;
use Base\model\UrlInternacionalModel;
use Base\entity\UrlInternacionalEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$UrlInternacionalEntity = new UrlInternacionalEntity($MyRequest->getRequest());
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$UrlInternacionalEntity->id($Tokenizer->decode($MyRequest->getRequest('id')));
$id = $UrlInternacionalEntity->id();
$error = false;

$validaciones =  new validaciones();
$valid = $validaciones->validRules($UrlInternacionalEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_URLINTERNACIONAL))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)
{
    $UrlInternacionalModel = new UrlInternacionalModel();

    if(empty($id))
    {
        $UrlInternacionalEntity->status(1);
        $UrlInternacionalEntity->fecha(date('Y-m-d H:i:s'));
    }
    $result = $UrlInternacionalModel->save($UrlInternacionalEntity->getArrayCopy());


    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  $MyRequest->url(ADMIN_URL_INTERNACIONAL);
        }
        else
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_URL_INTERNACIONAL));
        }
    }
    else
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
            $location = $MyRequest->getReferer();
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
            $location = $MyRequest->getReferer();
        }
    }
}
else
{
    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>
