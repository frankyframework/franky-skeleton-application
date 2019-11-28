<?php
namespace Catalog\model;

class CatalogproductrelatedModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('catalog_product_related');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id_parent","id_product"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("catalog_product_related.".$k,$v,'=');
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

    function existe($parent,$product)
    {
        $campos = array("id_product");
        $this->where()->addAnd('id_parent',$parent,'=');
        $this->where()->addAnd('id_product',$product,'=');
        
        return $this->getColeccion($campos);
    }
}
?>
