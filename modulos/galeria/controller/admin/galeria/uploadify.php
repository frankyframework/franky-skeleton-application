<?php
use Galeria\model\fotos;
$MyFoto = new fotos();
$respuesta = array("error" => false);  
$album = $MyRequest->getRequest('album');

$dir = $MyConfigure->getServerUploadDir()."/galeria/";
if(!file_exists($dir))
{
    mkdir($dir, 0777);
    chmod($dir,0777);
}
$dir = $MyConfigure->getServerUploadDir()."/galeria/$album/";
if(!file_exists($dir))
{
    mkdir($dir, 0777);
    chmod($dir,0777);
}

$files = array();
foreach ($_FILES['photos'] as $k => $l) {
    foreach ($l as $i => $v) {
        if (!array_key_exists($i, $files))
            $files[$i] = array();
        $files[$i][$k] = $v;
    }
}      
     
if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
{

    $respuesta = array("error" => true,"msg" => $MyMessageAlert->Message("sin_privilegios"));  
}
        
        
foreach ($files as $file) 
{    
    $handle = new \Franky\Filesystem\Upload($file);
    if ($handle->uploaded)
    {
        if  (in_array(strtolower(pathinfo($file["name"], PATHINFO_EXTENSION)),array("jpg","png","gif","bmp","jpe","jpeg")))//($handle->file_is_image)
        {      
            $handle->file_max_size = 1024*1024*100; //1k(1024) x 512
            //$handle->image_resize = true;
            //$handle->image_x = 800;
            //$handle->image_y = 600;

            //$handle->image_ratio = true; //Conserva proporciones
            //$handle->image_background_color = '#000000';
            //$handle->image_ratio_fill = true; // Agrega cuadro para completar la medida
            //$handle->image_watermark       = "../imags/pie-foto.png";
            //$handle->image_watermark_position = 'BR';

            $handle->Process($dir);

            if ($handle->processed)
            {

               $MyFoto->save($handle->file_dst_name,$album);
               $respuesta["img"][] = array("name" => $file['name'], "error" => false, "msg" => "");
            }
            else
            {
               $respuesta["img"][] = array("name" => $file['name'], "error" => true, "msg" => "Error al subir la imagen");
            }
        }
        else
        {
            $respuesta["img"][] = array("name" => $file['name'], "error" => true, "msg" => "Solo puedes subir archivos de imagen");
        }
    }
    else
    {
        $respuesta["img"][] = array("name" => $file['name'], "error" => true, "msg" => "Error al subir la imagen");
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