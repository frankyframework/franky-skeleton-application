<?php
namespace Ecommerce\Data;

class FreeData implements \Ecommerce\interfaces\EcommerceenviosInterface
{
    public function getData(){
        
        $minimo = getCoreConfig('ecommerce/envios-free/minimo');
        
        if(empty($minimo))
        {
            return 0;
        }
        else
        {
            $productos_comprados = getCarrito();
            if($minimo >= $productos_comprados['gran_total'] )
            {
                return 0;
            }
            
            
        }
        return false;

    }
}

