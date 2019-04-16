<?php
namespace Blog\Form;

class buscadorForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();

     
       $this->setAtributos(array(
            'name' => $name,
            'action' => "",
            'method' => 'get'
        ));
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
        $this->add(array(
                'name' => 'buscar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => "Buscar",
                    
                 )
                
            )
        );
    
    }
    
}
?>