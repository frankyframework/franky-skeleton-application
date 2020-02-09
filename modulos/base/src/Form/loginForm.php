<?php
namespace Base\Form;

class loginForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

       parent::__construct();
       $this->setAtributos(array(
            'name' => $name,
            'action' => "/login.php",
            'method' => 'post'
        ));

       $this->add(array(
                'name' => 'callback',

                'type'  => 'hidden',
                'required'  => false,

            )
        );

        $this->add(array(
                'name' => 'usuario',
                'label' => 'E-mail:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 30
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'contrasena',
                'label' => "Contraseña",
                'type'  => 'password',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 15
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

         $this->add(array(
                'name' => 'login',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => '_btn _btn-primary',
                    'value' => "Entrar"
                 )

            )
        );

    }


    function addCallback($uri)
    {
        $this->add(array(
                'name' => 'callback',

                'type'  => 'hidden',
                'required'  => false,
                'atributos' => array(
                    'value'       => $uri,

                 )

            )
        );
    }

}
?>
