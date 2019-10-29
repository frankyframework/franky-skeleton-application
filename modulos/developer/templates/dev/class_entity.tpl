<?php
namespace {modulo}\\entity;


class {nombre}Entity
{
    {vars}

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        {vars_fill}
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array( {filter});
    }

    {getters}

    {setters}

}
?>
