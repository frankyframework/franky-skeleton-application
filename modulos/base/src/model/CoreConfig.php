<?php
namespace Base\model;

class CoreConfig extends \Franky\Core\configure
{

    function __construct()
    {
         parent::__construct();

    }

    public function getMap($modulo)
    {
        $path = PROJECT_DIR."/modulos/".$modulo."/configure/core_config.php";

        if(!file_exists($path))
        {
          return false;
        }
        return include($path);
    }

    public function getMapRender($path=null)
    {
        $config = $this->getServerUploadDir()."/core_config/core_config.php";
        if(!file_exists($config))
        {
          return false;
        }

        $configure = include($config);

        if($path === null)
        {
            return $configure;

        }
        if(isset($configure[$path]))
        {
          return $configure[$path];
        }

        return false;
    }
}
?>
