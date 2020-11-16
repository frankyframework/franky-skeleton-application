<?php

namespace Ecommerce\entity;


 
 class promociones
 {
    private $id;
    private $status;
    private $fecha;

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id           = (isset($data['id']))          ? $data['id']           : null;
       
        $this->status       = (isset($data['status']))      ? $data['status']       : null;
        $this->fecha        = (isset($data['fecha']))       ? $data['fecha']        : null;
       
        
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array(
        "Codigo" => array("valor" => $this->codigo,"required","length"=> array("max" => "10"))
        );
    }

    public function getId()
    {
        return $this->id;
    }

  
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
   

   
    public function setId($id)
    {
        $this->id = $id;
    }

  
    

   public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    
    public function setStatus($status)
    {
        $this->status = $status;
    }
    

 }

