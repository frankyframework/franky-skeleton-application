<?php
namespace Ecommerce\model;

class promociones  extends \Franky\Database\Mysql\objectOperations
{

  public function __construct()
  {
    parent::__construct();
    $this->from()->addTable('ecommerce_promociones');
  }
    function getData($id='',$status='1')
    {
        $campos = array();

        if(!empty($id))
        {
            if(is_numeric($id))
            {
              $this->where()->addAnd('id',$id,'=');
            }
        }

        if(!empty($status))
        {
            $this->where()->addAnd('status',$status,'=');
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

    public function save($promociones)
    {
        $promociones = $this->optimizeEntity($promociones);


    	if (isset($promociones['id']))
    	{
              $this->where()->addAnd('id',$promociones['id'],'=');
            return $this->editarRegistro( $promociones);
    	}
    	else {

            return $this->guardarRegistro( $promociones);
    	}

    }
}


?>
