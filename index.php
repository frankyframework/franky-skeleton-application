<?php
define('PROJECT_DIR',$_SERVER["DOCUMENT_ROOT"]);
require(PROJECT_DIR."/modulos/base/loads/init.php");

$controller = $MyFrankyMonster->MyPHPFile();
require(getController(str_replace(".phtml",".php",$controller)));


if($MyFrankyMonster->isAdmin())
{

  require(getController("admin/layout/index.php"));
  $dump_hmtl = render(getVista("admin/layout/index.phtml"));
}
else {
  require(getController("index.php"));
  $dump_hmtl = render(getVista("index.phtml"));
}


if(getCoreConfig('base/debug/debug') == 0 && getCoreConfig('base/debug/production'))
{
    $MinifyHtml = new modulos\base\vendor\model\MinifyHtml();
    echo $MinifyHtml->minify($dump_hmtl);
}
else
{
    echo $dump_hmtl;
}
?>
