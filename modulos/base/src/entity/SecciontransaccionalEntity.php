<?php
namespace Base\entity;


class SecciontransaccionalEntity
{
    private $id;
    private $nombre;
    private $friendly;
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
        $this->nombre = (isset($data["nombre"]) ? $data["nombre"] : null);
        $this->friendly = (isset($data["friendly"]) ? $data["friendly"] : null);
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

    public function nombre($nombre = null){ if($nombre != null){ $this->nombre=$nombre; }else{ return $this->nombre; } }

    public function friendly($friendly = null){ if($friendly != null){ $this->friendly=$friendly; }else{ return $this->friendly; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }



}
?>
