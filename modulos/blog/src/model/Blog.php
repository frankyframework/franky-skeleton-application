<?php
namespace Blog\model;

class Blog  extends \Franky\Database\Mysql\objectOperations
{

    var $visible_in_search;
    var $nivel;
    var $is_admin;
    var $lang;

    public function __construct()
      {
        parent::__construct();
        $this->from()->addTable('blog');
        $this->visible_in_search = "";
        $this->nivel = "";
        $this->is_admin = 0;
      }

      public function isVisibleInSearch($val)
      {
        $this->visible_in_search = $val;
      }
      
      public function setNivel($nivel)
      {
        $this->nivel = $nivel;
      }
      
      public function setIsAdmin($val)
      {
        $this->is_admin = $val;
      }

      public function setLang($lang)
      {
        $this->lang = $lang;
      }


        function getData($id='',$busca='',$autor='',$destacado='',$status='',$categoria="",$next="",$back ="")
        {
            $campos = array("blog.id","blog.categoria","titulo","contenido","destacado","blog.friendly","comentarios","blog.fecha","fecha_modificado","blog.lang",
                "blog.status","autor","keywords","meta_titulo","meta_descripcion","visible_in_search","blog.permisos","blog.imagen","blog.imagen_portada",
                "categorias_blog.nombre as categoria_nombre","categorias_blog.friendly as amigable_categoria","categorias_blog.visible","categorias_blog.permisos"
                ,"users.nombre as nombre_user","usuario","biografia","users.id as id_user","autortext");

            
            if(!empty($busca))
            {
                    $this->where()->concat('AND (');
                    $this->where()->addOr("blog.titulo","%$busca%",'like');
                    $this->where()->addOr("blog.contenido","%$busca%",'like');
                    $this->where()->addOr("blog.keywords","%$busca%",'like');
                    $this->where()->addOr("categorias_blog.nombre","%$busca%",'like');
                    $this->where()->concat(')');
            }
            if(!empty($autor))
            {
                if(is_numeric($autor))
                {
                    $this->where()->addAnd('autor',$autor,'=');
                }
                else
                {
                    $this->where()->addAnd('usuario',$autor,'=');

                }
            }
             if(!empty($destacado))
            {
                $this->where()->addAnd('destacado',$destacado,'=');
            }

            if($status != "")
            {
                $this->where()->addAnd('blog.status',$status,'=');
            }

            if($categoria != "")
            {
               if(is_numeric($categoria))
               {
                    $this->where()->addAnd('blog.categoria',$categoria,'=');
               }
               else
               {
                    $this->where()->addAnd('categorias_blog.friendly',$categoria,'=');
               }


            }
            if(!empty($next) && !empty($id))
            {
							$this->where()->addAnd('blog.id',$id,'>');
            }elseif(!empty($back) && !empty($id))
            {
							$this->where()->addAnd('blog.id',$id,'<');
            }
            else{
                if(!empty($id))
                {
                    if(is_numeric($id))
                    {
                            $this->where()->addAnd("blog.id",$id,'=');
                    }
                    else
                    {
                            $this->where()->addAnd("blog.friendly",$id,'=');
                    }

                }
            }

            if($this->visible_in_search !== "")
            {
                $this->where()->addAnd('blog.visible_in_search',$this->visible_in_search,'=');
            }
            if(!empty($this->lang))
            {
              $this->where()->addAnd("blog.lang",$this->lang,'=');
            }
            if(empty($this->is_admin))
            {

                if(empty($this->nivel))
                {
                  $this->where()->concat('AND (');
                  $this->where()->addOr("blog.permisos","[]",'=');
                  $this->where()->addOr("blog.permisos","",'=');
                  $this->where()->concat(')');
                }
                else {
                  $this->where()->concat('AND (');
                  $this->where()->addOr("blog.permisos","[]",'=');
                  $this->where()->addOr("blog.permisos","",'=');
                    $this->where()->addOr("blog.permisos",'%'.$this->nivel.'%','like');
                  $this->where()->concat(')');
                }
            }

            
            $this->from()->addInner('categorias_blog','blog.categoria','categorias_blog.id');
            $this->from()->addInner('users','blog.autor','users.id');

            return $this->getColeccion($campos);

        }

        function save($categoria,$titulo,$friendly,$autortext,$contenido,$comentarios,$autor,$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search,$permisos,$meta_titulo="", $meta_descripcion="")
        {
            $nvoregistro = array(
                "categoria" => $categoria,
                "titulo" => $titulo,
                "contenido" => $contenido,
                "friendly" => $friendly,
                "comentarios" => $comentarios,
                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                "autor" => $autor,
                "keywords" => $keywords,
                "status" => "1",
                "destacado" => $destacado,
                "autortext" => $autortext,
                "imagen" => $imagen,
                "imagen_portada" => $imagen_portada,
                "visible_in_search" => $visible_in_search,
                "permisos" => $permisos,
                "meta_titulo" => $meta_titulo,
                "meta_descripcion" => $meta_descripcion
            );

            if(!empty($this->lang))
            {
              $nvoregistro['lang'] = $this->lang;
            }

            return $this->guardarRegistro( $nvoregistro);
        }

        function edit($id,$categoria,$titulo,$friendly,$autortext,$contenido,$comentarios,$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search,$permisos,$meta_titulo="", $meta_descripcion="")
        {
           $nvoregistro = array(
                "categoria" => $categoria,
                "titulo" => $titulo,
               "autortext" => $autortext,
                "contenido" => $contenido,
                "friendly" => $friendly,
                "comentarios" => $comentarios,
                "keywords" => $keywords,
                "destacado" => $destacado,
                "visible_in_search" => $visible_in_search,
                "permisos" => $permisos,
                "meta_titulo" => $meta_titulo,
                "meta_descripcion" => $meta_descripcion
            );
            if(!empty($this->lang))
            {
              $nvoregistro['lang'] = $this->lang;
            }

            if(!empty($imagen))
            {
              $nvoregistro['imagen'] = $imagen;
              $nvoregistro['imagen_portada'] = $imagen_portada;
            }
              $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro($nvoregistro);
        }
        function delete($id,$status)
        {
            $nvoregistro = array(
                "status" => "$status"
            );

              $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro($nvoregistro);
        }

    function existe($titulo,$categoria,$id='')
    {
            $campos = array("id");

						$this->where()->addAnd('titulo',$titulo,'=');
						$this->where()->addAnd('categoria',$categoria,'=');

            if(!empty($id))
            {
							$this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

}

?>
