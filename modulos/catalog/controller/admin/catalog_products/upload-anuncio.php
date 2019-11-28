<?php
use Franky\Filesystem\File;

if(!$MyRequest->isAjax() || !$MyAccessList->MeDasChancePasar(SUSCRIPTOR_ADMINISTRAR_EXPERIENCIAS_PUBLICADAS))
{
    $MyRequest->redirect();
}

$respuesta = array("error" => false);

$usadas = 0;
foreach($_SESSION['album_'.$album] as $img)
{
  $usadas++;
}
if($usadas >= 12)
{
  $MyRequest->redirect();
}


$album = $MySession->GetVar('addExperiencia');

$dir = $MyConfigure->getServerUploadDir()."/experiencias/".$MySession->GetVar('id')."/$album/";
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
            $handle->file_auto_rename = true;
            $handle->file_overwrite = false;

            $handle->Process($dir);

            if ($handle->processed)
            {
                $respuesta["img"][] = array("name" => $handle->file_dst_name, "error" => false, "msg" => "", "html" => getBingooFotoExperiencia($album,$handle->file_dst_name,md5($handle->file_dst_name),$MySession->GetVar('id')));
            //    $_SESSION[$album] = array();
                $_SESSION['album_'.$album][] = array("token" => md5($handle->file_dst_name), "img" => $handle->file_dst_name);
            }
            else
            {
               $respuesta["img"][] = array("name" => $handle->file_dst_name, "error" => true, "msg" => "Error al subir la imagen");
            }
        }
        else
        {
            $respuesta["img"][] = array("name" => $handle->file_dst_name, "error" => true, "msg" => "Solo puedes subir archivos de imagen");
        }
    }
    else
    {
        $respuesta["img"][] = array("name" => $handle->file_dst_name, "error" => true, "msg" => "Error al subir la imagen");
    }
}

header('Content-Type: application/json');
echo json_encode($respuesta);

?>
