<?php
namespace Sociallogin\model;

class configureGoogle extends \Franky\Core\configure
{

    private $config;
    function __construct()
    {
        parent::__construct();
        if(file_exists(PROJECT_DIR."/modulos/".$this->modulo."/env/googlep.php"))
        {
            $this->config = include(PROJECT_DIR."/modulos/".$this->modulo."/env/googlep.php");
        }
    }


    public function getConsumeKey()
    {
        return $this->config["key"];
    }
    public function getConsumerSecret()
    {
        global $MyRequest;
        return $this->config["consumer"];
    }
    public function getConsumerDevelop()
    {
        global $MyRequest;
        return $this->config["develop"];
    }

}
?>
