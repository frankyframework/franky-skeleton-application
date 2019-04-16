<?php
namespace Base\entity;


class UserdeviceEntity
{
    private $id;
    private $id_user;
    private $type;
    private $os;
    private $user_agent;
    private $ip;
    private $create_at;
    private $access_last;
    private $device_id;
    private $status;


    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->id_user = (isset($data["id_user"]) ? $data["id_user"] : null);
        $this->type = (isset($data["type"]) ? $data["type"] : null);
        $this->os = (isset($data["os"]) ? $data["os"] : null);
        $this->user_agent = (isset($data["user_agent"]) ? $data["user_agent"] : null);
        $this->ip = (isset($data["ip"]) ? $data["ip"] : null);
        $this->create_at = (isset($data["create_at"]) ? $data["create_at"] : null);
        $this->access_last = (isset($data["access_last"]) ? $data["access_last"] : null);
        $this->device_id = (isset($data["device_id"]) ? $data["device_id"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);

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

    public function id_user($id_user = null){ if($id_user != null){ $this->id_user=$id_user; }else{ return $this->id_user; } }

    public function type($type = null){ if($type != null){ $this->type=$type; }else{ return $this->type; } }

    public function os($os = null){ if($os != null){ $this->os=$os; }else{ return $this->os; } }

    public function user_agent($user_agent = null){ if($user_agent != null){ $this->user_agent=$user_agent; }else{ return $this->user_agent; } }

    public function ip($ip = null){ if($ip != null){ $this->ip=$ip; }else{ return $this->ip; } }

    public function create_at($create_at = null){ if($create_at != null){ $this->create_at=$create_at; }else{ return $this->create_at; } }

    public function access_last($access_last = null){ if($access_last != null){ $this->access_last=$access_last; }else{ return $this->access_last; } }

    public function device_id($device_id = null){ if($device_id != null){ $this->device_id=$device_id; }else{ return $this->device_id; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }
}
?>
