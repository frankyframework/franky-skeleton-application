<?php
namespace Developer\Form;

class filtrosForm extends \Base\Form\filtrosForm
{
    public function addEntity()
    {
        $this->add(array(
            'name' => 'entity',
            'label' => 'Entidad:',
            'type'  => 'select',
            'required'  => false,
            'atributos' => array(
                'class'       => ''
            ),
            'options' => array(

            ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
            )
            )
        );  
    }


}
?>
