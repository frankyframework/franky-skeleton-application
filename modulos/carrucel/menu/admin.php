<?php
return array(
     array('title'=> "Carrucel",
            'children' =>  array(
   

            array(
             "permiso" =>   ADMINISTRAR_CARRUCEL,
             "url" => $MyRequest->url(ADMIN_CARRUCEL_LIST),
             "etiqueta" => "Carruceles"
            )
    ))
);
?>