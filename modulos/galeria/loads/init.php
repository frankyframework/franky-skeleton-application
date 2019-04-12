<?php
include 'lca.php';
include 'util.php';
bindtextdomain("galeria", PROJECT_DIR .'/modulos/galeria/locale');


if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("galeria", 'UTF-8');
}


$MyMetatag->setJs("/public/js/galeria.js");
?>