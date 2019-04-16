<?php

function changeDir($path = PROJECT_DIR)
{
    $File = new \Franky\Filesystem\File;
    $contenido = array();

    foreach($files = $File->getFiles(realpath($path),'dir') as $file)
    {
        $contenido[] = array($file,'directory');
    }
    foreach($files = $File->getFiles(realpath($path)) as $file)
    {
        $contenido[] = array($file,'file');
    }

    return array("connect" => true,"ls_remoto" => $contenido,"pwd_remoto" => realpath($path));
}


function renameFile($path,$new_path)
{

        if(file_exists($path))
        {
            return rename ( $path, $new_path);
        }

        return true;
}


function eliminarCarpeta($path)
{
    if(file_exists($path))
    {
         return rmdir ($path);
    }

    return true;
}

function eliminarArchivo($path)
{
    if(!is_dir($path))
    {
       return unlink($path);
    }

    return true;
}


function nuevaCarpeta($path)
{
    if(!file_exists($path))
    {
        return mkdir($path,'0777');
    }

    return true;
}

function descargarArchivo($path)
{

    global $MyRequest;
    return ["dowload" => $MyRequest->link(str_replace(PROJECT_DIR, "", $path),false,false)];
}

function getAllFiles($path)
{
    $File = new \Franky\Filesystem\File;
    $files = $File->getAllFiles($path);
  return $files;
}

$MyAjax->register("changeDir");
$MyAjax->register("renameFile");
$MyAjax->register("nuevaCarpeta");
$MyAjax->register("eliminarCarpeta");
$MyAjax->register("eliminarArchivo");
$MyAjax->register("descargarArchivo");
$MyAjax->register("getAllFiles");
?>
