<?php
use Base\model\AvataresModel;
use Base\entity\AvataresEntity;


$AvataresEntity = new AvataresEntity();
$AvataresModel = new AvataresModel();

$error = false;

$name = $MyRequest->getRequest("avatar");


$AvataresEntity->id_user($MySession->GetVar('id'));
$AvataresModel->setTampag('10');
$AvataresModel->getData($AvataresEntity->getArrayCopy());

$avatares_validos = array();
while($registro = $AvataresModel->getRows())
{
    $avatares_validos[] = $registro["name"];
}

if(!in_array($name, $avatares_validos))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("avatar_error"));
    $error = true;
    
}

if($error == false)
{
        $AvataresEntity->status(1);
        $AvataresModel->getData($AvataresEntity->getArrayCopy());
        
        $registro = $AvataresModel->getRows();
        $AvataresEntity->id($registro["id"]);
        $AvataresEntity->status(0);
        $AvataresModel->save($AvataresEntity->getArrayCopy());
        
        
        $AvataresEntity->name($name);
        $data = $AvataresEntity->getArrayCopy();
        unset($data["id"]);
        $AvataresModel->getData($data);

        
        $registro = $AvataresModel->getRows();
        
        $AvataresEntity->id($registro["id"]);
        
        $AvataresEntity->status(1);
        
       
        if($AvataresModel->save($AvataresEntity->getArrayCopy()) != REGISTRO_SUCCESS)
        {
             $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("avatar_error",$name));
        }
     
}

$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($MyRequest->getReferer());
?>