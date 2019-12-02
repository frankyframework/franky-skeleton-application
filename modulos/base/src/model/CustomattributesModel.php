<?php
namespace Base\model;

class CustomattributesModel  extends \Franky\Database\Mysql\objectOperations
{
    private $busca;
    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('custom_attributes');
    }

    public function setBusca($busca){
        $this->busca=$busca;
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","name","label","type","data","source","entity","createdAt","updateAt","status"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("custom_attributes.".$k,$v,'=');
        }

        if($this->busca != "")
        {
          
          $this->where()->addAnd('name','%'.$this->busca.'%','like');
          
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

    function existe($attribute,$entity,$id='')
    {
        $campos = array("id");
        $this->where()->addAnd('name',$attribute,'=');
        $this->where()->addAnd('entity',$entity,'=');
        if(!empty($id))
        {
                $this->where()->addAnd('id',$id,'<>');
        }
        return $this->getColeccion($campos);
    }
}
?>
