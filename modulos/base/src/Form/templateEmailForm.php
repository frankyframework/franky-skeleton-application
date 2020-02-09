<?php
namespace Base\Form;

class templateEmailForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/template_email/submit.php",
            'method' => 'post'
        ));


       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );


        $this->add(array(
                'name' => 'nombre',
                'label' => 'Nombre:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 50
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => "id_transaccional",
                'type'  => 'select',

                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
        ));


          $this->add(array(
                'name' => 'Asunto',
                'label' => 'Asunto:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 250
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

           $this->add(array(
                'name' => 'destinatario',
                'label' => 'Destinatarios(s):',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',

                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
         $this->add(array(
                'name' => 'cc',
                'label' => 'Con copia(s):',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(


                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );
         $this->add(array(
                'name' => 'bcc',
                'label' => 'Con copia oculta:',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(


                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );
         $this->add(array(
                'name' => 'name_from',
                'label' => 'Nombre del remitente:',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(


                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );
        $this->add(array(
                'name' => 'email_from',
                'label' => 'E-mail del remitente:',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(


                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );
         $this->add(array(
                'name' => 'reply',
                'label' => 'Responder a:',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(


                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );
           $this->add(array(
                'name' => 'html',
                'label' => 'Template:',
                'type'  => 'textarea',
                'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'rows'  => 5
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

    public function addId()
    {
      $this->add(array(
             'name' => 'id',
             'type'  => 'hidden',

         )
     );
    }

}
?>
