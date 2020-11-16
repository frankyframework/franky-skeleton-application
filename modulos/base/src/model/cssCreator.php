<?php
namespace Base\model;



class cssCreator
{
    
    private $css;
    private $cssFolder = '/public/css/';
    private $Namecss;
    private $path;
    public function __construct($name="global.css") {
        $this->css = array();
        $this->Namecss = $name;
        $this->path = "";
    }
    
    public function addCss($css)
    {
        $this->css = $css;
    }
     public function setPath($path)
    {
        $this->path = $path;
        
    }
    
    public function setName($name)
    {
        $this->Namecss = $name;
    }
    
    private function MKD()
    {
         if(!file_exists(PROJECT_DIR.$this->cssFolder))
        {
            mkdir(PROJECT_DIR.$this->cssFolder,0777);
            
        }
        
        if(!file_exists(PROJECT_DIR.$this->cssFolder.$this->path))
        {
            mkdir(PROJECT_DIR.$this->cssFolder.$this->path,0777);
            
        }
    }
    private function compararHash()
    {
        
       $this->MKD();
        if(!file_exists(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss.".hash"))
        {
            return true;
        }

        $file = fopen(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss.".hash",'r');

        $hash = json_decode(fgets($file),true);

        fclose($file);

        
        if(is_array($this->css))
        {
            foreach($this->css as $file)
            {
                
                if(md5_file(PROJECT_DIR.$file) != $hash[$file])
                {
                    return true;
                }
            }
        }
        else
        {
          
            if(md5_file(PROJECT_DIR.$this->css) != $hash[$this->css])
            {
                return true;
            }
        }
        return false;
    }
    
    private function crearHash()
    {
       
         $this->MKD();
        $hash = array();
        if(is_array($this->css))
        {
            foreach($this->css as $file)
            {
                $hash[$file] = md5_file(PROJECT_DIR.$file);
             
            }
        }
        else
        {
            $hash[$this->css] = md5_file(PROJECT_DIR.$this->css);
        }
        
        $file = fopen(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss.".hash",'w');
        $hash = json_encode($hash);
        fwrite($file,$hash.PHP_EOL);
        fclose($file);

        chmod(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss.".hash", 0777);

        return false;
    }
    
    private function crearCss()
    {
         $this->MKD();
        $buffer = "";
        if(is_array($this->css))
        {
            foreach($this->css as $file)
            {
                                               
                $buffer .= str_replace(array("../","fonts/franky-font."),
                        array(dirname($file)."/../",dirname($file)."/fonts/franky-font."),
                        file_get_contents(PROJECT_DIR.$file));

            }
        }
        else
        {
            $buffer = str_replace(array("../","fonts/franky-font."),
                    array(dirname($this->css)."/../",dirname($this->css)."/fonts/franky-font."),
                    file_get_contents(PROJECT_DIR.$this->css));
        }

        $globalFile = fopen(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss, 'w');
        
        
        
        $contenidoCss = $this->minify($buffer);

        $objDate = new \DateTime();
        $objDate->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        fwrite($globalFile,'/***ARCHIVO GENERADO: '.$objDate->format(\DateTime::ISO8601).'***/ '.$contenidoCss);

        fclose($globalFile);

        chmod(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss, 0777);
    }
    
    private function minify($contenido)
    {
        $comprimido='';
        // Remove comments
        $comprimido = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contenido);

        // Remove space after colons
        $comprimido = str_replace(': ', ':', $comprimido);

        // Remove whitespace
        $comprimido = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $comprimido);
        
        
        return $comprimido;
    }
    
    
    public function  get()
    {
        if($this->compararHash())
        {
            
            $this->crearHash();
            $this->crearCss();
        }
        
        return $this->cssFolder.$this->path.$this->Namecss."?".md5_file(PROJECT_DIR.$this->cssFolder.$this->path.$this->Namecss);
        
        
    }
    
    
}
