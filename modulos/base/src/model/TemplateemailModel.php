<?php
namespace Base\model;

class TemplateemailModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('templates_email');
    }

    function getData($data = array(),$secciones = array(),$buscar='')
    {
        $data = $this->optimizeEntity($data);
        $secciones = $this->optimizeEntity($secciones);
        $campos = ["templates_email.id","templates_email.nombre","id_transaccional","templates_email.status","fecha","Asunto","destinatario","cc","bcc","name_from",
        "email_from","reply","editable","html","secciones_transaccionales.nombre as seccion"];

        foreach($data as $k => $v)
        {
            $this->where()->addAnd("templates_email.".$k,$v,'=');
        }

        foreach($secciones as $k => $v)
        {
            $this->where()->addAnd("secciones_transaccionales.".$k,$v,'=');
        }

        if(!empty($busca))
        {
          $this->where()->concat('AND (');
          $this->where()->addOr('templates_email.nombre','%'.$busca.'%','like');
          $this->where()->addOr('secciones_transaccionales.nombre','%'.$busca.'%','like');
          $this->where()->concat(')');
        }

        $this->from()->addInner("secciones_transaccionales","templates_email.id_transaccional","secciones_transaccionales.id");
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

    function existe($nombre,$id='')
    {
            $campos = array("id");

             $this->where()->addAnd('nombre',$nombre,'=');
            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

    public function save($templates_email)
    {
        $templates_email = $this->optimizeEntity($templates_email);


    	if (isset($templates_email['id']))
    	{
            $this->where()->addAnd('id',$templates_email['id'],'=');

            return $this->editarRegistro($templates_email);
    	}
    	else {

            return $this->guardarRegistro( $templates_email);
    	}

    }
}
?>
