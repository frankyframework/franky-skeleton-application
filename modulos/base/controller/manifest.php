<?php
$icon = (getCoreConfig('base/pwa/icon') ? getCoreConfig('base/pwa/icon') : '');
$name = (getCoreConfig('base/pwa/name') ? getCoreConfig('base/pwa/name') : '');
if(!empty($icon) || !empty($name))
{
  $manifest =array(
      "name"=> $name,
      "short_name" => $name,
      "icons" => 
      array(
          array("src" => imageResize($icon,512,512,true),"type" => "image/png","sizes" => "512x512"),
          array("src" => imageResize($icon,192,192,true),"type" => "image/png","sizes" => "192x192"),
          array("src" => imageResize($icon,144,144,true),"type" => "image/png","sizes" => "144x144"),
          array("src" => imageResize($icon,96,96,true),"type" => "image/png","sizes" => "96x96"),
          array("src" => imageResize($icon,48,48,true),"type" => "image/png","sizes" => "48x48")
    ),
      "start_url" => "/?utm_source=homescreen",
      "display" => "standalone",
      "theme_color" => getCoreConfig('base/pwa/theme-color'),
      "background_color" => getCoreConfig('base/pwa/background_color')
      );

header("Content-type: text/json");
echo stripslashes(json_encode($manifest));
}
?>
