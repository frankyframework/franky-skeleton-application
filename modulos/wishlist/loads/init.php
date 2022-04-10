<?php
use Franky\Core\ObserverManager;
$ObserverManager = new ObserverManager;
include 'lca.php';
include 'util.php';
__bindtextdomain("wishlist", 'wishlist');

if (function_exists('bind_textdomain_codeset')) 
{
    bind_textdomain_codeset("wishlist", 'UTF-8');
}

$ObserverManager->addObserver('login_user','wishlist_completarTareas');

$MyMetatag->setJs("/public/ajax/wishlist/ajax.wishlist.js");
?>