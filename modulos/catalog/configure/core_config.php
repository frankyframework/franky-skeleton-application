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
                   
              
          )
  )
);

?>
