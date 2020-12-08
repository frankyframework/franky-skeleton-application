<?php
use Carrucel\model\CarrucelfotosModel;
use Carrucel\entity\CarrucelfotosEntity;
use Carrucel\model\CarrucelcarrucelesModel;
use Carrucel\entity\CarrucelcarrucelesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$carrucel	= $Tokenizer->decode($MyRequest->getRequest('id'));
$CarrucelcarrucelesEntity = new CarrucelcarrucelesEntity();
$CarrucelcarrucelesModel = new CarrucelcarrucelesModel();
$lista_admin_data = array();

$CarrucelcarrucelesEntity->id($carrucel);
if($CarrucelcarrucelesModel->getData($CarrucelcarrucelesEntity->getArrayCopy()) == REGISTRO_SUCCESS)
{

    $registro = $CarrucelcarrucelesModel->getRows();
    
    $carrucel_nombre = $registro["nombre"];
    
    $CarrucelfotosModel = new CarrucelfotosModel();
    $CarrucelfotosEntity = new CarrucelfotosEntity();
    $CarrucelfotosEntity->id_carrucel($carrucel);
    $CarrucelfotosEntity->status(1);
    $CarrucelfotosModel->setPage(1);
    $CarrucelfotosModel->setTampag(2000);
    $CarrucelfotosModel->setOrdensql("orden ASC");

    $result   = $CarrucelfotosModel->getData($CarrucelfotosEntity->getArrayCopy());

    if($CarrucelfotosModel->getTotal() > 0)
    {
        while($registro = $CarrucelfotosModel->getRows())
        {
            
            $lista_admin_data[] = $registro;

        }
    }

    $carrucel=$Tokenizer->token("carrucel", $carrucel);
}
else
{
    $MyRequest->redirect($MyRequest->getReferer());
}
?>