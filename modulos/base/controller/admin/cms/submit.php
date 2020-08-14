<?php
use Base\entity\redireccionesEntity;
use Franky\Core\validaciones;

$id             = $MyRequest->getRequest('id');
$callback       = $MyRequest->getRequest('callback');
$mostrar_titulo = $MyRequest->getRequest('mostrar_titulo',0);
$titulo         = $MyRequest->getRequest('titulo');
$template       = $MyRequest->getRequest('template',"",true);
$meta_titulo    = $MyRequest->getRequest('meta_titulo');
$meta_descripcion       = $MyRequest->getRequest('meta_descripcion');
$nametemplate    = $MyRequest->getRequest('friendly');
$MyCMS = new \Base\model\CMS;

$error = false;

$rules = array(
            "Titulo" => array("valor" => $titulo,"required","length" => array("max" => "200")),
            "Template" => array("valor" => $template,"required"),
            "URL" => array("valor" => $nametemplate,"required"),
            "Metatag titulo" => array("valor" => $meta_titulo,"required","length" => array("max" => "200")),
            "Metatag descripción" => array("valor" => $meta_descripcion,"required","length" => array("max" => "200")),
            );


$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($MyCMS->existeTemplate($nombre,$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("nombre_template_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_CMS_TEMPLATE))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($validaciones->validaUrl($nametemplate))
{
  $parse_url = parse_url($nametemplate);
  $path  = explode("/",$parse_url['PHP_URL_PATH']);
  $nametemplate = "/";
  foreach($path as $k)
  {
    if(!empty($k))
    {
      $nametemplate .= getFriendly($k)."/";
    }

  }
}
else {
  $path  = explode("/",$nametemplate);
  $nametemplate = "/";
  foreach($path as $k)
  {
    if(!empty($k))
    {
      $nametemplate .= getFriendly($k)."/";
    }

  }
}

if($error == false)
{
    if(empty($id))
    {

        $result = $MyCMS->save($titulo,$nametemplate,$template,$meta_titulo,$meta_descripcion,$mostrar_titulo);
        if($result == REGISTRO_SUCCESS)
        {
            $dir_blog = $MyConfigure->getServerUploadDir()."/cms/".$MySession->GetVar('path_img_blog')."/";
            rename($dir_blog,str_replace($MySession->GetVar('path_img_blog'),$MyCMS->getUltimoID(),$dir_blog));

            $template = str_replace($MySession->GetVar('path_img_blog'),$MyCMS->getUltimoID(),$template);
            $MyCMS->edit($MyCMS->getUltimoID(),$titulo,$nametemplate,$template,$meta_titulo,$meta_descripcion,$mostrar_titulo);


            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_CMS_TEMPLATE));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
        $MyCMS->getData($id);
        $registro = $MyCMS->getRows();
        $_titulo		= $registro["titulo"];
        $friendly              = $registro["friendly"];



        $result = $MyCMS->edit($id,$titulo,$nametemplate,$template,$meta_titulo,$meta_descripcion,$mostrar_titulo);

        if($result == REGISTRO_SUCCESS)
        {


            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_CMS_TEMPLATE));

            if($nametemplate != $friendly)
            {

                $url = $MyRequest->link($friendly,false,true);
                $urln =  $MyRequest->link($nametemplate,false,true);

                $redireciconesEntity = new redireccionesEntity();

                if($MyRedireccion->existe($urln) == REGISTRO_SUCCESS)
                {
                    $registro = $MyRedireccion->getRows();
                    $redireciconesEntity->setId($registro["id"]);
                    $redireciconesEntity->setStatus(0);
                    $MyRedireccion->save($redireciconesEntity->getArrayCopy());
                }

                $MyRedireccion->free();

                if($MyRedireccion->existe($url) == REGISTRO_SUCCESS)
                {
                    $registro = $MyRedireccion->getRows();
                    $redireciconesEntity->setId($registro["id"]);
                    $redireciconesEntity->setStatus(1);
                    $MyRedireccion->save($redireciconesEntity->getArrayCopy());
                }
                else
                {
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
           $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
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
