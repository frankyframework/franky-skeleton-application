<?php
namespace Base\entity;


class TemplateemailEntity
{
    private $id;
    private $nombre;
    private $id_transaccional;
    private $status;
    private $fecha;
    private $Asunto;
    private $destinatario;
    private $cc;
    private $bcc;
    private $name_from;
    private $email_from;
    private $reply;
    private $editable;
    private $html;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->nombre = (isset($data["nombre"]) ? $data["nombre"] : null);
        $this->id_transaccional = (isset($data["id_transaccional"]) ? $data["id_transaccional"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->Asunto = (isset($data["Asunto"]) ? $data["Asunto"] : null);
        $this->destinatario = (isset($data["destinatario"]) ? $data["destinatario"] : null);
        $this->cc = (isset($data["cc"]) ? $data["cc"] : null);
        $this->bcc = (isset($data["bcc"]) ? $data["bcc"] : null);
        $this->name_from = (isset($data["name_from"]) ? $data["name_from"] : null);
        $this->email_from = (isset($data["email_from"]) ? $data["email_from"] : null);
        $this->reply = (isset($data["reply"]) ? $data["reply"] : null);
        $this->editable = (isset($data["editable"]) ? $data["editable"] : null);
        $this->html = (isset($data["html"]) ? $data["html"] : null);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
      $rules = array(
                  "Asunto" => array("valor" => $this->Asunto,"required","length" => array("max" => "250")),
                  "Seccion" => array("valor" => $this->id_transaccional,"required","numeric"),
                  "Destinatario(s)" => array("valor" => $this->destinatario,"required"),
                  "HTML" => array("valor" => $his->html,"required"),
                  "Nombre Remitente" => array("valor" => $this->name_from,"required"),
                  "Email Remitente" => array("valor" => $this->email_from,"required"),
                  "Responde a" => array("valor" => $this->reply,"required")
                  );

        return array();
    }

    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function nombre($nombre = null){ if($nombre != null){ $this->nombre=$nombre; }else{ return $this->nombre; } }

    public function id_transaccional($id_transaccional = null){ if($id_transaccional != null){ $this->id_transaccional=$id_transaccional; }else{ return $this->id_transaccional; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function Asunto($Asunto = null){ if($Asunto != null){ $this->Asunto=$Asunto; }else{ return $this->Asunto; } }

    public function destinatario($destinatario = null){ if($destinatario != null){ $this->destinatario=$destinatario; }else{ return $this->destinatario; } }

    public function cc($cc = null){ if($cc != null){ $this->cc=$cc; }else{ return $this->cc; } }

    public function bcc($bcc = null){ if($bcc != null){ $this->bcc=$bcc; }else{ return $this->bcc; } }

    public function name_from($name_from = null){ if($name_from != null){ $this->name_from=$name_from; }else{ return $this->name_from; } }

    public function email_from($email_from = null){ if($email_from != null){ $this->email_from=$email_from; }else{ return $this->email_from; } }

    public function reply($reply = null){ if($reply != null){ $this->reply=$reply; }else{ return $this->reply; } }

    public function editable($editable = null){ if($editable != null){ $this->editable=$editable; }else{ return $this->editable; } }

    public function html($html = null){ if($html != null){ $this->html=$html; }else{ return $this->html; } }
}
?>
