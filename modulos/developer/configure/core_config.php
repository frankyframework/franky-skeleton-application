<?php
return array(
    'ftp' => array(
        'menu' => "FTP",
        'title' => "Credenciales de FTP",
        'config' => array(
                  array('path' => 'developer/ftp/host',
                          'type' => 'text',
                          'label' => 'Host',
                          'validation' => array('required' => false,'maxlength' => 255),
                          'value' => ''
                        ),

                  array('path' => 'developer/ftp/user',
                      'type' => 'text',
                      'label' => 'Usuario',
                      'validation' => array('required' => false,'maxlength' => 255),
                      'value' => ''
                    ),
                  array('path' => 'developer/ftp/password',
                      'type' => 'password',
                      'label' => 'Password',
                      'validation' => array('required' => false,'maxlength' => 255),
                      'value' => ''
                    ),
        )

    )
);

?>
