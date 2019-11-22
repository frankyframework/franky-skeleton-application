<?php
use Developer\Form\CustomAttributesForm;
use Developer\model\CustomattributesModel;
use Developer\entity\CustomattributesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback      = $MyRequest->getRequest('callback');
$data          = $MyFlashMessage->getResponse();

if(!empty($id))
{
    $CustomattributesModel = new CustomattributesModel();
    $CustomattributesEntity = new CustomattributesEntity();
    $CustomattributesEntity->id($id);
    $result	 = $CustomattributesModel->getData($CustomattributesEntity->getArrayCopy());
    $data           = $CustomattributesModel->getRows();
    $data['data'] = json_decode($data['data'],true);
    

    $data['id'] = $Tokenizer->token('custom_attributes', $data['id']);
}

$entidades = ['users' => "Usuarios"];
$modulos = getModulos();
if(in_array('catalog',$modulos))
{
    $entidades = ['users' => "Usuarios","catalog_products" => "Productos"];
}

$adminForm = new CustomAttributesForm("frmattributes");
$adminForm->setOptionsInput("entity", $entidades);
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$title_form = "Atributos personalizados";
