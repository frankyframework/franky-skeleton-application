<?php
namespace Base\model;

class CoreConfigModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('core_config');
    }

    function getData($data = array())
    {

        $data = $this->optimizeEntity($data);

        $campos = ["id","modulo","path","value"];

        foreach($data as $k => $v)
        {
            if(!empty($v))
            {
              $this->where()->addAnd($k,$v,'=');
            }
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

      	if (isset($avatares['id']))
      	{
              $this->where()->addAnd('id',$data['id'],'=');
              return $this->editarRegistro($data);
      	}
      	else {

              return $this->guardarRegistro($data);
      	}

    }

    public function updateByPath($data)
    {
        $data = $this->optimizeEntity($data);

        if (isset($data['path']))
        {
              $this->where()->addAnd('path',$data['path'],'=');
              return $this->editarRegistro($data);
        }
        return false;

    }



}
?>
