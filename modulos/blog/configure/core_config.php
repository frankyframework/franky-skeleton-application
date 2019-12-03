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
                   
              
          )
  )
);

?>
