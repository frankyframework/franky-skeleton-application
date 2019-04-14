<?php
use Galeria\model\albumes;

$MyAlbum = new albumes();

$MyAlbum->setPage(1);
$MyAlbum->setTampag(1000);
$MyAlbum->setOrdensql("orden ASC");
$result	 = $MyAlbum->get("",1);

while($registro = $MyAlbum->getRows())
{
    $p = explode(" ", $registro["fecha"]);
    $f = explode("-", $p[0]);
    $fecha = $f[2] . " " . $_Months[$f[1]] . " " . $f[0] . " " . substr($p[1], 0, -3) . " Hrs.";

    $lista_admin_data[] = array_merge($registro,array(
        "fecha"         => $fecha
        ));
}


?>