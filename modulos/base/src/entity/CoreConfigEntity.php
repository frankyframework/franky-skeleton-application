<?php
namespace Base\entity;


class CoreConfigEntity
{
    private $id;
    private $modulo;
    private $path;
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
        $this->modulo = (isset($data["modulo"]) ? $data["modulo"] : null);
        $this->path = (isset($data["path"]) ? $data["path"] : null);
        $this->value = (isset($data["value"]) ? $data["value"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array();
    }



    public function id($id = null){ if($id !== null){ $this->id=$id; }else{ return $this->id; } }

    public function modulo($modulo = null){ if($modulo !== null){ $this->modulo=$modulo; }else{ return $this->modulo; } }

    public function path($path = null){ if($path !== null){ $this->path=$path; }else{ return $this->path; } }

    public function value($value = null){ if($value !== null){ $this->value=$value; }else{ return $this->value; } }
}
?>
