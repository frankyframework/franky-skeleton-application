<?php
define('PROJECT_DIR',$_SERVER["DOCUMENT_ROOT"]);
require(PROJECT_DIR."/modulos/base/loads/init.php");

$path = ltrim(str_replace("/public/php/","",parse_url($MyRequest->getURI(),PHP_URL_PATH)),'/');



$modulos = getModulos('DESC');


foreach($modulos as $modulo)
{
    if(file_exists(PROJECT_DIR."/modulos/$modulo/configure/alias.php"))
    {
        $files[$modulo] = include(PROJECT_DIR."/modulos/$modulo/configure/alias.php");
    }
}
$_files = array();
foreach ($files as $k => $v)
{
    foreach ($v as $_k => $_v)
    {
            $_files[$_k] = $_v;
    }

}

if(isset($_files[$path]) && file_exists($_files[$path]))
{
    require($_files[$path]);
}
else
{

    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");
    $MyRequest->redirect($MyRequest->url(ERR_404));
}


?>
