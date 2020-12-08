<?php
namespace Carrucel\entity;


class CarrucelcarrucelesEntity
{
    private $id;
    private $code;
    private $infinito;
    private $nombre;
    private $dots;
    private $auto;
    private $status;
    private $createdAt;
    private $updateAt;
    private $responsivo;
    private $scroll;
    private $visible;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->code = (isset($data["code"]) ? $data["code"] : null);
        $this->dots = (isset($data["dots"]) ? $data["dots"] : null);
        $this->infinito = (isset($data["infinito"]) ? $data["infinito"] : null);
        $this->nombre = (isset($data["nombre"]) ? $data["nombre"] : null);
        $this->auto = (isset($data["auto"]) ? $data["auto"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->createdAt = (isset($data["createdAt"]) ? $data["createdAt"] : null);
        $this->updateAt = (isset($data["updateAt"]) ? $data["updateAt"] : null);
        $this->responsivo = (isset($data["responsivo"]) ? $data["responsivo"] : null);
        $this->scroll = (isset($data["scroll"]) ? $data["scroll"] : null);
        $this->visible = (isset($data["visible"]) ? $data["visible"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array( 
            "code" => array("valor" => $this->code,"required"),
            "nombre" => array("valor" => $this->nombre,"required"),
            );
    }

    

    public function id($id = null){ if($id !== null){ $this->id=$id; }else{ return $this->id; } }

    public function code($code = null){ if($code !== null){ $this->code=$code; }else{ return $this->code; } }

    public function dots($dots = null){ if($dots !== null){ $this->dots=$dots; }else{ return $this->dots; } }

    public function infinito($infinito = null){ if($infinito !== null){ $this->infinito=$infinito; }else{ return $this->infinito; } }

    public function name($nombre = null){ if($nombre !== null){ $this->nombre=$nombre; }else{ return $this->nombre; } }

    public function auto($auto = null){ if($auto !== null){ $this->auto=$auto; }else{ return $this->auto; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function createdAt($createdAt = null){ if($createdAt !== null){ $this->createdAt=$createdAt; }else{ return $this->createdAt; } }

    public function updateAt($updateAt = null){ if($updateAt !== null){ $this->updateAt=$updateAt; }else{ return $this->updateAt; } }

    public function responsivo($responsivo = null){ if($responsivo !== null){ $this->responsivo=$responsivo; }else{ return $this->responsivo; } }

    public function scroll($scroll = null){ if($scroll !== null){ $this->scroll=$scroll; }else{ return $this->scroll; } }

    public function visible($visible = null){ if($visible !== null){ $this->visible=$visible; }else{ return $this->visible; } }
}
?>
