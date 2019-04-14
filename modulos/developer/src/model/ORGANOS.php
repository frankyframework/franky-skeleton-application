<?php
namespace Developer\model;

class ORGANOS  extends \Franky\Database\Mysql\objectOperations
{

  public function __construct()
  {
    parent::__construct();
    $this->from()->addTable('franky');
  }


        function getData($id='',$nombre='',$url='',$status='1',$delete='1')
        {
            $campos = array("nombre","url","id","css","js","jquery","php","permisos","constante","ajax","modulo","status");

            if(!empty($id))
            {
                if(is_numeric($id))
                {
                  $this->where()->addAnd('id',$id,'=');
                }
                else
                {
                  $this->where()->addAnd('constante',$id,'=');
                }
            }
            if(!empty($url))
            {
              $this->where()->addAnd('urlo',"%$url%",'like');
            }
            if(!empty($nombre))
            {
              $this->where()->addAnd('nombre',"%$nombre%",'like');
            }
            if($delete != "")
            {
              $this->where()->addAnd('editable',$delete,'=');
            }
             if($status != "")
            {
              $this->where()->addAnd('status',$status,'=');
            }

            return $this->getColeccion($campos);

        }

        function findPagina($campo, $valor,$id)
        {
            $campos = array("id");
            $this->where()->addAnd('status','1','=');
            $this->where()->addAnd($campo,$valor,'=');
            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'<>');
            }


            return $this->getColeccion($campos);


        }

        private function optimizeEntity($array)
        {
            foreach ($array as $k => $v )
            {
                if (!isset($v)) {
                    unset($array[$k]);
                }
            }
            return $array;
        }

        public function save($organos)
        {

            $organos = $this->optimizeEntity($organos);

            if (isset($organos['id']))
            {
                $this->where()->addAnd('id',$organos['id'],'=');
                return $this->editarRegistro($organos);
            }
            else {

                return $this->guardarRegistro( $organos);
            }

        }
}

?>
