<?php
use Carrucel\model\CarrucelfotosModel;
use Carrucel\entity\CarrucelfotosEntity;
use Franky\Haxor\Tokenizer;
use Franky\Filesystem\File;



$Tokenizer = new Tokenizer();

$CarrucelfotosModel = new CarrucelfotosModel();
$CarrucelfotosEntity = new CarrucelfotosEntity();

$respuesta = array("error" => false);  
$carrucel	= $Tokenizer->decode($MyRequest->getRequest('carrucel'));

$dir = $MyConfigure->getServerUploadDir()."/carruceles/".$carrucel.'/';
$File = new File();
$File->mkdir($dir);

$files = array();
foreach ($_FILES['photos'] as $k => $l) {
    foreach ($l as $i => $v) {
        if (!array_key_exists($i, $files))
            $files[$i] = array();
        $files[$i][$k] = $v;
    }
}      
     
if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_CARRUCEL))
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
            if($handle->image_src_x > 2000 || $handle->image_src_y > 2000)
            {
                $handle->image_resize = true;
                $handle->image_x = 2000;
                $handle->image_y = 2000;
            }
            $handle->file_auto_rename = true;
            $handle->file_overwrite = false;

            $handle->Process($dir);

            if ($handle->processed)
            {
                $CarrucelfotosEntity->id_carrucel($carrucel);
                $CarrucelfotosEntity->foto($handle->file_dst_name);
                $CarrucelfotosEntity->status(1);
                $CarrucelfotosEntity->createdAt(date('Y-m-d H:i:s'));

               $CarrucelfotosModel->save($CarrucelfotosEntity->getArrayCopy());
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