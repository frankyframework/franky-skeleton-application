<?php
$MyCMS = new \Base\model\CMS;

if($MyCMS->getData($MyRequest->getURI() ,"",1) == REGISTRO_SUCCESS)
{

				$registro           = $MyCMS->getRows();
				$id_cms             = $registro["id"];
        $titulo_cms         = $registro["titulo"];
        $mostrar_titulo         = $registro["mostrar_titulo"];
        $template_cms       = $registro["template"];
        $MyMetatag->setTitulo($registro["meta_titulo"]);
        $MyMetatag->setDescripcion($registro["meta_descripcion"]);
        $MyMetatag->setkeywords("");
}
else
{
    $MyRequest->redirect();
}
