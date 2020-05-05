<?php
$menuadminblog = array(
     array('title'=> "Blog",
            'children' =>  array(
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
            )
    )

);


if(getCoreConfig('blog/calificaciones/enabled') == 1):
  if(getCoreConfig('blog/calificaciones/moderado') == 1):
      
    $menuadminblog[0]['children'][] = array(
      "permiso" =>   ADMINISTRAR_BLOG_CALIFICACIONES_PENDIENTES,
      "url" => $MyRequest->url(ADMIN_CALIFICACIONES_PENDIENTES_BLOG),
      "etiqueta" => "Calificaciones y comentarios pendientes"
    );
  endif;

  $menuadminblog[0]['children'][] = array(
    "permiso" =>   ADMINISTRAR_BLOG_CALIFICACIONES,
    "url" => $MyRequest->url(ADMIN_CALIFICACIONES_BLOG),
    "etiqueta" => "Calificaciones y comentarios"
  );

  $menuadminblog[0]['children'][] = array(
    "permiso" =>   ADMINISTRAR_BLOG_MIS_CALIFICACIONES,
    "url" => $MyRequest->url(ADMIN_MIS_CALIFICACIONES_BLOG),
    "etiqueta" => "Mis Calificaciones y comentarios"
  );
endif;

return $menuadminblog;
?>
