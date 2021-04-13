<?php
use Blog\model\Blog;
use Blog\model\BorradorblogModel;
use Blog\entity\BorradorblogEntity;
use Franky\Haxor\Tokenizer;
use Franky\Filesystem\File;

$Tokenizer = new Tokenizer();
$MyBlog = new Blog();
$BorradorblogModel = new BorradorblogModel();
$BorradorblogEntity = new BorradorblogEntity();

$imagen = "";
$imagen_portada = "";
$id                 = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback           = $Tokenizer->decode($MyRequest->getRequest('callback'));
$borrador             = $MyRequest->getRequest('borrador');
$titulo             = $MyRequest->getRequest('titulo');
$categoria          = $MyRequest->getRequest('categoria');
$contenido          = $MyRequest->getRequest('contenido',"",true);
$comentarios        = $MyRequest->getRequest('comentarios',0);
$keywords           = $MyRequest->getRequest('keywords');
$destacado          = $MyRequest->getRequest('destacado',0);
$meta_titulo        = $MyRequest->getRequest('meta_titulo');
$meta_descripcion   = $MyRequest->getRequest('meta_descripcion');
$visible_in_search    = $MyRequest->getRequest('visible_in_search',0);
$permisos             = $MyRequest->getRequest('permisos',array());
$autortext   = $MyRequest->getRequest('autortext');
$lang   = $MyRequest->getRequest('lang');

$data_img   = json_decode(stripslashes($MyRequest->getRequest('data_img')),true);

$data = $MyRequest->getRequest();
$error = false;


if($MyBlog->existe($titulo,$categoria,$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_articulo_duplicado"));
    $error = true;
}


if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_ARTICULOS_BLOG))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}


$dir_blog = $MyConfigure->getServerUploadDir()."/blog/".$MySession->GetVar('path_img_blog')."/";
$File = new File();
$File->mkdir($dir_blog);
$handle = new \Franky\Filesystem\Upload($_FILES["imagen"]);
if ($handle->uploaded)
{
    if  (in_array(strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION)),array("jpg","png","gif","bmp","jpe","jpeg")))//($handle->file_is_image)
    {
        $fileinfo = @getimagesize($_FILES["imagen"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $handle->file_max_size = "22024288"; //1k(1024) x 512
        $handle->image_resize= false;
        $handle->image_ratio_fill = true;
        $handle->file_auto_rename = true;
        $handle->file_overwrite = false;
        $handle->image_background_color = '#FFFFFF';

        $handle->Process($dir_blog);

        if ($handle->processed)
        {
            $data['imagen'] = $handle->file_dst_name;
            $handle->image_ratio_crop      = true;

            $image_x            = intval(($data_img['x']+$data_img['w'])/$data_img['scale']);
            $image_y            = intval(($data_img['y']+$data_img['h'])/$data_img['scale']);

            $handle->image_crop  = intval($data_img['y']/$data_img['scale']) .' '.($width-$image_x).' '.($height-$image_y).' '.intval($data_img['x']/$data_img['scale']);


            $handle->Process($dir_blog);
            $data['imagen_portada'] = $handle->file_dst_name;
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("imagen_error",$handle->error));
            $error = true;
        }
    }
    else
    {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("solo_imagen"));
        $error = true;
    }
}
else {
  if(!empty($borrador))
  {
      if(!empty($data_img))
      {
          $data['imagen'] = $data_img['imagen'];
          $data['imagen_portada'] = $data_img['imagen_portada'];
      }
  }

}

if($error == false)
{
    if(!empty($id))
    {
        $BorradorblogEntity->id_blog($id);
        $BorradorblogModel->eliminar($BorradorblogEntity->getArrayCopy());

        $BorradorblogEntity->fecha(date('Y-m-d H:i:s'));
        unset($data['guardar']);
        unset($data['callback']);
        unset($data['borrador']);
        unset($data['data_img']);
        $data['id'] = $id;
        $data['contenido'] = ($contenido);
        $BorradorblogEntity->data((json_encode($data)));

        $result = $BorradorblogModel->save($BorradorblogEntity->getArrayCopy());
        if($result == REGISTRO_SUCCESS)
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("blog_guardar_borrador_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_LISTA_ARTICULOS_BLOG));

        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_guardar_borrador_error"));
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_guardar_borrador_error"));
            $location = $MyRequest->getReferer();
    }

}
else
{

    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>
