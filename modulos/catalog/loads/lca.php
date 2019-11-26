<?php

define("ADMINISTRAR_CATEGORY_CATALOG",           "administrar_category_catalog");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_CATEGORY_CATALOG);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_CATEGORY_CATALOG);

define("ADMINISTRAR_PRODCUT_CATALOG",           "administrar_product_catalog");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_PRODCUT_CATALOG);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_PRODCUT_CATALOG);


?>