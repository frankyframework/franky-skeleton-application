<?php
namespace  Galeria\model;
class fotos  extends \Franky\Database\Mysql\objectOperations
{
  public function __construct()
  {
    parent::__construct();
    $this->from()->addTable('fotos_galeria');
  }
        function get($album = "",$status="")
        {
            $campos = array("id","foto","id_album","status","fecha","descripcion","orden");

            if($status != "")
            {
                  $this->where()->addAnd('status',$status,'=');
            }

            if($album != "")
            {
              $this->where()->addAnd('id_album',$album,'=');
            }

            return $this->getColeccion($campos);

        }


        function save($foto,$album)
        {
            $nvoregistro = array(
                "foto" => $foto,
                "id_album" => $album,
                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                "status" => "1",
                "orden" => 0
            );


            return $this->guardarRegistro($nvoregistro);
        }



        function editCampo($id,$campo,$valor)
        {
            $nvoregistro = array(
                $campo => $valor
            );

            $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro( $nvoregistro);
        }


        function delete($id,$status)
        {
            $nvoregistro = array(
                "status" => "$status"
            );

            $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro( $nvoregistro);
        }

}


?>
