<?php
include 'lca.php';
include 'util.php';
bindtextdomain("catalog", PROJECT_DIR ."/modulos/catalog/locale");


if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("catalog", 'UTF-8');
}

?>