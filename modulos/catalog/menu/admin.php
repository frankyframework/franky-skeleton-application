<?php
return array(
    'title'=> "Catalogo",
    array(
     "permiso" =>   ADMINISTRAR_PRODCUT_CATALOG,
     "url" => $MyRequest->url(ADMIN_CATALOG_PRODUCT),
     "etiqueta" => "Productos"
    ),
    array(
     "permiso" =>   ADMINISTRAR_CATEGORY_CATALOG,
     "url" => $MyRequest->url(ADMIN_CATALOG_CATEGORY),
     "etiqueta" => "Categorías"
    ),
    array(
     "permiso" =>   ADMINISTRAR_CATEGORY_CATALOG,
     "url" => $MyRequest->url(ADMIN_CATALOG_SUBCATEGORY),
     "etiqueta" => "Subcategorias"
    ),
   
);
?>
