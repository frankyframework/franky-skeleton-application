<?php
use Blog\model\Blog;
use Blog\model\categoriasBlog;

$MyBlog = new Blog();
$MyCategoriaBlog = new categoriasBlog();

$blog = [
    ["loc" => BLOG, "vars" => array(),"priority" => "1.0","changefreq" => "daily"],
];

if (defined('BLOG_CATEGORIA')) {
    $MyCategoriaBlog->setPage(1);
    $MyCategoriaBlog->setTampag(10000);
    $MyCategoriaBlog->getData();
    while($registro = $MyCategoriaBlog->getRows()){

    
        $permisos = json_decode($registro['permisos'],true);
        if(!empty($permisos) && !$MySession->LoggedIn())
        {
            continue;
        }
        if(!empty($permisos) && !in_array($MySession->GetVar('nivel'),$permisos))
        {
            continue;
        }

        $blog[] = ["loc" => BLOG_CATEGORIA, "vars" =>['categoria' => $registro['amigable_categoria']],"priority" => "0.8","changefreq" => "daily"];  
    }
}


$MyBlog->setPage(1);
$MyBlog->setTampag(10000);
$MyBlog->setOrdensql("blog.fecha DESC");
$MyBlog->setNivel($MySession->GetVar('nivel'));

$result	 = $MyBlog->getData( '', '','','',1,'');


if($MyBlog->getTotal() > 0)
{
    $iRow = 0;

    while($registro = $MyBlog->getRows())
    {
        $blog[] = ["loc" => BLOG_DETALLE, "vars" =>array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]),"priority" => "0.8","changefreq" => "daily"];
    }
}

return $blog;