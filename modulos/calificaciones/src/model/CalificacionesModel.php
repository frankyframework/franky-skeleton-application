<?php
namespace Calificaciones\model;

class CalificacionesModel  extends \Franky\Database\Mysql\objectOperations
{
    private $campos;

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('calificaciones_calificaciones');
    }
    
    function setCampos($campos)
    {
        $this->campos = $campos;
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["calificaciones_calificaciones.id",
            "calificaciones_calificaciones.id_item",
            "calificaciones_calificaciones.tabla",
            "calificaciones_calificaciones.createdAt",
            "calificaciones_calificaciones.updateAt",
            "calificaciones_calificaciones.status",
            "calificaciones_calificaciones.aprovado",
            "calificaciones_calificaciones.calificacion",
            "calificaciones_calificaciones.titulo",
            "calificaciones_calificaciones.comentario"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("calificaciones_calificaciones.".$k,$v,'=');
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

    public function save($data)
    {
        $data = $this->optimizeEntity($data);


    	if (isset($data['id']))
    	{
            $this->where()->addAnd('id',$data['id'],'=');

            return $this->editarRegistro($data);
    	}
    	else {

            return $this->guardarRegistro($data);
    	}

    }
}
?>
