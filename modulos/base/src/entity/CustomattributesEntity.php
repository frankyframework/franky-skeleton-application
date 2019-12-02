<?php
namespace Base\entity;


class CustomattributesEntity
{
    private $id;
    private $name;
    private $label;
    private $type;
    private $data;
    private $source;
    private $entity;
    private $createdAt;
    private $updateAt;
    private $status;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->name = (isset($data["name"]) ? $data["name"] : null);
        $this->label = (isset($data["label"]) ? $data["label"] : null);
        $this->type = (isset($data["type"]) ? $data["type"] : null);
        $this->data = (isset($data["data"]) ? $data["data"] : null);
        $this->source = (isset($data["source"]) ? $data["source"] : null);
        $this->entity = (isset($data["entity"]) ? $data["entity"] : null);
        $this->createdAt = (isset($data["createdAt"]) ? $data["createdAt"] : null);
        $this->updateAt = (isset($data["updateAt"]) ? $data["updateAt"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array( "Nombre" => array("valor" => $this->name,"required"),
        "Etiqueta" => array("valor" => $this->label,"required"),
        "Tipo campo" => array("valor" => $this->type,"required"),
        "Entidad" => array("valor" => $this->entity,"required")
        );
    }

    

    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function name($name = null){ if($name != null){ $this->name=$name; }else{ return $this->name; } }

    public function label($label = null){ if($label != null){ $this->label=$label; }else{ return $this->label; } }

    public function type($type = null){ if($type != null){ $this->type=$type; }else{ return $this->type; } }

    public function data($data = null){ if($data !== null){ $this->data=$data; }else{ return $this->data; } }

    public function source($source = null){ if($source !== null){ $this->source=$source; }else{ return $this->source; } }

    public function entity($entity = null){ if($entity != null){ $this->entity=$entity; }else{ return $this->entity; } }

    public function createdAt($createdAt = null){ if($createdAt != null){ $this->createdAt=$createdAt; }else{ return $this->createdAt; } }

    public function updateAt($updateAt = null){ if($updateAt != null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }



}
?>
