<?php
namespace  Galeria\model;
class albumes  extends \Franky\Database\Mysql\objectOperations
{
  public function __construct()
  {
    parent::__construct();
    $this->from()->addTable('albumes_galeria');
  }
        function get($id= "",$status="")
        {
            $campos = array("id","nombre","friendly","status","fecha","orden");


            if($status != "")
            {
              $this->where()->addAnd('status',$status,'=');
            }

            if($id != "")
            {
                if(is_numeric($id))
                {
                    $this->where()->addAnd('id',$id,'=');
                }
                else
                {
                  $this->where()->addAnd('friendly',$id,'=');
                }
            }


            return $this->getColeccion($campos);

        }


        function save($nombre,$friendly)
        {
            $nvoregistro = array(
                "nombre" => $nombre,
                "friendly" => $friendly,
                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                "status" => "1",
                "orden" => 0
            );


            return $this->guardarRegistro( $nvoregistro);
        }

        function edit($id,$nombre,$friendly)
        {
            $nvoregistro = array(
                "nombre" => $nombre,
                "friendly" => $friendly
            );

              $this->where()->addAnd('id',$id,'=');


            return $this->editarRegistro($nvoregistro);
        }

        function editCampo($id,$campo,$valor)
        {
            $nvoregistro = array(
                $campo => $valor
            );

            $this->where()->addAnd('id',$id,'=');


            return $this->editarRegistro($nvoregistro);
        }


        function delete($id,$status)
        {
            $nvoregistro = array(
                "status" => "$status"
            );

            $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro( $nvoregistro);
        }


    function existeAlbum($nombre,$id='')
    {
            $campos = array("id");
            $this->where()->addAnd('nombre',$nombre,'=');
            $this->where()->addAnd('status','1','=');

            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

}


?>
