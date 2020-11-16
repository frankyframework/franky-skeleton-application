<?php
use PHPUnit\Framework\TestCase;
use Franky\Core\configure;

class AliasPHPTest extends TestCase
{

  public function setUp() {
    define(PROJECT_DIR,realpath(dirname(__FILE__).'/../../../'));


  }


  public function testExist()
  {
      $Configure = new configure;
      $modulos =  include(PROJECT_DIR."/configure/modulos.php");
      $modulos[] = "base";
      $modulos[] = $Configure->getPathSite();

      $files = array();
      foreach($modulos as $modulo)
      {
          if(file_exists(PROJECT_DIR."/modulos/$modulo/configure/alias.php"))
          {
              $files[$modulo] = include(PROJECT_DIR."/modulos/$modulo/configure/alias.php");
          }
      }
      $_files = array();
      foreach ($files as $k => $v)
      {
          foreach ($v as $_k => $_v)
          {
            $this->assertTrue(file_exists($_v),$_v);
          }

      }

    }



}
