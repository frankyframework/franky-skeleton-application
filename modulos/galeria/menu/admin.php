<?php
return array(
     array('title'=> "Galeria",
            'children' =>  array(
   

            array(
             "permiso" =>   ADMINISTRAR_GALERIA,
             "url" => $MyRequest->url(ANMIN_ALBUM_GALERIA),
             "etiqueta" => "Galeria"
            )
    ))
);
?>