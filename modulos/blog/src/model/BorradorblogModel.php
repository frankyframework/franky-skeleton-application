<?php
namespace Blog\model;

class BorradorblogModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('borrador_blog');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","data","fecha","id_blog"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("borrador_blog.".$k,$v,'=');
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

    public function save($borrador_blog)
    {
        $borrador_blog = $this->optimizeEntity($borrador_blog);


    	if (isset($borrador_blog['id']))
    	{
            $this->where()->addAnd('id',$borrador_blog['id'],'=');

            return $this->editarRegistro($borrador_blog);
    	}
    	else {

            return $this->guardarRegistro( $borrador_blog);
    	}

    }
    
    public function eliminar($borrador_blog)
    {
        $borrador_blog = $this->optimizeEntity($borrador_blog);
        foreach($borrador_blog as $k => $v)
        {
            $this->where()->addAnd("borrador_blog.".$k,$v,'=');
        }
        
        return $this->eliminarRegistro($borrador_blog);
    }
}
?>
