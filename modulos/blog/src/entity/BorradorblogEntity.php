<?php
namespace Blog\entity;

class BorradorblogEntity
{
    private $id;
    private $data;
    private $fecha;
    private $id_blog;

    
    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->data = (isset($data["data"]) ? $data["data"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->id_blog = (isset($data["id_blog"]) ? $data["id_blog"] : null);

    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array();
    }
    
    
    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function data($data = null){ if($data != null){ $this->data=$data; }else{ return $this->data; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function id_blog($id_blog = null){ if($id_blog != null){ $this->id_blog=$id_blog; }else{ return $this->id_blog; } }
  
}
?>