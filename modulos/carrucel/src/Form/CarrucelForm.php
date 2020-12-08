<?php
namespace Carrucel\Form;

class CarrucelForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        

        parent::__construct();
       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/carrucel/submit.php",
            'method' => 'post'
        ));

        $this->add(array(
            'name' => 'id',
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
                    'maxlength' => 200
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'code',
                'label' => 'Codigo único:',
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
            'name' => 'auto',
            'type'  => 'checkbox',
            'options' =>  array("1" => "Inicio automatico"),
            )
        );
      
        $this->add(array(
            'name' => 'infinito',
            'type'  => 'checkbox',
            'options' =>  array("1" => "Loop infinito"),
            )
        );

        $this->add(array(
            'name' => 'dots',
            'type'  => 'checkbox',
            'options' =>  array("1" => "Paginado"),
            )
        );

       
        $this->add(array(
            'name' => '_width[]',
          //  'label' => '',
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
            'name' => 'visible',
            'label' => 'Items visibles',
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
            'name' => 'scroll',
            'label' => 'Scroll',
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
            'name' => '_visible[]',
          //  'label' => '',
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
            'name' => '_scroll[]',
          //  'label' => '',
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