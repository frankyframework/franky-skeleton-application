<?php
namespace Sliders\Form;

class SlidersItemsForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' =>  "/admin/sliders/items/submit.php",
            'method' => 'post',
            'enctype' => "multipart/form-data"
        ));

        $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',
            )
        );

        $this->add(array(
                'name' => 'id_slider',
                'type'  => 'hidden',
            )
        );

        $this->add(array(
                    'name' => 'callback',
                    'type'  => 'hidden',
                )
        );


        $this->add(array(
                'name' => 'titulo',
                'label' => 'Titulo',
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(
                    'class'       => '',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );

        $this->add(array(
            'name' => 'descripcion',
            'label' => 'Descripcion',
            'type'  => 'textarea',
            'required'  => false,
            'atributos' => array(
                'class'       => '',
                'maxlength' => 255
            ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio'
            )
            )
        );
      
        $this->add(array(
            'name' => 'url',
            'label' => 'Url',
            'type'  => 'text',
            'required'  => false,
            'atributos' => array(
                'class'       => '',
                'maxlength' => 255
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
             )
            )
        );
        
        $this->add(array(
            'name' => 'tipo',
            'label' => 'Tipo:',
            'type'  => 'select',
            'required'  => true,
            'atributos' => array(
                'class'       => 'required'
             ),
            'options' => array(
                'video' => 'Video local',
                'video-embebed' => 'Código embebido',
                'imagen' => 'imagen'
            ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio'
             )
            )
        );

        $this->add(array(
            'name' => 'file',
            'label' => _('Archivo Slider'),
            'type'  => 'file',
            'atributos' => array(
                'id' => "file"
                )
            )
        );

        $this->add(array(
            'name' => 'file_responsive',
            'label' => _('Archivo Slider mobile'),
            'type'  => 'file',
            'atributos' => array(
                'id' => "file_responsive"
                )
            )
        );

        $this->add(array(
            'name' => 'code',
            'label' => 'Codigo embebido',
            'type'  => 'textarea',
            'required'  => false,
            'atributos' => array(
                'class'       => '',
                'maxlength' => 255
            ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
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

}
?>
