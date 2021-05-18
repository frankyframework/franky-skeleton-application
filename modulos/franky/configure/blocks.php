<?php
return json_encode([
    [
        'position' => 'append',
        'reference' => '._search_bar',
        'html' => getCatalogBuscadorPrincipal()
    ], 
    [
        'position' => 'after',
        'reference' => '.cont_mi_carrito',
        'html' => getHTMLRenderMinicart()
        
    ], 
    [
        'position' => 'before',
        'reference' => '._category_menu',
        'html' => getCategoryMenu()
    ],
]);
