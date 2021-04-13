<?php
use Blog\Form\articulosBlogForm;
use Blog\model\Blog;
use Blog\model\BorradorblogModel;
use Blog\entity\BorradorblogEntity;
use Franky\Haxor\Tokenizer;


$Tokenizer = new Tokenizer();
$MyBlog = new Blog();
$BorradorblogModel = new BorradorblogModel();
$BorradorblogEntity = new BorradorblogEntity();
$MyBlog->setIsAdmin(1);
$borrador   = $MyRequest->getRequest('borrador');
$id         = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback   = $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();
$data["contenido"]    = $MyFlashMessage->getResponse('contenido',"",true);
$path_img_blog = 'temp/'.md5(time());

$title_form = "Nuevo articulos del BLOG";
$img ="";
if(!empty($id))
{


    $title_form = "Editar articulos del BLOG";
    $MyBlog->setIsAdmin(1);
    $result	 = $MyBlog->getData($id);

    $data           = $MyBlog->getRows();

    if(!empty($data["imagen_portada"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$data["id"]."/".$data["imagen_portada"]))
    {
        $img = imageResize($MyConfigure->getUploadDir()."/blog/".$data["id"]."/".$data["imagen_portada"],1500,750, true);
        $data["imagen_portada"] = $img;

    }else{
         $data["imagen_portada"] = "";
    }
    $data['permisos'] = json_decode($data['permisos'],true);
    $data['id'] = $Tokenizer->token('articulo_blog', $data['id']);;



    if(!empty($borrador))
    {
        $title_form = "Borrador articulos del BLOG";

        $BorradorblogEntity->id_blog($id);

        if($BorradorblogModel->getData($BorradorblogEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            $data       = $BorradorblogModel->getRows();
            $data['data'] = str_replace(["\n","\r"],"",$data['data']);
            $data = json_decode($data['data'],true);
            
            $data['titulo'] = htmlentities($data['titulo']);
            $data['autortext'] = htmlentities($data['autortext']);
            $data['autortext'] = htmlentities($data['autortext']);
            $data['meta_titulo'] = htmlentities($data['meta_titulo']);
            $data['meta_descripcion'] = htmlentities($data['meta_descripcion']);
            
            $data['data_img'] = htmlentities(json_encode(['imagen' => $data['imagen'],'imagen_portada' => $data['imagen_portada']]));

            if(!empty($data["imagen_portada"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$data["id"]."/".$data["imagen_portada"]))
            {
                $img = imageResize($MyConfigure->getUploadDir()."/blog/".$data["id"]."/".$data["imagen_portada"],1500,750, true);
                $data["imagen_portada"] = $img;

            }else{
                 $data["imagen_portada"] = $img;
            }
            $data['permisos'] = json_decode($data['permisos'],true);
           $data['id'] = $Tokenizer->token('articulo_blog', $data['id']);;
        }
    }
    $path_img_blog = $id;
}
$MySession->SetVar('path_img_blog',$path_img_blog);
$adminForm = new articulosBlogForm("frmarticulosblog");
$adminForm->setOptionsInput("categoria", makeHTMLCategoriasBlog("sql"));
$adminForm->setOptionsInput("permisos[]", $_Niveles_usuarios);

if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $idiomas_disponibles = getCoreConfig('base/theme/langs');
    $idiomas = array();
    foreach($idiomas_disponibles as $idioma)
    {
        $idiomas[$idioma] = $idioma;
    }
    $adminForm->addLang();
    $adminForm->setOptionsInput("lang", $idiomas);

}


$adminForm->setData($data);
$adminForm->setAtributoInput("contenido","value", ($data['contenido']));
$adminForm->setAtributoInput("callback","value", $callback);
$adminForm->setAtributoInput("borrador","value", $borrador);



$MyMetatag->setCode("<script  src='/public/plugins/tinymce/tinymce.min.js'></script>");
