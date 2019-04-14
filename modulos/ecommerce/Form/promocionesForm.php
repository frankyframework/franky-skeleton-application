<?php
namespace Ecommerce\Form;

class promocionesForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();

     
       $this->setAtributos(array(
            'name' => $name,
            'action' => "//ecommers/admin/promociones/submit.php",
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