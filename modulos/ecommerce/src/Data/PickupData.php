<?php
namespace Ecommerce\Data;

class PickupData implements \Ecommerce\interfaces\EcommerceenviosInterface
{
    public function getData(){
        
        $precio = getCoreConfig('ecommerce/pick-up/precio');
      
        return $precio;

    }
}

