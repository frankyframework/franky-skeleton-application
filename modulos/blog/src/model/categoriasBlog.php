<?php
namespace Blog\model;

class categoriasBlog  extends \Franky\Database\Mysql\objectOperations
{
        var $visible;

        public function __construct()
        {
          parent::__construct();
          $this->from()->addTable('categorias_blog');
          $this->visible = "";

        }

        function getData($id='',$status='',$busca='')
        {
            $campos = array("id","categorias_blog.nombre","categorias_blog.friendly as amigable_categoria","fecha","status","visible","permisos","imagen","imagen_portada");


            if(!empty($id))
            {
                if(is_numeric($id))
                {
                    $this->where()->addAnd('categorias_blog.id',$id,'=');

                }
                else
                {
                    $this->where()->addAnd('categorias_blog.friendly',$id,'=');
                }

            }
            if(!empty($busca))
            {
                $this->where()->addAnd('categorias_blog.nombre',"%$busca%",'like');
            }

            if($status != "")
            {
                $this->where()->addAnd('categorias_blog.status',$status,'=');
            }

            if($this->visible !== "")
            {
                $this->where()->addAnd('visible',$this->visible,'=');
            }

          


            return $this->getColeccion($campos);

        }

        function save($categoria,$friendly,$imagen,$permisos,$visible)
        {
            $nvoregistro = array(
                "nombre" => $categoria,
                "friendly" => $friendly,
                "imagen" => $imagen,
                "visible" => $visible,
                "permisos" => $permisos,
                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                "status" => "1",
            );


            return $this->guardarRegistro($nvoregistro);
        }

        function edit($id,$categoria,$friendly,$imagen,$permisos,$visible)
        {
           $nvoregistro = array(
                "nombre" => $categoria,
                "friendly" => $friendly,
                "visible" => $visible,
                "permisos" => $permisos,
            );

            if(!empty($imagen))
            {
              $nvoregistro['image'] = $imgen;
            }

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




    function existe($categoria,$id='')
    {
            $campos = array("id");
            $this->where()->addAnd('nombre',$categoria,'=');
            if(!empty($id))
            {
							$this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

}
?>
