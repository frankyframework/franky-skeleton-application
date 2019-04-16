<?php
namespace Blog\model;

class comentariosBlog  extends \Franky\Database\Mysql\objectOperations
{

  public function __construct()
  {
    parent::__construct();
    $this->from()->addTable('comentarios_blog');
  }


        function getData($id='',$articulo="",$usuario="",$busca='',$status= "",$reportado='')
        {
            $campos = array("comentarios_blog.id","comentarios_blog.usuario","comentarios_blog.nombre","id_blog","comentarios_blog.titulo","comentario","comentarios_blog.fecha","reportado",
                            "comentarios_blog.status","ip","blog.titulo as titulo_blog",
                            "users.usuario as autor","blog.friendly","users.id as user_id",
                            "categorias_blog.friendly as amigable_categoria");

            if(!empty($id))
            {
                if(is_numeric($id))
                {
                  $this->where()->addAnd('comentarios_blog.id',$id,'=');
                }
            }
            if(!empty($busca))
            {
              $this->where()->concat('AND (');
                $this->where()->addAnd('comentarios_blog.titulo',"%$busca%",'like');
                $this->where()->addAnd('blog.titulo',"%$busca%",'like');
                $this->where()->addAnd('comentario',"%$busca%",'like');
                $this->where()->concat(')');
                  }
            if(!empty($articulo))
            {
                if(is_numeric($articulo))
                {
                  $this->where()->addAnd('id_blog',$articulo,'=');
                }
                else
                {
                  $this->where()->addAnd('blog.friendly',$articulo,'=');
                }
            }
            if(!empty($usuario))
            {
                $this->where()->addAnd('comentarios_blog.usuario',$usuario,'=');
            }
            if($status != "")
            {
                $this->where()->addAnd('comentarios_blog.status',$status,'=');
            }

            if($reportado != "")
            {
              $this->where()->addAnd('reportado',$reportado,'=');
            }

            $this->from()->addLeft('users','comentarios_blog.usuario','users.id');
            $this->from()->addInner('blog','blog.id','comentarios_blog.id_blog');
            $this->from()->addInner('categorias_blog','blog.categoria','categorias_blog.id');



            return $this->getColeccion($campos);

        }

        function save($usuario,$blog,$titulo,$comentario,$nombre)
        {
            global $MyRequest;
            $nvoregistro = array(
                                "usuario" => $usuario,
                                "nombre" => $nombre,
                                "id_blog" => $blog,
                                "titulo" => $titulo,
                                "comentario" => $comentario,
                                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                                "status" => "1",
                                "ip" => $MyRequest->getIP()


                                );

            return $this->guardarRegistro($nvoregistro);
        }

        function edit($id,$titulo,$comentario)
        {
             $nvoregistro = array(

                                "titulo" => "$titulo",
                                "comentario" => "$comentario",

                                );
            $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro($nvoregistro);
        }
        function delete($id,$status)
        {
            $this->where()->addAnd('id',$id,'=');
            $nvoregistro = array("status" => "$status");
            return $this->editarRegistro($nvoregistro);
        }
        function reportar($id,$status)
        {
            $this->where()->addAnd('id',$id,'=');
            $nvoregistro = array("reportado" => "$status");
            return $this->editarRegistro($nvoregistro);
        }


}
?>
