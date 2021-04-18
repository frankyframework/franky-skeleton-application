<?php
use Blog\model\Blog;
use Blog\schema\blogPostingSchema;
use Franky\Schema\aggregateRatingSchema;
use Franky\Schema\personSchema;
use Base\model\USERS;
use Blog\Form\buscadorForm;

$MyBuscadorBlog = new buscadorForm('buscadorblog');
$MyBuscadorBlog->setAtributo("action", $MyRequest->url(BLOG));

$MyUser             = new USERS();
$MyBlog = new Blog();

$schema = new blogPostingSchema();
$ratingSchema =  new aggregateRatingSchema();
$personSchema =  new personSchema();

$amigable_context =  $MyRequest->getUrlParam("articulo");;
$amigable_categoria_context =  $MyRequest->getUrlParam("categoria");;

$MyBlog->setNivel($MySession->GetVar('nivel'));
if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $MyBlog->setLang($_SESSION['lang'] );
}

$MyBlog->getData($amigable_context, "","","",1);
$total			= $MyBlog->getTotal();

$blog_detalle = array();

if($total > 0)
{
	$iRow = 0;
	$registro = $MyBlog->getRows();


        $url_200 = $MyRequest->url(BLOG_DETALLE,array("categoria"=>$registro["amigable_categoria"], "articulo" => $registro["friendly"]));
        if(isMatchUrl($url_200))
        {
            $MyRequest->redirect($MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" => $registro["friendly"])),"301");
        }


        $fecham = "";
        if(!empty($registro["fecha_modificado"]) && $registro["fecha_modificado"] != "0000-00-00 00:00:00"):
            $fecham = getFechaUI($registro["fecha_modificado"]);
					endif;



        $blog_detalle = array(
        "id"                => $registro["id"],
        "titulo"            => $registro["titulo"],
        "autor"             => $registro["nombre_user"],
        "autortext"             => $registro["autortext"],
        "id_user"             => $registro["id_user"],
        "contenido"         => $registro["contenido"],
        "destacado"         => $registro["destacado"],
        "permitircomentarios"       => $registro["comentarios"],
        "fecha"             => getFechaUI($registro["fecha"]),
        "fecha_original"             => $registro["fecha"],
        "fecha_modificado"  => $fecham,
        "friendly"          => $registro["friendly"],
        "keywords"          => $registro["keywords"],
        "bio"          => $registro["biografia"],
        "visible_in_search"          => $registro["visible_in_search"],
        "permisos"  => json_decode($registro["permisos"],true),
        "meta_titulo"                => $registro["meta_titulo"],
        "meta_descripcion"                => $registro["meta_descripcion"]
        );

        if(!empty($registro["imagen_portada"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$registro["id"]."/".$registro["imagen_portada"]))
        {
            $img = imageResize($MyConfigure->getUploadDir()."/blog/".$registro["id"]."/".$registro["imagen_portada"],1500,750, true);
            $blog_detalle["imagen_portada"] = $img;

        }
        /*
        else {
            preg_match_all("/<img[^>]*"."src=[\"|\'](.*)[\"|\']/Ui", $registro["contenido"], $imagenes);
            $blog_detalle["imagen_portada"] = (!empty($imagenes[1]) ? $imagenes[1]: '');

            if(is_array($blog_detalle["imagen_portada"])){
                $blog_detalle["imagen_portada"] = $blog_detalle["imagen_portada"][0];
            }
        }

        */

        $ratingSchema->setBestRating("5");
       // $ratingSchema->setRatingValue($blog_detalle["cal"]);
       // $ratingSchema->setReviewCount($blog_detalle["t_cal"]);
        $personSchema->setName($registro["usuario"]);

        $schema->setHeadline($registro["titulo"]);
        $schema->setKeywords($registro["keywords"]);
        $schema->setDatePublished($registro["fecha"]);
        $schema->setImage($MyRequest->link($blog_detalle["imagen_portada"],false,true));
        $schema->setArticleSection($registro["categoria_nombre"]);
        $schema->setAggregateRating(json_decode($ratingSchema->get(false),true));
        $schema->setDateModified((empty($fecham) ? $registro["fecha"] : $registro["fecha_modificado"]));

        $MyMetatag->setTitulo($registro["meta_titulo"]);
        $MyMetatag->setDescripcion($registro["meta_descripcion"]);
        $MyMetatag->setKeywords($registro["keywords"]);
        $MyMetatag->setJs("/public/plugins/calificacion/rating.js");
        $MyMetatag->setCss("/public/plugins/calificacion/rating.css");
        $MyMetatag->setImage($MyRequest->link($blog_detalle["imagen_portada"],false,true));
        $schema->setAuthor(json_decode($personSchema->get(false),true));

        $blog_detalle['url'] = $MyRequest->url(BLOG_DETALLE,['categoria' => $blog_detalle['categoria_friendly'],'articulo' => $blog_detalle['friendly']],true);
        $blog_detalle["thumb_resize"] = $MyRequest->link($blog_detalle["imagen_portada"],false,true);
       
        $MyMetatag->setVars($blog_detalle);


        /*
        if($MyUserSocial->findSocial("", "google", $registro["autor"]) == REGISTRO_SUCCESS):
            $_registro = $MyUserSocial->getRows();
            $blog_detalle["m_info_google"] = json_decode($_registro["info"],true);
            $MyMetatag->setAuthor($blog_detalle["m_info_google"]['link']);

            $personSchema->setUrl($blog_detalle["m_info_google"]['link']);

            $schema->setAuthor(json_decode($personSchema->get(false),true));
        endif;
        */


        $blog_detalle["miavatar"] = getAvatar(0);

        if($MySession->LoggedIn()):
            $blog_detalle["miavatar"] = getAvatar($MySession->GetVar('id'));
            $social_data = $MySession->GetVar('social');

        endif;
       

    if(!empty($blog_detalle["permisos"]) && !$MySession->LoggedIn())
    {
        $MyRequest->redirect($MyRequest->Url(LOGIN).'?callback='.urlencode($MyRequest->url(BLOG_DETALLE,array("categoria" => $amigable_categoria_context,"articulo" =>$amigable_context))));
    }
    if(!empty($blog_detalle['permisos']) && !in_array($MySession->GetVar('nivel'),$blog_detalle['permisos']))
    {
        $MyRequest->redirect();
    }
}
else{
    $MyRequest->redirect($MyRequest->url(BLOG_CATEGORIA,array("categoria" => $amigable_categoria_context)),"301");
}

$MyMetatag->setJs("/public/plugins/codesample/prism.js");
$MyMetatag->setCss('/public/plugins/codesample/prism.css');
?>
