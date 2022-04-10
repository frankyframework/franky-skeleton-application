<?php
use Franky\Core\ObserverManager;
$ObserverManager = new ObserverManager;
include 'lca.php';
include 'util.php';
__bindtextdomain("calificaciones", "calificaciones");

if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("calificaciones", 'UTF-8');
}

$ObserverManager->addObserver('login_user','calificaciones_completarTareas');

$MyMetatag->setJs("/public/js/calificaciones.js");
?>