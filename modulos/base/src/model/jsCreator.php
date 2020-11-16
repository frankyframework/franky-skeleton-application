<?php
namespace Base\model;
use Base\model\Minifier;


class jsCreator
{
    
    private $js;   
    private $embebed;   
    private $jsFolder = '/public/mjs/';
    private $Namejs;
    private $path;
    public function __construct($name="global.js") {
        $this->js = array();
        $this->Namejs = $name;
        $this->path = "";
        $this->embebed = "";
    }
    
    public function addJs($js)
    {
        $this->js = $js;
    }
    
    public function setEmbebed($code)
    {
        $this->embebed = $code;
    }
    
 
    public function setPath($path)
    {
        $this->path = $path;
        
    }
    public function setName($name)
    {
        $this->Namejs = $name;
    }
    
    private function MKD()
    {
         if(!file_exists(PROJECT_DIR.$this->jsFolder))
        {
            mkdir(PROJECT_DIR.$this->jsFolder,0777);
            
        }
        
         if(!file_exists(PROJECT_DIR.$this->jsFolder.$this->path))
        {
            mkdir(PROJECT_DIR.$this->jsFolder.$this->path,0777);
            
        }
    }
    private function compararHash()
    {
        
       $this->MKD();
        if(!file_exists(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs.".hash"))
        {
            return true;
        }

        $file = fopen(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs.".hash",'r');

        $hash = json_decode(fgets($file),true);

        fclose($file);

        
        if(is_array($this->js))
        {
            foreach($this->js as $file)
            {
                if(md5_file(PROJECT_DIR.$file) != $hash[$file])
                {
                    return true;
                }
            }
        }
        else
        {
            if(md5_file(PROJECT_DIR.$this->js) != $hash[$this->js])
            {
                return true;
            }
        }
        
        if(md5($this->embebed) != $hash["embebed"])
        {
            return true;
        }
        
       
        return false;
    }
    
    private function crearHash()
    {
       
         $this->MKD();
        $hash = array();
        if(is_array($this->js))
        {
            foreach($this->js as $file)
            {
                $hash[$file] = md5_file(PROJECT_DIR.$file);
             
            }
        }
        else
        {
            $hash[$this->js] = md5_file(PROJECT_DIR.$this->js);
        }
        
       
        $hash["embebed"] =md5($this->embebed);
        
        $file = fopen(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs.".hash",'w');
        $hash = json_encode($hash);
        fwrite($file,$hash.PHP_EOL);
        fclose($file);

        chmod(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs.".hash", 0777);

        return false;
    }
    
    private function crearJs()
    {
         $this->MKD();
        $buffer = "";
        if(is_array($this->js))
        {
            foreach($this->js as $file)
            {
                $buffer .= file_get_contents(PROJECT_DIR.$file);
            }
        }
        else
        {
            $buffer = file_get_contents($this->js);
        }

       
        
        $globalFile = fopen(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs, 'w');
        

        $contenidoCss = Minifier::minify($buffer."\n".$this->embebed);

        $objDate = new \DateTime();
        $objDate->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        fwrite($globalFile,'/***ARCHIVO GENERADO: '.$objDate->format(\DateTime::ISO8601).'***/ '.$contenidoCss);

        fclose($globalFile);

        chmod(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs, 0777);
    }
    

    
    public function  get()
    {
       // print_r($this->js);
        if($this->compararHash())
        {
            
            $this->crearHash();
            $this->crearJs();
        }
        
        return $this->jsFolder.$this->path.$this->Namejs."?".md5_file(PROJECT_DIR.$this->jsFolder.$this->path.$this->Namejs);
        
        
    }
    
    
}
