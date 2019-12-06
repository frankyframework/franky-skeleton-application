<?php
namespace Catalog\model;

class CatalogwishlistModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('catalog_wishlist');
    }

    function getData($data = array(), $products = array(),$busca='',$rango=array())
    {
        $products = $this->optimizeEntity($products);
        $data = $this->optimizeEntity($data);
        $campos = ["catalog_wishlist.id","catalog_wishlist.uid","product_id","catalog_wishlist.fecha","catalog_wishlist.status","name","catalog_products.url_key"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("catalog_wishlist.".$k,$v,'=');
        }
         foreach($products as $k => $v)
        {
            $this->where()->addAnd("catalog_products.".$k,$v,'=');
        }

        if(!empty($busca))
        {
              $this->where()->addAnd('catalog_products.name','%'.$busca.'%','like');
        }
        if(!empty($rango))
        {
              $this->where()->concat('AND (');
              $this->where()->addAnd('Fecha',$rango[0],'>=');
              $this->where()->addAnd('Fecha',$rango[1],'<=');
              $this->where()->concat(')');
        }

        $this->from()->addInner("catalog_products","catalog_wishlist.product_id","catalog_products.id");
        $this->from()->addInner("users","users.id","catalog_wishlist.uid");


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

    public function delete($data)
    {

      $data = $this->optimizeEntity($data);
      foreach($data as $k => $v)
      {
          $this->where()->addAnd("catalog_wishlist.".$k,$v,'=');
      }

      return $this->eliminarRegistro($data);
    }
}
?>
