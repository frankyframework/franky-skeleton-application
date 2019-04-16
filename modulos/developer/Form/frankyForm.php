<?php
namespace Developer\Form;

class frankyForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        

        parent::__construct();
       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/franky/submit.php",
            'method' => 'post'
        ));

        
       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',
                
            )
        );
       
       
        $this->add(array(
                'name' => 'nombre',
                'label' => 'Nombre de la página:',
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
                'name' => 'constante',
                'label' => 'Constante de identificacion:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'     => 'required',
                    'style'     => "text-transform: uppercase;",
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
        
         $this->add(array(
                'name' => 'url',
                'label' => 'URL:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'     => 'required',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
         
        $this->add(array(
                'name' => 'php',
                'label' => 'Path del archivo PHP:',
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'     => 'required',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
        
         $this->add(array(
                'name' => 'modulo',
                'label' => 'Modulo:',
                'type'  => 'select',
                'required'  => true,
                'options' => array(),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
        
         
        $this->add(array(
                'label' => 'Javascript:',
                'name' => 'js[]',                
                'type'  => 'checkbox',                
                'options' => array(
                    "values" => array(),
                    "value" => array()
                ),
             
            )
        );
        
        $this->add(array(
                'label' => 'Plugins jQuery:',
                'name' => 'jquery[]',                
                'type'  => 'checkbox',                
                'options' => array(
                ),
             
            )
        );
         
        $this->add(array(
                'label' => 'AJAX:',
                'name' => 'ajax[]',                
                'type'  => 'checkbox',                
                'options' => array(
                ),
             
            )
        );
        
        $this->add(array(
                'label' => 'Hoja de estilos CSS:',
                'name' => 'css[]',                
                'type'  => 'checkbox',                
                'options' => array(
                ),
             
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