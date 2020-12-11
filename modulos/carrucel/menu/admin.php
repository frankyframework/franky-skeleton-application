<?php
return array(
     array('title'=> "Carrusel",
            'children' =>  array(
            array(
             "permiso" =>   ADMINISTRAR_CARRUCEL,
             "url" => $MyRequest->url(ADMIN_CARRUCEL_LIST),
             "etiqueta" => "Carruseles"
            )
    ))
);
?>