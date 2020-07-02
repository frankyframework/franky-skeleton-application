<?php
namespace Ecommerce\model;

class EcommercetiendasModel  extends \Franky\Database\Mysql\objectOperations
{

    private $pickup;
    public function __construct()
    {
        parent::__construct();
        $this->from()->addTable('ecommerce_tiendas');
        $this->pickup = "";
    }

    public function pickup($val)
    {
        $this->pickup = $val;
    }
    function getData($id='',$status='1',$busca ='')
    {
        $campos = array("id","status","fecha","nombre","telefono","calle","numero","numeroi","cp","estado","ciudad","municipio",
            "colonia","pickup_point","horario");

        if(!empty($id))
        {
            if(is_numeric($id))
            {
                      $this->where()->addAnd('id',$id,'=');
            }
        }

        if(!empty($uid))
        {
            if(is_numeric($uid))
            {
                      $this->where()->addAnd('uid',$uid,'=');
            }
        }

        if(!empty($status))
        {
               $this->where()->addAnd('status',$status,'=');

        }
        if($this->pickup !== "")
        {
               $this->where()->addAnd('pickup_point',$this->pickup,'=');

        }
        if(!empty($busca))
        {
            $this->where()->concat('AND (');
            $this->where()->addOr('nombre',"%$busca%",'like');
            $this->where()->addOr('calle',"%$busca%",'like');
            $this->where()->addOr('estado',"%$busca%",'like');
            $this->where()->addOr('ciudad',"%$busca%",'like');
            $this->where()->addOr('municipio',"%$busca%",'like');
            $this->where()->addOr('colonia',"%$busca%",'like');
            $this->where()->concat(')');

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

    public function save($direcciones)
    {
        $direcciones = $this->optimizeEntity($direcciones);


    	if (isset($direcciones['id']))
    	{
            $this->where()->addAnd('id',$direcciones['id'],'=');
            return $this->editarRegistro($direcciones);
    	}
    	else {

            return $this->guardarRegistro($direcciones);
    	}

    }
}


?>
