<?php
namespace Base\Form;

class contrasenaForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/users/submit.pass.php",
            'method' => 'post'
        ));

         $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',

            )
        );
       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );

         $this->add(array(
                'name' => 'contrasena',
                'label' => 'Nueva contraseña:',
                'type'  => 'password',
                'required'  => true,
                'atributos' => array(

                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

       $this->add(array(
                'name' => 'contrasena1',
                'label' => 'Confirmar contraseña:',
                'type'  => 'password',
                'required'  => true,
                'atributos' => array(

                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena1'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );






    }


    public function addSubmit()
    {
          $this->add(array(
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => '_btn _btn-primary',
                    'value' => "Guardar"
                 )

            )
        );
    }


    public function addContrasenaAnterior()
    {
        $this->add(array(
                'name' => 'contrasena_ant',
                'label' => 'Contraseña actual:',
                'type'  => 'password',
                'required'  => true,
                'atributos' => array(

                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasenaant'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }

}
?>
