<?php
namespace Calificaciones\entity;


class CalificacionesuserEntity
{
    

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array( );
    }

    

    

}
?>
