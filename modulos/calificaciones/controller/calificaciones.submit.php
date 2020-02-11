<?php
use Franky\Core\validaciones; 
use Calificaciones\model\CalificacionesModel;
use Calificaciones\model\CalificacionesgeneralesModel;
use calificaciones\model\CalificacionesuserModel;
use calificaciones\model\CalificacionesguestModel;
use Calificaciones\entity\CalificacionesEntity;
use Calificaciones\entity\CalificacionesgeneralesEntity;
use Calificaciones\entity\CalificacionesuserEntity;
use Calificaciones\entity\CalificacionesguestEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$CalificacionesModel = new CalificacionesModel();
$CalificacionesgeneralesModel = new CalificacionesgeneralesModel();
$CalificacionesuserModel = new CalificacionesuserModel();
$CalificacionesguestModel = new CalificacionesguestModel();

$CalificacionesEntity = new CalificacionesEntity($MyRequest->getRequest());
$CalificacionesguestEntity = new CalificacionesguestEntity($MyRequest->getRequest());
$CalificacionesuserEntity = new CalificacionesuserEntity();
$CalificacionesgeneralesEntity = new CalificacionesgeneralesEntity();


$calificacion       = $MyRequest->getRequest('calificacion');
$seccion       = $Tokenizer->decode($MyRequest->getRequest('seccion'));
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$id_item = $Tokenizer->decode($MyRequest->getRequest('id_item'));
$CalificacionesEntity->id_item($id_item);
$CalificacionesEntity->tabla($seccion);
if(empty($calificacion))
{
    $calificacion = 1;
}

$error = false;

$validaciones =  new validaciones();

if(getCoreConfig('catalog/calificaciones/tipo') == 'calificacion')
{
    $CalificacionesEntity->calificacion($calificacion);
    $validaciones = $CalificacionesEntity->setValidationCalificacion();
}
if(getCoreConfig('catalog/calificaciones/tipo') == 'comentario'){
    $validaciones = $CalificacionesEntity->setValidationComentario();
}
if(getCoreConfig('catalog/calificaciones/tipo') == 'calificacion-comentario'){
    $CalificacionesEntity->calificacion($calificacion);
    $validaciones = $CalificacionesEntity->setValidationCalificacionComentario();
}

$valid = $validaciones->validRules($validaciones);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if(!$MySession->LoggedIn() && getCoreConfig('catalog/calificaciones/guest') == 1):
    $valid = $validaciones->validRules($CalificacionesguestEntity->setValidation());
    if(!$valid)
    {
        $MyFlashMessage->setMsg("error",$validaciones->getMsg());
        $error = true;
    }
endif;

if(!$MySession->LoggedIn() && getCoreConfig('catalog/calificaciones/guest') == 0):
    //pendiente.
    $MySession->SetVar('calificaciones_eventos_pendientes',[
        'calificaciones' => $CalificacionesEntity->getArrayCopy()
    ]);
    $MyRequest->redirect(LOGIN);
endif;

if($error == false)        
{
    if(empty($id))
    {

        $CalificacionesEntity->createdAt(date('Y-m-d H:i:s'));
        $CalificacionesEntity->status(1);
        $CalificacionesEntity->aprovado(0);
    }
    else
    {
        $CalificacionesEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $result = $CalificacionesModel->save($CalificacionesEntity->getArrayCopy());
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

        $location = $callback;

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