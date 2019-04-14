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

$MyAjax->register("EliminarPagina");
?>
