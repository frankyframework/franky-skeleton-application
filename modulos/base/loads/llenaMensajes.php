<?php
$archivos_mensaje = array();

$lang = (isset($_SESSION["lang"]) ? $_SESSION["lang"] : DEFAULT_LOCALE);

$modulos = getModulos();
if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {

          if(file_exists(PROJECT_DIR."/modulos/".$modulo."/locale/".$lang."/messages.xml"))
          {
              $archivos_mensaje[] = PROJECT_DIR."/modulos/".$modulo."/locale/".$lang."/messages.xml";
          }

    }
}


foreach ($archivos_mensaje as $_archivos_mensaje)
{

    $mensajes_site =  simplexml_load_file($_archivos_mensaje);

    $mensajes_site = json_decode(json_encode((array)$mensajes_site), true);
    if(!empty($mensajes_site))
    {
        foreach ($mensajes_site["mensaje"] as $mensaje)
        {

            $MyMessageAlert->pushMessage(
                    (!empty($mensajes_site["prefijo"]) ? $mensajes_site["prefijo"]: "").$mensaje["llave"],
                    $mensaje["valor"]);
        }
    }

}
?>
