<?php
use Base\model\AvataresModel;
use Base\entity\AvataresEntity;

$AvataresModel = new AvataresModel();
$AvataresEntity = new AvataresEntity();


$AvataresEntity->id_user($MySession->GetVar('id'));
$AvataresModel->setTampag('10');
$AvataresModel->getData($AvataresEntity->getArrayCopy());

$avatares_validos = array();
while($registro = $AvataresModel->getRows())
{
    $avatares_validos[] = $registro;
}


$MyMetatag->setTitulo("Editar Avatar");
$MyMetatag->setDescripcion("Editar Avatar");
