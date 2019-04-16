<?php
namespace Base\entity;

class redireccionesEntity
{
    public $id;
    public $redireccion;
    public $url;
    public $fecha;
    public $status;



    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id           = (isset($data['id']))              ? $data['id']           : null;
        $this->redireccion  = (isset($data['redireccion']))     ? $data['redireccion']  : null;
        $this->url          = (isset($data['url']))             ? $data['url']          : null;
        $this->status       = (isset($data['status']))          ? $data['status']       : null;
        $this->fecha        = (isset($data['fecha']))           ? $data['fecha']        : null;


    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
       return  array(
            "Url 404" => array("valor" => $this->url,"required"),
            "Redireccion 301" => array("valor" => $this->redireccion,"required")
            );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRedireccion()
    {
        return $this->redireccion;
    }
    public function getUrl()
    {
        return $this->url;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function getFecha()
    {
        return $this->fecha;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRedireccion($redireccion)
    {
        $this->redireccion = $redireccion;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
 }
