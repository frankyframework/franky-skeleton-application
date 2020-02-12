<?php

function _calificaciones($txt)
{
    return dgettext("calificaciones",$txt);
}

function getFrmCalificacion($seccion,$tabla,$id)
{
    if(getCoreConfig($seccion.'/calificaciones/enabled') == 0)
    {
        return '';
    }
    global $MyMetatag;
    global $MySession;
    global $MyRequest;
    global $MyFrankyMonster;
    $uiCommand = $MyFrankyMonster->getUiCommand($MyFrankyMonster->MySeccion());
  
    if (is_array($uiCommand[3])) {
        if (!in_array('jquery-validate',$uiCommand[3])) 
        {
            $MyMetatag->setJs("/public/jquery/jquery-validate/js/jquery.validate.min.js");
            $MyMetatag->setCss("/public/jquery/jquery-validate/css/validate.css");
        }     
    }
    else{
        $MyMetatag->setJs("/public/jquery/jquery-validate/js/jquery.validate.min.js");
        $MyMetatag->setCss("/public/jquery/jquery-validate/css/validate.css");
    }
    $CalificacionesForm = new \Calificaciones\Form\CalificacionesForm('frmreview');
    $Tokenizer = new Franky\Haxor\Tokenizer;

    $CalificacionesForm->setAtributoInput('callback','value',$Tokenizer->token("calificaciones", $MyRequest->getURI()));
    $CalificacionesForm->setAtributoInput('seccion','value',$Tokenizer->token("calificaciones", $tabla));
    $CalificacionesForm->setAtributoInput('id_item','value',$Tokenizer->token("calificaciones", $id));
    $MyMetatag->setJs("/public/plugins/calificacion/rating.js");
    $MyMetatag->setCss("/public/plugins/calificacion/rating.css"); 
    
    return render(PROJECT_DIR.'/modulos/calificaciones/diseno/frm.calificaciones.phtml',
    [
        'MySession' => $MySession,
        'CalificacionesForm' => $CalificacionesForm,
        'seccion' => $seccion

    ]);   
}


function catalog_completarTareas()
{
    global $MySession;
    global $MyRequest;
    global $MyFlashMessage;
    global $MyMessageAlert;
    $eventos_pendientes = $MySession->GetVar('calificaciones_eventos_pendientes');


    if(isset($eventos_pendientes['calificaciones']))
    {
        $CatalogwishlistModel = new Calificaciones\model\CatalogwishlistModel;
        $CatalogwishlistEntity = new Calificaciones\entity\CatalogwishlistEntity($eventos_pendientes['wishlist']);

        $CalificacionesModel = new \Calificaciones\model\CalificacionesModel();
        $CalificacionesgeneralesModel =  new \Calificaciones\model\CalificacionesgeneralesModel();
        $CalificacionesuserModel = new \Calificaciones\model\CalificacionesusersModel();
        
        $CalificacionesEntity = new \Calificaciones\entity\CalificacionesEntity($MyRequest->getRequest());
        $CalificacionesuserEntity = new Calificaciones\entity\CalificacionesusersEntity();
        $CalificacionesgeneralesEntity = new Calificaciones\entity\CalificacionesgeneralesEntity();
        
        $CalificacionesEntity->createdAt(date('Y-m-d H:i:s'));
        $CalificacionesEntity->status(1);
        $CalificacionesEntity->aprovado(0);

        $result = $CalificacionesModel->save($CalificacionesEntity->getArrayCopy());
        if($result == REGISTRO_SUCCESS)
        {
            $id = $CalificacionesModel->getUltimoId();

            $CalificacionesEntity->exchangeArray([]);
            $CalificacionesEntity->status(1);
            $CalificacionesEntity->aprovado(1);
            $CalificacionesModel->setTampag(1000000000000000);
            $total = 0;
            if($CalificacionesModel->getData($CalificacionesEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {
                while($registro = $CalificacionesModel->getRows())
                {
                    $total += $registro['calificacion'];
                }
                $total = $total/$CalificacionesModel->getTotal();
            }

            $CalificacionesgeneralesEntity->calificacion($total);
            $CalificacionesgeneralesEntity->tabla($CalificacionesEntity->tabla());
            $CalificacionesgeneralesEntity->id_item($CalificacionesEntity->id_item());  
            $CalificacionesgeneralesModel->save($CalificacionesgeneralesEntity->getArrayCopy());      

            $CalificacionesusersEntity->id_calificacion($CalificacionesEntity->id_item());
            $CalificacionesusersEntity->id_user($CalificacionesEntity->tabla());
            $CalificacionesusersModel->save($CalificacionesusersEntity->getArrayCopy());      

        }

    }

    $MySession->UnsetVar('calificaciones_eventos_pendientes');

}

?>