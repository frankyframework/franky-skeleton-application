<?php
namespace Blog\Form;

class categoriasBlogForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' =>  "/admin/blog/categorias/submit.php",
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
                'name' => 'nombre',
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
                'name' => 'visible',
                'type'  => 'checkbox',
                'atributos' => array(
                    'class' => ''
                 ),
                'options' =>  array("1" => "Esta categoria es visible en busquedas"),


            )
        );
        $this->add(array(
                'label' => 'Restringir acceso a:',
                'name' => 'permisos[]',
                'type'  => 'checkbox',
                'options' => array(
                ),

            )
        );


        $this->add(array(
            'name' => 'meta_keywords',
            'label' => 'Keywords:',
            'type'  => 'text',
            'required'  => false,
            'atributos' => array(
                'class'       => '',
                'maxlength' => 255,
                'id'    => "keywords"
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
             )
        )
    );

    $this->add(array(
            'name' => 'meta_titulo',
            'label' => 'Meta titulo:',
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
            'name' => 'meta_descripcion',
            'label' => 'Meta descripcion:',
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

    function addLang()
    {
        $this->add(array(
            'name' => 'lang',
            'type'  => 'select',
            'label' => 'Idioma',
            'require' => true,
            'atributos' => array(
                'class' => 'required'
             ),
            'options' =>  array(),


        )
    );
    }

}
?>
