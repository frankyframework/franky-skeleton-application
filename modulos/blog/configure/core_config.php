<?php
return array(
  'blog-articulo' => array(
          'menu' => "BLOG",
          'title' => "Configuración de articulos",
          'config' =>  array(
                    array('path' => 'blog/articulo/descripcion-length',
                            'type' => 'text',
                            'label' => 'Longitud de la descripción en resultados',
                             'validation' => array('numeric' => true),
                            'value' => '200'
                          ),
                          array('path' => 'blog/articulo/script',
                          'type' => 'select',
                          'label' => '¿Permitir javascript?',
                          'validation' => array('required' => false),
                          'data' => ['0' => 'No', '1' => 'Si'],
                          'value' => '0'
                        ),
                        array('path' => 'blog/registers/showdelete',
                        'type' => 'select',
                        'label' => '¿Mostrar registros eliminados?',
                        'validation' => array('required' => false),
                        'data' => ['0' => 'No', '1' => 'Si'],
                        'value' => '0'
                      ),
                      array('path' => 'blog/paginacion/tipo',
                      'type' => 'select',
                      'label' => 'Tipo de paginación',
                      'data' => ['normal' => 'Normal', 'ajax' => 'Ajax'],
                      'value' => 'normal'
                    ) ,
                    array('path' => 'blog/idioma/multi-idioma',
                      'type' => 'select',
                      'label' => 'Habilitar multi idioma',
                      'data' => ['1' => 'Sí', '0' => 'No'],
                      'value' => '0'
                    )   
   
          ),
         ),
         'blog-rss' => array(
          'menu' => "BLOG RSS",
          'title' => "RSS de articulos",
          'config' =>  array(
                      array('path' => 'blog/rss/titulo',
                        'type' => 'text',
                        'label' => 'Titulo',
                        'validation' => array(),
                        'value' => 'Titulo RSS'
                      ),
                      array('path' => 'blog/rss/descripcion',
                      'type' => 'text',
                      'label' => 'Descripcion',
                      'validation' => array(),
                      'value' => 'Descripcion RSS'
                      ),
                      array('path' => 'blog/rss/autor',
                      'type' => 'text',
                      'label' => 'Generador RSS',
                      'validation' => array(),
                      'value' => 'Generador RSS'
                      ),
                    )
            ),
       'blog-calificaciones' => array(
          'menu' => "BLOG REVIEWS",
          'title' => "Calificación y comentarios de articulos",
          'config' =>  array(
                    array('path' => 'blog/calificaciones/enabled',
                            'type' => 'select',
                            'label' => 'Habilitar calificaciones y comentarios',
                            'data' => ['0' => 'No', '1' => 'Si'],
                            'value' => 1
                          ),
                    array('path' => 'blog/calificaciones/guest',
                            'type' => 'select',
                            'label' => 'Habilitar para usuarios invitados',
                            'data' => ['0' => 'No', '1' => 'Si'],
                            'value' => 1
                          ),
                    array('path' => 'blog/calificaciones/tipo',
                    'type' => 'select',
                    'label' => 'Tipo de comentario',
                    'data' => ['calificacion' => 'Solo calificacion',
                        'comentario' => 'Solo comentario',
                        'calificacion-comentario' => 'Calificacion y comentario',
                        ],
                    'value' => ''
                  ),
                  array('path' => 'blog/calificaciones/moderado',
                            'type' => 'select',
                            'label' => 'Moderar calificaciones y comentarios',
                            'data' => ['0' => 'No', '1' => 'Si'],
                            'value' => 1
                          ),
                   
          )    
       
      )
);

?>
