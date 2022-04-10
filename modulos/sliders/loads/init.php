<?php
include 'lca.php';
include 'util.php';
__bindtextdomain("sliders",'sliders');

if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset("sliders", 'UTF-8');
}
$MyMetatag->setCss("/public/skin/sliders/css/sliders.css");
?>
