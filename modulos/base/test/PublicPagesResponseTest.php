<?php
use PHPUnit\Framework\TestCase;
use Base\model\paginasModel;
use Franky\Core\configure;
use Franky\Core\request;

class PublicPagesResponseTest extends TestCase
{

    private $paginasModel;
    private $request;

    public function setUp() {
      define(PROJECT_DIR,realpath(dirname(__FILE__).'/../../../'));
      $this->paginasModel = new paginasModel();
      $this->request = new request();
    }


  public function testModules()
  {
      $Configure = new configure;
      $modulos =  include(PROJECT_DIR."/configure/modulos.php");
      $modulos[] = "base";
      sort($modulos);
      $_modulos = array();

      $urlInternacional = array();

      $this->paginasModel->setTampag(1000);
      $this->paginasModel->setOrdensql("id ASC");
      if($this->paginasModel->getData() == REGISTRO_SUCCESS)
      {
          while($registro = $this->paginasModel->getRows())
          {
            if(in_array($registro['modulo'],$modulos))
            {
                if(!in_array($registro['modulo'],$_modulos))
                {
                  $_modulos[] = $registro['modulo'];
                }
              }
            }
      }

      sort($_modulos);

      $this->assertEquals(json_encode($modulos), json_encode($_modulos));

      return $urlInternacional;

    }


     /**
      * @depends testModules
      */
    public function testPages(array $urlInternacional)
    {

          $urlInternacional = array();

          $this->paginasModel->setTampag(1000);
          $this->paginasModel->setOrdensql("id ASC");
          if($this->paginasModel->getData(1,'base') == REGISTRO_SUCCESS)
          {
              while($registro = $this->paginasModel->getRows())
              {
                    if($registro["constante"] == 'HOME' || $registro["constante"] == 'ERR_404')
                    {
                        $registro["url"] = "";
                    }

                    $permisos = json_decode($registro['permisos'],true);
                    if(!in_array($registro["url"],$urlInternacional) && empty($permisos) && !preg_match("/\[[a-z0-9-_]+\]/i",$registro['url']))
                    {

                        $urlInternacional[] = $registro["url"];
                    }
                }
          }

        foreach($urlInternacional as $url)
        {
          /*
          $ch = curl_init($this->request->link($url,false,true));
          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch,CURLOPT_TIMEOUT,10);
          $output = curl_exec($ch);
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);

          $this->assertSame($httpcode,200,$this->request->link($url,false,true));
          */
        }


    }



}
