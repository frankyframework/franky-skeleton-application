<?php
namespace developer\entity;


class CustomattributesvaluesEntity
{
    private $id;
    private $id_atribute;
    private $id_ref;
    private $value;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->id_atribute = (isset($data["id_atribute"]) ? $data["id_atribute"] : null);
        $this->id_ref = (isset($data["id_ref"]) ? $data["id_ref"] : null);
        $this->value = (isset($data["value"]) ? $data["value"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array( "Atributo" => array("valor" => $this->id_atribute,"required"),
        "id_ref" => array("valor" => $this->id_ref,"required"),
        "Valor" => array("valor" => $this->value,"required"));
    }

    

    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function id_atribute($id_atribute = null){ if($id_atribute != null){ $this->id_atribute=$id_atribute; }else{ return $this->id_atribute; } }

    public function id_ref($id_ref = null){ if($id_ref != null){ $this->id_ref=$id_ref; }else{ return $this->id_ref; } }

    public function value($value = null){ if($value != null){ $this->value=$value; }else{ return $this->value; } }



}
?>
