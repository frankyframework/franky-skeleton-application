<?php
include 'lca.php';
include 'util.php';
bindtextdomain("{nombre}", PROJECT_DIR ."/modulos/{nombre}/locale");


if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("{nombre}", 'UTF-8');
}

?>