<?php
namespace Seo\entity;


class SeoEntity
{
    private $id;
    private $id_franky;
    private $titulo;
    private $descripcion;
    private $keywords;
    private $status;
    private $fecha;
    private $lang;
    private $extra;
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
        $this->id_franky = (isset($data["id_franky"]) ? $data["id_franky"] : null);
        $this->titulo = (isset($data["titulo"]) ? $data["titulo"] : null);
        $this->descripcion = (isset($data["descripcion"]) ? $data["descripcion"] : null);
        $this->keywords = (isset($data["keywords"]) ? $data["keywords"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->lang = (isset($data["lang"]) ? $data["lang"] : null);
        $this->extra = (isset($data["extra"]) ? $data["extra"] : null);
        $this->updateAt = (isset($data["updateAt"]) ? $data["updateAt"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array(
            "Titulo" => array("valor" => $this->titulo,"required","length" => array("max" => "70")),
            "Descripcion" => array("valor" => $this->descripcion,"required", "length" => array("min" => "1")),
            "Keywords" => array("valor" => $this->keywords,"length" => array("max" => "500")),
            "Página" => array("valor" => $this->id_franky,"required"),
            "Idioma" => array("valor" => $this->lang,"required")
            );
    }

    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function id_franky($id_franky = null){ if($id_franky != null){ $this->id_franky=$id_franky; }else{ return $this->id_franky; } }

    public function titulo($titulo = null){ if($titulo != null){ $this->titulo=$titulo; }else{ return $this->titulo; } }

    public function descripcion($descripcion = null){ if($descripcion != null){ $this->descripcion=$descripcion; }else{ return $this->descripcion; } }

    public function keywords($keywords = null){ if($keywords != null){ $this->keywords=$keywords; }else{ return $this->keywords; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function lang($lang = null){ if($lang != null){ $this->lang=$lang; }else{ return $this->lang; } }

    public function extra($extra = null){ if($extra != null){ $this->extra=$extra; }else{ return $this->extra; } }

    public function updateAt($updateAt = null){ if($updateAt != null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }

}
?>
