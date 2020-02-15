<?php
define("ADMINISTRAR_CATEGORIAS_BLOG",           "administrar_categorias_blog");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_CATEGORIAS_BLOG);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_CATEGORIAS_BLOG);


define("ADMINISTRAR_ARTICULOS_BLOG",            "administrar_articulo_blog");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_ARTICULOS_BLOG);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_ARTICULOS_BLOG);


define("ADMINISTRAR_BLOG_CALIFICACIONES_PENDIENTES",           "administrar_blog_calificaciones_pendientes");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_BLOG_CALIFICACIONES_PENDIENTES);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_BLOG_CALIFICACIONES_PENDIENTES);

define("ADMINISTRAR_BLOG_CALIFICACIONES",           "administrar_blog_calificaciones");
$MyAccessList->addRoll(NIVEL_USERADMIN,         ADMINISTRAR_BLOG_CALIFICACIONES);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,     ADMINISTRAR_BLOG_CALIFICACIONES);


define("ADMINISTRAR_BLOG_MIS_CALIFICACIONES",       "administrar_blog_mis_calificaciones");
$MyAccessList->addRoll(NIVEL_USERADMIN,                 ADMINISTRAR_BLOG_MIS_CALIFICACIONES);
$MyAccessList->addRoll(NIVEL_USERDEVELOPER,             ADMINISTRAR_BLOG_MIS_CALIFICACIONES);
$MyAccessList->addRoll(NIVEL_USERSEO,                   ADMINISTRAR_BLOG_MIS_CALIFICACIONES);
$MyAccessList->addRoll(NIVEL_USERSUSCRIPTOR,            ADMINISTRAR_BLOG_MIS_CALIFICACIONES);

?>
