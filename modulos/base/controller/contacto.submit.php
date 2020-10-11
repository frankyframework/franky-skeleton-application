<?php
use Franky\Core\validaciones;
use Base\model\Contacto;
use Base\entity\comentarios;
use Franky\Haxor\Tokenizer;

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

                $TemplateemailModel    = new \Base\model\TemplateemailModel;
                $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
                $SecciontransaccionalEntity->friendly('contactanos');
                $TemplateemailModel->setOrdensql('id DESC');
                $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

                $registro  = $TemplateemailModel->getRows();

                sendEmail($campos,$registro);

                if(getCoreConfig('base/contactanos/user-notification')==1):
                    $SecciontransaccionalEntity->friendly('contactanos-user-notification');
                    $TemplateemailModel->setOrdensql('id DESC');
                    $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());
    
                    $registro  = $TemplateemailModel->getRows();
    
                    sendEmail($campos,$registro);
                endif;

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
