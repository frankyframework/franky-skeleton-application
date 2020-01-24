<?php
namespace sliders\entity;


class SlidersEntity
{
    private $id;
    private $code;
    private $class;
    private $controlnav;
    private $loop;
    private $name;
    private $status;
    private $createdAt;
    private $updateAt;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->code = (isset($data["code"]) ? $data["code"] : null);
        $this->class = (isset($data["class"]) ? $data["class"] : null);
        $this->controlnav = (isset($data["controlnav"]) ? $data["controlnav"] : null);
        $this->loop = (isset($data["loop"]) ? $data["loop"] : null);
        $this->name = (isset($data["name"]) ? $data["name"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->createdAt = (isset($data["createdAt"]) ? $data["createdAt"] : null);
        $this->updateAt = (isset($data["updateAt"]) ? $data["updateAt"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array( 
            "code" => array("valor" => $this->code,"required"),
            "class" => array("valor" => $this->class,"required"),
            "name" => array("valor" => $this->name,"required"),
            );
    }

    

    public function id($id = null){ if($id !== null){ $this->id=$id; }else{ return $this->id; } }

    public function code($code = null){ if($code !== null){ $this->code=$code; }else{ return $this->code; } }

    public function class($class = null){ if($class !== null){ $this->class=$class; }else{ return $this->class; } }

    public function controlnav($controlnav = null){ if($controlnav !== null){ $this->controlnav=$controlnav; }else{ return $this->controlnav; } }

    public function loop($loop = null){ if($loop !== null){ $this->loop=$loop; }else{ return $this->loop; } }

    public function name($name = null){ if($name !== null){ $this->name=$name; }else{ return $this->name; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function createdAt($createdAt = null){ if($createdAt !== null){ $this->createdAt=$createdAt; }else{ return $this->createdAt; } }

    public function updateAt($updateAt = null){ if($updateAt !== null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }

}
?>
