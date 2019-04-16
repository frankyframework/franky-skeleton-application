<?php
namespace Ecommerce\entity;


 
 class direcciones_facturacion
 {
    private $id;
    private $uid;
    private $status;
    private $fecha;
    private $nombre;
    private $apellido_paterno;
    private $apellido_materno;
    private $telefono;
    private $calle;
    private $numero;
    private $numeroi;
    private $cp;
    private $estado;
    private $ciudad;
    private $municipio;
    private $colonia;
    private $rfc;

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id                   = (isset($data['id']))                  ? $data['id']                   : null;
        $this->uid                  = (isset($data['uid']))                ? $data['uid']                   : null;
        $this->status               = (isset($data['status']))              ? $data['status']               : null;
        $this->fecha                = (isset($data['fecha']))               ? $data['fecha']                : null;
        $this->nombre               = (isset($data['nombre']))              ? $data['nombre']               : null;
        $this->apellido_paterno     = (isset($data['apellido_paterno']))    ? $data['apellido_paterno']     : null;
        $this->apellido_materno     = (isset($data['apellido_materno']))    ? $data['apellido_materno']     : null;
        $this->telefono             = (isset($data['telefono']))            ? $data['telefono']             : null;
        $this->calle                = (isset($data['calle']))               ? $data['calle']                : null;
        $this->numero               = (isset($data['numero']))              ? $data['numero']               : null;
        $this->numeroi              = (isset($data['numeroi']))             ? $data['numeroi']              : null;
        $this->cp                   = (isset($data['cp']))                  ? $data['cp']                   : null;
        $this->estado               = (isset($data['estado']))              ? $data['estado']               : null;
        $this->ciudad               = (isset($data['ciudad']))              ? $data['ciudad']               : null;
        $this->municipio            = (isset($data['municipio']))           ? $data['municipio']            : null;
        $this->colonia              = (isset($data['colonia']))             ? $data['colonia']              : null;
        $this->rfc                  = (isset($data['rfc']))                 ? $data['rfc']                  : null;
        
        
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array(
        _ecommerce("Nombre") => array("valor" => $this->nombre,"required","length"=> array("max" => "50")),
        _ecommerce("Apellido paterno") => array("valor" => $this->nombre,"required","length"=> array("max" => "50")),
        _ecommerce("Teléfono") => array("valor" => $this->telefono,"required","length"=> array("max" => "21")),        
        _ecommerce("Calle") => array("valor" => $this->calle,"required"),
        _ecommerce("Numero") => array("valor" => $this->numero,"required","length"=> array("max" => "10")),
        _ecommerce("Código postal") => array("valor" => $this->cp,"required","length"=> array("max" => "5")),
        _ecommerce("Estado") => array("valor" => $this->estado,"required"),
        _ecommerce("Ciudad") => array("valor" => $this->ciudad,"required"),
        _ecommerce("Municipio") => array("valor" => $this->municipio,"required"),
        _ecommerce("Colonia") => array("valor" => $this->colonia,"required"),
        _ecommerce("Entre calles") => array("valor" => $this->entre_calle1,"required"),
        _ecommerce("Entre calles") => array("valor" => $this->entre_calle2,"required")
        );
    }

    public function setValidationFacturacion()
    {
        return array(
        _ecommerce("Nombre") => array("valor" => $this->nombre,"required","length"=> array("max" => "50")),
        _ecommerce("Apellido paterno") => array("valor" => $this->nombre,"required","length"=> array("max" => "50")),
        _ecommerce("Teléfono") => array("valor" => $this->telefono,"required","length"=> array("max" => "21")),        
        _ecommerce("Calle") => array("valor" => $this->calle,"required"),
        _ecommerce("Numero") => array("valor" => $this->numero,"required","length"=> array("max" => "10")),
        _ecommerce("Código postal") => array("valor" => $this->cp,"required","length"=> array("max" => "5")),
        _ecommerce("Estado") => array("valor" => $this->estado,"required"),
        _ecommerce("Ciudad") => array("valor" => $this->ciudad,"required"),
        _ecommerce("Municipio") => array("valor" => $this->municipio,"required"),
        _ecommerce("Colonia") => array("valor" => $this->colonia,"required"),
        _ecommerce("RFC") => array("valor" => $this->rfc,"required"),
        
        );
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUid()
    {
        return $this->uid;
    }

  
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
   
    public function getNombre()
    {
        return $this->nombre;
    }
   
    public function getApellido_patenro()
    {
        return $this->apellido_paterno;
    }
    
    public function getApellido_materno()
    {
        return $this->apellido_materno;
    }
    
    public function getTelefono()
    {
        return $this->telefono;
    }
    
  
    public function getCalle()
    {
        return $this->calle;
    }
    
    public function getNumero()
    {
        return $this->numero;
    }
    
    public function getNumeroi()
    {
        return $this->numeroi;
    }
    
    public function getCp()
    {
        return $this->cp;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function getCiudad()
    {
        return $this->ciudad;
    }
    
    public function getMunicipio()
    {
        return $this->municipio;
    }
    
    public function getColonia()
    {
        return $this->colonia;
    }
    
   
    
    public function getRfc()
    {
        return $this->rfc;
    }
    
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    public function setApellido_paterno($apellido_paterno)
    {
        $this->apellido_paterno = $apellido_paterno;
    }
    
    public function setApellido_materno($apellido_materno)
    {
        $this->apellido_materno = $apellido_materno;
    }
   
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    
    public function setTelefono_otro($telefono_otro)
    {
        $this->telefono_otro = $telefono_otro;
    }
    
    public function setCalle($calle)
    {
        $this->calle = $calle;
    }
    
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
    
    public function setNumeroi($numeroi)
    {
        $this->numeroi = $numeroi;
    }
    
    public function setCp($cp)
    {
        $this->cp = $cp;
    }
    
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }
    
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;
    }
    
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;
    }
    
   
    
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;
    }

 }

