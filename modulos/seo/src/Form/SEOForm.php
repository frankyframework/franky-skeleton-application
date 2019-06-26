<?php
namespace Seo\Form;

class SEOForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();


       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/seo/submit.php",
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
                'name' => 'titulo',
                'label' => 'Metatag Titulo:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 70
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


          $this->add(array(
                'name' => 'descripcion',
                'label' => 'Metatag descripcion:',
                'type'  => 'textarea',
                'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'rows'  => 5,
                    'placeholder' => 'Recuerda que el optimo son 160 caracteres.'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
            'name' => 'extra_name[]',
            'label' => 'Nombre metatag:',
            'type'  => 'text',
            'required'  => true,
            'atributos' => array(
                'class'       => 'required',
                'maxlength' => 70,
                'placeholder' => 'Nombre de la mataetiqueta'
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio'
             )
            )
        );

        $this->add(array(
            'name' => 'extra_scheme[]',
            'label' => 'Scheme metatag:',
            'type'  => 'text',
            'required'  => false,
            'atributos' => array(
                'class'       => '',
                'maxlength' => 70,
                'placeholder' => 'Tipo de scheme de la mataetiqueta'
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
             )
            )
        );

        $this->add(array(
            'name' => 'extra_type[]',
            'label' => 'tipo propiedad:',
            'type'  => 'select',
            'required'  => true,
                
                'atributos' => array(
                    'class'       => 'required',
                   
                 ),
                'options' => array(
                    'name' => 'name',
                    'property' => 'property'
                ),
                'label_atributos' => array(
                     'class'       => 'desc_form_obligatorio'
                 )
        ));


        $this->add(array(
            'name' => 'extra_value[]',
            'label' => 'Valor:',
            'type'  => 'textarea',
            'required'  => true,
            'atributos' => array(
                'class' => 'required',
                'rows'  => 5,
                'placeholder' => 'Contenido de la mataetiqueta'
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio'
             )
        )
    );

          $this->add(array(
                'name' => 'keywords',
                'label' => 'Metatag keywords:',
                'type'  => 'textarea',
                'required'  => false,
                'atributos' => array(
                    'class' => '',
                    'rows'  => 5,
                    'id'    => 'keywords'
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
