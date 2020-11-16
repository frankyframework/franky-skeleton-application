<?php
namespace Base\model;

class SecciontransaccionalModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('secciones_transaccionales');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","nombre","friendly","status"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("secciones_transaccionales.".$k,$v,'=');
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

    public function save($secciones_transaccionales)
    {
        $secciones_transaccionales = $this->optimizeEntity($secciones_transaccionales);


    	if (isset($secciones_transaccionales['id']))
    	{
            $this->where()->addAnd('id',$secciones_transaccionales['id'],'=');

            return $this->editarRegistro($secciones_transaccionales);
    	}
    	else {

            return $this->guardarRegistro( $secciones_transaccionales);
    	}

    }
}
?>
