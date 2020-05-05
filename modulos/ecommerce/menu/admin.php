<?php
return array(
    array('title'=> "Ecommerce",
            'children' =>  array(
   
        array(
         "permiso" =>   ADMINISTRAR_DIRECCIONES_ECOMMERCE,
         "url" => $MyRequest->url(ADMIN_LISTA_DIRECCIONES_ECOMMERCE),
         "etiqueta" => _ecommerce("Administrar mis direcciones de entrega")
        ),
        array(
         "permiso" =>   ADMINISTRAR_DIRECCIONES_ECOMMERCE,
         "url" => $MyRequest->url(ADMIN_LISTA_DIRECCIONES_FACTURACION_ECOMMERCE),
         "etiqueta" => _ecommerce("Administrar mis direcciones de facturacion")
        ),

        array(
         "permiso" =>   ADMINISTRAR_TARJETAS_ECOMMERCE,
         "url" => $MyRequest->url(ADMIN_LISTA_TARJETAS_ECOMMERCE),
         "etiqueta" => _ecommerce("Administrar mis tarjetas")
        ),
        array(
         "permiso" =>   ADMINISTRAR_MIS_PEDIDOS,
         "url" => $MyRequest->url(ADMIN_LISTA_PEDIDOS),
         "etiqueta" => _ecommerce("Mis pedidos")
        ),
        array(
         "permiso" =>   ADMINISTRAR_PEDIDOS,
         "url" => $MyRequest->url(ADMIN_LISTA_PEDIDOS),
         "etiqueta" => _ecommerce("Administrar pagos")
        )
    )
    )

);
?>
