<?php
namespace Base\model;

class USERS  extends \Franky\Database\Mysql\objectOperations
{
    protected $rango;
    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('users');
    }
  
    public function setRango($rango)
    {
        $this->rango = $rango;
    }
    
    
    function getData($id='',$busca='',$nivel='',$status='1')
    {
            $campos = array("id","nombre","usuario","email","nivel","fecha","fecha_nacimiento","sexo","telefono","contrasena","verificado","biografia","status");

            if(!empty($id))
            {
                if(is_numeric($id))
                {
                  $this->where()->addAnd('id',$id,'=');
                }
                else
                {
                  $this->where()->addAnd('usuario',$id,'=');
                }

            }
            if(!empty($busca))
            {
                $this->where()->concat('AND (');
                $this->where()->addOr('usuario',"%$busca%",'like');
                $this->where()->addOr('email',"%$busca%",'like');
                $this->where()->concat(')');
            }
            if(!empty($nivel))
            {
                if(is_array($nivel))
                {

                    $this->where()->concat('AND (');
                    foreach ($nivel as $k)
                    {
                      $this->where()->addOr('nivel',$k,'=');

                    }
                    $this->where()->concat(')');

                }
                else
                {
                  $this->where()->addAnd('nivel',$nivel,'=');
                }
            }
             if(!empty($status))
            {
              $this->where()->addAnd('status',$status,'=');
            }
            
             if(!empty($this->rango))
            {
                  $this->where()->concat('AND (');
                  $this->where()->addAnd('fecha',$this->rango[0],'>=');
                  $this->where()->addAnd('fecha',$this->rango[1],'<=');
                  $this->where()->concat(')');
            }


            return $this->getColeccion($campos);

        }





    function findUser($usuario,$id=null)
    {
        $campos = array("usuario");
        $this->where()->addAnd('usuario',$usuario,'=');

        if(!empty($id))
        {
            $this->where()->addAnd('id',$id,'<>');
        }

        return $this->getColeccion($campos);

    }
    function findEmail($email,$id=null)
    {
        $campos = array("email");
        $this->where()->addAnd('email',$email,'=');
        if(!empty($id))
        {
          $this->where()->addAnd('id',$id,'<>');
        }

        return $this->getColeccion($campos);

    }
    function findTelefono($telefono,$id=null)
    {
        $campos = array("telefono");
        $this->where()->addAnd('telefono',$telefono,'=');
        if(!empty($id))
        {
          $this->where()->addAnd('id',$id,'<>');
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

    public function save($user)
    {

        $user = $this->optimizeEntity($user);


    	if (isset($user['id']))
    	{
          $this->where()->addAnd('id',$user['id'],'=');
            return $this->editarRegistro( $user);
    	}
    	else {

            return $this->guardarRegistro($user);
    	}

    }
}


?>
