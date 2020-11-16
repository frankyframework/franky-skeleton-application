<?php
namespace Developer\model;

class configure extends \Franky\Core\configure
{	
    private $db;
    function __construct() 
    {
        parent::__construct();


        $this->db = include(PROJECT_DIR."/modulos/".$this->modulo."/env/ftp.php");

    }

    public function getCONECTHOST($conexion)
    {
        return $this->db[$conexion]["host"];
    }
    public function getCONECTUSER($conexion)
    {
        return $this->db[$conexion]["usuario"];
    }
    public function getCONECTPASSWORD($conexion)
    {
        return $this->db[$conexion]["password"];
    }
    
    public function getDBNAME($conexion)
    {
        return $this->db[$conexion]["basedatos"];
    }
    
   
}
?>