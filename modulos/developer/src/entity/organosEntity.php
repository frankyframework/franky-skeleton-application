<?php

namespace Developer\entity;


 
 class organosEntity
 {
    public $id;
    public $nombre;
    public $url;
    public $css;
    public $js;
    public $jquery;
    public $php;
    public $permisos;
    public $constante;
    public $ajax;
    public $modulo;
    public $status;
 

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id           = (isset($data['id']))          ? $data['id']           : null;
        $this->nombre       = (isset($data['nombre']))      ? $data['nombre']       : null;
        $this->url          = (isset($data['url']))         ? $data['url']          : null;
        $this->css          = (isset($data['css']))         ? $data['css']          : null;
        $this->js           = (isset($data['js']))          ? $data['js']           : null;
        $this->jquery       = (isset($data['jquery']))      ? $data['jquery']       : null;
        $this->php          = (isset($data['php']))         ? $data['php']          : null;
        $this->permisos     = (isset($data['permisos']))    ? $data['permisos']     : null;
        $this->constante    = (isset($data['constante']))   ? $data['constante']    : null;
        $this->ajax         = (isset($data['ajax']))        ? $data['ajax']         : null;
        $this->modulo       = (isset($data['modulo']))      ? $data['modulo']       : null;
        $this->status       = (isset($data['status']))      ? $data['status']       : null;
        
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array(
            "Nombre" => array("valor" => $this->nombre,"required","length" => array("max" => "200")),
            "Url" => array("valor" => $this->url,"required"),
            "PHP" => array("valor" => $this->php,"required","length" => array("max" => "255")),
            "Modulo" => array("valor" => $this->modulo,"required"),
            "Constante" => array("valor" => $this->constante,"required","length" => array("min" => "1","max" => "100")),
            );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getUrl()
    {
        return $this->url;
    }

    public function getCss()
    {
        return $this->css;
    }
    public function getJs()
    {
        return $this->js;
    }
    public function getJquery()
    {
        return $this->jquery;
    }
    public function getPhp()
    {
        return $this->php;
    }
    public function getPermisos()
    {
        return $this->permisos;
    }
    public function getConstante()
    {
        return $this->constante;
    }
    public function getAjax()
    {
        return $this->ajax;
    }
    public function getModulo()
    {
        return $this->modulo;
    }
    public function getStatus()
    {
        return $this->status;
    }

    
   
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setCss($css)
    {
        $this->css = $css;
    }
    public function setJs($js)
    {
        $this->js = $js;
    }
    public function setJquery($jquery)
    {
        $this->jquery = $jquery;
    }
    public function setPhp($php)
    {
        $this->php = $php;
    }
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }
    public function setConstante($constante)
    {
        $this->constante = $constante;
    }
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
    }
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }


 }

