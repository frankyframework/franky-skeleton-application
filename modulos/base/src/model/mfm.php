<?php
namespace Base\model;

class mfm{
    
    private $rootPath;
    private $thmb_size;
    public function __construct($rootpath){
    
        $this->rootPath=$rootpath;
        $this->thmb_size = 100;
      
    }
    
    public function viewdir($viewdir,$field,$pwd)
    {
        $html = '
        <ul id="browser-toolbar">
            <li class="file-new"><a href="#" title="Cargar Archivo" onClick="$(\'#load-file\').slideToggle(); return false;">'._("Agregar Archivo").'</a></li>
            <li class="folder-new"><a href="#" title="Crear directorio" onClick="create_folder(\''.$viewdir.'\'); return false;">'._("Crear Directorio").'</a></li>
            <li class="file-refresh"><a href="#" title="Recargar archivos" onClick="load(\'viewdir='.$viewdir.'&field='.$field.'\',\'view-files\'); return false;">'._("Recargar").'</a></li>
        </ul>
        <form style="display: none;" id="load-file" class="load-file" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>'._("Cargar Archivo").'</legend>
            <input type="hidden" value="'.$viewdir.'" name="return" />
            <input type="hidden" value="'.$field.'" name="field" />
                <input type="hidden" value="'.$pwd.'" name="pwd" />
            <label>'._("Archivo").'<input type="file" name="new_file" /></label>
            <label>'._("Cambiar ancho de la imagen").'<input type="text" class="number" name="new_resize" value="0" /></label>
            <input type="submit" id="insert" value="Guardar" />
            </fieldset>
        </form>
        ';
        return $html;
	
    }
  
    public function newdir($newdir,$viewdir)
    {
        $new_title = $this->format_filename($newdir);
        if(!is_dir(PROJECT_DIR.$viewdir . '/' . $new_title)) {
            if(mkdir(PROJECT_DIR.$viewdir . '/' . $new_title, 0777)) {
                    echo '<p class="successful">&quot;' . $new_title . '&quot;' . _("Carpeta creada") . '</p>';
            } else {
                    echo '<p class="failed">' . _("No se puede crear la carpeta") . '&quot;' . $new_title . '&quot;!<br />' . _("Revisar permisos de escritura") . '</p>';
            }
        } else {
            echo '<p class="failed">' . _("No se puede crear la carpeta") . '&quot;' . $new_title . '&quot;!<br />' . _("La carpeta ya existe") . '</p>';
        }
    }
    public function print_tree($dir = '.',$field="",$pwd="")
    {
       
        $html =  "";
	$dir_array = array(); 
        $ruta_completa = array();
	$handle = opendir(PROJECT_DIR.$dir);  
	while($nombre = readdir($handle)) { 	
		if(strpos($nombre, '.') === 0) continue;	
		$ruta_completa[] =  $nombre; 
	}	  
	closedir($handle);
	usort($ruta_completa, 'strnatcasecmp');
	$html .= '<ul class="dirlist">';
        if(count($ruta_completa) > 0)
        {
            foreach($ruta_completa as $v)
            {  
                //echo $_SERVER["DOCUMENT_ROOT"].$dir.$v."<br />";
		if(is_dir(PROJECT_DIR.$dir.$v)) {
                   
                    $html .= '<li>';
                    $html .= '<a href="'.$dir."/".$v . '/" onclick="load(\'viewdir=' . $dir.$v . '&pwd='.$pwd.'&field='.$field.'\',\'view-files\'); return false;">' .$v . '</a>';
                    $html .= $this->print_tree($dir.$v."/",$field,$pwd);
                    $html .= '</li>';
                        
		}
            }
        }
	$html .= '</ul>';
         
        return $html;
    }
    
    
    public function print_files($c = '.') {
    
        $html = "";
        
        $html .= '<table id="file-list">';
        $d = opendir(PROJECT_DIR.$c);
        $i = 0;
        while($f = readdir($d)) {
            if(strpos($f, '.') === 0) continue;
            $ff = $c . '/' . $f; //   $ff = $c . '/' . $f;
            if(!is_dir(PROJECT_DIR.$ff)) {
                $html .=  '<tr' . ($i%2 ? ' class="light"' : ' class="dark"') .'>';
                //show preview and different icon, if file is image
                if($imageinfo = @getimagesize(PROJECT_DIR.$ff)) {
                    $resize = '';
                    if($imageinfo[0] > $this->thmb_size or $imageinfo[1] > $this->thmb_size) {
                        if($imageinfo[0] > $imageinfo[1]) {
                            $resize = ' style="width: ' . $this->thmb_size . 'px;"';
                        } else {
                            $resize = ' style="height: ' . $this->thmb_size . 'px;"';
                        }
                    }
                    if ($imageinfo[2] == 1) {
                        $imagetype = "image_gif";
                    } elseif ($imageinfo[2] == 2) {
                        $imagetype = "image_jpg";
                    } else {
                       $imagetype = "image";		
                    }
                    $html .=  '<td><a class="thumbnail ' . $imagetype . '" href="#" onclick="submit_url(\'' . $this->rootPath . '' . $ff . '\');">' . $f . '<span><img' . $resize . ' src="' . $this->rootPath . '/' . $ff . '" /></span></a>'; 
                    $html .=  '</td>';
                    //all other files
                } else {
                    $html .=  '<td><a class="unknown" href="#" onclick="submit_url(\'' . $this->rootPath . '' . $ff . '\');">' . $f . '</a>'; 
                    $html .=  '</td>';
                }
                $html .=  '<td>' . $this->byte_convert(filesize(PROJECT_DIR.$ff)) . '</td>';
                $html .=  '<td class="delete"><a href="#" title="' . _("Eliminar archivo") . '" onclick="delete_file(\'' . $c . '\',\'' . $f . '\');">' . _("Eliminar"). '</a></td>';
                $html .=  '</tr>';
                $i++;
            }
        }
        $html .= '</table>';
        return $html;
    }

    public function viewtree($field,$file_root,$pwd)
    {
        $html = '<ul class="dirlist">'
        .'<li><a href="'.$this->rootPath.'/'.$file_root.'" onClick="load(\'viewdir='.$file_root.'&pwd='.$pwd.'&field='.$field.'\',\'view-files\'); return false;">'.$file_root.'</a> <a href="#" onClick="load(\'viewtree=true&pwd='.$pwd.'&field='.$field.'\',\'view-tree\'); return false;" id="refresh-tree">Recargar</a>';
        $html .= $this->print_tree($file_root);
        $html .= '</li></ul>';
        return $html;
    }
    
    
    public function delete($viewdir,$deletefile)
    {
        if(!file_exists(PROJECT_DIR.$viewdir. '/' . $deletefile )) {
                $html = '<p class="failed">' . _("El archivo no existe"). '</p>';
        } else {
            if(unlink(PROJECT_DIR.$viewdir . '/' .$deletefile )) {
                    $html = '<p class="successful">' . _("Archivo eliminado") . '</p>';
            } else {
                    $html = '<p class="failed">' . _("No se puede eliminar el archivo") . '</p>';
            }
        }
	
	return $html;
    }
    
    private function byte_convert($bytes) {
        $symbol = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        $exp = 0;
        $converted_value = 0;
        if( $bytes > 0 ) {
            $exp = floor( log($bytes)/log(1024) );
            $converted_value = ( $bytes/pow(1024,floor($exp)) );
        }
        return sprintf( '%.2f '.$symbol[$exp], $converted_value );
    }
    
    public function format_filename($filename) {
	$bads = array(' ','ā','č','ē','ģ','ī','ķ','ļ','ņ','ŗ','š','ū','ž','Ā','Č','Ē','Ģ','Ī','Ķ','Ļ','Ņ','Ŗ','Š','Ū','Ž','$','&','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','ЫЬ','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','шщ','ъ','ы','ь','э','ю','я');
	$good = array('-','a','c','e','g','i','k','l','n','r','s','u','z','A','C','E','G','I','K','L','N','R','S','U','Z','s','and','A','B','V','G','D','E','J','Z','Z','I','J','K','L','M','N','O','P','R','S','T','U','F','H','C','C','S','S','T','T','E','Ju','Ja','a','b','v','g','d','e','e','z','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','c','s','t','t','y','z','e','ju','ja');
	$filename = str_replace($bads,$good,trim($filename));
	$allowed = "/[^a-z0-9\\.\\-\\_\\\\]/i";
	$filename = preg_replace($allowed,'',$filename);
	return $filename;
    }
}
?>