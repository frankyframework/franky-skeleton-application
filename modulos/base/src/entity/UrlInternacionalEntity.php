<?php
namespace Base\entity;


class UrlInternacionalEntity
{
    private $id;
    private $id_franky;
    private $url;

    private $status;
    private $fecha;
    private $lang;

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
        $this->url = (isset($data["url"]) ? $data["url"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->lang = (isset($data["lang"]) ? $data["lang"] : null);
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array(
            "Url" => array("valor" => $this->url,"required","length" => array("max" => "100")),
            "Página" => array("valor" => $this->id_franky,"required"),
            "Idioma" => array("valor" => $this->lang,"required")
            );
    }

    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function id_franky($id_franky = null){ if($id_franky != null){ $this->id_franky=$id_franky; }else{ return $this->id_franky; } }

    public function url($url = null){ if($url != null){ $this->url=$url; }else{ return $this->$url; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function lang($lang = null){ if($lang != null){ $this->lang=$lang; }else{ return $this->lang; } }



}
?>
