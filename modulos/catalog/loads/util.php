<?php

function _catalog($txt)
{
    return dgettext("catalog",$txt);
}


function getCatalogCategorys( $type="interface")
{
    $CatalogcategoryModel = new Catalog\model\CatalogcategoryModel();
    $CatalogcategoryModel->setTampag(1000);
    $CatalogcategoryModel->setOrdensql("name ASC");
    $CatalogcategoryModel->getData();
    $total			= $CatalogcategoryModel->getTotal();
    $categorias = array();

    if($total > 0)
    {

        while($registro = $CatalogcategoryModel->getRows())
        {
            $categorias[($type == "interface" ? $registro["url_key"] : $registro['id'])] = $registro["name"];
	}
    }
    return $categorias;
}


function getCatalogSubcategorys($id=null, $type="interface")
{
    $CatalogsubcategoryModel = new Catalog\model\CatalogsubcategoryModel();
    $CatalogsubcategoryEntity = new Catalog\entity\CatalogsubcategoryEntity();
    $CatalogsubcategoryModel->setTampag(1000);
    $CatalogsubcategoryModel->setOrdensql("catalog_subcategory.name ASC");
    $CatalogsubcategoryEntity->id_category($id);
    $CatalogsubcategoryModel->getData($CatalogsubcategoryEntity->getArrayCopy());
    $total	= $CatalogsubcategoryModel->getTotal();
    $subcategorias = array();

    if($total > 0)
    {

        while($registro = $CatalogsubcategoryModel->getRows())
        {
            if($id != null)
            {
                $subcategorias[($type == "interface" ? $registro["url_key"] : $registro['id'])] = $registro["name"];
            }
            else
            {
                 $subcategorias[$registro["id_category"]][($type == "interface" ? $registro["url_key"] : $registro['id'])] = $registro["name"];
          
            }
	}
    }
    return $subcategorias;
}


function getFotoCatalogProduct($album,$foto,$token,$principal)
{

    global $MyConfigure;
    $Tokenizer = new \Franky\Haxor\Tokenizer();
    $html = "";
    $html .= "<div class='w-xxxx-4 w-xxx-4 w-xx-4 w-x-4 align_center img_foto_clientes foto_".$token."' id='foto_".$token."'>"
            ."<div class=\"w-xxxx-6 w-xxx-6 w-xx-6 w-x-6\">"
            ."<input type=\"radio\" value=\"$token\" name=\"principal\" ".($principal == 1 ? "checked='checked'" :'')." />Principal"
            ."</div>"
            ."<div class=\"w-xxxx-6 w-xxx-6 w-xx-6 w-x-6\">"
            ."<button type='button' onclick=\"eliminarFotoCatalogProduct('$token')\"><i class='icon icon-r-eliminar'></i></button>"

            . "</div><div>".  makeHTMLImg(imageResize($MyConfigure->getUploadDir()."/catalog/products/$album/$foto",220,220,true), "", "", "")."</div>"
            . "</div>";
    return $html;
}


function getCatalogBuscadorPrincipal()
{
    global $MyRequest;
    $BuscadorPrincipalForm =  new \Catalog\Form\BuscadorPrincipalForm('buscadorPrincipal');
    $BuscadorPrincipalForm->setAtributo('action',$MyRequest->url(CATALOG_SEARCH));
    
    return render('widget.buscador.phtml',['BuscadorPrincipalForm' => $BuscadorPrincipalForm]);
}


function catalog_getBuscadorLateral()
{
    global $MyRequest;
    global $MyFrankyMonster;
    $BuscadorLateralForm =  new \Catalog\Form\BuscadorLateralForm('buscadorLateral');
    $BuscadorLateralForm->setAtributo('action',$MyRequest->url(CATALOG_SEARCH));
    $categorias = getCatalogCategorys('interface');
    $BuscadorLateralForm->setOptionsInput("categoria[]", $categorias);
    $categorias = [];
    $clasificaciones = [];
    $detalle_clasificacion = [];


    return render('widget.buscador.lateral.phtml',[
    'MyFrankyMonster' => $MyFrankyMonster,
    'MyRequest'  => $MyRequest,
    'BuscadorLateralForm' => $BuscadorLateralForm,
    ]);
}


function catalog_completarTareas()
{
    global $MySession;
    global $MyRequest;
    global $MyFlashMessage;
    global $MyMessageAlert;
    $eventos_pendientes = $MySession->GetVar('catalog_eventos_pendientes');


    if(isset($eventos_pendientes['whishlist']))
    {
        $CatalogwhishlistModel = new Catalog\model\CatalogwhishlistModel;
        $CatalogwhishlistEntity = new Catalog\entity\CatalogwhishlistEntity($eventos_pendientes['whishlist']);

        if($CatalogwhishlistEntity->status() == 1)
        {
          $CatalogwhishlistEntity->fecha(date('Y-m-d H:i:s'));
          $CatalogwhishlistEntity->uid($MySession->GetVar('id'));
          $result = $CatalogwhishlistModel->save($CatalogwhishlistEntity->getArrayCopy());
        }
        else{
          $CatalogwhishlistEntity->uid($MySession->GetVar('id'));
          $CatalogwhishlistModel->delete($CatalogwhishlistEntity->getArrayCopy());
        }

    }

    $MySession->UnsetVar('catalog_eventos_pendientes');

}



function catalog_getPriceMaxMinProduct()
{
    $CatalogproductsModel = new \Catalog\model\CatalogproductsModel;
    $CatalogproductsEntity = new \Catalog\entity\CatalogproductsEntity;
    $CatalogproductsModel->setOrdensql("price ASC");
    $precio = [0,0];
    if($CatalogproductsModel->getData($CatalogproductsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
            $registro = $CatalogproductsModel->getRows();
            $precio[0] = $registro['price'];

    }
    $CatalogproductsModel->setOrdensql("price DESC");
    if($CatalogproductsModel->getData($CatalogproductsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
            $registro = $CatalogproductsModel->getRows();
            $precio[1] = $registro['price'];

    }

    return $precio;
}
?>