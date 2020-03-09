<?php
$sitemap = 
    [
        ["loc" => "", "vars" => array(),"priority" => "1.0","changefreq" => "daily"]
    ];
$modulos = getModulos();

if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
        if($modulo != 'base' && file_exists(PROJECT_DIR."/modulos/$modulo/controller/sitemap.php"))
        {
           
           $add = include(PROJECT_DIR."/modulos/$modulo/controller/sitemap.php");
           foreach($add as $loc)
           {
               $sitemap[] = $loc;
           }
           
            
        }
    }
}


$catalogo_idiomas  = include(PROJECT_DIR.'/modulos/base/configure/idiomas.php');
$idioma_base = getCoreConfig('base/theme/baselang');
$idiomas = getCoreConfig('base/theme/langs');


header('Content-Type: text/xml'); 

echo '<';?>?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach($sitemap as $map): ?>
<url>
    <loc><?php echo $MyRequest->url($map["loc"],$map["vars"],true); ?></loc>
<?php


foreach ($catalogo_idiomas as $idioma => $path_idioma)
{
    if($idioma != $idioma_base && in_array($idioma,$idiomas))
    {

            $_lang = $path_idioma;
            $path_idioma = $path_idioma."/";


         $key_map_idioma = array_search($map["loc"], $urlInternacional[$idioma_base]);


        ?>
        <xhtml:link rel="alternate" hreflang="<?php echo $_lang; ?>" href="<?php echo $MyRequest->url($path_idioma.$urlInternacional[$idioma][$key_map_idioma],$map["vars"],true); ?>" />
        <?php
    }
}

?>
<priority><?php echo $map["priority"]; ?></priority>
    <changefreq><?php echo $map["changefreq"]; ?></changefreq>
</url>
<?php endforeach; ?>
</urlset>