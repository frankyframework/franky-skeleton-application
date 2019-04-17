<?php
use PHPUnit\Framework\TestCase;
use Base\model\Contacto;
use Base\entity\comentarios;
use Franky\Core\MYDEBUG;

class ContactoTest extends TestCase
{

  private $ContactoModel;
  private $ContactoEntity;
  public function setUp() {
    define(PROJECT_DIR,realpath(dirname(__FILE__).'/../../../'));

    $this->ContactoModel = new Contacto();
    $this->ContactoEntity         = new comentarios();
  }


  public function testSave()
  {
      $data = [
        'nombre' => 'UnitTest',
        'email' => 'unittest@unittest.com',
        'asunto' => 'UnitTest',
        'telefono' => '5555555555',
        'comentario' => 'prueba UnitTest',
        'fecha' => date('Y-m-d H:i:s'),
        'ip' => '127.0.0.1'
      ];

      $this->ContactoEntity->exchangeArray($data);
        $result = $this->ContactoModel->save($this->ContactoEntity->getArrayCopy());
        $this->assertSame($result, REGISTRO_SUCCESS);

    }

    /**
     * @depends testSave
     */
    public function testSelect()
    {

      $result	 = $this->ContactoModel->getData('UnitTest');

      $this->assertSame($result, REGISTRO_SUCCESS);

      $registro = $this->ContactoModel->getRows();

      return $registro['id'];

    }

    /**
     * @depends testSelect
     */
    public function testDelete($id)
    {

      $result = $this->ContactoModel->delete($id);

      $this->assertSame($result, REGISTRO_SUCCESS);
    }


}
