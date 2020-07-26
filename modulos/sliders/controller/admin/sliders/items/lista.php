<?php
use Base\Form\filtrosForm;
use Sliders\model\SlidersitemsModel;
use Sliders\entity\SlidersitemsEntity;
use Franky\Core\paginacion;
use Franky\Haxor\Tokenizer;

$MyPaginacion = new paginacion();
$Tokenizer = new Tokenizer();
$id_slider = $MyRequest->getRequest('id');
$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"orden"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));		
$busca_b	= $MyRequest->getRequest('busca_b');	


$SlidersitemsModel = new SlidersitemsModel();
$SlidersitemsEntity = new SlidersitemsEntity();
$SlidersitemsEntity->id_slider($Tokenizer->decode($id_slider));
$SlidersitemsModel->setPage($MyPaginacion->getPage());
$SlidersitemsModel->setTampag($MyPaginacion->getTampageDefault());
$SlidersitemsModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$result	 = $SlidersitemsModel->getData($SlidersitemsEntity->getArrayCopy());
$MyPaginacion->setTotal($SlidersitemsModel->getTotal());

$lista_admin_data = array();
if($SlidersitemsModel->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $SlidersitemsModel->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
                
                if($registro['tipo'] == 'imagen')
                {
                    if(!empty($registro["file"]) && file_exists($MyConfigure->getServerUploadDir()."/sliders/".$registro['id_slider']."/".$registro["file"]))
                    {
                        $registro['preview'] = makeHTMLImg(imageResize($MyConfigure->getUploadDir()."/sliders/".$registro["id_slider"]."/".$registro["file"],50,50, true),50,50,"");

                    }
                }
                if($registro['tipo'] == 'video')
                {
                   if(!empty($registro["file"]) && file_exists($MyConfigure->getServerUploadDir()."/sliders/".$registro['id_slider']."/".$registro["file"]))
                    {
                        $registro['preview'] = '<video class="w_video" loop="loop" muted="muted" playsinline="playsinline" width="50">
                            <source src="'.$MyConfigure->getUploadDir()."/sliders/".$registro["id_slider"]."/".$registro["file"].'" />
                            </video>';

                    } 
                }
                if($registro['tipo'] == 'video-embebed')
                {
                    $registro['preview'] = "<div style='width:50px;height:50px;'>".$registro['code']."</div>";
                }
		$lista_admin_data[] = array_merge($registro,array(
                "id" => $Tokenizer->token("sliders", $registro["id"]),
                "callback" => $Tokenizer->token("sliders", $MyRequest->getURI()),    
                "createdAt" 	=> getFechaUI($registro["createdAt"]),
                "thisClass"     => $thisClass,
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                ));
                $iRow++;
        }
}



//$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$ordenfunction = "setOrdenSlidersItems";
$title_grid = "Sliders";
$class_grid = "cont_sliders";
$error_grid = "No items para este sliders";
$deleteFunction = "DeleteSlidersItems";
$frm_constante_link = FRM_SLIDERS_ITEMS;
$titulo_columnas_grid = array("createdAt" => "Fecha","tipo" => "Tipo");
$value_columnas_grid = array("createdAt", "tipo" );

$css_columnas_grid = array("createdAt" => "w-xxxx-3" ,"tipo" => "w-xxxx-3" );

$permisos_grid = ADMINISTRAR_SLIDERS;
$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
?>