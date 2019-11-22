<?php
use Franky\Core\validaciones; 
use Developer\model\CustomattributesModel;
use Developer\entity\CustomattributesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$CustomattributesModel = new CustomattributesModel();
$CustomattributesEntity = new CustomattributesEntity($MyRequest->getRequest());

$id       = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$CustomattributesEntity->data(json_encode($MyRequest->getRequest('data',array())));

if($Tokenizer->decode($MyRequest->getRequest('id')) != false)
{
    $CustomattributesEntity->id($id);
}


$error = false;



$validaciones =  new validaciones();
$valid = $validaciones->validRules($CustomattributesEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($CustomattributesModel->existe($nombre,$entity,$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_categoria_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_CUSTOM_ATTRIBUTES))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}



if($error == false)        
{
    if(empty($id))
    {

        $CustomattributesEntity->createdAt(date('Y-m-d H:i:s'));
        $CustomattributesEntity->status(1);
    }
    else
    {
        $CustomattributesEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $result = $CustomattributesModel->save($CustomattributesEntity->getArrayCopy());
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

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMINISTRAR_CUSTOM_ATTRIBUTES));

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