<?php
include 'lca.php';
include 'util.php';
__bindtextdomain("blog", "blog");


if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset("blog", 'UTF-8');
}


$MyMetatag->setCss("/public/skin/blog/css/blog.css");
$MyMetatag->setJs("/public/js/blog.js");
?>
