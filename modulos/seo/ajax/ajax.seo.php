<?php


function EliminarRedireccion($id,$status)
{
	global $MyRedireccion;
        global $MyAccessList;
        global $MyMessageAlert;
        
        $redireccionEntity = new Base\entity\redireccionesEntity();
        $redireccionEntity->setId($id);
        $redireccionEntity->setStatus($status);
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_REDIRECCIONES_301))
        {
            if($MyRedireccion->save($redireccionEntity->getArrayCopy()) == REGISTRO_SUCCESS)
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

function EliminarSeo($id,$status)
{
        global $MyAccessList;
        global $MyMessageAlert;

        $MySeo              = new \Seo\model\SeoModel();
        $SeoEntity              = new \Seo\entity\SeoEntity();
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_SEO))
        {
            $SeoEntity->id(addslashes($id));
            $SeoEntity->status(addslashes($status));
            if($MySeo->save($SeoEntity->getArrayCopy()) == REGISTRO_SUCCESS)
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

$MyAjax->register("EliminarRedireccion");
$MyAjax->register("EliminarSeo");
?>