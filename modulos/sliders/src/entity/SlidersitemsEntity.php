<?php
namespace sliders\entity;


class SlidersitemsEntity
{
    private $id;
    private $id_slider;
    private $tipo;
    private $file;
    private $titulo;
    private $descripcion;
    private $url;
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
        $this->id_slider = (isset($data["id_slider"]) ? $data["id_slider"] : null);
        $this->tipo = (isset($data["tipo"]) ? $data["tipo"] : null);
        $this->file = (isset($data["file"]) ? $data["file"] : null);
        $this->titulo = (isset($data["titulo"]) ? $data["titulo"] : null);
        $this->descripcion = (isset($data["descripcion"]) ? $data["descripcion"] : null);
        $this->url = (isset($data["url"]) ? $data["url"] : null);
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
            "id_slider" => array("valor" => $this->id_slider,"required"),
            "tipo" => array("valor" => $this->tipo,"required"),
            );
    }

    

    public function id($id = null){ if($id !== null){ $this->id=$id; }else{ return $this->id; } }

    public function id_slider($id_slider = null){ if($id_slider !== null){ $this->id_slider=$id_slider; }else{ return $this->id_slider; } }

    public function tipo($tipo = null){ if($tipo !== null){ $this->tipo=$tipo; }else{ return $this->tipo; } }

    public function file($file = null){ if($file !== null){ $this->file=$file; }else{ return $this->file; } }

    public function titulo($titulo = null){ if($titulo !== null){ $this->titulo=$titulo; }else{ return $this->titulo; } }

    public function descripcion($descripcion = null){ if($descripcion !== null){ $this->descripcion=$descripcion; }else{ return $this->descripcion; } }

    public function url($url = null){ if($url !== null){ $this->url=$url; }else{ return $this->url; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function createdAt($createdAt = null){ if($createdAt !== null){ $this->createdAt=$createdAt; }else{ return $this->createdAt; } }

    public function updateAt($updateAt = null){ if($updateAt !== null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }
}
?>
