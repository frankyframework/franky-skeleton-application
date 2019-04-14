<?php
use Base\Form\filtrosForm;
use Blog\model\calificacionBlog;
use Franky\Core\paginacion;
$MyPaginacion = new paginacion();
$MyCalificacionBlog = new calificacionBlog();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"calificaciones_blog.fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b = $MyRequest->getRequest('busca_b');
$usuario_b = $MyRequest->getRequest('usuario_b');
$articulo_b = $MyRequest->getRequest('articulo_b');
$calificacion_b = $MyRequest->getRequest('calificacion_b');


$MyCalificacionBlog->setPage($MyPaginacion->getPage());
$MyCalificacionBlog->setTampag($MyPaginacion->getTampageDefault());
$MyCalificacionBlog->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$result	 = $MyCalificacionBlog->getData('', $articulo_b,($MyAccessList->MeDasChancePasar(ADMINISTRAR_CALIFICAR_ARTICULOS_BLOG) ? "" : $MySession->GetVar('id')),$calificacion_b, $busca_b);
$MyPaginacion->setTotal($MyCalificacionBlog->getTotal());


$lista_admin_data = array();
if($MyCalificacionBlog->getTotal() > 0)
{	
	$iRow = 0;	

	while($registro = $MyCalificacionBlog->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
	
                $lista_admin_data[] = array_merge($registro,array(
                    "fecha"             => getFechaUI($registro["fecha"]),
                    "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" =>$registro["amigable_categoria"],"articulo" => $registro["friendly"])),
                    "thisClass"     => $thisClass
                ));
                $iRow++;
        }
}

$MyFiltrosForm = new filtrosForm('paginar');

$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>