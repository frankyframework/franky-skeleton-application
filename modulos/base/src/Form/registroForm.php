<?php
namespace Base\Form;

class registroForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/registro/submit.users.php",
            'method' => 'post'
        ));

    }

    public function addGeneral(){


      $this->add(array(
               'name' => 'token_xsrf',
               'type'  => 'hidden',

           )
       );


       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );

        $this->add(array(
                'name' => 'nombre',
              //  'label' => 'Nombre:',
                'type'  => 'text',
               // 'required'  => true,
                'atributos' => array(
                    'placeholder' => 'Nombre',
                    'maxlength' => 200
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


       $this->add(array(
                'name' => 'email',
                //'label' => 'E-mail:',
                'type'  => 'text',
               // 'required'  => true,
                'atributos' => array(
                    'placeholder' => 'E-mail',
                    'maxlength' => 200,
                    'minlength' => 5,
                    'type_mobile'  => 'email'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );







       $this->add(array(
                'name' => 'telefono',
               // 'label' => 'Teléfono celular:',
                'type'  => 'text',
               // 'required'  => false,
                'atributos' => array(
                    'placeholder' => 'Teléfono celular',
                    'maxlength' => 10,
                    'type_mobile'  => 'tel'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );



       $this->add(array(
                'name' => 'sexo',
                'label' => 'Sexo:',
                'type'  => 'radio',

                'required'  => false,
                'options' =>  array("h" => "Hombre",
                                     "m"  => "Mujer"),



                'atributos' => array("value" => "h"),
                'label_atributos' => array(
                    'class'       => ''
                 )
            )
        );
        $this->add(array(
                'name' => 'fecha_nacimiento',
                'label' => 'Fecha de nacimiento:',
                'type'  => 'date',
                'required'  => false,
                'atributos' => array(
                    'type_mobile' => 'date'

                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );





    }
    public function addGuardar()
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
    public function addId()
    {
          $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',

            )
        );
    }
    public function addContrasena1()
    {
        $this->add(array(
                'name' => 'contrasena1',
             //   'label' => 'Confirmar contraseña:',
                'type'  => 'password',
              //  'required'  => true,
                'atributos' => array(
                    'placeholder' => 'Confirmar contraseña',
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
    public function addContrasena()
    {
          $this->add(array(
                'name' => 'contrasena',
             //   'label' => 'Contraseña:',
                'type'  => 'password',
               // 'required'  => true,
                'atributos' => array(
                    'placeholder' => 'Contraseña',
                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }

    public function addNivel()
    {
        $this->add(array(
                'name' => 'nivel',
                'label' => 'Nivel:',
                'type'  => 'select',
                'required'  => true,
                'options' => array(),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

    }


    public function addContrasenaAnt()
    {
          $this->add(array(
                'name' => 'contrasena_ant',
            //    'label' => 'Contraseña actual:',
                'type'  => 'password',
            //    'required'  => true,
                'atributos' => array(
                    'placeholder' => 'Contraseña actual',
                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }
    public function addUsuario()
    {
        $this->add(array(
                'name' => 'usuario',
            //    'label' => 'Usuario:',
                'type'  => 'text',
              //  'required'  => true,
                'atributos' => array(
                    'placeholder' => 'Usuario',
                    'maxlength' => 15,
                    'minlength' => 3,
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }
    public function addBiografia()
    {
        $this->add(array(
                'name' => 'biografia',
            //    'label' => 'Biografia:',
                'type'  => 'textarea',
              //  'required'  => false,
                'atributos' => array(
                    'placeholder' => 'Biografia',
                    'cols' => 45,
                    'rows' => 5,
                 ),
                'label_atributos' => array(

                 )
            )
        );
    }

    public function addAcepto()
    {
        $this->add(array(
                'name' => 'acepto',
                'type'  => 'checkbox',
                'atributos' => array(
                    'class' => 'required'
                 ),
                'options' =>  array("1" => "He leído el aviso de privacidad y estoy de acuerdo con los términos y condiciones del servicio"),


            )
        );

    }

}
?>
