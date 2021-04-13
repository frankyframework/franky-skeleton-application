<?php
use Franky\Core\validaciones; 
use Blog\model\categoriasBlog;
$MyCategoriaBlog = new categoriasBlog();

$id                 = $MyRequest->getRequest('id');
$callback           = $MyRequest->getRequest('callback');
$nombre             = $MyRequest->getRequest('nombre');
$visible             = $MyRequest->getRequest('visible',0);
$permisos             = $MyRequest->getRequest('permisos',array());
$lang                 = $MyRequest->getRequest('lang');
$error = false;
            
$rules = array(
            "Nombre de la categoria" => array("valor" => $nombre,"required","length" => array("max" => "255")),
            );
        

$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($MyCategoriaBlog->existe($nombre,$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_categoria_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_CATEGORIAS_BLOG))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)        
{
    if(getCoreConfig('blog/idioma/multi-idioma') == 1)
    {
        $MyCategoriaBlog ->setLang($lang);
    }
    if(empty($id))
    {
        $result = $MyCategoriaBlog->save($nombre, getFriendly($nombre),'',json_encode($permisos),$visible);
        if($result == REGISTRO_SUCCESS)
        {
            
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG);
        }
        else
        {
     
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
        
         
         
        $result = $MyCategoriaBlog->edit($id,$nombre, getFriendly($nombre),'',json_encode($permisos),$visible);
        if($result == REGISTRO_SUCCESS)
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG));
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