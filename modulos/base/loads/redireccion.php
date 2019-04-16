<?php
$MyRedireccion      = new \Base\model\redireccionesModel();

$result	 	= $MyRedireccion->getData("",parse_url($MyRequest->getURI(),PHP_URL_PATH),1);
$total		= $MyRedireccion->getTotal();
if($result == REGISTRO_SUCCESS)
{
    $registro = $MyRedireccion->getRows();
    $redireccion = parse_url($registro["redireccion"]);

    $redireccion = $redireccion["path"];

    $MyRequest->redirect($redireccion,"301");
}
