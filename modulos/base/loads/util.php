<?php
$method = strtolower($_SERVER['REQUEST_METHOD']);

switch($method)
{
        case 'get':
                $CONTEXT =& $_GET;
                break;
        case 'post':
                $CONTEXT =& $_POST;
                break;
        default:
                $CONTEXT = array();
                break;
}

$_Months = Array ('01'=>"Ene",
                '02'=>"Feb",
                '03'=>"Mar",
                '04'=>"Abr",
                '05'=>"May",
                '06'=>"Jun",
                '07'=>"Jul",
                '08'=>"Ago",
                '09'=>"Sep",
                '10'=>"Oct",
                '11'=>"Nov",
                '12'=>"Dic");

$_Days = array('Dom','Lun','Mar','Mie','Jue','Vie','Sab');

function makeHTMLImg($src, $width="", $height="", $alt="", $extra='',$live=0)
{
	if(!empty($height))
	{
		$height = "height='$height'";
	}

	if(!empty($width))
	{
		$width = "width='$width'";
	}
  if($live == 0)
  {
    $html = "<img src=\"$src\" $width $height  alt=\"$alt\"  $extra />";
  }
  else {
    if($live == 1)
    {
      $img_live = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z/C/HgAGgwJ/lK3Q6wAAAABJRU5ErkJggg==";
    }
    else {
      $img_live = $live;
    }
    $html = "<img src=\"$img_live\" data-alive=\"$src\" $width $height  alt=\"$alt\"  $extra />";
  }

	return ($html);
}

function makeHTMLOrder($campo, $caption)
{
        global $MyPaginacion;
        global $MyRequest;
        $campo_orden = $MyPaginacion->getCampoOrden();
        $order = $MyPaginacion->getOrden();

        $query = $MyRequest->getRequest();

        unset($query["por"]);
       // unset($query["page"]);
        unset($query["order"]);
        unset($query["my_url_friendly"]);
       // unset($query["tampag"]);
        $_query = "";
        foreach($query as $k => $v)
        {
          if(is_array($v))
          {
            foreach($v as $_v)
            {
              $_query .= $k.'[]='.$_v.'&amp;';
            }

          }
          else {
            $_query .= $k.'='.$v.'&amp;';
          }

        }

        $uri = parse_url($_SERVER["REQUEST_URI"]);

	if($campo == $MyPaginacion->getCampoOrden())
	{
		$order = $MyPaginacion->getOrden();

	}
        else {
            $order = "";
        }


	if(!empty($caption))
	{
		$caption = "<a href=\"".$uri["path"]."?".$_query."por=$campo&amp;order=".($campo == $campo_orden ? ($order == "ASC" ? "DESC" : "ASC"): "ASC")."\" data-transition=\"fade\">$caption</a>";
	}

	print ("<div  class='$order'>$caption</div>");

}

function getToken($name)
{
     $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
     $token = md5(substr(md5(str_shuffle($alphanum)), 0, 10));
     $_SESSION["token_".$name] = $token;

     return $token;
}

function getFriendly($string)
{
        $string = trim($string);
        $string = trim($string,"?");
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = strtolower($string);
	$string = preg_replace('#([^.a-z0-9]+)#i', '-', $string);
        $string = preg_replace('#-{2,}#','-',$string);
        $string = trim($string,"-");
	return $string;
}


function tinyurl($url_larga)
{
    global $MyConfigure;
    $tiny = "http://api.bit.ly/v3/shorten?login=&apiKey=".$MyConfigure->getTinyUrlKey()."&format=txt&longUrl=".urlencode($url_larga);
    $sesion = curl_init();
    curl_setopt ( $sesion, CURLOPT_URL, $tiny );
    curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
    $url_tiny = curl_exec ( $sesion );
    curl_close( $sesion );
    return(str_replace("\n","",$url_tiny));
    // configurar en http://bitly.com/a/account
}


function getCss($file)
{
    global $MyConfigure;
    global $MyFrankyMonster;
    if(file_exists(PROJECT_DIR."/public/skin/".$MyConfigure->getPathSite()."/css/".$file))
    {
        return "/public/skin/".$MyConfigure->getPathSite()."/css/".$file;
    }
    if(file_exists(PROJECT_DIR."/public/skin/".$MyFrankyMonster->MyModulo()."/css/".$file))
    {
        return "/public/skin/".$MyFrankyMonster->MyModulo()."/css/".$file;
    }
    else
    {
        return "/public/skin/default/css/".$file;
    }

}

function getImg($file)
{
    global $MyConfigure;
    global $MyFrankyMonster;
    if(file_exists(PROJECT_DIR."/public/skin/".$MyConfigure->getPathSite()."/images/".$file))
    {
        return "/public/skin/".$MyConfigure->getPathSite()."/images/".$file;
    }
    if(file_exists(PROJECT_DIR."/public/skin/".$MyFrankyMonster->MyModulo()."/images/".$file))
    {
        return "/public/skin/".$MyFrankyMonster->MyModulo()."/images/".$file;
    }
    else
    {
        return "/public/skin/default/images/".$file;
    }
}


function stripJS($html)
{
    $doc = new \DOMDocument();

    $doc->loadHTML(utf8_decode($html));
    $domxpath = new \DOMXPath($doc);
    $filtered = $domxpath->query("//script[not(@type)]");
    foreach ($filtered as $_p) {
        $_p->parentNode->removeChild($_p);
    }

    return preg_replace(array('/<!DOCTYPE.+?>/','/%7B%7B(.+?)%7D%7D/'), array('','{{$1}}'),
            str_replace( array('<html>', '</html>', '<body>', '</body>','<head>', '</head>'), array('', '', '', '','','',''), $doc->saveHTML())
            );
}

function getJSEmbebed($html)
{
    $js_embebed = "";
    $doc = new \DOMDocument();
    $doc->loadHTML(($html));
    $domxpath = new \DOMXPath($doc);
    $filtered = $domxpath->query("//script[not(@type)]");
    foreach ($filtered as $_p) {
        $js_embebed .= str_replace(array('<!--'),array(''),$_p->nodeValue."\n");
    }
    return $js_embebed;
}

function render($file_render, $variables = array())
{
    //global $MySession;
    $debug_enable = false;
    if(empty($variables))
    {
        extract($GLOBALS);


        if($MyDebug->DebugEnabled())
        {
            $debug_enable = true;
        }
    }
    else {
        extract($variables);
    }
    ob_start();

    if(!file_exists($file_render))
    {
        $file_render = getVista($file_render);
    }

    if($debug_enable){
        echo "<fieldset>"
        . "<legend> "
                . str_replace(PROJECT_DIR,"",$file_render)." <a href=\"#\" class=\"hide_render_debug\">[-]</a> <a href=\"#\" class=\"close_render_debug\">[X]</a></legend>"
                . "<div class='content_render_debug'>";
    }

    include $file_render;

    if($debug_enable){
        echo "</div>"
        . "</fieldset>";
    }
    return ob_get_clean();



}

function getVista($file,$type="server")
{
    global $MyConfigure;
    global $MyFrankyMonster;

    if($MyFrankyMonster->MyModulo() == "base")
    {
        if(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/diseno/".$file))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/diseno/".$file;
        }
        else
        {
            $url = "/modulos/base/diseno/".$file;
        }
    }
    else
    {

        if(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/".$MyFrankyMonster->MyModulo()."/diseno/".$file))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/".$MyFrankyMonster->MyModulo()."/diseno/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/".$MyFrankyMonster->MyModulo()."/diseno/".$file))
        {
            $url = "/modulos/".$MyFrankyMonster->MyModulo()."/diseno/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/diseno/".$file))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/diseno/".$file;
        }
        else
        {

            $url = "/modulos/base/diseno/".$file;
        }

    }

    return ($type == "server" ? PROJECT_DIR : "").$url;
}

function getController($file,$type="server")
{
    global $MyConfigure;
    global $MyFrankyMonster;

    if($MyFrankyMonster->MyModulo() == "base")
    {
        if(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/controller/".$file))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/controller/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/base/controller/".$file))
        {
            $url = "/modulos/base/controller/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/controller/common.php"))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/controller/common.php";
        }
        else
        {
            $url = "/modulos/base/controller/common.php";
        }
    }
    else
    {

        if(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/".$MyFrankyMonster->MyModulo()."/controller/".$file))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/".$MyFrankyMonster->MyModulo()."/controller/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/".$MyFrankyMonster->MyModulo()."/controller/".$file))
        {
             $url = "/modulos/".$MyFrankyMonster->MyModulo()."/controller/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/base/controller/".$file))
        {
            $url = "/modulos/base/controller/".$file;
        }
        elseif(file_exists(PROJECT_DIR."/modulos/".$MyConfigure->getPathSite()."/controller/common.php"))
        {
            $url = "/modulos/".$MyConfigure->getPathSite()."/controller/common.php";
        }
        else
        {
            $url = "/modulos/base/controller/common.php";
        }

    }

    return  ($type == "server" ? PROJECT_DIR : "").$url;
}

function sendEmail($campos,$data)
{


    global $MyConfigure;
    $plantilla = new \Franky\Core\Plantilla();
    $plantilla->asigna_variables($campos);
    $validaciones =  new \Franky\Core\validaciones();

    $ContenidoString = $plantilla->muestra($data['html']);


    if(preg_match("/\{([a-z0-9\-_]*?)\}/", $data["email_from"],$__cc))
    {
        if(!empty($campos[$__cc[1]]) && $validaciones->ValidaMail($campos[$__cc[1]]))
        {
            $data["email_from"] = $campos[$__cc[1]];
        }
    }
    if(preg_match("/\{([a-z0-9\-_]*?)\}/", $data['reply'],$__cc))
    {
        if(!empty($campos[$__cc[1]]) && $validaciones->ValidaMail($campos[$__cc[1]]))
        {
            $data['reply'] = $campos[$__cc[1]];
        }
    }
    if(preg_match("/\{([a-z0-9\-_]*?)\}/", $data['name_from'],$__cc))
    {
        $data['name_from'] = $campos[$__cc[1]];
    }

    $from = ["name_from" =>$data['name_from'],"email_from" => $data["email_from"]];

    $reply = $data['reply'];

    $finallybcc = [];
    $finallycc = [];

    $bcc = json_decode($data["bcc"],true);
    if(is_array($bcc) && count($bcc) > 0)
    {
        foreach($bcc as $_bcc)
        {
            $_bcc = trim($_bcc);
            if(preg_match("/\{([a-z0-9\-_]*?)\}/", $_bcc,$__bcc))
            {

                $_bcc = $campos[$__bcc[1]];
            }
            if(!empty($_bcc) && $validaciones->ValidaMail($_bcc))
            {
                $finallybcc[] = $_bcc;
            }
        }
    }
    $cc = json_decode($data["cc"],true);
    if(is_array($cc) && count($cc) > 0)
    {
        foreach($cc as $_cc)
        {
            $_cc = trim($_cc);
            if(preg_match("/\{([a-z0-9\-_]*?)\}/", $_cc,$__cc))
            {

                $_cc = $campos[$__cc[1]];
            }
            if(!empty($_cc) && $validaciones->ValidaMail($_cc))
            {
                $finallycc[] = $_cc;
            }
        }
    }
    $destinatario = "";
    $mails = json_decode($data["destinatario"],true);
    if(is_array($mails) && count($mails) > 0)
    {
       foreach($mails as $_mails)
       {
            $_mails = trim($_mails);
            if(preg_match("/\{([a-z0-9\-_]*?)\}/", $_mails,$__mails))
            {

                $_mails = $campos[$__mails[1]];
            }
            if(!empty($_mails) && $validaciones->ValidaMail($_mails))
            {
                $destinatario .="$_mails,";
            }
       }
       $destinatario = substr($destinatario,0,-1);
    }
    if(getCoreConfig('base/smtp/enabled')==1):
        $Correo = new \Base\model\Correo();
        return $Correo->Enviar(utf8_decode($data['Asunto']), $destinatario, $ContenidoString, $from,$reply,$bcc,$cc);
    endif;

    $Headers = "";
    $Headers .= 'MIME-Version: 1.0' . "\r\n";
    $Headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $Headers .= 'Reply-To: '.$reply. "\r\n" ;
    $Headers .= 'From: '.$from['name_from'].' <'.$from['email_from'].'>' . "\r\n";
    if(!empty($cc)):
        foreach($cc as $email_cc):
            if(!empty($email_cc)):
                $Headers .= 'Cc: '.$email_cc . "\r\n";
            endif;
        endforeach;
    endif;
    if(!empty($bcc)):
    foreach($bcc as $email_bcc):
        if(!empty($email_bcc)):
            $Headers .= 'Bcc: '.$email_bcc . "\r\n";
        endif;
    endforeach;
    endif;
    //echo $Headers;
    return mail($destinatario,$data['Asunto'],$ContenidoString, $Headers);
    
}

function getAvatar($id)
{

    if(!empty($id))
    {
      $AvataresModel = new \Base\model\AvataresModel();
      $AvataresEntity = new \Base\entity\AvataresEntity();
      $AvataresEntity->id_user($id);

      $AvataresEntity->status(1);
      if($AvataresModel->getData($AvataresEntity->getArrayCopy()) == REGISTRO_SUCCESS)
      {
          $registro = $AvataresModel->getRows();

          return $registro["url"];
      }
    }
    return  getImg("ico_avatar.jpg");
}

function limitePalabras($limit,$txt)
{
    $contador = 0;
    $_txt = '';

    if(!empty($txt) && strlen($txt) > $limit)
    {
        $arrayTexto = explode(' ',$txt);

        while($limit >= (strlen($_txt) + strlen($arrayTexto[$contador]))){
            $_txt .= ' '.$arrayTexto[$contador];
            $contador++;
        }


        return trim($_txt).'...';
    }

    return trim($txt);

}

function imageResize($img,$w,$h,$crop=false)
{
    if(substr($img,0,1) != "/"){ $img = "/".$img; }

    $array_archivo = explode("/",$img);

    $name = $array_archivo[count($array_archivo)-1];


    list($ancho, $alto, $tipo, $atributos) = getimagesize(PROJECT_DIR.$img);

    if($alto < $h || $ancho < $w)
    {
    //    return $img;
    }
    if (file_exists(PROJECT_DIR.$img))
    {
        if (!file_exists(PROJECT_DIR.str_replace($name,$w."x".$h."_".($crop ? "crop_" : "").$name,$img)))
        {



            $image = new Franky\Core\ImageResize(PROJECT_DIR.$img);
            if($crop)
            {
                $image->crop($w, $h);
            }
            else {
                $image->resizeToBestFit($w, $h);
            }

            $image->save(PROJECT_DIR.str_replace($name,$w."x".$h."_".($crop ? "crop_" : "").$name,$img));
        }
        return str_replace($name,$w."x".$h."_".($crop ? "crop_" : "").$name,$img);
    }

    return $img;
}



 function getModulos($orden = "ASC")
 {
        $MyConfigure = new \Franky\Core\configure;
        $_modulos =  include(PROJECT_DIR."/configure/modulos.php");
        $_modulos = array_merge(array("base"),$_modulos);
        $modulos = array($MyConfigure->getPathSite());

        if($orden == "ASC")
        {
            $modulos2 = array_merge($modulos,$_modulos);
        }
        else{
            $modulos2 = array_merge($_modulos,$modulos);
        }

        return  $modulos2;
 }

 function nl2p($txt)
 {

     $txt = nl2br($txt);
     $p = explode("<br />",$txt);
     $_txt = "";
     foreach($p as $_p)
     {
         $_txt .= "<p>".$_p."</p>\n";
     }

     return $_txt;

 }


function isMatchUrl($url_200)
{
    global $MyRequest;
    global $MyRequest;
    return (trim($url_200,"/") != trim($MyRequest->getRequest("my_url_friendly",""),"/"));
}


function breadcrumbs()
{
    global $MyRequest;
    global $MyFrankyMonster;
    global $MySession;
    $uri = parse_url($MyRequest->getURI());

    $uri = explode("/",trim($uri["path"],"/"));
    $link = "";
    $html = '<div class="w-xxxx-12 cont_breadcrumb">
                <div class="content">
		<ul class="breadcrumb">';
    $x = 0;

    if(count($uri) > 1)
    {
        foreach($uri as $path)
        {
            $link .= $path."/";

            $uiCommand =  $MyFrankyMonster->getUiCommand($MyFrankyMonster->getSeccion($link));

            if($uiCommand)
            {

                $permiso = true;
                if(is_array($uiCommand[0]) && count($uiCommand[0]) > 0)
            		{
                	if(!in_array($MySession->GetVar('nivel'),$uiCommand[0]) && $MySession->GetVar('nivel') != NIVEL_USERDEVELOPER )
            			{
            				$permiso = false;
            			}
            		}

                if($permiso)
                {

                    if($x == count($uri) - 1)
                    {
                        $html .= '<li class="nivel_'.($x+1).'">'.$uiCommand[8].'</li>';
                    }
                    else
                    {
                      $html .= '<li class="nivel_'.($x+1).'"><a href="'.$link.'" data-transition="back">'.$uiCommand[8].'</a></li>';
                    }
                }
            }
            $x++;
        }
    }

    $html .= '  </ul>
                </div>
        </div>';

    return trim($html," / ");
}


function getFechaUI($date)
{
    global $_Months;
    $p	= explode(" ",$date);
    $f = explode("-",$p[0]);
    return $fecha = $f[2]." ".$_Months[$f[1]]." ".$f[0]." ".(isset($p[1]) ?substr($p[1],0,-3)." Hrs." : '');
}


function selectPagina()
{

      $pagina = new \Base\model\paginasModel();

      $paginas = array();
      $pagina->setTampag(1000);
      $pagina->setOrdensql("nombre ASC");
      if($pagina->getData(1) == REGISTRO_SUCCESS)
      {
        while($registro = $pagina->getRows())
        {
                        $paginas[$registro['id']] = $registro['nombre']."(".$registro['url'].")";

        }
      }

return ($paginas);
}


function selectSeccionTransaccional()
{
      $SecciontransaccionalModel = new \Base\model\SecciontransaccionalModel();
      $SecciontransaccionalEntity = new \Base\entity\SecciontransaccionalEntity();

      $SecciontransaccionalEntity->status(1);
      $secciones = array();
      $SecciontransaccionalModel->setTampag(1000);
      $SecciontransaccionalModel->setOrdensql("nombre ASC");
      if($SecciontransaccionalModel->getData($SecciontransaccionalEntity->getArrayCopy()) == REGISTRO_SUCCESS)
      {
        while($registro = $SecciontransaccionalModel->getRows())
        {
            $secciones[$registro['id']] = $registro['nombre'];

        }
      }

      return $secciones;
}


function getNameDay($nombredia)
{
  global $_Days;
  return  $_Days[date('N', strtotime($nombredia))];
}

function CalculaEdad( $fecha ) {
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}


function getFormatoPrecio($number, $fractional=true,$simbol = true) {

    if(empty($number))
    {
      $number = 0;
    }
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    $number = explode(".",$number);
    return ($simbol ? '$ ' : '').$number[0].(isset($number[1]) ? '.<sup>'.$number[1].'</sup>': '').' MXN';
}


function getCoreConfig($path)
{

   $CoreConfig = new Base\model\CoreConfig();
   return $CoreConfig->getMapRender($path);
 }

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function validLoginUserDevice()
{
      global $MySession;
      global $MyRequest;
      $UserdeviceModel = new \Base\model\UserdeviceModel();
      $UserdeviceEntity = new \Base\entity\UserdeviceEntity();
      $Mobile_detect      = new \Mobile_Detect();

      $type= 'desktop';
      $os = 'desconocido';

      if($Mobile_detect->isMobile())
      {
        $type= 'mobile';
        if($Mobile_detect->isTablet())
        {
          $type= 'tablet';
        }
        if( $Mobile_detect->isiOS() )
        {
          $os = 'iOS';
        }

        if( $Mobile_detect->isAndroidOS() ){
          $os = 'Android';
        }
      }
      else {
        if(preg_match('/Linux/i',$Mobile_detect->getUserAgent())) $os = 'Linux';
        elseif(preg_match('/Mac/i',$Mobile_detect->getUserAgent())) $os = 'Mac';
        elseif(preg_match('/Unix/i',$Mobile_detect->getUserAgent())) $os = 'Unix';
        elseif(preg_match('/Windows/i',$Mobile_detect->getUserAgent())) $os = 'Windows';
      }

      $device_id =md5($Mobile_detect->getUserAgent());
      $UserdeviceEntity->id_user($MySession->GetVar('id'));
      $UserdeviceEntity->device_id($device_id);
      if($UserdeviceModel->getData($UserdeviceEntity->getArrayCopy()) == REGISTRO_SUCCESS)
      {
            $data_device = $UserdeviceModel->getRows();

            if($data_device['status'] == 0)
            {
                  $MySession->EndSession();
                  $MyRequest->redirect();
            }
            $UserdeviceEntity->access_last(date('Y-m-d H:i:s'));
            $UserdeviceEntity->ip($MyRequest->getIp());
            $UserdeviceEntity->id($data_device['id']);
            $UserdeviceModel->save($UserdeviceEntity->getArrayCopy());

      }
      else {

        $UserdeviceEntity->type($type);
        $UserdeviceEntity->os($os);
        $UserdeviceEntity->user_agent($Mobile_detect->getUserAgent());
        $UserdeviceEntity->create_at(date('Y-m-d H:i:s'));
        $UserdeviceEntity->status(1);
        $UserdeviceEntity->access_last(date('Y-m-d H:i:s'));
        $UserdeviceEntity->ip($MyRequest->getIp());
        $UserdeviceModel->save($UserdeviceEntity->getArrayCopy());
        //die;
        $campos = $UserdeviceEntity->getArrayCopy();
        $UserdeviceEntity->exchangeArray([]);
        $UserdeviceEntity->id_user($MySession->GetVar('id'));
        if($UserdeviceModel->getData($UserdeviceEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            if($UserdeviceModel->getTotal() > 1)
            {
                $TemplateemailModel    = new \Base\model\TemplateemailModel;
                $SecciontransaccionalEntity    = new \Base\entity\SecciontransaccionalEntity;
                $SecciontransaccionalEntity->friendly('nuevo-dispositivo');
                $TemplateemailModel->setOrdensql('id DESC');
                $TemplateemailModel->getData([],$SecciontransaccionalEntity->getArrayCopy());


                $campos['email'] = $MySession->GetVar('email');
                $campos['nombre'] = $MySession->GetVar('nombre');
                $registro  = $TemplateemailModel->getRows();

                sendEmail($campos,$registro);
            }

        }

      }

}


function validUserDevice()
{
      global $MySession;
      global $MyRequest;
      $UserdeviceModel = new \Base\model\UserdeviceModel();
      $UserdeviceEntity = new \Base\entity\UserdeviceEntity();
      $Mobile_detect      = new \Mobile_Detect();


      $device_id =md5($Mobile_detect->getUserAgent());

      $UserdeviceEntity->id_user($MySession->GetVar('id'));
      $UserdeviceEntity->device_id($device_id);
      $UserdeviceEntity->status(1);
      if($UserdeviceModel->getData($UserdeviceEntity->getArrayCopy()) != REGISTRO_SUCCESS)
      {
          $MySession->EndSession();
          $MyRequest->redirect();
      }
}

function getDataCustomAttribute($id_ref,$entity)
{
    $CustomattributesModel              = new Base\model\CustomattributesModel();
    $CustomattributesEntity             = new Base\entity\CustomattributesEntity();
    $CustomattributesvaluesModel        = new Base\model\CustomattributesvaluesModel();
    $CustomattributesvaluesEntity       = new Base\entity\CustomattributesvaluesEntity();


    $custom_imputs = [];
    $values_attrs = [];
    $CustomattributesEntity->entity($entity);
    $CustomattributesEntity->status(1);
    $CustomattributesModel->setTampag(100);
    $CustomattributesModel->getData($CustomattributesEntity->getArrayCopy());

    if($CustomattributesModel->getTotal() > 0)
    {
        while($data_attrs = $CustomattributesModel->getRows()){
            
            
            $data_attrs['data'] = json_decode($data_attrs['data'],true);


            if(!empty($data_attrs['source'])){
                $objData = new $data_attrs['source'];
                $data_attrs['data'] = $objData->getCollection();
            }

            $custom_imputs[$data_attrs['id']] = $data_attrs;

        }
    

        $CustomattributesvaluesEntity->id_ref($id_ref);
        $CustomattributesvaluesEntity->entity($entity);
        $CustomattributesvaluesModel->setTampag(100);
        if($CustomattributesvaluesModel->getData($CustomattributesvaluesEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            
            
            while($_values_attrs = $CustomattributesvaluesModel->getRows()){
            
                $value =json_decode($_values_attrs['value'],true);
        
                if($value == null)
                {
                    $value = $_values_attrs['value'];
                }
                $values_attrs[$custom_imputs[$_values_attrs['id_attribute']]['name']] = $value;
            
            }
            
        }
    }

    return ['custom_imputs' => $custom_imputs,'custom_values'=>$values_attrs];


}

function saveDataCustomAttribute($id_ref,$entity)
{
    global $MyRequest;
    global $MyConfigure;
    $File                               = new Franky\Filesystem\File();
    $CustomattributesModel              = new Base\model\CustomattributesModel();
    $CustomattributesEntity             = new Base\entity\CustomattributesEntity();
    $CustomattributesvaluesModel        = new Base\model\CustomattributesvaluesModel();
    $CustomattributesvaluesEntity       = new Base\entity\CustomattributesvaluesEntity();

    $custom_imputs = [];
    $CustomattributesEntity->entity("catalog_products");
    $CustomattributesEntity->status(1);
    $CustomattributesModel->setTampag(100);
    $CustomattributesModel->getData($CustomattributesEntity->getArrayCopy());
    while($data_attrs = $CustomattributesModel->getRows()){
        
        $custom_imputs[] = ['id' => $data_attrs['id'],'name' => $data_attrs['name'],'type' => $data_attrs['type']];
    }

   
//print_r($custom_imputs);
//print_r($MyRequest->getRequest());
//die;
    foreach($custom_imputs as $input)
    {
        
        $name = str_replace("[]", "", $input['name']);
        if($input['type'] == 'file')
        {
           
            $dir = $MyConfigure->getServerUploadDir()."/$entity/".$id_ref."/";
          
            $File->mkdir($dir);
            $handle = new \Franky\Filesystem\Upload($_FILES[$input['name']]);
            if ($handle->uploaded)
            {
                if  (!in_array(strtolower(pathinfo($_FILES[$input['name']]["name"], PATHINFO_EXTENSION)),array("php","phtml")))
                {
                    $fileinfo = @getimagesize($_FILES[$input['name']]["tmp_name"]);
                    //$width = $fileinfo[0];
                    //$height = $fileinfo[1];
                    
                    //$handle->image_resize= false;
                    //$handle->image_ratio_fill = true;
                    //$handle->image_background_color = '#FFFFFF';
                    $handle->file_auto_rename = true;
                    $handle->file_overwrite = false;
                    $handle->file_max_size = "22024288"; 

                    $handle->Process($dir);

                    if ($handle->processed)
                    {
                        $value = "/$entity/".$id_ref."/".$handle->file_dst_name;
                    }
                    else
                    {
                        continue;
                    }
                }else
                {
                    continue;
                }
                
            }
            else{
                if($MyRequest->getRequest('file__'.$input['name'],0) == 1){
                    continue;
                }
                else{
                    $value = "";
                }

                
            }
            

        }
        else if($input['type'] == 'multifile')
        {
           
            $multifiles = $MyRequest->getRequest('file__'.$name,[]);

            $dir = $MyConfigure->getServerUploadDir()."/$entity/".$id_ref."/";
          
            $File->mkdir($dir);

            $files = array();
           // print_r($_FILES);
            foreach ($_FILES[$name] as $k => $l) {
           
                foreach ($l as $i => $v) {
                    
                    $files[$i][$k] = $v;
                }
            }
   
           //print_r($files);
           //die;

            foreach ($files as $file)
            {
              
                $handle = new \Franky\Filesystem\Upload($file);
                if ($handle->uploaded)
                {
                    if  (!in_array(strtolower(pathinfo($file["name"], PATHINFO_EXTENSION)),array("php","phtml")))
                    {
                        $fileinfo = @getimagesize($file["tmp_name"]);
                        //$width = $fileinfo[0];
                        //$height = $fileinfo[1];
                        
                        //$handle->image_resize= false;
                        //$handle->image_ratio_fill = true;
                        //$handle->image_background_color = '#FFFFFF';
                        $handle->file_auto_rename = true;
                        $handle->file_overwrite = false;
                        $handle->file_max_size = "22024288"; 

                        $handle->Process($dir);

                        if ($handle->processed)
                        {
                            $multifiles[] = "/$entity/".$id_ref."/".$handle->file_dst_name;
                        }
                        else
                        {
                            continue;
                        }
                    }else
                    {
                        continue;
                    }
                    
                }
            }
            $value = json_encode($multifiles);
            
            
        }
        else{
            $value = (is_array($MyRequest->getRequest($name)) ? json_encode($MyRequest->getRequest($name)) : $MyRequest->getRequest($name,'',true));
        }
        $CustomattributesvaluesEntity->exchangeArray([]);
        $CustomattributesvaluesEntity->id_attribute($input['id']);
        $CustomattributesvaluesEntity->id_ref($id_ref);
        $CustomattributesvaluesEntity->entity($entity);
        $CustomattributesvaluesModel->remove($CustomattributesvaluesEntity->getArrayCopy());


        $CustomattributesvaluesEntity->value($value);
        $CustomattributesvaluesModel->save($CustomattributesvaluesEntity->getArrayCopy());


    }
    
}
?>
