<?php
define('PROJECT_DIR',$_SERVER["DOCUMENT_ROOT"]);
require(PROJECT_DIR."/modulos/base/loads/init.php");

$MyAjax = new \Franky\Core\Ajax();

$modulos = getModulos();
if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
        $File = new \Franky\Filesystem\File();
        $files = $File->getFiles(PROJECT_DIR."/modulos/$modulo/ajax/","file");

        if(count($files) > 0)
        {
            foreach($files as $file)
            {
                    include_once(PROJECT_DIR."/modulos/$modulo/ajax/".$file);
            }
        }
    }
}

$MyAjax->execute($CONTEXT);
?>
