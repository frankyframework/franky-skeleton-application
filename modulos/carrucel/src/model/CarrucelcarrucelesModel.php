<?php
namespace Carrucel\model;

class CarrucelcarrucelesModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('carrucel_carruceles');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","code","auto","dots","infinito","nombre","responsivo","visible","scroll","status","createdAt","updateAt"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("carrucel_carruceles.".$k,$v,'=');
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
    
    function existe($code,$id='')
    {
        $campos = array("id");
        $this->where()->addAnd('code',$code,'=');
        if(!empty($id))
        {
                        $this->where()->addAnd('id',$id,'<>');
        }
        return $this->getColeccion($campos);
    }
}
?>
