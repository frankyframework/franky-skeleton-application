<?php
use vendor\core\validaciones;
use modulos\blog\vendor\model\comentariosBlog;

$MyComentariosBlog =  new comentariosBlog;
$nombre        = $MyRequest->getRequest('nombre');
$comment        = $MyRequest->getRequest('comentario');
$id             = $MyRequest->getRequest('id');

$error = false;

$rules = array(
"Nombre" => array("valor" => $nombre, ($MySession->LoggedIn() ? "no_required" : "required") , "length" =>  array("max" => "50")),
"Comentario" => array("valor" => $comment, "required", "length" =>  array("max" => "140")),
"id" => array("valor" => $id, "required", "numeric")
);



$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);

if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar(COMENTAR_ARTICULOS_BLOG))
{
    $MyFlashMessage->setMsg("error", $MyMessageAlert->Message("sin_privilegios"));
    $error=true;
}

if($error== false)
{

    $resul= $MyComentariosBlog->save($MySession->GetVar('id'),$id,"",$comment,$nombre); // (isApropiado($comment) ? 1 : 0)



    if($resul == REGISTRO_SUCCESS)
    {
        $location = $MyRequest->getReferer();
        $http_vars = array();
        $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("blog_comentario_success"));

    }
    else
    {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_comentario_error"));
	$location = $MyRequest->getReferer();
    }
}
else
{
    $location = $MyRequest->getReferer();
}

$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($location);
?>
