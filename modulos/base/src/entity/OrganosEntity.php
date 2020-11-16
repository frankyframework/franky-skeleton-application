<?php
namespace Base\entity;


class OrganosEntity
{
    private $id;
    private $php;
    private $css;
    private $js;
    private $jquery;
    private $permisos;
    private $constante;
    private $url;
    private $nombre;
    private $ajax;
    private $status;
    private $editable;
    private $modulo;
    private $cache;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->php = (isset($data["php"]) ? $data["php"] : null);
        $this->css = (isset($data["css"]) ? $data["css"] : null);
        $this->js = (isset($data["js"]) ? $data["js"] : null);
        $this->jquery = (isset($data["jquery"]) ? $data["jquery"] : null);
        $this->permisos = (isset($data["permisos"]) ? $data["permisos"] : null);
        $this->constante = (isset($data["constante"]) ? $data["constante"] : null);
        $this->url = (isset($data["url"]) ? $data["url"] : null);
        $this->nombre = (isset($data["nombre"]) ? $data["nombre"] : null);
        $this->ajax = (isset($data["ajax"]) ? $data["ajax"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->editable = (isset($data["editable"]) ? $data["editable"] : null);
        $this->modulo = (isset($data["modulo"]) ? $data["modulo"] : null);
        $this->cache = (isset($data["cache"]) ? $data["cache"] : null);

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

    public function php($php = null){ if($php != null){ $this->php=$php; }else{ return $this->php; } }

    public function css($css = null){ if($css != null){ $this->css=$css; }else{ return $this->css; } }

    public function js($js = null){ if($js != null){ $this->js=$js; }else{ return $this->js; } }

    public function jquery($jquery = null){ if($jquery != null){ $this->jquery=$jquery; }else{ return $this->jquery; } }

    public function permisos($permisos = null){ if($permisos != null){ $this->permisos=$permisos; }else{ return $this->permisos; } }

    public function constante($constante = null){ if($constante != null){ $this->constante=$constante; }else{ return $this->constante; } }

    public function url($url = null){ if($url != null){ $this->url=$url; }else{ return $this->url; } }

    public function nombre($nombre = null){ if($nombre != null){ $this->nombre=$nombre; }else{ return $this->nombre; } }

    public function ajax($ajax = null){ if($ajax != null){ $this->ajax=$ajax; }else{ return $this->ajax; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function editable($editable = null){ if($editable != null){ $this->editable=$editable; }else{ return $this->editable; } }

    public function modulo($modulo = null){ if($modulo != null){ $this->modulo=$modulo; }else{ return $this->modulo; } }

    public function cache($cache = null){ if($cache != null){ $this->cache=$cache; }else{ return $this->cache; } }



}
?>
