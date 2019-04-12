<?php
namespace modulos\ecommerce\Form;

class promocionesForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();

     
       $this->setAtributos(array(
            'name' => $name,
            'action' => "/public/php/ecommers/admin/promociones/submit.php",
            'method' => 'post'
        ));

    
       
        
      
        
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