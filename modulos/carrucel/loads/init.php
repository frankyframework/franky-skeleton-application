<?php
include 'lca.php';
include 'util.php';
__bindtextdomain("carrusel", 'carrusel');


if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("carrucel", 'UTF-8');
}


$MyMetatag->setJs("/public/js/carrucel.js");
?>