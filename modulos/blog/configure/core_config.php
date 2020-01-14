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
   
          )
  )
);

?>
