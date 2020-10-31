<?php
include 'lca.php';
include 'util.php';

bindtextdomain("franky", PROJECT_DIR ."/modulos/franky/locale");


if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset("franky", 'UTF-8');
}


$MyMetatag->setCss("https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i");

// $MyMetatag->setCss("/public/skin/theme_name/css/franky-font-extended/style.css");
// $MyMetatag->setJs("/public/js/theme_name.js");

?>
