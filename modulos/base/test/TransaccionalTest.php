<?php
use PHPUnit\Framework\TestCase;
use Franky\Core\MYDEBUG;
use \Base\model\TemplateemailModel;
use \Base\entity\SecciontransaccionalEntity;

include(dirname(__FILE__).'/../loads/util.php');

class TransaccionalTest extends TestCase
{

  private $TemplateemailModel;
  private $SecciontransaccionalEntity;
  public function setUp() {
    define(PROJECT_DIR,realpath(dirname(__FILE__).'/../../../'));

    $this->TemplateemailModel = new TemplateemailModel();
    $this->SecciontransaccionalEntity         = new SecciontransaccionalEntity();
  }


  public function testMail()
  {
      $campos = [
        'nombre' => 'UnitTest',
        'email' => 'unittest@unittest.com',
        'asunto' => 'UnitTest',
        'telefono' => '5555555555',
        'comentarios' => 'prueba UnitTest',
        'sitio_titulo' => ''
      ];


      $this->SecciontransaccionalEntity->friendly('contactanos');
      $this->TemplateemailModel->setOrdensql('id DESC');
      $result = $this->TemplateemailModel->getData([],$this->SecciontransaccionalEntity->getArrayCopy());

      $this->assertSame($result, REGISTRO_SUCCESS);

      $registro  = $this->TemplateemailModel->getRows();


      $this->assertTrue(sendEmail($campos,$registro));


    }

}
