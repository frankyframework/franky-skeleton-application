<?php
use Franky\Core\validaciones;
use Developer\entity\organosEntity;
use Developer\model\ORGANOS;



$organosEntity    = new organosEntity($MyRequest->getRequest());
$OrganosCorporales  = new ORGANOS();


$organosEntity->setCss(json_encode($MyRequest->getRequest('css',array())));
$organosEntity->setJs(json_encode($MyRequest->getRequest('js',array())));
$organosEntity->setJquery(json_encode($MyRequest->getRequest('jquery',array())));
$organosEntity->setPermisos(json_encode($MyRequest->getRequest('permisos',array())));
$organosEntity->setAjax(json_encode($MyRequest->getRequest('ajax',array())));
$organosEntity->setConstante(strtoupper($MyRequest->getRequest('constante')));

$error = false;

$validaciones =  new validaciones();
$valid = $validaciones->validRules($organosEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($OrganosCorporales->findPagina("nombre", $organosEntity->getNombre(),$organosEntity->getId()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("developer_nombre_pagina_duplicado"));
    $error = true;
}
if($OrganosCorporales->findPagina("constante", $organosEntity->getConstante(),$organosEntity->getId()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("developer_constante_pagina_duplicado"));
    $error = true;
}
if($OrganosCorporales->findPagina("url", $organosEntity->getUrl(),$organosEntity->getId()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("developer_url_pagina_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_FRANKY))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)
{
    $result = $OrganosCorporales->save($organosEntity->getArrayCopy());
    $id = $organosEntity->getId();

    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("success", $MyMessageAlert->Message("guardar_generico_success"));
            $location =  $MyRequest->url(LISTA_PAGINAS);
        }
        else
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_PAGINAS));
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
