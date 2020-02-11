<?php
return array(
  'catalog-product' => array(
          'menu' => "CATALOGO",
          'title' => "Configuración de productos",
          'config' =>  array(
                    array('path' => 'catalog/product/placeholder',
                            'type' => 'file',
                            'label' => 'Placeholder del producto',
                             'validation' => array('image' => true),
                            'value' => ''
                          ),
                    array('path' => 'catalog/product/buscadorlateral',
                    'type' => 'select',
                    'label' => 'Habilitar buscador lateral',
                    'data' => ['0' => 'No', '1' => 'Si'],
                    'value' => 1
                  ),
                   
              
          )
  ),
    'catalog-calificaciones' => array(
          'menu' => "CATALOGO REVIEWS",
          'title' => "Calificación y comentarios de productos",
          'config' =>  array(
                    array('path' => 'catalog/calificaciones/enabled',
                            'type' => 'select',
                            'label' => 'Habilitar calificaciones y comentarios',
                            'data' => ['0' => 'No', '1' => 'Si'],
                            'value' => 1
                          ),
                    array('path' => 'catalog/calificaciones/guest',
                            'type' => 'select',
                            'label' => 'Habilitar para usuarios invitados',
                            'data' => ['0' => 'No', '1' => 'Si'],
                            'value' => 1
                          ),
                    array('path' => 'catalog/calificaciones/tipo',
                    'type' => 'select',
                    'label' => 'Tipo de comentario',
                    'data' => ['calificacion' => 'Solo calificacion',
                        'comentario' => 'Solo comentario',
                        'calificacion-comentario' => 'Calificacion y comentario',
                        ],
                    'value' => ''
                  ),
                   
              
          )
  ),
);

?>
