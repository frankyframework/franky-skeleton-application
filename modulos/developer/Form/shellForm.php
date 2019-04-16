<?php
namespace Developer\Form;

class  shellForm extends \Franky\Form\Form
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
                'name' => 'command_shell',
                'type'  => 'text',
                'atributos' => array(
                    "autocomplete"=> "off",
                    "class" => "buffer"
                 ),
                'label_atributos' => array(  
                 )
            )
        );
        
        $this->add(array(
                'name' => 'palabra_magica',
                'type'  => 'text',
                'atributos' => array(
                    "class" => "buffer",
                    "autocomplete"=> "off",
                 ),
                'label_atributos' => array(  
                 )
            )
        );

    }
 
}
?>