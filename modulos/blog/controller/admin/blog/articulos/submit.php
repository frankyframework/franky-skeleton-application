<?php
use Blog\model\Blog;
use Franky\Core\validaciones;
use Base\entity\redireccionesEntity;
use Blog\model\BorradorblogModel;
use Blog\entity\BorradorblogEntity;
use Franky\Filesystem\File;

use Franky\Haxor\Tokenizer;

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

$lang   = $MyRequest->getRequest('lang');
$autortext   = $MyRequest->getRequest('autortext');

$data_img   = json_decode(stripslashes($MyRequest->getRequest('data_img')),true);

$visible_in_search   = $MyRequest->getRequest('visible_in_search',0);
$permisos   = $MyRequest->getRequest('permisos',array());
$error = false;
$rules = array(
            "Titulo" => array("valor" => $titulo,"required","length" => array("max" => "255")),
            "Categoria" => array("valor" => $categoria,"required","numeric"),
            "Articulo" => array("valor" => $contenido,"required"),
            "Keywords" => array("valor" => $keywords,"length" => array("max" => "255"))
            );


$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

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
            $imagen = $handle->file_dst_name;
            $handle->image_rotate          = $data_img['angle'];
            $image_x            = intval(($data_img['x']+$data_img['w'])/$data_img['scale']);
            $image_y            = intval(($data_img['y']+$data_img['h'])/$data_img['scale']);

            $handle->image_crop  = intval($data_img['y']/$data_img['scale']) .' '.($width-$image_x).' '.($height-$image_y).' '.intval($data_img['x']/$data_img['scale']);

            $handle->Process($dir_blog);
            $imagen_portada = $handle->file_dst_name;
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
          $imagen= $data_img['imagen'];
          $imagen_portada = $data_img['imagen_portada'];
      }
  }

}

if($error == false)
{

    if(getCoreConfig('blog/idioma/multi-idioma') == 1)
    {
        $MyBlog->setLang($lang);
    }
    if(empty($id))
    {
        $result = $MyBlog->save($categoria,$titulo,  getFriendly($titulo),$autortext,$contenido,$comentarios,$MySession->GetVar('id'),$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search,json_encode($permisos),$meta_titulo, $meta_descripcion);
        if($result == REGISTRO_SUCCESS)
        {

            rename($dir_blog,str_replace($MySession->GetVar('path_img_blog'),$MyBlog->getUltimoID(),$dir_blog));

            $contenido = str_replace($MySession->GetVar('path_img_blog'),$MyBlog->getUltimoID(),$contenido);
            $MyBlog->edit($MyBlog->getUltimoID(),$categoria,$titulo,  getFriendly($titulo),$autortext,$contenido,$comentarios,$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search, json_encode($permisos),$meta_titulo, $meta_descripcion);

            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("blog_guardar_articulo_success"));
            $location =  $MyRequest->url(ADMIN_LISTA_ARTICULOS_BLOG);
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_guardar_articulo_error"));
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
        $MyBlog->setIsAdmin(1);
         $MyBlog->getData($id);
         $registro = $MyBlog->getRows();
         $_titulo		= $registro["titulo"];
         $_categoria                 = $registro["categoria"];


         $friendly_categoria          = $registro["amigable_categoria"];
         $friendly              = $registro["friendly"];



        $result = $MyBlog->edit($id,$categoria,$titulo,  getFriendly($titulo),$autortext,$contenido,$comentarios,$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search, json_encode($permisos),$meta_titulo, $meta_descripcion);
        if($result == REGISTRO_SUCCESS)
        {

            if($borrador == 1)
            {
                $BorradorblogEntity->id_blog($id);
                $BorradorblogModel->eliminar($BorradorblogEntity->getArrayCopy());
            }
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("blog_editar_articulo_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_LISTA_ARTICULOS_BLOG));

            if(getFriendly(($titulo)) != $friendly || $categoria != $_categoria)
            {

                $url = $MyRequest->url(BLOG_DETALLE,array("categoria" => $friendly_categoria,"articulo" =>$friendly),true);


                $MyBlog->free();
                $MyBlog->getData($id);
                $registro = $MyBlog->getRows();


                $friendly_categoria          = $registro["amigable_categoria"];

                $friendly              = $registro["friendly"];
                $urln =  $MyRequest->url(BLOG_DETALLE,array("categoria" => $friendly_categoria,"articulo" =>$friendly),true);

                $redireciconesEntity = new redireccionesEntity();

                if($MyRedireccion->existe($urln) == REGISTRO_SUCCESS)
                {
                    $registro = $MyRedireccion->getRows();
                    $redireciconesEntity->setId($registro["id"]);
                    $redireciconesEntity->setStatus(0);
                    $MyRedireccion->save($redireciconesEntity->getArrayCopy());
                }

                $MyRedireccion->free();

                if($MyRedireccion->existe($url,'',$urln) == REGISTRO_SUCCESS)
                {
                    $registro = $MyRedireccion->getRows();
                    $redireciconesEntity->setId($registro["id"]);
                    $redireciconesEntity->setStatus(1);
                    $MyRedireccion->save($redireciconesEntity->getArrayCopy());
                }
                else
                {
                    $redireciconesEntity->exchangeArray([]);
                    $redireciconesEntity->setUrl($url);
                    $redireciconesEntity->setRedireccion($urln);
                    $redireciconesEntity->setStatus(1);
                     $redireciconesEntity->setFecha(date('Y-m-d H:i:s'));
                    $MyRedireccion->save($redireciconesEntity->getArrayCopy());
                }
            }
	}
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_editar_articulo_error"));
            $location = $MyRequest->getReferer();
        }
    }

}
else
{

    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>
