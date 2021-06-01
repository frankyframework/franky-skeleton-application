<?php
namespace Base\model;
class FileSessionHandler implements \SessionHandlerInterface
{

    private $savePath;
    private $filesystem;
    function __construct(\Franky\Filesystem\File $filesystem)
    {
        $this->filesystem = $filesystem;
    }
 
    function open($savePath, $sessionName)
    {
        
        $this->savePath = $savePath;
        $this->filesystem->mkdir($this->savePath);

        return true;
    }

    function close()
    {
        return true;
    }

    function read($id)
    {
        return (string)@file_get_contents("$this->savePath/sess_$id");
    }

    function write($id, $data)
    {
        return file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
    }

    function destroy($id)
    {
        $file = "$this->savePath/sess_$id";
        if (file_exists($file)) {
            unlink($file);
        }

        return true;
    }

    function gc($maxlifetime)
    {
    
        foreach (glob("$this->savePath/sess_*") as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) { // Use our own lifetime
                unlink($file);
            }
        }

        return true;
    }
}