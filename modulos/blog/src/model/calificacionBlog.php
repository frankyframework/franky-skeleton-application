<?php
namespace Blog\model;

class calificacionBlog  extends \Franky\Database\Mysql\objectOperations
{

  public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('calificaciones_blog');
    }

    function getCalificacion($id)
     {
          $campos         = array("sum(calificacion)","count(calificacion)");
          $this->where()->addAnd('id_blog',$id,'=');
          $calificacion = 0;
          if($this->getColeccion($campos) == REGISTRO_SUCCESS)
          {
              $registro = $this->getRows();
              $calificaciones = $registro["count(calificacion)"]  ;
              $calificacion += $registro["sum(calificacion)"];
              $calificacion = (empty($registro["count(calificacion)"]) ? 0 : $calificacion/$calificaciones);
          }
		else
		{
			$calificacion = 0;
      $calificaciones = 0;
		}

		return $calificacion.":".$calificaciones;
	}


        function getData($id='', $articulo="",$usuario ="", $calificacion="",$busca="")
        {


            $campos = array("calificaciones_blog.id","calificacion","calificaciones_blog.fecha","blog.titulo","users.usuario as autor","blog.friendly","categorias_blog.friendly as amigable_categoria");



            if(!empty($id))
            {
                if(is_numeric($id))
                {
                  $this->where()->addAnd('calificaciones_blog.id',$id,'=');
                }
            }
            if(!empty($busca))
            {
              $this->where()->addAnd('blog.titulo',"%$busca%",'like');
            }

            if(!empty($articulo))
            {
                $this->where()->addAnd('calificaciones_blog.id_blog',$articulo,'=');
            }

            if(!empty($usuario))
            {
                $this->where()->addAnd('calificaciones_blog.usuario',$usuario,'=');
            }

            if(!empty($calificacion))
            {
              $this->where()->addAnd('calificacion',$calificacion,'=');
            }


          $this->from()->addInner('users','calificaciones_blog.usuario','users.id');
          $this->from()->addInner('blog','blog.id','calificaciones_blog.id_blog');
          $this->from()->addInner('categorias_blog','blog.categoria','categorias_blog.id');


            return $this->getColeccion($campos);

        }


        function save($id,$calificacion,$user)
        {
            global $MyRequest;
            $nvoregistro = array("id_blog" => $id,"calificacion" => $calificacion,"usuario" => $user, "ip " => $MyRequest->getIP(),"fecha" => date('Y-m-d')." ".date('H:i:s'));
            return $this->guardarRegistro( $nvoregistro);
        }

        function getCalificacionUser($id,$usuario)
	{
		$campos         = array("calificacion");
    $this->where()->addAnd('id_blog',$id,'=');
    $this->where()->addAnd('usuario',$usuario,'=');

                return $this->getColeccion($campos);

	}
}
?>
