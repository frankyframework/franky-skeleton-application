<?php
namespace Seo\Form;

class redireccion301Form extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();


       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/301/submit.php",
            'method' => 'post'
        ));


        $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );


        $this->add(array(
                'name' => 'url',
                'label' => 'Url 404:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 255

                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

         $this->add(array(
                'name' => 'redireccion',
                'label' => 'Redireccion 301:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
               'name' => 'guardar',
               'type'  => 'submit',
               'atributos' => array(
                   'class'       => 'btn btn-primary btn-big float_right',
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
