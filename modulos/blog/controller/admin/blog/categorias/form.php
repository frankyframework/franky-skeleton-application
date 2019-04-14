<?php
use Blog\Form\categoriasBlogForm;
use Blog\model\categoriasBlog;

$id                 = $MyRequest->getRequest('id');
$callback           = $MyRequest->getRequest('callback');
$data             = $MyFlashMessage->getResponse();

if(!empty($id))
{
    $MyCategoriaBlog = new categoriasBlog();
    $result	 = $MyCategoriaBlog->getData($id);
    $data           = $MyCategoriaBlog->getRows();
    $data['permisos'] = json_decode($data['permisos'],true);

}

$adminForm = new categoriasBlogForm("frmcategoria");
$adminForm->setOptionsInput("permisos[]", $_Niveles_usuarios);
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$title_form = "Categorias Blog";
