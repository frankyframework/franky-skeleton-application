<?php
namespace Base\model;


class VerificacionesPendientes  extends \Franky\Database\Mysql\objectOperations
{


    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('verificaciones_pendientes');
    }

    function addVerifica($id,$token)
    {
        $nvoregistro= array("id_user"=>$id,"token"=>$token  ,"fecha"=>date('Y-m-d'), "hora"=>date('H:i:s'));
        return $this->guardarRegistro($nvoregistro);
    }

    function getVerificacion($token)
    {
       $campos = array("id_user");

        $this->where()->addAnd('token',$token,'=');

        return $this->getColeccion($campos);
    }

    function deleteVerificacion($key)
    {
          $this->where()->addAnd('token',$key,'=');
        return $this->eliminarRegistro();
    }



}


?>
