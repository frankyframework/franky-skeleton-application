<?php
use PHPUnit\Framework\TestCase;
use Base\model\USERS;
use Franky\Core\LOGIN;

class AcountTest extends TestCase
{

    public function setUp() {
        define(PROJECT_DIR,realpath(dirname(__FILE__).'/../../../'));
      
    }


    public function testGet()
    {
          $usuariosModel = new USERS();
          $result = $usuariosModel->getData();
          $data = $usuariosModel->getRows();
          $this->assertSame($result, REGISTRO_SUCCESS);

          return $data;

    }

    /**
     * @depends testGet
     */
    public function testLogin($data)
    {
        $MyLogin = new LOGIN("users",array("usuario","email"),1,array("status" => "1"));

        $result	 = $MyLogin->setLogin($data['usuario'], 1) ;

        $this->assertSame($result, LOGIN_SUCCESS,$data['usuario'].":".$data['contrasena']);

    }

}
