<?php
namespace sliders\entity;


class SlidersitemsEntity
{
    private $id;
    private $id_slider;
    private $tipo;
    private $file;
    private $file_responsive;
    private $code;
    private $titulo;
    private $descripcion;
    private $url;
    private $orden;
    private $status;
    private $createdAt;
    private $updateAt;
    private $boton_link;
    private $fecha_inicio;
    private $fecha_fin;


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
        $this->file_responsive = (isset($data["file_responsive"]) ? $data["file_responsive"] : null);
        $this->code = (isset($data["code"]) ? $data["code"] : null);
        $this->titulo = (isset($data["titulo"]) ? $data["titulo"] : null);
        $this->descripcion = (isset($data["descripcion"]) ? $data["descripcion"] : null);
        $this->url = (isset($data["url"]) ? $data["url"] : null);
        $this->orden = (isset($data["orden"]) ? $data["orden"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->createdAt = (isset($data["createdAt"]) ? $data["createdAt"] : null);
        $this->updateAt = (isset($data["updateAt"]) ? $data["updateAt"] : null);
        $this->boton_link = (isset($data["boton_link"]) ? $data["boton_link"] : null);
        $this->fecha_inicio = (isset($data["fecha_inicio"]) ? $data["fecha_inicio"] : null);
        $this->fecha_fin = (isset($data["fecha_fin"]) ? $data["fecha_fin"] : null);

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

    public function file_responsive($file_responsive = null){ if($file_responsive !== null){ $this->file_responsive=$file_responsive; }else{ return $this->file_responsive; } }

    public function code($code = null){ if($code !== null){ $this->code=$code; }else{ return $this->code; } }

    public function titulo($titulo = null){ if($titulo !== null){ $this->titulo=$titulo; }else{ return $this->titulo; } }

    public function descripcion($descripcion = null){ if($descripcion !== null){ $this->descripcion=$descripcion; }else{ return $this->descripcion; } }

    public function url($url = null){ if($url !== null){ $this->url=$url; }else{ return $this->url; } }

    public function orden($orden = null){ if($orden !== null){ $this->orden=$orden; }else{ return $this->orden; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function createdAt($createdAt = null){ if($createdAt !== null){ $this->createdAt=$createdAt; }else{ return $this->createdAt; } }

    public function updateAt($updateAt = null){ if($updateAt !== null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }

    public function boton_link($boton_link = null){ if($boton_link !== null){ $this->boton_link=$boton_link; }else{ return $this->boton_link; } }

    public function fecha_inicio($fecha_inicio = null){ if($fecha_inicio !== null){ $this->fecha_inicio=$fecha_inicio; }else{ return $this->fecha_inicio; } }

    public function fecha_fin($fecha_fin = null){ if($fecha_fin !== null){ $this->fecha_fin=$fecha_fin; }else{ return $this->fecha_fin; } }
}
?>
