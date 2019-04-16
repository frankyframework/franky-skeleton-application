<?php
namespace Base\entity;

 
class AvataresEntity
{
    private $id;
    private $id_user;
    private $name;
    private $url;
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
        $this->id_user = (isset($data["id_user"]) ? $data["id_user"] : null);
        $this->name = (isset($data["name"]) ? $data["name"] : null);
        $this->url = (isset($data["url"]) ? $data["url"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);

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

    public function id_user($id_user = null){ if($id_user != null){ $this->id_user=$id_user; }else{ return $this->id_user; } }

    public function name($name = null){ if($name != null){ $this->name=$name; }else{ return $this->name; } }

    public function url($url = null){ if($url != null){ $this->url=$url; }else{ return $this->url; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }
}
?>