<?php
use Sliders\Form\SlidersForm;
use Sliders\model\SlidersModel;
use Sliders\entity\SlidersEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback      = $MyRequest->getRequest('callback');
$data          = $MyFlashMessage->getResponse();

if(!empty($id))
{
    $SlidersModel = new SlidersModel();
    $SlidersEntity = new SlidersEntity();
    $SlidersEntity->id($id);
    $result	 = $SlidersModel->getData($SlidersEntity->getArrayCopy());
    $data           = $SlidersModel->getRows();

    $data['id'] = $Tokenizer->token('category', $data['id']);
}

$adminForm = new SlidersForm("frmsliders");
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$title_form = "Sliders";
