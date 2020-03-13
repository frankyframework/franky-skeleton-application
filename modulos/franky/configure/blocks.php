<?php
return json_encode([
/*    [
        'position' => 'after',
        'reference' => '.menu_web',
        'html' => getCatalogBuscadorPrincipal()
    ], */
    [
        'position' => 'after',
        'reference' => '._menu',
        'html' => getCategoryMenu()
    ],
]);
