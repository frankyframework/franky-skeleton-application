<?php
namespace Base\Form;

class forgotForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();


       $this->setAtributos(array(
            'name' => $name,
            'action' =>  "/forgot.php",
            'method' => 'post'
        ));

        $this->add(array(
                'name' => 'email',
                'label' => 'E-mail:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required email',
                    'maxlength' => 150
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


         $this->add(array(
                'name' => 'recuperar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => '_btn _btn-primary',
                    'value' => "Recuperar contraseña"
                 )

            )
        );

    }

}
?>
