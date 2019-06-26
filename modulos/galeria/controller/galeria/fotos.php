<?php
use Galeria\model\fotos;
use Galeria\model\albumes;

$album	= $MyRequest->getRequest('album');
$MyAlbum = new albumes();


if($MyAlbum->get($album,1) == REGISTRO_SUCCESS)
{

    $_registro = $MyAlbum->getRows();
    $MyFoto = new fotos();

    $MyFoto->setPage(1);
    $MyFoto->setTampag(2000);
    $MyFoto->setOrdensql("orden ASC");

    $result   = $MyFoto->get($album,1);

    if($MyFoto->getTotal() > 0)
    {
        while($registro = $MyFoto->getRows())
        {
            $iRow = 0;	
            $p = explode(" ", $registro["fecha"]);
            $f = explode("-", $p[0]);
            $registro["fecha"] = $f[2] . " " . $_Months[$f[1]] . " " . $f[0] . " " . substr($p[1], 0, -3) . " Hrs.";
            
            $lista_admin_data[] = $registro;

        }
    }
    
    

}
else
{
    $MyRequest->redirect($MyRequest->getReferer());
}
?>