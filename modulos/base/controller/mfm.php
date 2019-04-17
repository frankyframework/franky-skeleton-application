<?php
use Base\model\mfm;
use Franky\Filesystem\File;

if (!$MyAccessList->MeDasChancePasar(ADMINISTRAR_UPLOADERS)) {  die('No autorizado'); }

$pwd = str_replace("..","",trim($MyRequest->getRequest("pwd")));

if(empty($pwd))
{
    $pwd = 'default';
}


$File = new File();
$File->mkdir($MyConfigure->getServerUploadDir()."/".$pwd."/");

$file_root = "/".trim($MyConfigure->getUploadDir(),"/").'/'.$pwd.'/';

$root_path = $MyRequest->getPROTOCOLO().$MyRequest->getSERVER().'/';
$thmb_size = 100;

header("Content-type: text/html; charset=utf-8");

//stand alone or tynimce?
$mode = $MyRequest->getRequest('mode',"alone");


$mfm = new mfm($root_path);

$field = $MyRequest->getRequest('field');



if(isset($_FILES['new_file']) && $MyRequest->getRequest('return') != "") {
    if(is_dir(PROJECT_DIR.$MyRequest->getRequest('return'))) {
        $handle = new \Franky\Filesystem\Upload($_FILES['new_file']);
        if ($handle->uploaded) {
            $handle->file_new_name_body   = $mfm->format_filename(substr($_FILES['new_file']['name'],0,-4));
            //resize image. more options coming soon.
            if($MyRequest->getRequest('new_resize')  > 0) {
                $handle->image_resize         = true;
                $handle->image_x              = (int)$MyRequest->getRequest('new_resize');
                $handle->image_ratio_y        = true;
            }
            $handle->process(PROJECT_DIR.$MyRequest->getRequest('return'). '/');
            if ($handle->processed) {
                $handle->clean();
            } else {
		//uncomment for debugging
                //echo 'error : ' . $handle->error;
            }
        }
    }
}


if($MyRequest->getRequest('viewdir') != "")
{
    if($MyRequest->getRequest('newdir') != "") {
        $mfm->newdir($MyRequest->getRequest('newdir'),$MyRequest->getRequest('viewdir'));
    }
    if($MyRequest->getRequest('deletefile') != "") {
        echo $mfm->delete($MyRequest->getRequest('viewdir'),$MyRequest->getRequest('deletefile'));
    }

    echo $mfm->viewdir($MyRequest->getRequest('viewdir'),$field,$pwd);

    echo $mfm->print_files($MyRequest->getRequest('viewdir') );


    exit(0);
}


if($MyRequest->getRequest('viewtree') != "")
{
    echo $mfm->viewtree($field,$file_root,$pwd);

    exit(0);
}


$print_tree = $mfm->print_tree($file_root,$field,$pwd);

if(isset($_REQUEST['return'])) {
        $return = $_REQUEST['return'];
} else {
        $return = $file_root;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="es" />
    <title><?php echo _("Administrador de archivos"); ?></title>
    <link rel="stylesheet" href="/public/plugins/tinymce/mfm/style.css" type="text/css" />
    <script  src="/public/jquery/jquery-2.2.2.min.js"></script>
    <script  src="/public/plugins/tinymce/tinymce.min.js"></script>


    <script >
        //<![CDATA[

        //load content using asynchronous HTML and HTTP
  	function load(query,targer) {

            $("#"+targer).html('<img src="/public/plugins/tinymce/mfm/loading.gif" alt="" /> <?php echo _("cargando"); ?>');

            $.ajax({
                type: "GET",
                url: "/mfm.php",
                data: query,
                cache: false,
                success: function(response){

                    $("#"+targer).html(response);
                },
                error: function(){ alert("Error de peticion AJAX"); }
            });

	}



        function create_folder(viewdir)
        {
            var name=prompt("<?php echo _("Crear carpeta"); ?>","<?php echo _("Nueva carpeta"); ?>");
            if (name!=null && name!=""){
                load('viewdir=' + viewdir + '&newdir=' + name+'&pwd=<?php echo $pwd; ?>&field=<?php echo $field; ?>','');
            }
        }


        function submit_url(URL) {
          $('#<?php echo $field; ?>',opener.document).val(URL);
          self.close();
        }


        //confirm and delete file
        function delete_file(dir,file) {
            var answer = confirm("<?php echo _("Estas seguro de realizar esta accion"); ?>");
            if (answer){
                load('viewdir=' + dir + '&deletefile=' + file+'&pwd=<?php echo $pwd; ?>&field=<?php echo $field; ?>','view-files');
            }
        }
        //]]>
    </script>
</head>

<?php $return = $MyRequest->getRequest('return',$file_root) ; ?>
<body onLoad="load('viewdir=<?php echo $return; ?>&pwd=<?php echo $pwd; ?>&field=<?php echo $field; ?>','view-files');">
    <div id="browser-wrapper">
        <div id="view-tree">
            <ul class="dirlist">
                <li>
                    <a href="<?php echo $root_path . '/' . $file_root; ?>/" onClick="load('viewdir=<?php echo $file_root; ?>&pwd=<?php echo $pwd; ?>&field=<?php echo $field; ?>','view-files'); return false;">
                        <?php echo $file_root; ?>
                    </a>
                    <a href="#" title="<?php echo _("Recargar directorio"); ?>" onClick="load('viewtree=true&pwd=<?php echo $pwd; ?>&field=<?php echo $field; ?>','view-tree'); return false;" id="refresh-tree">
                        <?php echo _("Recargar"); ?>
                    </a>
                    <?php echo $print_tree; ?>
                </li>
            </ul>
        </div>
        <div id="view-files"></div>
    </div>
</body>
</html>
