<?php
namespace Sliders\model;

class SlidersitemsModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('sliders_sliders_items');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","id_slider","tipo","file","file_responsive","titulo","descripcion","url","status","createdAt","updateAt",
        "orden","code","boton_link","fecha_inicio","fecha_fin"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("sliders_sliders_items.".$k,$v,'=');
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
