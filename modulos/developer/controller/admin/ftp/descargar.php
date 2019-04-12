<?php
use Franky\Filesystem\File;
$file = $MyRequest->getRequest('file');
if(empty($file))
{
    $MyRequest->redirect();
}
if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_FTP))
{
    $MyRequest->redirect();
}
if(!file_exists(PROJECT_DIR.$file))
{
    $MyRequest->redirect();
}

if(is_dir(PROJECT_DIR.$file))
{

    $zip = new ZipArchive();

    $zip->open(basename($file).".zip", ZipArchive::CREATE);

    $File = new File;

    $files = $File->getAllFiles(PROJECT_DIR."/".$file);

    foreach($files['file'] as $_file)
    {
        echo str_replace(PROJECT_DIR."/".$file,basename($file), $_file)."<br />";
        $zip->addFile($_file,str_replace(PROJECT_DIR."/".$file,basename($file), $_file));
    }

    $zip->close();

    header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=".basename($file).".zip");
    readfile(basename($file).'.zip');
    unlink(basename($file).'.zip');
}
else
{
    header("Content-disposition: attachment; filename=".basename($file));
    header("Content-type: application/octet-stream");
    readfile(PROJECT_DIR.$file);
}
?>
