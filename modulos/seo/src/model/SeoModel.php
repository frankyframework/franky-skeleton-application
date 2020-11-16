<?php
namespace Seo\model;

class SeoModel  extends \Franky\Database\Mysql\objectOperations
{
       public function __construct()
    {
        parent::__construct();
        $this->from()->addTable('seo');
    }
    
    function getData($seo = array(),$franky = array(),$busca = "")
    {
        $seo = $this->optimizeEntity($seo);
        $franky = $this->optimizeEntity($franky);
        $campos = ["seo.id","id_franky","titulo","descripcion","keywords","seo.status","fecha","lang","nombre","extra"];

         $this->where()->addAnd("franky.status",'1','=');

         foreach($seo as $k => $v)
         {
             $this->where()->addAnd("seo.".$k,$v,'=');
         }
         foreach($franky as $k => $v)
         {
             $this->where()->addAnd("franky.".$k,$v,'=');
         }

        if(!empty($busca))
        {
           $this->where()->addAnd("nombre","%$busca%",'like');
        }

        $this->from()->addInner('franky','seo.id_franky','franky.id');

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

    public function save($seo)
    {
        $seo = $this->optimizeEntity($seo);


    	if (isset($seo['id']))
    	{
              $this->where()->addAnd('id',$seo['id'],'=');
            return $this->editarRegistro($seo);
    	}
    	else {

            return $this->guardarRegistro($seo);
    	}

    }
}
?>
