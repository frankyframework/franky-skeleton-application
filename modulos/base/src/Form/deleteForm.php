<?php
namespace Base\Form;

class deleteForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/registro/delete.profile.php",
            'method' => 'post'
        ));




         $this->add(array(
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => '_btn _btn-primary',
                    'value' => "Eliminar Mi cuenta"
                 )

            )
        );

    }

    public function addContrasenaAnterior()
    {
         $this->add(array(
                'name' => 'contrasena_ant',
                'label' => "Contrase&ntilde;a actual",
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

    }

}
?>
