<?php
use Franky\\Core\\validaciones;
use {modulo}\\model\\{modelo};
use {modulo}\\entity\\{entidad};
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
${modelo}             = new {modelo}();
${entidad}       = new {entidad}($MyRequest->getRequest());
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
${entidad}->id($Tokenizer->decode($MyRequest->getRequest('id')));
$id = ${entidad}->id();
$error = false;


$validaciones =  new validaciones();
$valid = $validaciones->validRules(${entidad}->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if(!$MyAccessList->MeDasChancePasar(""))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}



if(!$error)
{

    $result = ${modelo}->save(${entidad}->getArrayCopy());

    if($result == REGISTRO_SUCCESS)
    {


        if(empty($id))
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        }
        else
        {
             $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(""));





    }
    elseif($result == REGISTRO_ERROR)
    {

        if(empty($id))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
        }
        $location = $MyRequest->getReferer();
    }
    else
    {
        $MyFlashMessage->setMsg("error",$result);
        $location = $MyRequest->getReferer();
    }
}
else
{
    $location = $MyRequest->getReferer();
}


$MyRequest->redirect($location);
?>
