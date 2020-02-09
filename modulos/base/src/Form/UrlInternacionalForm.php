<?php
namespace Base\Form;

class UrlInternacionalForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();


       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/url-internacional/submit.php",
            'method' => 'post'
        ));


       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );

       $this->add(array(
                'name' => 'id_franky',
                'label' => 'Página:',
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
                'name' => 'url',
                'label' => 'Path URL:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 100
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );



        $this->add(array(
                'name' => "lang",
                'type'  => 'select',
                'label' => 'Idioma:',
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
