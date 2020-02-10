<?php

function _calificaciones($txt)
{
    return dgettext("calificaciones",$txt);
}

function getFrmCalificacion($seccion,$tabla)
{
    global $MyConfigure;
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

    $seccion = '';
    $CalificacionesForm->setAtributoInput('callback','value',$MyRequest->getURI());
    $CalificacionesForm->setAtributoInput('seccion','value',$seccion);

    $MyMetatag->setJs("/public/plugins/calificacion/rating.js");
    $MyMetatag->setCss("/public/plugins/calificacion/rating.css"); 
    
    return render(PROJECT_DIR.'/modulos/calificaciones/diseno/frm.calificaciones.phtml',
    [
        'MySession' => $MySession,
        'CalificacionesForm' => $CalificacionesForm,

    ]);   
}
?>