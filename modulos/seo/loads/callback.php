<?php

use Seo\model\SeoModel;
use Seo\entity\SeoEntity;
use Base\entity\OrganosEntity;

$MySeo          = new SeoModel();
$SeoEntity      = new SeoEntity();
$OrganosEntity  = new OrganosEntity();

$seccion = $MyFrankyMonster->MyId();

$OrganosEntity->id($seccion);
$SeoEntity->lang($_SESSION["lang"]);
$SeoEntity->status(1);

$MySeo->getData($SeoEntity->getArrayCopy(), $OrganosEntity->getArrayCopy());

$metatags_seo = $MySeo->getRows();

if($MySeo->getTotal() > 0)
{
    $MyMetatag->setTitulo($metatags_seo["titulo"]);
    $MyMetatag->setDescripcion($metatags_seo["descripcion"]);
    $MyMetatag->setkeywords($metatags_seo["keywords"]);
}