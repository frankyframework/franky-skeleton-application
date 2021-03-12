<?php
namespace Base\Form;

class filtrosForm extends \Franky\Form\Form
{
    public function __construct($name)
    {


       parent::__construct();
       $this->setAtributos(array(
            "name"  => $name,
            'action' => "",
            'method' => 'get'
        ));


    }

    function addBusca()
    {
        $this->add(array(
                'name' => 'busca_b',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 150,
                    'placeholder' => "Escribe tu busqueda",
                      'type_mobile'  => 'search',
                 ),

            )
        );

    }

    function addNivel()
    {
        $this->add(array(
                'name' => "nivel_b",
                'type'  => 'select',

                'required'  => false,
                'atributos' => array(
                    'class'       => 'required',
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
        ));

    }


   function addFecha($name)
    {
        $this->add(array(
                'name' => $name,
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(
                    'class'       => 'filtros_panel',
                    'maxlength' => 10,
                    'placeholder' => "",
                    'type_mobile' => 'date'
                 ),

            )
        );

    }

    function addLang()
    {
        $this->add(array(
                'name' => "lang_b",
                'type'  => 'select',

                'required'  => false,
                'atributos' => array(
                    'class'       => '',
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                    'class'       => ''
                 )
        ));
    }

    function addId()
    {
        $this->add(array(
                'name' => "id",
                'type'  => 'hidden'
        ));
    }

    function addSubmit()
    {
        $this->add(array(
                'name' => 'buscar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => '_btn',
                    'value' => "Buscar"
                 )

            )
        );
    }



}
?>
