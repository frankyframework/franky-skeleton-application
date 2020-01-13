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
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"blog.fecha"));
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
                    "fecha"             => getFechaUI($registro["fecha"]),
                    "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]))

                );

                if(!empty($registro["imagen"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"]))
                {
                    $img = imageResize($MyConfigure->getUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"],800,700, true);
                    $lista_articulos_blog[$iRow]['contenido']["img"] = $img;
                }
                $iRow++;

        }


}

$MyCategoriaBlog->getData($amigable_categoria_context);
$registro = $MyCategoriaBlog->getRows();

if(!empty($amigable_categoria_context))
{
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

?>
