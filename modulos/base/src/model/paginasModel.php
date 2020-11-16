<?php
namespace Base\model;

class paginasModel  extends \Franky\Database\Mysql\objectOperations
{

           public function __construct()
    {
        parent::__construct();
        $this->from()->addTable('franky');
    }
        function getData($status='1',$modulo='')
        {
            $campos = array("nombre","id","url","constante","permisos","js","css","jquery","ajax","php","modulo");

            if($status != "")
            {
              $this->where()->addAnd('status',$status,'=');
            }

            if($modulo != "")
            {
              $this->where()->addAnd('modulo',$modulo,'=');
            }


            return $this->getColeccion($campos);

        }


}

?>
