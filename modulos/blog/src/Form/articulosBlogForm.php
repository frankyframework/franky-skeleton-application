<?php
namespace Blog\Form;

class articulosBlogForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/blog/articulos/submit.php",
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
                'name' => 'borrador',
                'type'  => 'hidden',

            )
        );


        $this->add(array(
                 'name' => 'data_img',
                 'type'  => 'hidden',

             )
         );


        $this->add(array(
                'name' => 'titulo',
                'label' => 'Titulo:',
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
                'name' => 'categoria',
                'label' => 'Categoria:',
                'type'  => 'select',
                'required'  => true,
               'required'  => true,
                'atributos' => array(
                    'class'       => 'required'
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'autortext',
                'label' => 'Autor:',
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
                'name' => 'contenido',
                'label' => 'Contenido:',
                'type'  => 'textarea',
                'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'rows'  => 5
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
                'name' => 'keywords',
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
                'name' => 'comentarios',

                'type'  => 'checkbox',

                'options' =>  array("1" => "Permitir comentarios en este articulo"),

            )
        );
        $this->add(array(
                'name' => 'destacado',

                'type'  => 'checkbox',

                'options' =>  array("1" => "Articulo destacado"),


            )
        );


        $this->add(array(
                'name' => 'imagen',
                'label' => _('Imagen principal'),
                'type'  => 'file',
                'atributos' => array(
                    'id' => "imagen"
                 )
            )
        );

        $this->add(array(
                'name' => 'visible_in_search',
                'type'  => 'checkbox',
                'atributos' => array(
                    'class' => ''
                 ),
                'options' =>  array("1" => "Esta articulo aparece en listas de resultados"),


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
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => "Guardar"
                 )

            )
        );

           $this->add(array(
                'name' => 'guardar_borrador',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-secondary btn-big float_right guardar_borrador',
                    'value' => "Guardar borrador"
                 )


            )
        );

        $this->add(array(
            'name' => 'descartar_borrador',
            'type'  => 'submit',
            'atributos' => array(
                'class'       => 'btn btn-primary btn-big float_right descartar_borrador',
                'value' => "Descartar borrador"
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
