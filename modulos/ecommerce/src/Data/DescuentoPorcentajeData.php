<?php
namespace Ecommerce\Data;

class DescuentoPorcentajeData implements \Ecommerce\interfaces\EcommercePromocionInterface
{
    private $data;
    private $user;    
    private $productos;
    
    public function getForm()
    {
        $input = array(
            array(
               'name' => 'minimo',
               'label' => 'Minimo de compra',
               'type'  => 'text',
               'required'  => true,
               'atributos' => array(
                   'maxlength' => 10,
                   'class' => 'required'
                ),
               'label_atributos' => array(
                   'class'       => 'desc_form_obligatorio'
                )
           )
        );
        
        return $input;
    }
    
    public function getDiscount()
    {
        return 0;
    }
    
    public function setConfig($data){
        $this->data = $data;
    }
    
    public function setUser($user){
        $this->user=$user;
    }
    
    public function setProducts($products){
        $this->productos = $products;
    }
}

