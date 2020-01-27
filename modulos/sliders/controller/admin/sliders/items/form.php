<?php
use Sliders\Form\SlidersItemsForm;
use Sliders\model\SlidersitemsModel;
use Sliders\entity\SlidersitemsEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$id_slider		= $MyRequest->getRequest('id_slider');
$callback      = $MyRequest->getRequest('callback');
$data          = $MyFlashMessage->getResponse();

if(!empty($id))
{
    $SlidersitemsModel = new SlidersitemsModel();
    $SlidersitemsEntity = new SlidersitemsEntity();
    $SlidersitemsEntity->id($id);
    
    
    $result	 = $SlidersitemsModel->getData($SlidersitemsEntity->getArrayCopy());
    $data           = $SlidersitemsModel->getRows();
    if($data['tipo'] == 'imagen')
    {
        if(!empty($data["file"]) && file_exists($MyConfigure->getServerUploadDir()."/sliders/".$data['id_slider']."/".$data["file"]))
        {
            $data['imagen'] = imageResize($MyConfigure->getUploadDir()."/sliders/".$data["id_slider"]."/".$data["file"],150,150, true);

        }
        if(!empty($data["file_responsive"]) && file_exists($MyConfigure->getServerUploadDir()."/sliders/".$data['id_slider']."/".$data["file_responsive"]))
        {
            $data['imagen_responsive'] = imageResize($MyConfigure->getUploadDir()."/sliders/".$data["id_slider"]."/".$data["file_responsive"],150,150, true);

        }
    }
    if($data['tipo'] == 'video')
    {
        if(!empty($data["file"]) && file_exists($MyConfigure->getServerUploadDir()."/sliders/".$data['id_slider']."/".$data["file"]))
        {
            $data['video'] = $MyConfigure->getUploadDir()."/sliders/".$data["id_slider"]."/".$data["file"];

        }
        if(!empty($data["file_responsive"]) && file_exists($MyConfigure->getServerUploadDir()."/sliders/".$data['id_slider']."/".$data["file_responsive"]))
        {
            $data['video_responsive'] = $MyConfigure->getUploadDir()."/sliders/".$data["id_slider"]."/".$data["file_responsive"];

        }
    }
    $data['id'] = $Tokenizer->token('category', $data['id']);
    
    $id_slider = $Tokenizer->token('category', $data['id_slider']);
}

$adminForm = new SlidersItemsForm("frmslidersitems");
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$adminForm->setAtributoInput("id_slider","value", $id_slider);
$title_form = "Sliders";
