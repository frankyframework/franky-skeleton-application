<?php
use vendor\core\validaciones;
use modulos\base\vendor\model\Contacto;
use modulos\base\vendor\entity\comentarios;
use vendor\haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyContacto         = new Contacto();
$MyContactoEntity         = new comentarios($MyRequest->getRequest());
$token	= $MyRequest->getRequest('token');
$error=false;

if(!$Tokenizer->decode($MyRequest->getRequest('token_xsrf')))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("bad_request"));
    $error = true;
}

$validaciones =  new validaciones();
$valid = $validaciones->validRules($MyContactoEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}
if($error== false)
{


        $MyContactoEntity->setFecha(date("Y-m-d")." ".date("H:i:s"));
        $MyContactoEntity->setIp($MyRequest->getIP());

	$result = $MyContacto->save($MyContactoEntity->getArrayCopy());

	if($result == REGISTRO_SUCCESS)
	{


               // $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("frm_success"));

                $location= $MyRequest->url(GRACIAS);

                $campos = $MyContactoEntity->getArrayCopy();

                $TemplateemailModel    = new \modulos\base\vendor\model\TemplateemailModel;
                $SecciontransaccionalEntity    = new \modulos\base\vendor\entity\SecciontransaccionalEntity;
                $SecciontransaccionalEntity->frinedly('contactanos');
                $TemplateemailModel->setOrdensql('id DESC');
                $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

                $registro  = $TemplateemailModel->getRows();

                sendEmail($campos,$registro);

	}
	else
	{
		$MyFlashMessage->setMsg("error",$MyMessageAlert->Message("frm_err"));
	        $location= $_SERVER['HTTP_REFERER'];
	}

}
else
{
	$location=$_SERVER['HTTP_REFERER'];
}

$MyRequest->redirect($location);
?>
