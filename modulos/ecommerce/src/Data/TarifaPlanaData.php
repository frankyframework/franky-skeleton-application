<?php
namespace Ecommerce\Data;

class TarifaPlanaData implements \Ecommerce\interfaces\EcommerceenviosInterface
{
    public function getData(){
        
        
        if(getCoreConfig('ecommerce/envios-tarifa-plana/tipo') == 'plana')
        {
            return getCoreConfig('ecommerce/envios-tarifa-plana/precio');
        }
        if(getCoreConfig('ecommerce/envios-tarifa-plana/tipo') == 'porcentaje')
        {
            $productos_comprados = getCarrito();
            
            return ($productos_comprados['gran_total'] * (getCoreConfig('ecommerce/envios-tarifa-plana/precio')/100));
        }
  
    }
}

