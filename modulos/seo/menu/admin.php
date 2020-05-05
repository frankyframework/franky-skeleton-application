<?php
global $MySession;

return array(
      array('title'=> "SEO",
            'children' =>  array(
   

    array(
     "permiso" =>   ADMINISTRAR_SEO,
     "url" => $MyRequest->url(ADMIN_SEO),
     "etiqueta" => _("Administrar SEO")
    ),
    array(
     "permiso" =>   ADMINISTRAR_REDIRECCIONES_301,
     "url" => $MyRequest->url(LISTA_REDIRECCIONES_301),
     "etiqueta" => _("Administrar redirecciones 301")
    ),
    
                )
          )
);
?>