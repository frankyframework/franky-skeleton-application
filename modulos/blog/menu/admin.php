<?php
return array(
     'title'=> "Blog",
    array(
     "permiso" =>   ADMINISTRAR_CATEGORIAS_BLOG,
     "url" => $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG),
     "etiqueta" => "Categorías"
    ),
    array(
     "permiso" =>   ADMINISTRAR_ARTICULOS_BLOG,
     "url" => $MyRequest->url(ADMIN_LISTA_ARTICULOS_BLOG),
     "etiqueta" => "Artículos"
    ),
    array(
     "permiso" =>   VER_CALIFICAR_ARTICULOS_BLOG,
     "url" => $MyRequest->url(ADMIN_LISTA_CALIFICACIONES_ARTICULOS_BLOG),
     "etiqueta" => "Calificaciones"
    ),
    array(
     "permiso" =>   VER_COMENTARIOS_ARTICULOS_BLOG,
     "url" => $MyRequest->url(ADMIN_LISTA_OPINIONES_ARTICULOS_BLOG),
     "etiqueta" => "Comentarios"
    ),

);
?>
