<?php
namespace Sliders\Form;

class SlidersForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' =>  "/admin/sliders/submit.php",
            'method' => 'post',
            'enctype' => "multipart/form-data"
        ));

        $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',
            )
        );

        $this->add(array(
                    'name' => 'callback',
                    'type'  => 'hidden',
                )
        );


        $this->add(array(
                'name' => 'name',
                'label' => 'Nombre:',
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
            'name' => 'controlnav',
            'type'  => 'checkbox',
            'options' =>  array("1" => "Controles de navegación"),
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
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => "Guardar"
                 )

            )
        );

    }

}
?>
