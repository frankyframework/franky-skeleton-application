<?php
use Base\Form\templateEmailForm;
use Base\model\TemplateemailModel;
use Base\entity\TemplateemailEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer;
$TemplateemailModel      = new TemplateemailModel();
$TemplateemailEntity     = new TemplateemailEntity();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback   = $MyRequest->getRequest('callback');

$data = $MyFlashMessage->getResponse();

$path_img_blog = 'temp/'.md5(time());
$MySession->SetVar('path_img_blog',$path_img_blog);

$adminForm = new templateEmailForm("frmemailtemplate");

$title = "Nuevo transaccional";
if(!empty($id))
{
	$TemplateemailEntity->id($id);


	$TemplateemailModel->getData($TemplateemailEntity->getArrayCopy());

	$data = $TemplateemailModel->getRows();


	$data['id'] = $Tokenizer->token('templates', $data['id']);
	$adminForm->addId();
	$title = "Editar transaccional";

  $data["destinatario"]       = implode(",",json_decode($data["destinatario"],true));
  $data["cc"]                 = implode(",",json_decode($data["cc"],true));
  $data["bcc"]                = implode(",",json_decode($data["bcc"],true));

	$path_img_blog = $id;
}

$adminForm->addSubmit();
$adminForm->setOptionsInput('id_transaccional',selectSeccionTransaccional());
$adminForm->setData($data);

$adminForm->setAtributoInput("callback","value", urldecode($callback));

$title_form = $title;

$MyMetatag->setCode("<script  src='/public/plugins/tinymce/tinymce.min.js'></script>");
?>
