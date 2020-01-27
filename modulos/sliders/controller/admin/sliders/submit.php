<?php
use Franky\Filesystem\File;
use Franky\Core\validaciones; 
use Sliders\model\SlidersModel;
use Sliders\entity\SlidersEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$SlidersModel = new SlidersModel();
$SlidersEntity = new SlidersEntity($MyRequest->getRequest());

$id       = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));

$SlidersEntity->id($id);

$error = false;
$SlidersEntity->code(getFriendly($SlidersEntity->code()));

$validaciones =  new validaciones();
$valid = $validaciones->validRules($SlidersEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($SlidersModel->existe($SlidersEntity->code(),$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sliders_sliders_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_SLIDERS))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}


if($error == false)        
{
    if(empty($id))
    {

        $SlidersEntity->createdAt(date('Y-m-d H:i:s'));
        $SlidersEntity->status(1);
    }
    else
    {
        $SlidersEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $result = $SlidersModel->save($SlidersEntity->getArrayCopy());
    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        }
        else
        {
             $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_SLIDERS));

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