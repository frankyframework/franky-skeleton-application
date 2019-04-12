<?php
ini_set('session.save_path', PROJECT_DIR.'/sess_tmp');
session_start();

ini_set('ignore_repeated_errors',true);

define ("_PHP_ERROR_LOG_", PROJECT_DIR."/logs/error_php.log");
ini_set('error_log',_PHP_ERROR_LOG_);

date_default_timezone_set('America/Mexico_City');

require_once(PROJECT_DIR.'/php-gettext/gettext.inc');
include_once(PROJECT_DIR."/modulos/base/loads/util.php");
include_once(PROJECT_DIR."/modulos/base/loads/util.shell.php");
include_once(PROJECT_DIR."/modulos/base/loads/constantes.php");
include_once(PROJECT_DIR."/modulos/base/loads/autoload.php");

$MyConfigure        = new \vendor\core\configure();

ini_set('display_errors',getCoreConfig('base/debug/display_errors'));


$MyDebug = new \vendor\core\MYDEBUG();
$MyDebug->SetDebug(getCoreConfig('base/debug/debug'));

$MySession          = new \vendor\core\MYSESSION("auth");
$MyMessageAlert     = new \vendor\core\MessageAlert();
$MyFrankyMonster    = new \vendor\core\FRANKY();
$MyMetatag          = new \vendor\core\Metatags();
$MyFlashMessage     = new \vendor\core\flashMessages($CONTEXT);
$MyRequest          = new \vendor\core\request();
$Mobile_detect      = new \vendor\mobile_detect\Mobile_Detect();
$MyRedireccion      = new \modulos\base\vendor\model\redireccionesModel();
$ObserverManager    = new \vendor\core\ObserverManager();

define('LOCALE_DIR', PROJECT_DIR .'/modulos/base/locale/');
$catalogo_idiomas  = include(PROJECT_DIR.'/modulos/base/configure/idiomas.php');
$idioma_base = getCoreConfig('base/theme/baselang');
define('DEFAULT_LOCALE',$idioma_base);

$idiomas = getCoreConfig('base/theme/langs');

$locale = DEFAULT_LOCALE;
$_SESSION['lang'] = DEFAULT_LOCALE;
if($MyRequest->getRequest("lang") != "" && in_array($MyRequest->getRequest("lang"),$idiomas))
{
   $locale = $MyRequest->Sanitizacion($MyRequest->getRequest("lang"));
   $path_idioma =  $catalogo_idiomas[$MyRequest->getRequest("lang")];
    $_SESSION["lang"] = $locale;
}
else
{
    $idioma_encontrado = false;
    foreach ($catalogo_idiomas as $idioma => $path_idioma)
    {
        $is_idioma = substr($MyRequest->getRequest("my_url_friendly",""), 0,strlen($path_idioma)+1);
        if(!empty($path_idioma) && $is_idioma == $path_idioma."/" && in_array($idioma,$idiomas))
        {
            $locale = $idioma;

            $_SESSION["lang"] = $idioma;

            $idioma_encontrado = true;
        }

    }
    if(!$idioma_encontrado)
    {
        $locale = $_SESSION["lang"];
    }

}

if($locale != DEFAULT_LOCALE)
{
    define("PREFIDIOMA", $catalogo_idiomas[$locale]);
}
else
{
    define("PREFIDIOMA", "");
}


$domain = 'messages';

bindtextdomain($domain, LOCALE_DIR);


if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset($domain, 'UTF-8');
}

  T_setlocale(LC_MESSAGES, $locale);
  putenv("LC_ALL=$locale"); //windows, MAC


textdomain($domain);

$lang_root = (!empty($catalogo_idiomas[$locale]) ? $catalogo_idiomas[$locale] : $catalogo_idiomas[$idioma_base]);

header("Content-type: text/html; charset=UTF-8");


$loginForm = new modulos\base\Form\loginForm("autentificacion");


include_once(PROJECT_DIR."/modulos/base/loads/lca.php");

include_once(PROJECT_DIR."/modulos/base/loads/llenaMensajes.php");


$modulos = getModulos("DESC");

if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
       if($modulo != "base")
       {
           if(file_exists(PROJECT_DIR.'/modulos/'.$modulo.'/loads/init.php'))
           {
                include_once(PROJECT_DIR.'/modulos/'.$modulo.'/loads/init.php');
           }
       }
    }
}

include_once(PROJECT_DIR."/modulos/base/loads/llenaFranky.php");
include_once(PROJECT_DIR."/modulos/base/loads/core_config.php");

$seccion = $MyRequest->getRequest("my_url_friendly","");
if(!$MyFrankyMonster->crearMonstruo(($seccion)) || $seccion == ERR_404)
{

      $MyCMS = new \modulos\base\vendor\model\CMS;
      if($MyCMS->getData($MyRequest->getURI(),"",1) == REGISTRO_SUCCESS){
          $MyFrankyMonster->crearMonstruo(CMS);
      }
      else {
        header("HTTP/1.0 404 Not Found");
        header("Status: 404 Not Found");
        $MyFrankyMonster->crearMonstruo(ERR_404);
      }
}
$permisos = $MyFrankyMonster->MyPermisos();
if(is_array($permisos) && !empty($permisos))
{
    if(!$MySession->LoggedIn())
    {
        $MyRequest->redirect($MyRequest->url(LOGIN)."?callback=".$MyRequest->getURI());
    }
    else
    {
        if(!in_array($MySession->GetVar('nivel'),$permisos) && $MySession->GetVar('nivel') != NIVEL_USERDEVELOPER )
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
            $MyRequest->redirect();
        }
    }
}

$callbacks_idioma = array();
foreach ($catalogo_idiomas as $idioma => $path_idioma)
{
      if($idioma == $idioma_base)
      {
          $_lang = $catalogo_idiomas[$idioma_base];
          $path_idioma = "";
      }
      else {
        $_lang = $path_idioma;
          $path_idioma = $path_idioma."/";

      }

      $callbacks_idioma[$idioma] = $MyRequest->url($path_idioma.$urlInternacional[$idioma][$MyFrankyMonster->MyId()],$MyRequest->getUrlParam(),true);

      $MyMetatag->setHreflang($_lang,$callbacks_idioma[$idioma]);

}

if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
       if($modulo != "base")
       {
           if(file_exists(PROJECT_DIR.'/modulos/'.$modulo.'/loads/callback.php'))
           {
                include_once(PROJECT_DIR.'/modulos/'.$modulo.'/loads/callback.php');
           }
       }
    }
}


if($MyRequest->getURI() != "")
{
      $result	 	= $MyRedireccion->getData("",$MyRequest->getPROTOCOLO().$MyRequest->getSERVER().$MyRequest->getURI(),1);
      $total		= $MyRedireccion->getTotal();
      if($result == REGISTRO_SUCCESS)
      {
          $registro = $MyRedireccion->getRows();
          $redireccion = $registro["redireccion"];
          $MyRequest->redirect($redireccion,"301");
      }
      $result	 	= $MyRedireccion->getData("",$MyRequest->getURI(),1);
      $total		= $MyRedireccion->getTotal();
      if($result == REGISTRO_SUCCESS)
      {
          $registro = $MyRedireccion->getRows();
          $redireccion = $registro["redireccion"];


          $MyRequest->redirect($redireccion,"301");
      }
}
if(isset($_SESSION["cookie_http_vars"]) && !empty($_SESSION["cookie_http_vars"])):

    foreach($_SESSION["cookie_http_vars"] as $key => $value)
    {
        foreach($_SESSION["cookie_http_vars"] as $key => $value)
        {
            $FORM[$key] = (!is_array($value) ? ($value) : $value);
        }
    }

$_SESSION["cookie_http_vars"]=array();
 endif;

$MyMenuFront = new \vendor\core\menuSitio();
$modulos = getModulos();
if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
        $MyMenuFront->setArraySeccion(PROJECT_DIR."/modulos/".$modulo."/menu/front.php","modulo_".$modulo);
    }
}


$ObserverManager->addObserver('login_user','validLoginUserDevice');
if($MySession->LoggedIn())
{
    validUserDevice();
}



?>
