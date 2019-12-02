<?php
namespace Base\model;

class CustomattributesvaluesModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('custom_attributes_values');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id_attribute","id_ref","value","entity"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("custom_attributes_values.".$k,$v,'=');
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

        return $this->guardarRegistro($data);
    	

    }

    public function remove($data)
    {
        $data = $this->optimizeEntity($data);
        if (!empty($data))
    	{
            foreach($data as $k => $v)
            {
                $this->where()->addAnd("custom_attributes_values.".$k,$v,'=');
            }

            return $this->eliminarRegistro();
    	}
    	return false;
    }
}
?>
