<?php
namespace Base\model;

class redireccionesModel  extends \Franky\Database\Mysql\objectOperations
{


          public function __construct()
          {
            parent::__construct();
            $this->from()->addTable('redirecciones');
          }

        function getData($id="", $url="",$status= "")
        {
            $campos = array("id","url","redireccion","status","fecha");

            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'=');
            }

            if(!empty($url))
            {
              $this->where()->addAnd('url',$url,'=');
            }

            if(!empty($status))
            {
                $this->where()->addAnd('status',$status,'=');
            }


            return $this->getColeccion($campos);

        }


        function existe($url,$id='',$urln='')
        {
                $campos = array("id");
                $this->where()->addAnd('url',$url,'=');

                if(!empty($id))
                {
                  $this->where()->addAnd('id',$id,'<>');
                }
                if(!empty($urln))
                {
                  $this->where()->addAnd('redireccion',$urln,'=');
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

        public function save($redireccion)
        {

            $redireccion = $this->optimizeEntity($redireccion);


            if (isset($redireccion['id']))
            {
                $this->where()->addAnd('id',$redireccion['id'],'=');
                return $this->editarRegistro( $redireccion);
            }
            else {

                return $this->guardarRegistro($redireccion);
            }

        }
}


?>
