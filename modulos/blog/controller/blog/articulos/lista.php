<?php
use Blog\model\Blog;
use Blog\model\categoriasBlog;
use Franky\Core\paginacion;
use Blog\Form\buscadorForm;

$MyPaginacion = new paginacion();

$MyBlog = new Blog();
$MyCategoriaBlog = new categoriasBlog();
$amigable_categoria_context =  $MyRequest->getUrlParam("categoria");;


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"blog.destacado DESC, blog.fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');
$autor_b = $MyRequest->getRequest('autor_b');
$destacado_b = $MyRequest->getRequest('destacado_b');


$MyBlog->setPage($MyPaginacion->getPage());
$MyBlog->setTampag($MyPaginacion->getTampageDefault());
$MyBlog->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

if(empty($amigable_categoria_context))
{
    $MyBlog->isVisibleInSearch(1);
}


$MyBlog->setNivel($MySession->GetVar('nivel'));
if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $MyBlog->setLang($_SESSION['lang'] );
}
$result	 = $MyBlog->getData( '', $busca_b,$autor_b,$destacado_b,1,$amigable_categoria_context);


$MyPaginacion->setTotal($MyBlog->getTotal());

$MyBuscadorBlog = new buscadorForm('buscadorblog');
$MyBuscadorBlog->setAtributo("action", $MyRequest->url(BLOG));

if($MyBlog->getTotal() > 0)
{
	$iRow = 0;

	while($registro = $MyBlog->getRows())
	{


                $lista_articulos_blog[$iRow] = array(
                    "id"		=> $registro["id"],
                    "titulo"		=> $registro["titulo"],
                    "categoria"		=> $registro["categoria_nombre"],
                    "contenido"		=>  previewBlog($registro["contenido"]),
                    "autor"		=> $registro["usuario"],
                    "status"    	=> $registro["status"],
                    "friendly_categoria"=> $registro["amigable_categoria"],
                    "friendly"          => $registro["friendly"],
                    "autortext"          => $registro["autortext"],
                    "destacado"          => $registro["destacado"],
                    "fecha"             => getFechaUI($registro["fecha"]),
                    "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]))

                );
                if($registro['destacado'] == 1)
                {
                    if(!empty($registro["imagen_portada"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$registro["id"]."/".$registro["imagen_portada"]))
                    {
                        $img = imageResize($MyConfigure->getUploadDir()."/blog/".$registro["id"]."/".$registro["imagen_portada"],1500,750, true);
                        $lista_articulos_blog[$iRow]['contenido']["img"] = $img;
                    }
                }
                else
                {
                    if(!empty($registro["imagen"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"]))
                    {
                        $img = imageResize($MyConfigure->getUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"],400,400, true);
                        $lista_articulos_blog[$iRow]['contenido']["img"] = $img;
                    }
                }


                $iRow++;

        }


}

if(!empty($amigable_categoria_context))
{
    if(getCoreConfig('blog/idioma/multi-idioma') == 1)
    {
        $MyCategoriaBlog->setLang($_SESSION['lang'] );
    }
    if($MyCategoriaBlog->getData($amigable_categoria_context)==REGISTRO_SUCCESS)
    {
        $registro = $MyCategoriaBlog->getRows();

        $registro['url'] = $MyRequest->url(BLOG_CATEGORIA,['categoria' => $registro['friendly']],true);
        $MyMetatag->setVars($registro);
        $MyMetatag->setTitulo($registro["meta_titulo"]);
        $MyMetatag->setDescripcion($registro["meta_descripcion"]);
        $MyMetatag->setKeywords($registro["meta_keywords"]);

        $permisos = json_decode($registro['permisos'],true);
        if(!empty($permisos) && !$MySession->LoggedIn())
        {
            $MyRequest->redirect($MyRequest->Url(LOGIN).'?callback='.urlencode($MyRequest->url(BLOG_CATEGORIA,array("categoria" => $amigable_categoria_context))));
        }
        if(!empty($permisos) && !in_array($MySession->GetVar('nivel'),$permisos))
        {
            $MyRequest->redirect();
        }   
    }
    else{
        $MyRequest->redirect($MyRequest->Url(BLOG));
    }
}


if($MyRequest->isAjax())
{
 
    if(!empty($lista_articulos_blog)):
        
        foreach ($lista_articulos_blog as $articulo):

        if($articulo['destacado'] == 1):
           echo render(PROJECT_DIR.'/modulos/blog/diseno/blog/articulos/card.destacado.phtml',['articulo' => $articulo]);
        else:
           echo render(PROJECT_DIR.'/modulos/blog/diseno/blog/articulos/card.phtml',['articulo' => $articulo]);
        endif;

        endforeach;
    endif;
    die;
}
?>
