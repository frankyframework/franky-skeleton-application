<?php
use Base\model\VerificacionesPendientes;
$VerificacionesPendientes             = new VerificacionesPendientes();

if($MySession->GetVar('id') != "")
{
    $token = getToken('verificar_email');

    $VerificacionesPendientes->addVerifica($MySession->GetVar('id'),  $token);

    $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("success_send_token_verificacion_email"));

    $campos = array( 'token'=> $token,'usuario' => $MySession->GetVar('usuario'), "url" => $MyRequest->getSERVER(),"email" => $MySession->GetVar('email'));



    $TemplateemailModel    = new \Base\model\TemplateemailModel;
    $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
    $SecciontransaccionalEntity->friendly('confirmacion-de-email');
    $TemplateemailModel->setOrdensql('id DESC');
    $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());

    $registro  = $TemplateemailModel->getRows();

    sendEmail($campos,$registro);

}
else
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("error_send_token_verificacion_email"));
}
$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($MyRequest->getReferer());
?>
