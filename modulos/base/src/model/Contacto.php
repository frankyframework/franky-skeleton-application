<?php
namespace Base\model;


class Contacto  extends \Franky\Database\Mysql\objectOperations
{


          public function __construct()
          {
            parent::__construct();
            $this->from()->addTable('comentarios');
          }

        function getData($busca='',$rango=array())
        {
            $campos = array("id","nombre","email","telefono","asunto","comentario","fecha","ip");


            if(!empty($busca))
            {
                  $this->where()->concat('AND (');
                  $this->where()->addOr('email','%'.$busca.'%','like');
                  $this->where()->addOr('nombre','%'.$busca.'%','like');
                  $this->where()->addOr('comentario','%'.$busca.'%','like');
                  $this->where()->concat(')');
                }
            if(!empty($rango))
            {
                  $this->where()->concat('AND (');
                  $this->where()->addAnd('Fecha',$rango[0].' 00:00:00','>=');
                  $this->where()->addAnd('Fecha',$rango[1].' 23:59:59','<=');
                  $this->where()->concat(')');
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

        public function save($contacto)
        {
            $contacto = $this->optimizeEntity($contacto);

            if (isset($contacto['id']))
            {
                $this->where()->addAnd('id',$contacto['id'],'=');
                return $this->editarRegistro($contacto);
            }
            else {

                return $this->guardarRegistro($contacto);
            }

        }

        public function delete($id)
        {
            $this->where()->addAnd('id',$id,'=');
            return $this->eliminarRegistro();
        }



}



?>
