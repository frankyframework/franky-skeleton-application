<?php
include 'lca.php';
include 'util.php';
__bindtextdomain("galeria", 'galeria');

if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("galeria", 'UTF-8');
}


$MyMetatag->setJs("/public/js/galeria.js");
?>