<?php
function EliminarPagina($id,$status)
{

        global $MyAccessList;
        global $MyMessageAlert;

        $OrganosCorporales  = new \Developer\model\ORGANOS();

        $organosEntity = new \Developer\entity\organosEntity();
        $organosEntity->setId($id);
        $organosEntity->setStatus($status);
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_FRANKY))
        {
            if($OrganosCorporales->save($organosEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

            }
            else
            {
		 $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function EliminarCustomAttribute($id,$status)
{
    global $MySession;
    $CustomattributesModel =  new \Base\model\CustomattributesModel();
    $CustomattributesEntity =  new \Base\entity\CustomattributesEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_CUSTOM_ATTRIBUTES))
    {
        $CustomattributesEntity->id(addslashes($Tokenizer->decode($id)));
        $CustomattributesEntity->status($status);

        if($CustomattributesModel->save($CustomattributesEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("custom_attribute_error_delete");
              $respuesta["error"] = true;
        }
    }
    else
    {
         $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
         $respuesta["error"] = true;
    }

    return $respuesta;
}

$MyAjax->register("EliminarPagina");
$MyAjax->register("EliminarCustomAttribute");
?>
