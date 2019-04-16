<?php
namespace Base\model;

class AvataresModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('avatares');
    }

    function getData($avatares = array())
    {

        $avatares = $this->optimizeEntity($avatares);

        $campos = ["id","id_user","name","url","status"];

        foreach($avatares as $k => $v)
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

    public function save($avatares)
    {
        $avatares = $this->optimizeEntity($avatares);

      	if (isset($avatares['id']))
      	{
              $this->where()->addAnd('id',$avatares['id'],'=');
              return $this->editarRegistro($avatares);
      	}
      	else {

              return $this->guardarRegistro($avatares);
      	}

    }

    public function delete($avatares)
    {
        $avatares = $this->optimizeEntity($avatares);


      	if (isset($avatares['id']))
      	{
              $this->where()->addAnd('id',$avatares['id'],'=');
              return $this->eliminarRegistro();
      	}


    }
}
?>
