<?php
use vendor\core\validaciones; 
use modulos\seo\vendor\model\SeoModel;
use modulos\seo\vendor\entity\SeoEntity;

$SeoEntity = new SeoEntity($MyRequest->getRequest());
$error = false;

$validaciones =  new validaciones();
$valid = $validaciones->validRules($SeoEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_SEO))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)        
{
    $MySeo = new SeoModel();
    $id = $SeoEntity->id();
    if(empty($id))
    {
        $SeoEntity->status(1);
        $SeoEntity->fecha(date('Y-m-d H:i:s'));
    }
    $result = $MySeo->save($SeoEntity->getArrayCopy());
    
  
    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  $MyRequest->url(ADMIN_SEO);
        }
        else
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_SEO));
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