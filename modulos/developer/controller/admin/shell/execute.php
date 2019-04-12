<?php
use Franky\Filesystem\File;

$File = new File();
$modulos = getModulos();

$exec = $MyRequest->getRequest("command");

$comandos = array();
$ls = "";

foreach($modulos as $modulo)
{
    if(file_exists(PROJECT_DIR."/modulos/$modulo/shell/"))
    {
        $files = $File->getFiles(PROJECT_DIR."/modulos/$modulo/shell/");

        foreach ($files as $file)
        {

            $comando = $modulo.":".basename($file,".php");

            $ls .= $comando."\n";
            $comandos[$comando] = PROJECT_DIR."/modulos/$modulo/shell/".$file;
        }
    }
}



if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_SHELL))
{
    echo shellFontColor($MyMessageAlert->Message("sin_privilegios"),"rojo")."\n";
    exit;
}


if($exec == "ls")
{
    echo shellFontColor($ls,'verde'); exit;
}

$ambiguo = array();
foreach($comandos as $k => $v)
{
    $command = explode(":",$k);
    $_command = explode(":",$exec);

    if($_command[0] == substr($command[0],0,strlen($_command[0])) && $_command[1] == substr($command[1],0,strlen($_command[1])))
    {
        $ambiguo[] = $k;
    }
}

if(count($ambiguo) > 1)
{
     echo shellFontColor("El commando es ambiguo","rojo")."\n";
     echo shellFontColor(implode("\n",$ambiguo),"verde")."\n";
}
elseif(isset($comandos[$ambiguo[0]]) && file_exists($comandos[$ambiguo[0]]))
{
    echo (render($comandos[$ambiguo[0]]));
}
else{
    echo shellFontColor("command not found","rojo")."\n";
    echo shellFontColor($ls,'verde'); exit;
}


?>
