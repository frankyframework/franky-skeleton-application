<?php
namespace Base\model;

class Mailing  extends \Franky\Database\Mysql\objectOperations
{


          public function __construct()
          {
            parent::__construct();
            $this->from()->addTable('mailing');
          }


        function getData($busca='')
        {
            $campos = array("email","fecha");

            if(!empty($busca))
            {
              $this->where()->addAnd('email',"%$busca%",'like');
            }



            return $this->getColeccion($campos);

        }



}


?>
