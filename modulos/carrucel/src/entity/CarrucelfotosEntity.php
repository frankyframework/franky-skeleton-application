<?php
namespace Carrucel\entity;


class CarrucelfotosEntity
{
    private $id;
    private $id_carrucel;
    private $foto;
    private $url;
    private $orden;
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
        $this->id_carrucel = (isset($data["id_carrucel"]) ? $data["id_carrucel"] : null);
        $this->foto = (isset($data["foto"]) ? $data["foto"] : null);
        $this->url = (isset($data["url"]) ? $data["url"] : null);
        $this->orden = (isset($data["orden"]) ? $data["orden"] : null);
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
            "id_carrucel" => array("valor" => $this->id_carrucel,"required")
            );
    }

    

    public function id($id = null){ if($id !== null){ $this->id=$id; }else{ return $this->id; } }

    public function id_carrucel($id_carrucel = null){ if($id_carrucel !== null){ $this->id_carrucel=$id_carrucel; }else{ return $this->id_carrucel; } }

    
    public function foto($foto = null){ if($foto !== null){ $this->foto=$foto; }else{ return $this->foto; } }

   
    public function url($url = null){ if($url !== null){ $this->url=$url; }else{ return $this->url; } }

    public function orden($orden = null){ if($orden !== null){ $this->orden=$orden; }else{ return $this->orden; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function createdAt($createdAt = null){ if($createdAt !== null){ $this->createdAt=$createdAt; }else{ return $this->createdAt; } }

    public function updateAt($updateAt = null){ if($updateAt !== null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }
}
?>
