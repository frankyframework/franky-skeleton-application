<?php
use modulos\base\Form\filtrosForm;
use modulos\blog\vendor\model\comentariosBlog;
use Franky\Core\paginacion;
$MyPaginacion = new paginacion();

$MyComentariosBlog = new comentariosBlog();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"comentarios_blog.fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b = $MyRequest->getRequest('busca_b');
$usuario_b = $MyRequest->getRequest('usuario_b');
$articulo_b = $MyRequest->getRequest('articulo_b');

$MyComentariosBlog->setPage($MyPaginacion->getPage());
$MyComentariosBlog->setTampag($MyPaginacion->getTampageDefault());
$MyComentariosBlog->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$result	 = $MyComentariosBlog->getData('', $articulo_b,($MyAccessList->MeDasChancePasar(ADMINISTRAR_COMENTARIOS_ARTICULOS_BLOG) ? "" : $MySession->GetVar('id')), $busca_b);
$MyPaginacion->setTotal($MyComentariosBlog->getTotal());
$lista_admin_data = array();
if($MyComentariosBlog->getTotal() > 0)
{
	$iRow = 0;

	while($registro = $MyComentariosBlog->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

								if(empty($registro['autor'])){
									$registro['autor'] = '';
								}
                $lista_admin_data[] = array_merge($registro,array(
                    "fecha"             => getFechaUI($registro["fecha"]),
                    "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" => $registro["friendly"])),
                    "thisClass"     => $thisClass,
                    "nuevo_estado"  => ($registro["status"] == 1 ? "desactivar" : "activar")
                ));
                $iRow++;
        }
}



$MyFiltrosForm = new filtrosForm('paginar');

$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();

$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>
