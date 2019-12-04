<?php
namespace Catalog\entity;


class CatalogwhishlistEntity
{
    private $id;
    private $uid;
    private $product_id;
    private $fecha;
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
        $this->uid = (isset($data["uid"]) ? $data["uid"] : null);
        $this->product_id = (isset($data["product_id"]) ? $data["product_id"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
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

    public function uid($uid = null){ if($uid != null){ $this->uid=$uid; }else{ return $this->uid; } }

    public function product_id($product_id = null){ if($product_id != null){ $this->product_id=$product_id; }else{ return $this->product_id; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }
}
?>
