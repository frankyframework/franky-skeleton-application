<?php

define("ADMINISTRAR_CATEGORY_CATALOG",           "administrar_category_catalog");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_CATEGORY_CATALOG);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_CATEGORY_CATALOG);

define("ADMINISTRAR_PRODUCTS_CATALOG",           "administrar_products_catalog");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_PRODUCTS_CATALOG);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_PRODUCTS_CATALOG);


define("ADMINISTRAR_CATALOG_WHISHLIST",                         "administrar_catalog_whishlist");
$MyAccessList->addRoll(NIVEL_USERADMIN,                 ADMINISTRAR_CATALOG_WHISHLIST);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,             ADMINISTRAR_CATALOG_WHISHLIST);
$MyAccessList->addRoll(NIVEL_USERSEO,                   ADMINISTRAR_CATALOG_WHISHLIST);
$MyAccessList->addRoll(NIVEL_USERSUSCRIPTOR,            ADMINISTRAR_CATALOG_WHISHLIST);

?>