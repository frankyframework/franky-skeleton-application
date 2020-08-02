<?php
return json_encode([
    [
        'position' => 'append',
        'reference' => '._search_bar',
        'html' => getCatalogBuscadorPrincipal()
    ], 
    [
        'position' => 'after',
        'reference' => '.menu_web',
        'html' => getHTMLRenderMinicart()
        
    ], 
    [
        'position' => 'before',
        'reference' => '._menu_section',
        'html' => getCategoryMenu()
    ],
]);
