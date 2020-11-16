<?php
namespace Ecommerce\model;

class cupones  extends \Franky\Database\Mysql\objectOperations
{
  public function __construct()
  {
    parent::__construct();
    $this->from()->addTable('ecommerce_cupones');
  }

    function getData($id='',$code='',$status='1')
    {
        $campos = array();

        if(!empty($id))
        {
            if(is_numeric($id))
            {
                   $this->where()->addAnd('id',$id,'=');
            }
        }
        if(!empty($code))
        {
            $this->where()->addAnd('codigo',$code,'=');
        }

        if(!empty($status))
        {
            $this->where()->addAnd('status',$status,'=');
        }


        return $this->getColeccion($campos);

    }

    function findCupon($codigo,$id=null)
    {
        $campos = array("codigo");
          $this->where()->addAnd('codigo',$codigo,'=');
        if(!empty($id))
        {
            $this->where()->addAnd('id',$id,'<>');
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

    public function save($cupon)
    {
        $cupon = $this->optimizeEntity($cupon);


    	if (isset($cupon['id']))
    	{
            $this->where()->addAnd('id',$cupon['id'],'=');
            return $this->editarRegistro($cupon);
    	}
    	else {

            return $this->guardarRegistro($cupon);
    	}

    }
}


?>
