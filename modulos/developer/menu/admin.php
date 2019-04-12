<?php
global $MySession;
return array(
    array(
     "permiso" =>   ADMINISTRAR_FRANKY,
     "url" => $MyRequest->url(LISTA_PAGINAS),
     "etiqueta" => _("Administrar Páginas")
    ),
    array(
     "permiso" =>   ADMINISTRAR_SHELL,
     "url" => $MyRequest->url(SHELL),
     "etiqueta" => _("Shell")
    ),
    array(
     "permiso" =>   ADMINISTRAR_FTP,
     "url" => $MyRequest->url(ADMIN_FTP),
     "etiqueta" => _("FTP")
    ),
);
?>