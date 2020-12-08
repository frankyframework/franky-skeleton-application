<?php
use Carrucel\Form\CarrucelForm;
use Carrucel\model\CarrucelcarrucelesModel;
use Carrucel\entity\CarrucelcarrucelesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback      = $MyRequest->getRequest('callback');
$data          = $MyFlashMessage->getResponse();

if(!empty($id))
{
    $CarrucelcarrucelesModel =  new CarrucelcarrucelesModel();
    $CarrucelcarrucelesEntity =  new CarrucelcarrucelesEntity();
    $CarrucelcarrucelesEntity->id($id);
    $result = $CarrucelcarrucelesModel->getData($CarrucelcarrucelesEntity->getArrayCopy());
    $data   = $CarrucelcarrucelesModel->getRows();
    $data['responsivo'] = json_decode($data['responsivo'],true);
    $data['id'] = $Tokenizer->token('carrucel', $data['id']);
}



$adminForm = new CarrucelForm("frmcarrucel");
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$title_form = "Carrucel";
