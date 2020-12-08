<?php
include 'lca.php';
include 'util.php';
bindtextdomain("carrucel", PROJECT_DIR .'/modulos/carrucel/locale');


if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("carrucel", 'UTF-8');
}


$MyMetatag->setJs("/public/js/carrucel.js");
?>