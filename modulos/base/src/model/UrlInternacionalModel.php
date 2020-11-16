<?php
namespace Base\model;

class UrlInternacionalModel  extends \Franky\Database\Mysql\objectOperations
{
       public function __construct()
    {
        parent::__construct();
        $this->from()->addTable('url_internacional');
    }

    function getData($url = array(),$franky = array(),$busca = "")
    {
        $url = $this->optimizeEntity($url);
        $franky = $this->optimizeEntity($franky);
        $campos = ["url_internacional.id","id_franky","url_internacional.url","url_internacional.status","fecha","lang","nombre","franky.url as urli"];

         $this->where()->addAnd("franky.status",'1','=');

         foreach($url as $k => $v)
         {
             $this->where()->addAnd("url_internacional.".$k,$v,'=');
         }
         foreach($franky as $k => $v)
         {
             $this->where()->addAnd("franky.".$k,$v,'=');
         }

        if(!empty($busca))
        {
           $this->where()->addAnd("nombre","%$busca%",'like');
        }

        $this->from()->addInner('franky','url_internacional.id_franky','franky.id');

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

    public function save($url)
    {
        $url = $this->optimizeEntity($url);


    	if (isset($url['id']))
    	{
              $this->where()->addAnd('id',$url['id'],'=');
            return $this->editarRegistro($url);
    	}
    	else {

            return $this->guardarRegistro($url);
    	}

    }
}
?>
