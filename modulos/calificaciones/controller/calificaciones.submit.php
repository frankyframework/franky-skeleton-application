<?php
use Franky\Core\validaciones; 
use Calificaciones\model\CalificacionesModel;
use Calificaciones\model\CalificacionesgeneralesModel;
use Calificaciones\model\CalificacionesusersModel;
use Calificaciones\model\CalificacionesguestModel;
use Calificaciones\entity\CalificacionesEntity;
use Calificaciones\entity\CalificacionesgeneralesEntity;
use Calificaciones\entity\CalificacionesusersEntity;
use Calificaciones\entity\CalificacionesguestEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$CalificacionesModel = new CalificacionesModel();
$CalificacionesgeneralesModel = new CalificacionesgeneralesModel();
$CalificacionesuserModel = new CalificacionesusersModel();
$CalificacionesguestModel = new CalificacionesguestModel();

$CalificacionesEntity = new CalificacionesEntity($MyRequest->getRequest());
$CalificacionesguestEntity = new CalificacionesguestEntity($MyRequest->getRequest());
$CalificacionesuserEntity = new CalificacionesusersEntity();
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
    $rules = $CalificacionesEntity->setValidationCalificacion();
}
if(getCoreConfig('catalog/calificaciones/tipo') == 'comentario'){
    $rules = $CalificacionesEntity->setValidationComentario();
}
if(getCoreConfig('catalog/calificaciones/tipo') == 'calificacion-comentario'){
    $CalificacionesEntity->calificacion($calificacion);
    $rules = $CalificacionesEntity->setValidationCalificacionComentario();
}

$valid = $validaciones->validRules($rules);
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
    $CalificacionesEntity->createdAt(date('Y-m-d H:i:s'));
    $CalificacionesEntity->status(1);
    $CalificacionesEntity->aprovado(0);
      
    $result = $CalificacionesModel->save($CalificacionesEntity->getArrayCopy());
    if($result == REGISTRO_SUCCESS)
    {
        
        $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        $id = $CalificacionesModel->getUltimoId();

        $CalificacionesModel->exchangeArray([]);
        $CalificacionesModel->tabla($seccion);
        $CalificacionesModel->id_item($id_item);
        $CalificacionesModel->status(1);
        $CalificacionesEntity->aprovado(1);
        $CalificacionesModel->setTampag(1000000000000000);
        $total = 0;
        if($CalificacionesModel->getData($CalificacionesEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            while($registro = $CalificacionesModel->getRows())
            {
                $total += $registro['calificacion'];
            }
        }

        $CalificacionesgeneralesEntity->calificacion($total/$CalificacionesModel->getTotal());
        $CalificacionesgeneralesEntity->tabla($seccion);
        $CalificacionesgeneralesEntity->id_item($id_item);  
        $CalificacionesgeneralesModel->save($CalificacionesgeneralesEntity->getArrayCopy());      

        if(!$MySession->LoggedIn())
        {
            $CalificacionesguestEntity->id_calificacion($id);
            $CalificacionesguestModel->save($CalificacionesguestEntity->getArrayCopy());
        }
        else
        {
            $CalificacionesusersEntity->id_calificacion($id);
            $CalificacionesusersEntity->id_user($seccion);
            $CalificacionesusersModel->save($CalificacionesusersEntity->getArrayCopy());      
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