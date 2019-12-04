<?php
use Franky\Core\ObserverManager;
$ObserverManager = new ObserverManager;

include 'lca.php';
include 'util.php';
bindtextdomain("catalog", PROJECT_DIR ."/modulos/catalog/locale");


if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset("catalog", 'UTF-8');
}

$ObserverManager->addObserver('login_user','catalog_completarTareas');
$ObserverManager->addObserver('save_catalog_product','catalog_setPriceEcommerce');
$ObserverManager->addObserver('edit_catalog_product','catalog_setPriceEcommerce');

define("OBJETO_PRODUCTOS", '\Catalog\model\CatalogproductsModel');
define("DIRECTORIO_IMAGENES_PRODUCTOS_ECOMMERCE","catalog/products/");
define("DETALLE_PRODUCTOS_ECOMMERCE", "");


$MyMetatag->setCss("/public/skin/catalog/css/catalog.css");
$MyMetatag->setJs("/public/ajax/catalog/ajax.catalog.js");
?>
