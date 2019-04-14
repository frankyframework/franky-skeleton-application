<?php

namespace Base\entity;



 class users
 {
    public $id;
    public $usuario;
    public $contrasena;
    public $email;
    public $nivel;
    public $fecha;
    public $ultimoAcceso;
    public $status;
    public $nombre;
    public $fecha_nacimiento;
    public $sexo;
    public $telefono;
    public $verificado;
    public $biografia;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id              = (isset($data['id']))                  ? $data['id']               : null;
        $this->usuario         = (isset($data['usuario']))             ? $data['usuario']          : null;
        $this->contrasena      = (isset($data['contrasena']))          ? $data['contrasena']       : null;
        $this->email           = (isset($data['email']))               ? $data['email']            : null;
        $this->nivel           = (isset($data['nivel']))               ? $data['nivel']            : null;
        $this->fecha           = (isset($data['fecha']))               ? $data['fecha']            : null;
        $this->ultimoAcceso    = (isset($data['ultimoAcceso']))        ? $data['ultimoAcceso']     : null;
        $this->status          = (isset($data['status']))              ? $data['status']           : null;
        $this->nombre          = (isset($data['nombre']))              ? $data['nombre']           : null;
        $this->fecha_nacimiento= (isset($data['fecha_nacimiento']))    ? $data['fecha_nacimiento'] : null;
        $this->sexo            = (isset($data['sexo']))                ? $data['sexo']             : null;
        $this->telefono        = (isset($data['telefono']))            ? $data['telefono']         : null;
        $this->verificado      = (isset($data['verificado']))          ? $data['verificado']       : null;
        $this->biografia       = (isset($data['biografia']))           ? $data['biografia']        : null;

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation($contrasena1,$length,$passwordlevel)
    {

        return array(
            "Usuario" => array("valor" => $this->usuario,"required","valid_chars" => "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.","length" => array("max" => "15")),
            "Nombre" => array("valor" => $this->nombre,"required",'name-validation',"length" => array("max" => "255")),
            "Teléfono" => array("valor" => $this->telefono,"length" => array("max" => "10")),
            "Email" => array("valor" => $this->email,"required", "email"),
            "Contraseña" => array("valor" => $this->contrasena, "required","password" => $passwordlevel,"length" => array("min" => $length,"max" => "15")),
            "Confirmar contraseña" => array("valor" => $contrasena1, "required","password" => $passwordlevel,"length" => array("min" => $length,"max" => "15"))
            );
    }

    public function setValidationadmin()
    {
        $rules = array(
            "Nombre" => array("valor" => $this->nombre,"required","length" => array("max" => "255")),
            "Email" => array("valor" => $this->email,"required", "email")
        );
        if(empty($this->id))
        {
            $rules["Usuario"] = array("valor" => $this->usuario, "required" ,"valid_chars" => "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.","length" => array("max" => "15"));
        }
        return $rules;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getNivel()
    {
        return $this->nivel;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getUltimoAcceso()
    {
        return $this->ultimoAcceso;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getFecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getVerificado()
    {
        return $this->verificado;
    }

    public function getBiografia()
    {
        return $this->biografia;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setUltimoAcceso($ultimoAcceso)
    {
        $this->ultimoAcceso = $ultimoAcceso;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setFecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setVerificado($verificado)
    {
        $this->verificado = $verificado;
    }

    public function setBiografia($biografia)
    {
        $this->biografia = $biografia;
    }



 }
