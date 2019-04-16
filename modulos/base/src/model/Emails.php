<?php
namespace Base\model;


class Emails  extends \Franky\Database\Mysql\objectOperations
{


    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('emails');
    }

     function getMailV($email)
    {
        $campos = array("email" );
        $this->where()->addAnd('email',$email,'=');

        return  $this->getColeccion($campos);

    }

    function setMailV($email)
    {
        $nvoregistro = array("email" => $email );

        return  $this->guardarRegistro($nvoregistro);
    }

}


?>
