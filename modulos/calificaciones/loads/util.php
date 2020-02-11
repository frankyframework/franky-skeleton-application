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
?>