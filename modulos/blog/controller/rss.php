<?php
use Blog\model\Blog;
use Blog\model\categoriasBlog;


$MyBlog = new Blog();
$MyCategoriaBlog = new categoriasBlog();
$amigable_categoria_context =  $MyRequest->getRequest("categoria");;

$busca_b	= $MyRequest->getRequest('busca_b');
$autor_b = $MyRequest->getRequest('autor_b');
$destacado_b = $MyRequest->getRequest('destacado_b');

$MyBlog->setPage(1);
$MyBlog->setTampag(10000);
$MyBlog->setOrdensql("blog.fecha DESC");

if(empty($amigable_categoria_context))
{
    $MyBlog->isVisibleInSearch(1);
}

$MyBlog->setNivel($MySession->GetVar('nivel'));
$result	 = $MyBlog->getData( '', $busca_b,$autor_b,$destacado_b,1,$amigable_categoria_context);

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
            "articulo"		=>  $registro["contenido"],
            "autor"		=> $registro["usuario"],
            "status"    	=> $registro["status"],
            "friendly_categoria"=> $registro["amigable_categoria"],
            "friendly"          => $registro["friendly"],
            "autortext"          => $registro["autortext"],
            "destacado"          => $registro["destacado"],
            "fecha"             => $registro["fecha"],
            "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]),true)
        );
        
        if(!empty($registro["imagen"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"]))
        {
            $img = imageResize($MyConfigure->getUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"],400,400, true);
            $lista_articulos_blog[$iRow]['contenido']["img"] = $img;
        }
        $iRow++;
    }
}

if(!empty($amigable_categoria_context))
{
    $MyCategoriaBlog->getData($amigable_categoria_context);
    $registro = $MyCategoriaBlog->getRows();

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

header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>

<rss version="2.0">
<channel>
    <title><?=getCoreConfig('blog/rss/titulo')?></title>
    <link><?=$MyRequest->getPROTOCOLO().$MyRequest->getSERVER().($_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '')?>/</link>
    <language><?=$locale?></language>
    <description><?=getCoreConfig('blog/rss/descripcion')?></description>
    <generator><?=getCoreConfig('blog/rss/autor')?></generator>
    <?php if(!empty($lista_articulos_blog)): ?>
    <?php foreach($lista_articulos_blog as $articulo): ?>
    <item>
        <title><?=$articulo['titulo']?></title>
        <link><?=$articulo['link']?></link>
        <?php //<comments>http://www.miurl.com/comentarios.php?id='.$row[id_post].'</comments> ?>
        <pubDate><?=$articulo['fecha']?></pubDate>
        <category><?=$articulo['categoria']?></category>
        <?php //<guid>http://www.miurl.com/comentarios.php?id='.$row[id_post].'</guid> ?>
        <description><![CDATA[<?=$articulo['contenido']['p']?>]]></description>
      <?php /*  <content:encoded><![CDATA[<?=$articulo['articulo']?>]]></content:encoded> */ ?>
    </item>
    <?php endforeach; ?>
    <?php endif; ?>
</channel>
</rss>