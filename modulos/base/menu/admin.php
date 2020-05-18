<?php
global $MySession;

return array(
    array('title'=> "Perfil",
            'children' =>  array(
                array(
                 "permiso" =>   ADMINISTRAR_OTROS_USUARIOS,
                 "url" => $MyRequest->url(LISTA_OPERADORES),
                 "etiqueta" => _("Usuarios")
                ),
                array(
                 "permiso" =>   ADMINISTRAR_MI_USUARIO,
                 "url" => $MyRequest->url(FRM_OPERADORES),
                 "etiqueta" => _("Editar mis datos")
                ),
                 array(
                 "permiso" =>   ADMINISTRAR_MI_CONTRASENA,
                 "url" => $MyRequest->url(FRM_MY_PASSWORD),
                 "etiqueta" => _("Cambiar mi contraseña")
                ),
               
         
               array(
                "permiso" =>   ELIMINAR_MI_PERFIL,
                "url" => $MyRequest->url(FRM_ELIMINAR_USER),
                "etiqueta" => _("Eliminar mi cuenta")
               )
        )
    ),
    array('title'=> "Contenido",
            'children' =>  array(
                 array(
                 "permiso" =>   ADMINISTRAR_CMS_TEMPLATE,
                 "url" => $MyRequest->url(LISTA_CMS_TEMPLATE),
                 "etiqueta" => _("CMS")
               ),
              
                array(
                 "permiso" =>   ADMINISTRAR_MAILING,
                 "url" => $MyRequest->url(MAILING),
                 "etiqueta" => _("Newsletter")
                ),
                array(
                 "permiso" =>   ADMINISTRAR_CONTACTANOS,
                 "url" => $MyRequest->url(CONTACTOS_LIST),
                 "etiqueta" => _("Contacto")
                ),
            )
    ),
    array('title'=> "Configuración",
            'children' =>  array(
                       array(
                 "permiso" =>   ADMINISTRAR_EMAIL_TEMPLATE,
                 "url" => $MyRequest->url(LISTA_EMAIL_TEMPLATE),
                 "etiqueta" => _("E-mails transaccionales")
                ),

               array(
                "permiso" =>   ADMINISTRAR_DEVICES,
                "url" => $MyRequest->url(ADMIN_DEVICES),
                "etiqueta" => _("Administrar dispositivos")
              ),
               array(
                "permiso" =>   ADMINISTRAR_CORE_CONFIG,
                "url" => $MyRequest->url(ADMIN_CORE_CONFIG),
                "etiqueta" => _("Administrar sistema")
              ),
                 array(
                "permiso" =>   ADMINISTRAR_URLINTERNACIONAL,
                "url" => $MyRequest->url(ADMIN_URL_INTERNACIONAL),
                "etiqueta" => _("Administrar URL Internacional")
               ),
            )
    ),
    
);
?>