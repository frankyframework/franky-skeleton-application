<?php
return array(
  'theme' => array(
          'menu' => "FRONTEND",
          'title' => "Configuración Front",
          'config' =>  array(
                      array('path' => 'base/theme/favicon',
                              'type' => 'file',
                              'label' => 'Favicon',
                              'validation' => array('image' => true),
                              'value' => ''
                            ),
                            array('path' => 'base/theme/logopanel',
                              'type' => 'file',
                              'label' => 'Logo panel',
                              'validation' => array('image' => true),
                              'value' => ''
                            ),
                      array('path' => 'base/theme/langs',
                              'type' => 'select',
                              'label' => 'Idiomas disponibles',
                              'validation' => array('required' => false),
                              'value' => ['es_MX'],
                              'data' => include(PROJECT_DIR.'/modulos/base/configure/idiomas.php'),
                              'multiple' => true
                            ),
                      array('path' => 'base/theme/baselang',
                              'type' => 'select',
                              'label' => 'Idioma predefinodo',
                              'validation' => array('required' => false),
                            'data' => include(PROJECT_DIR.'/modulos/base/configure/idiomas.php'),
                              'value' => 'es_MX'
                            ),

                          array('path' => 'base/theme/theme',
                            'type' => 'select',
                            'label' => 'Tema',
                              'validation' => array('required' => true),
                            'data' => ['default' => 'Default','theme1' => 'Tema 1'],
                              'value' => 'default'
                            )
                          
          )
  ),
  'empresa' => array(
      'menu' => "EMPRESA",
      'title' => "Configuración Empresa",
      'config' =>  array(
          array('path' => 'base/empresa/contacto',
          'type' => 'select',
          'label' => 'Mostrar medios de contato',
          'validation' => array('required' => true),
          'data' => ['0' => 'No','1' => 'Sí'],
          'value' => '1'
          ),
          array('path' => 'base/empresa/ciudad',
          'type' => 'text',
          'label' => 'Ciudad',
          'validation' => array('required' => false),
          'value' => 'Ciudad de México'
        ),
        array('path' => 'base/empresa/municipio',
          'type' => 'text',
          'label' => 'Municipio',
          'validation' => array('required' => false),
          'value' => 'CDMX'
        ),
        array('path' => 'base/empresa/pais',
          'type' => 'text',
          'label' => 'Pais',
          'validation' => array('required' => false),
          'value' => 'Mexico'
        ),
          array('path' => 'base/empresa/calle',
          'type' => 'text',
          'label' => 'Calle',
          'validation' => array('required' => false),
          'value' => 'Calle'
        ),
        array('path' => 'base/empresa/numero',
          'type' => 'text',
          'label' => 'Número',
          'validation' => array('required' => false),
          'value' => '666'
        ),
        array('path' => 'base/empresa/colonia',
          'type' => 'text',
          'label' => 'Colonia',
          'validation' => array('required' => false),
          'value' => 'Colonia'
        ),
        array('path' => 'base/empresa/cp',
          'type' => 'text',
          'label' => 'Código postal',
          'validation' => array('required' => false),
          'value' => '0000'
        ),
          array('path' => 'base/empresa/email',
          'type' => 'text',
          'label' => 'E-mail',
          'validation' => array('email' => true),
          'value' => 'contacto@cloudstudio.mx'
        ),
          array('path' => 'base/empresa/telefono',
          'type' => 'text',
          'label' => 'Teléfono',
          'validation' => array('required' => false),
          'value' => '+52 (55) 00-00-00-00'
        ),
        array('path' => 'base/empresa/redes',
                  'type' => 'select',
                  'label' => 'Mostrar redes sociales',
                  'validation' => array('required' => true),
                  'data' => ['0' => 'No','1' => 'Sí'],
                  'value' => '1'
                  ),
        array('path' => 'base/empresa/facebook',
          'type' => 'text',
          'label' => 'Facebook',
          'validation' => array('url' => true),
          'value' => 'https://www.facebook.com/'
        ),
        array('path' => 'base/empresa/twitter',
        'type' => 'text',
        'label' => 'Twitter',
        'validation' => array('url' => true),
        'value' => 'https://www.twitter.com/'
        ),
        array('path' => 'base/empresa/instagram',
        'type' => 'text',
        'label' => 'Instagram',
        'validation' => array('url' => true),
        'value' => 'https://www.instagram.com/'
      ),

    )
),
  'user' => array(
          'menu' => "USUARIO",
          'title' => "Configuración de usuario",
          'config' =>  array(
                      array('path' => 'base/user/passwordlength',
                              'type' => 'select',
                              'label' => 'Longitud minima de contraseña',
                              'validation' => array('required' => true),
                              'data' => ['6' => '6 caracteres','7' => '7 caracteres','8' => '8 caracteres','9' => '9 caracteres','10' => '10 caracteres','11' => '11 caracteres','12' => '12 caracteres','13' => '13 caracteres'],
                              'value' => '6'
                            ),
                            array('path' => 'base/user/passwordlevel',
                                    'type' => 'select',
                                    'label' => 'Nivel de seguridad',
                                    'validation' => array('required' => true),
                                    'data' => ['1' => 'Sin restriccion','2' => 'Almenos una mayuscula','3' => 'Almenos una mayuscula y un numero','4' => 'Almenos una ,ayuscula, un numero y un simbolo'],
                                    'value' => '1'
                                  ),

          )
  ),
  'contactanos' => array(
    'menu' => "CONTACTANOS",
    'title' => "Configuración de contactanos",
    'config' =>  array(
                array('path' => 'base/contactanos/user-notification',
                        'type' => 'select',
                        'label' => '¿Notificar al remitente que su información fue recibida?',
                        'validation' => array('required' => false),
                        'data' => ['0' => 'No', '1' => 'Si'],
                        'value' => '0'
                      ),

    )
),
  'google' => array(
          'menu' => "GOOGLE",
          'title' => "Configuración de google",
          'config' =>  array(
                      array('path' => 'base/google/apimaps',
                              'type' => 'text',
                              'label' => 'API Google maps',
                              'validation' => array('required' => false),
                              'value' => ''
                            ),
                        array('path' => 'base/google/analytics',
                                'type' => 'text',
                                'label' => 'UID Google analytics',
                                'validation' => array('required' => false),
                                'value' => ''
                              ),


          )
  ),
  'pwa' => array(
          'menu' => "PWA",
          'title' => "Configuración PWA",
          'config' =>  array(
                      array('path' => 'base/pwa/icon',
                              'type' => 'file',
                              'label' => 'Icono',
                              'validation' => array('required' => false,'image' => true),
                              'value' => ''
                            ),
                      array('path' => 'base/pwa/iconios',
                            'type' => 'file',
                            'label' => 'Icono IOS',
                            'validation' => array('required' => false,'image' => true),
                            'value' => ''
                          ),
                      array(
                          'path' => 'base/pwa/name',
                          'type' => 'text',
                            'label' => 'Nombre',
                            'validation' => array('required' => false,'maxlength' => 50),
                            'value' => 'Franky'
                      ),
                      array(
                        'path' => 'base/pwa/theme-color',
                        'type' => 'text',
                          'label' => 'Color de  tema',
                          'validation' => array('required' => false,'maxlength' => 10),
                          'value' => '#000'
                      ),
                      array(
                        'path' => 'base/pwa/background_color',
                        'type' => 'text',
                          'label' => 'Color de  tema',
                          'validation' => array('required' => false,'maxlength' => 10),
                          'value' => '#000'
                      ),
                      array(
                        'path' => 'base/pwa/images-next-generation',
                        'type' => 'select',
                        'label' => '¿Habilitar imagenes con formato de próxima generación?',
                        'validation' => array('required' => false),
                        'data' => ['0' => 'No', '1' => 'Si'],
                        'value' => '0'
                      ),
            )
                     


          ),
    'smtp' => array(
        'menu' => "SMTP",
        'title' => "Configurar SMTP",
        'config' => array(
                  array('path' => 'base/smtp/enabled',
                  'type' => 'select',
                  'label' => 'Habilitar',
                  'validation' => array('required' => true),
                  'data' => ['0' => 'No','1' => 'Sí'],
                  'value' => '0'
                  ),
                  array('path' => 'base/smtp/host',
                          'type' => 'text',
                          'label' => 'Host',
                          'validation' => array('required' => true,'maxlength' => 255,'url' => true),
                          'value' => ''
                        ),
                  array('path' => 'base/smtp/secure',
                          'type' => 'text',
                          'label' => 'Secure',
                          'validation' => array('required' => true,'maxlength' => 255),
                          'value' => 'tls'
                        ),
                  array('path' => 'base/smtp/auth',
                        'type' => 'select',
                        'label' => 'Autenticar',
                        'validation' => array('required' => true,'maxlength' => 1),
                        'data' => ['0' => 'No','1' => 'Sí'],
                        'value' => 1
                      ),
                  array('path' => 'base/smtp/user',
                      'type' => 'text',
                      'label' => 'Usuario',
                      'validation' => array('required' => true,'maxlength' => 255),
                      'value' => ''
                    ),
                  array('path' => 'base/smtp/password',
                      'type' => 'password',
                      'label' => 'Password',
                      'validation' => array('required' => true,'maxlength' => 255),
                      'value' => ''
                    ),
                  array('path' => 'base/smtp/port',
                      'type' => 'text',
                      'label' => 'Puerto',
                      'validation' => array('required' => true,'maxlength' => 50,'numeric' => true),
                      'value' => '587'
                    ),
                  array('path' => 'base/smtp/debug',
                      'type' => 'select',
                      'label' => 'Debug',
                      'validation' => array('required' => true,'maxlength' => 1),
                      'data' => ['0' => '0','1' => '1','2' => '2'],
                      'value' => 0
                    ),

        )

    ),
    'servidor' => array(
      'menu' => "Servirdor",
      'title' => "Configurar Servidor",
      'config' => array(
                array('path' => 'base/server/session_path',
                'type' => 'text',
                'label' => 'Path para guardar las sesiones',
                'validation' => array('required' => true),
                'value' => 'sess_tmp' 
                ),
                array('path' => 'base/server/session_time',
                'type' => 'text',
                'label' => 'Tiempo de vida de la sesion en segundos',
                'validation' => array('required' => true),
                'value' => '43200' //12 hrs
                ),
            
                array('path' => 'base/server/session_renew',
                      'type' => 'select',
                      'label' => '¿Renovar sesion automaticamente?',
                      'validation' => array('required' => true,'maxlength' => 1),
                      'data' => ['0' => 'No','1' => 'Sí'],
                      'value' => 0
                    )
      )

  ),
    'debug' => array(
            'menu' => "DEBUG",
            'title' => "Herramientas de debbuging",
            'config' =>  array(
                        array('path' => 'base/debug/ip',
                                'type' => 'text',
                                'label' => 'IP(s)',
                                'validation' => array('required' => true),
                                'value' => '%'
                              ),
                        array('path' => 'base/debug/display_errors',
                                'type' => 'select',
                                'label' => 'Mostrar errores',
                                'validation' => array('required' => true),
                                'data' => ['0' => 'No','1' => 'Sí'],
                                'value' => '0'
                              ),
                        array('path' => 'base/debug/debug',
                              'type' => 'select',
                              'label' => 'Habilitar debug',
                              'validation' => array('required' => true),
                              'data' => ['0' => 'No','1' => 'Sí'],
                              'value' => '0'
                            ),
                        array('path' => 'base/debug/production',
                              'type' => 'select',
                              'label' => 'Produccion',
                              'validation' => array('required' => true),
                              'data' => ['0' => 'No','1' => 'Sí'],
                              'value' => '0'
                        ),

            )
    ),
);

?>
