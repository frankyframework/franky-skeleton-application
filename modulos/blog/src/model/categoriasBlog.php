<?php
namespace Blog\model;

class categoriasBlog  extends \Franky\Database\Mysql\objectOperations
{
        var $visible;
        var $lang;

        public function __construct()
        {
          parent::__construct();
          $this->from()->addTable('categorias_blog');
          $this->visible = "";

        }

        public function setLang($lang)
        {
          $this->lang = $lang;
        }

        function getData($id='',$status='',$busca='')
        {
            $campos = array("id","categorias_blog.nombre","categorias_blog.friendly as amigable_categoria","fecha","status","visible","permisos","imagen","imagen_portada","lang");


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

            if(!empty($this->lang))
            {
              $this->where()->addAnd("categorias_blog.lang",$this->lang,'=');
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

            if(!empty($this->lang))
            {
              $nvoregistro['lang'] = $this->lang;
            }


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
              $nvoregistro['image'] = $imagen;
            }
            if(!empty($this->lang))
            {
              $nvoregistro['lang'] = $this->lang;
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
