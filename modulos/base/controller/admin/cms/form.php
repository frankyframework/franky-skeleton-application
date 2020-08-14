<?php
use Base\Form\cmsForm;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer;


$id             = $MyRequest->getRequest('id');
$callback       = $MyRequest->getRequest('callback');

$data           = $MyFlashMessage->getResponse();

$path_img_blog = 'temp/'.md5(time());
$MySession->SetVar('path_img_blog',$path_img_blog);
if(!empty($id))
{
    $MyCMS = new \Base\model\CMS;
    $result = $MyCMS->getData($id);
    $data   = $MyCMS->getRows();
    $path_img_blog = $id;

}

$css_template = array(getCss("estilos.css"));
if(is_array($MyFrankyMonster->MyCSSFile()))
{
	if(count($MyFrankyMonster->MyCSSFile()) > 0)
	{
		foreach($MyFrankyMonster->MyCSSFile() as $css)
		{
                    if(!empty($css))
                    {
			$css_template[] = getCss($css);
                    }
		}
	}
}

$cmsForm = new cmsForm("frmcmstemplate");
$cmsForm->setData($data);
$cmsForm->setAtributoInput("callback","value", urldecode($callback));
$cmsForm->setAtributoInput("template","value", ($data['template']));
$MyMetatag->setCode("<script  src='/public/plugins/tinymce/tinymce.min.js'></script>");
?>
