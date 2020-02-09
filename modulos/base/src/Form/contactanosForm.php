<?php
namespace Base\Form;

class contactanosForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();
       $this->setAtributos(array(
            'name' => $name,
            'action' => "/contacto.submit.php",
            'method' => 'post'
        ));

        $this->add(array(
                 'name' => 'token_xsrf',
                 'type'  => 'hidden',

             )
         );
        $this->add(array(
                'name' => 'nombre',
                // 'label' => 'Nombre:',
                'type'  => 'text',
                // 'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'placeholder' => _('Nombre'),
                    'maxlength' => 200,
                    'minlength' => 4,
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

       $this->add(array(
                'name' => 'email',
                // 'label' => 'E-mail:',
                'type'  => 'text',

                // 'required'  => true,
                'atributos' => array(
                    'class'       => 'required email',
                    'placeholder' => _('E-mail'),
                    'maxlength' => 200,
                    'minlength' => 5,
                    'type_mobile'  => 'email',
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

       $this->add(array(
                'name' => 'telefono',
                // 'label' => 'Teléfono:',
                'type'  => 'text',
                // 'required'  => false,
                'atributos' => array(
                    'class'       => '',
                    'placeholder' => _('Teléfono'),
                    'maxlength' => 10,
                    'type_mobile'  => 'tel',
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );


       $this->add(array(
                'name' => 'asunto',
                // 'label' => 'Asunto:',
                'type'  => 'text',
                // 'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'placeholder' => _('Asunto'),
                    'maxlength' => 200,
                    'minlength' => 5,
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

       $this->add(array(
                'name' => 'comentario',
                // 'label' => 'Comentario:',
                'type'  => 'textarea',
                // 'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'placeholder' => _('Comentarios'),
                    'rows'  => 5
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
               'name' => 'send',
               'type'  => 'submit',
               'atributos' => array(
                   'class'       => '_btn _btn-primary',
                   'value' => _("ENVIAR")
                )

           )
        );

    }

}
?>
