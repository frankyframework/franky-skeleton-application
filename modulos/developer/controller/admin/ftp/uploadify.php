<?php
$respuesta = array("error" => false);  
$path = $MyRequest->getRequest('path');

$files = array();
foreach ($_FILES['files'] as $k => $l) {
    foreach ($l as $i => $v) {
        if (!array_key_exists($i, $files))
            $files[$i] = array();
        $files[$i][$k] = $v;
    }
}      
     
if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_FTP))
{

    $respuesta = array("error" => true,"msg" => $MyMessageAlert->Message("sin_privilegios"));  
}
        
        
foreach ($files as $file) 
{    
    $handle = new \Franky\Filesystem\Upload($file);
    if ($handle->uploaded)
    {
              
        $handle->file_max_size = 1024*1024*100; //1k(1024) x 512
       

        $handle->Process($path);

        if ($handle->processed)
        {

          
           $respuesta["file"][] = array("name" => $file['name'], "error" => false, "msg" => "");
        }
        else
        {
           $respuesta["file"][] = array("name" => $file['name'], "error" => true, "msg" => "Error al subir la imagen");
        }

    }
    else
    {
        $respuesta["file"][] = array("name" => $file['name'], "error" => true, "msg" => "Error al subir la imagen");
    }
}
if($MyRequest->isAjax())
{
    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
else
{
    $MyRequest->redirect();
}
?>