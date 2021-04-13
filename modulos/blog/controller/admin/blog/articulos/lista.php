<?php
use Base\Form\filtrosForm;
use Blog\model\Blog;
use Blog\model\BorradorblogModel;
use Blog\entity\BorradorblogEntity;
use Franky\Core\paginacion;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyPaginacion = new paginacion();
$MyBlog = new Blog();

$BorradorblogModel = new BorradorblogModel();
$BorradorblogEntity = new BorradorblogEntity();


$BorradorblogModel->setPage(1);
$BorradorblogModel->setTampag(10000);
$borrador = [];
if($BorradorblogModel->getData($BorradorblogEntity->getArrayCopy()) == REGISTRO_SUCCESS)
{
    while($registro = $BorradorblogModel->getRows()){
        $borrador[] = $registro['id_blog'];
    }  
}


$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"blog.fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b = $MyRequest->getRequest('busca_b');
$autor_b = $MyRequest->getRequest('autor_b');
$destacado_b = $MyRequest->getRequest('destacado_b');
$status_b = $MyRequest->getRequest('status_b');
$categoria_b = $MyRequest->getRequest('categoria_b');

if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $lang_b	= $MyRequest->getRequest('lang_b',$_SESSION['lang'] );
    $idiomas_disponibles = getCoreConfig('base/theme/langs');
    $MyBlog->setLang($lang_b);

}

if(getCoreConfig('blog/registers/showdelete') == 0){
    $status_b = 1;
}

$MyBlog->setPage($MyPaginacion->getPage());
$MyBlog->setTampag($MyPaginacion->getTampageDefault());
$MyBlog->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$MyBlog->setIsAdmin(1);
$result	 = $MyBlog->getData('', $busca_b,$autor_b,$destacado_b,$status_b,$categoria_b);
$MyPaginacion->setTotal($MyBlog->getTotal());


$lista_admin_data = array();
if($MyBlog->getTotal() > 0)
{	
	$iRow = 0;	

	while($registro = $MyBlog->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
		   
                
		$lista_admin_data[$iRow] = array(
                    "id" => $Tokenizer->token('articulo_blog',$registro["id"]),
                    "fecha"             => getFechaUI($registro["fecha"]),
                    "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" => $registro["friendly"])),
                    "thisClass"     => $thisClass,
                    "nuevo_estado"  =>($registro["status"] == 1 ?  "desactivar" : "activar"),
                    "borrador" =>'',
                    "callback" => $Tokenizer->token('anuncios',$MyRequest->getURI()),
                    "titulo" => '<a href="'.$MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" => $registro["friendly"])).'" target="_blank">'.$registro['titulo'].'</a>',
                    "categoria_nombre" => $registro['categoria_nombre'],
                    "usuario" => $registro['usuario']
                );
                
                
                if(in_array($registro['id'],$borrador)){
                    $lista_admin_data[$iRow]['borrador'] = '<a class="btn_adm_borrador"  href="'. $MyRequest->link(ADMIN_FRM_ARTICULOS_BLOG)."?id=".$lista_admin_data[$iRow]['id']."&amp;callback=".$lista_admin_data[$iRow]['callback'].'&borrador=1"><i class="icon icon-borrar"> </i></a>';
                }
                $iRow++;
        }
}



$title_grid = "Articulos";
$class_grid = "cont_blog";
$error_grid = "No hay articulos registrados";
$deleteFunction = "EliminarArticuloBlog";
$frm_constante_link = ADMIN_FRM_ARTICULOS_BLOG;

$css_columnas_grid = array("fecha" => "w-xxxx-1" ,"titulo" => "w-xxxx-3" , "categoria_nombre" => "w-xxxx-3","usuario" => "w-xxxx-2" );
$titulo_columnas_grid = array("fecha" => "Fecha","titulo" => "Titulo", "categoria_nombre" =>  "Categoria","usuario" => "Autor");
$value_columnas_grid = array("fecha","titulo" , "categoria_nombre" ,"usuario" );
$permisos_grid = ADMINISTRAR_ARTICULOS_BLOG;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());


$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);


if(getCoreConfig('blog/idioma/multi-idioma') == 1)
{
    $idiomas = array();
    foreach($idiomas_disponibles as $idioma)
    {
        $idiomas[$idioma] = $idioma;
    }
    $MyFiltrosForm->addLang();
    $MyFiltrosForm->setOptionsInput("lang_b", $idiomas);
    $MyFiltrosForm->setAtributoInput("lang_b","value",$lang_b);

}
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

?>