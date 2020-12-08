<?php
use Franky\Filesystem\File;
use Franky\Core\validaciones; 
use Carrucel\model\CarrucelcarrucelesModel;
use Carrucel\entity\CarrucelcarrucelesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$CarrucelcarrucelesModel =  new CarrucelcarrucelesModel();
$CarrucelcarrucelesEntity =  new CarrucelcarrucelesEntity($MyRequest->getRequest());

$id       = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));

$CarrucelcarrucelesEntity->id($id);

$error = false;
$CarrucelcarrucelesEntity->code(getFriendly($CarrucelcarrucelesEntity->code()));

$validaciones =  new validaciones();
$valid = $validaciones->validRules($CarrucelcarrucelesEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($CarrucelcarrucelesModel->existe($CarrucelcarrucelesEntity->code(),$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("carrucel_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_CARRUCEL))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}


if($error == false)        
{
    $width = $MyRequest->getRequest('_width',array());
    $visible = $MyRequest->getRequest('_visible',array());
    $scroll = $MyRequest->getRequest('_scroll',array());
    $options = [];
    if(!empty($width))
    {
        foreach($width as $k => $v)
        {
            $options[$k] = ['width' => $width[$k],'visible' => $visible[$k],'scroll' => $scroll[$k]];
        }
    }

    $CarrucelcarrucelesEntity->responsivo(json_encode($options));
    if(empty($id))
    {

        $CarrucelcarrucelesEntity->createdAt(date('Y-m-d H:i:s'));
        $CarrucelcarrucelesEntity->status(1);
    }
    else
    {
        $CarrucelcarrucelesEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $result = $CarrucelcarrucelesModel->save($CarrucelcarrucelesEntity->getArrayCopy());
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

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_CARRUCEL_LIST));

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