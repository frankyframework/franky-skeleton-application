<?php
namespace Catalog\model;

class CatalogproductsModel  extends \Franky\Database\Mysql\objectOperations
{

    private $busca;
    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('catalog_products');
    }

    public function setBusca($busca){
        $this->busca=$busca;
    }


    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","name","sku","category","visible_in_search","description","images","videos","url_key","meta_title","meta_keyword","meta_description","price","stock","iva","incluye_iva","createdAt","updateAt","status"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("catalog_products.".$k,$v,'=');
        }

        if($this->busca != "")
        {
          $this->where()->concat('AND (');
          $this->where()->addOr('name','%'.$this->busca.'%','like');
          $this->where()->addOr('description','%'.$this->busca.'%','like');
          $this->where()->addOr('sku','%'.$this->busca.'%','like');
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

    function existeURLKEY($key,$id='')
    {
        $campos = array("id");
        $this->where()->addAnd('url_key',$key,'=');
        if(!empty($id))
        {
                        $this->where()->addAnd('id',$id,'<>');
        }
        return $this->getColeccion($campos);
    }
    function existeSQKU($sku,$id='')
    {
        $campos = array("id");
        $this->where()->addAnd('sku',$sku,'=');
        if(!empty($id))
        {
                        $this->where()->addAnd('id',$id,'<>');
        }
        return $this->getColeccion($campos);
    }
}
?>
