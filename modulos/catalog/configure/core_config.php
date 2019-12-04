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
  )
);

?>
