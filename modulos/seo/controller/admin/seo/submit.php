<?php
use Franky\Core\validaciones; 
use Seo\model\SeoModel;
use Seo\entity\SeoEntity;

$SeoEntity = new SeoEntity($MyRequest->getRequest());
$extra_type = $MyRequest->getRequest('extra_type');
$extra_name = $MyRequest->getRequest('extra_name');
$extra_value = $MyRequest->getRequest('extra_value');
$extra_scheme = $MyRequest->getRequest('extra_scheme');
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
    else{
        $SeoEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $extra = [];
    if(!empty($extra_type))
    {
        foreach($extra_type as $k => $v)
        {
            if(!empty($v)):
                $extra[] = ['type' => $v,'name' => $extra_name[$k],'scheme' => $extra_scheme[$k],'value' => $extra_value[$k]];
            endif;
        }
    }
    $SeoEntity->extra(addslashes(json_encode($extra)));
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