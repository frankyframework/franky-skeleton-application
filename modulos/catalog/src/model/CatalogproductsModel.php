<?php
namespace Catalog\model;

class CatalogproductsModel  extends \Franky\Database\Mysql\objectOperations
{

    private $busca;
    private $precio;
    private $categoria_array;
    private $subcategoria_array;

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('catalog_products');
    }

    public function setBusca($busca){
        $this->busca=$busca;
    }

    public function setPrecioArray($data)
    {
        $this->precio = $data;
    }
    public function setCategoriaArray($data)
    {
        $this->categoria_array = $data;
    }

    public function setSubcategoriaArray($data)
    {
        $this->subcategoria_array = $data;
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","name","sku","category","visible_in_search","description","images","videos","url_key","meta_title","meta_keyword","meta_description","price","stock","iva","incluye_iva","createdAt","updateAt","status",
        "in_stock","saleable","min_qty","stock_infinito"];

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

    function getDataSearch($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["catalog_products.id","catalog_products.name","sku","category",
        "catalog_products.visible_in_search","catalog_products.description",
        "images","videos","catalog_products.url_key","catalog_products.meta_title",
        "catalog_products.meta_keyword","catalog_products.meta_description",
        "price","stock","iva","incluye_iva","catalog_products.createdAt",
        "catalog_products.updateAt","catalog_products.status",
        "in_stock","saleable","min_qty","stock_infinito"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("catalog_products.".$k,$v,'=');
        }

        if(!empty($this->busca) )
        {

            $this->where()->concat("AND (MATCH(catalog_products.name) "
                . "AGAINST('$busca' in boolean mode) "
                . "or "
                . "MATCH(catalog_products.meta_keyword) "
                . "AGAINST('$busca' in boolean mode) ");
           
                $this->where()->addOr('catalog_products.name',"%$this->busca%",'like');
                $this->where()->addOr('catalog_products.meta_keyword',"%$this->busca%",'like');
        
                $this->where()->concat(')');

        }
      

          if(!empty($this->precio)){
                  if(is_array($this->precio))
                  {
                    $this->where()->concat("AND (");
                    $this->where()->addAnd("catalog_products.price ",trim($this->precio[0]),'>=');
                    $this->where()->addAnd("catalog_products.price ",trim($this->precio[1]),'<=');
                    $this->where()->concat(')');
                  }
                }


        if(!empty($this->categoria_array)){
          if(is_array($this->categoria_array))
          {
            $this->where()->concat("AND (");
            foreach($this->categoria_array as $id)
            {
                  $this->where()->addOr("catalog_category.url_key",$id,'=');
            }
              $this->where()->concat(')');
          }
          if(!empty($this->subcategoria_array)){
            if(is_array($this->subcategoria_array))
            {
              $this->where()->concat("AND (");
              foreach($this->subcategoria_array as $id)
              {
                    $this->where()->addOr("catalog_subcategory.url_key",$id,'=');
              }
                $this->where()->concat(')');
            }
            }
         
          $this->from()->addInner('catalog_subcategory_product','catalog_subcategory_product.id_product','catalog_products.id');
          $this->from()->addInner('catalog_subcategory','catalog_subcategory_product.id_subcategory','catalog_subcategory.id');
          $this->from()->addInner('catalog_category','catalog_subcategory.id_category','catalog_category.id');
          $this->setGrupo('catalog_products.id');
        }

        return $this->getColeccion($campos);
    }



    function getInfoProducto($id)
    {

        $campos = ["catalog_products.id","precio","ecommerce_precios.incluye_iva","ecommerce_precios.iva","name as nombre","images as imagen","stock","url_key","min_qty","stock_infinito","saleable","in_stock","min_qty"];

        $this->where()->addAnd("catalog_products.id",$id,'=');

        $this->from()->addLeft('ecommerce_precios','catalog_products.id','ecommerce_precios.id_producto');

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
