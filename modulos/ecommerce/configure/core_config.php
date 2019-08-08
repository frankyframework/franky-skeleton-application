<?php
return array(
     'ecommerc' => array(
          'menu' => "ECOMMERCE",
          'title' => "Configuración de ecommerce",
          'config' =>  array(
                    array('path' => 'ecommerce/ecommerce/limitcards',
                            'type' => 'text',
                            'label' => 'Habilitar metodo de pago',
                            'validation' => array('required' => true,'numeric' => true),
                            'value' => '3'
                          )
              )
         ),
  'ecommerce-conekta' => array(
          'menu' => "ECOMMERCE API CONEKTA",
          'title' => "Configuración de conekta",
          'config' =>  array(
                    array('path' => 'ecommerce/conekta/enabled',
                            'type' => 'select',
                            'label' => 'Habilitar metodo de pago',
                            'validation' => array('required' => true),
                            'data' => ['0' => 'No','1' => 'Sí'],
                            'value' => '0'
                          ),
                      array('path' => 'ecommerce/conekta/sandbox',
                              'type' => 'select',
                              'label' => 'SANDBOX',
                              'validation' => array('required' => true),
                              'data' => ['0' => 'No','1' => 'Sí'],
                              'value' => '1'
                            ),
                      array('path' => 'ecommerce/conekta/key',
                              'type' => 'text',
                              'label' => 'API KEY',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/conekta/public',
                              'type' => 'text',
                              'label' => 'Public KEY',
                              'validation' => array('required' => false),
                              'value' => ''
                        ),
                      array('path' => 'ecommerce/conekta/keysandbox',
                              'type' => 'text',
                              'label' => 'API KEY SANDBOX',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/conekta/publicsandbox',
                              'type' => 'text',
                              'label' => 'Public KEY SANDBOX',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/conekta/methods',
                              'type' => 'select',
                              'label' => 'Metodos de pago',
                              'validation' => array('required' => false),
                              'value' => ['conekta_tarjeta','conekta_oxxo'],
                              'data' => array('conekta_tarjeta' => 'Tarjeta credito/debito',
                                              'conekta_oxxo' => 'OXXO'
                              ),
                              'multiple' => true
                            ),
          )
  ),
  'ecommerce-paypal' => array(
          'menu' => "ECOMMERCE API PAYPAL",
          'title' => "Configuración de paypal",
          'config' =>  array(
                    array('path' => 'ecommerce/paypal/enabled',
                            'type' => 'select',
                            'label' => 'Habilitar metodo de pago',
                            'validation' => array('required' => true),
                            'data' => ['0' => 'No','1' => 'Sí'],
                            'value' => '0'
                          ),
                      array('path' => 'ecommerce/paypal/sandbox',
                              'type' => 'select',
                              'label' => 'SANDBOX',
                              'validation' => array('required' => true),
                              'data' => ['0' => 'No','1' => 'Sí'],
                              'value' => '1'
                            ),
                      array('path' => 'ecommerce/paypal/key',
                              'type' => 'text',
                              'label' => 'API KEY',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/paypal/secret',
                              'type' => 'text',
                              'label' => 'SECRET KEY',
                              'validation' => array('required' => false),
                              'value' => ''
                        ),
                      array('path' => 'ecommerce/paypal/keysandbox',
                              'type' => 'text',
                              'label' => 'API KEY SANDBOX',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/paypal/secretsandbox',
                              'type' => 'text',
                              'label' => 'SECRET KEY SANDBOX',
                              'validation' => array('required' => false),
                              'value' => ''
                            )
          )
  ),
  'ecommerce-openpay' => array(
          'menu' => "ECOMMERCE API OPEPAY",
          'title' => "Configuración de openpay",
          'config' =>  array(
                    array('path' => 'ecommerce/openpay/enabled',
                            'type' => 'select',
                            'label' => 'Habilitar metodo de pago',
                            'validation' => array('required' => true),
                            'data' => ['0' => 'No','1' => 'Sí'],
                            'value' => '0'
                          ),
                      array('path' => 'ecommerce/openpay/sandbox',
                              'type' => 'select',
                              'label' => 'SANDBOX',
                              'validation' => array('required' => true),
                              'data' => ['0' => 'No','1' => 'Sí'],
                              'value' => '1'
                            ),
                      array('path' => 'ecommerce/openpay/id',
                              'type' => 'text',
                              'label' => 'ID',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/openpay/public',
                              'type' => 'text',
                              'label' => 'Public KEY',
                              'validation' => array('required' => false),
                              'value' => ''
                        ),
                        array('path' => 'ecommerce/openpay/secret',
                                'type' => 'text',
                                'label' => 'Secret KEY',
                                'validation' => array('required' => false),
                                'value' => ''
                          ),
                      array('path' => 'ecommerce/openpay/idsandbox',
                              'type' => 'text',
                              'label' => 'ID SANDBOX',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                      array('path' => 'ecommerce/openpay/publicsandbox',
                              'type' => 'text',
                              'label' => 'Public KEY SANDBOX',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                            array('path' => 'ecommerce/openpay/secretsandbox',
                                    'type' => 'text',
                                    'label' => 'Secret KEY SANDBOX',
                                    'validation' => array('required' => false),
                                    'value' => ''
                                  ),
                      array('path' => 'ecommerce/openpay/methods',
                              'type' => 'select',
                              'label' => 'Metodos de pago',
                              'validation' => array('required' => false),
                              'value' => ['openpay_tarjeta','openpay_establecimiento'],
                              'data' => array('openpay_tarjeta' => 'Tarjeta credito/debito',
                                              'openpay_establecimiento' => 'Establecimientos'
                              ),
                              'multiple' => true
                            ),
          )
  ),
);

?>
