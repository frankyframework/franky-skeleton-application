<?php
namespace Galeria\Form;

class albumForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        

        parent::__construct();
       $this->setAtributos(array(
            'name' => $name,
            'action' => "",
            'method' => 'post'
        ));

       
       
        $this->add(array(
                'name' => 'nombre_album',
                'label' => 'Nombre Album:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 200
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
        
      
       
        
         $this->add(array(
                'name' => 'guardar_album',
                'type'  => 'button',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right ',
                    'value' => "Guardar"
                 )
                
            )
        );

    }
 
}
?>