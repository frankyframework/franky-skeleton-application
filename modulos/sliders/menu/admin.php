<?php
global $MySession;

return array(
    "title" => "SLIDERS",
    array(
     "permiso" =>   ADMINISTRAR_SLIDES,
     "url" => $MyRequest->url(ADMIN_SLIDERS),
     "etiqueta" => _("Administrar Sliders")
    )
    

);
?>