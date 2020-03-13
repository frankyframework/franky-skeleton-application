<?php

function _catalog($txt)
{
    return dgettext("catalog",$txt);
}

function getImageCategorys($id)
{
    global $MyConfigure;
    $CatalogcategoryModel = new Catalog\model\CatalogcategoryModel();
    $CatalogcategoryEntity = new Catalog\entity\CatalogcategoryEntity();
    $CatalogcategoryEntity->url_key($id);
    $CatalogcategoryModel->setTampag(1);
    $CatalogcategoryModel->setOrdensql("name ASC");
    $CatalogcategoryModel->getData($CatalogcategoryEntity->getArrayCopy());
    $total	= $CatalogcategoryModel->getTotal();

    if($total > 0)
    {

        $data = $CatalogcategoryModel->getRows();
        
        if(!empty($data["image"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/category/".$data["image"]))
        {
            return imageResize($MyConfigure->getUploadDir()."/catalog/category/".$data["image"],1200,700, true);

        }
     
    }
    return '';
}


function getCategoryMenu()
{
    global $MyRequest;
    $CatalogcategoryModel = new Catalog\model\CatalogcategoryModel();
    $CatalogcategoryModel->setTampag(1000);
    $CatalogcategoryModel->setOrdensql("name ASC");
    $CatalogcategoryModel->getData();
    $total			= $CatalogcategoryModel->getTotal();
    $menu = '<li class="_nav_catalog">
        <ul class="_ul_nav_catalog">';

    if($total > 0)
    {
        while($registro = $CatalogcategoryModel->getRows())
        {
            $menu .= '<li><a href="'. $MyRequest->url(CATALOG_SEARCH_CATEGORY,[ 'categoria' => $registro['url_key']]).'">'.$registro['name'].'</a></li>';
	    }
    }

    $menu .= '</ul>
    </li>';

    return $menu;
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

function getImageSubcategorys($id)
{
    global $MyConfigure;
    $CatalogsubcategoryModel = new Catalog\model\CatalogsubcategoryModel();
    $CatalogsubcategoryEntity = new Catalog\entity\CatalogsubcategoryEntity();
    $CatalogsubcategoryModel->setTampag(1);
    $CatalogsubcategoryModel->setOrdensql("catalog_subcategory.name ASC");
    $CatalogsubcategoryEntity->url_key($id);
    $CatalogsubcategoryModel->getData($CatalogsubcategoryEntity->getArrayCopy());
    $total	= $CatalogsubcategoryModel->getTotal();
    

    if($total > 0)
    {
        $data = $CatalogsubcategoryModel->getRows();
        if(!empty($data["image"]) && file_exists($MyConfigure->getServerUploadDir()."/catalog/category/".$data["image"]))
        {
            return imageResize($MyConfigure->getUploadDir()."/catalog/category/".$data["image"],1200,700, true);
        
        }
	
    }
    return '';
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

    return render(PROJECT_DIR.'/modulos/catalog/diseno/widget.buscador.phtml',['BuscadorPrincipalForm' => $BuscadorPrincipalForm]);
}


function catalog_getBuscadorLateral()
{
    global $MyRequest;
    global $MyFrankyMonster;
    $BuscadorLateralForm =  new \Catalog\Form\BuscadorLateralForm('buscadorLateral');
    $BuscadorLateralForm->setAtributo('action',$MyRequest->url(CATALOG_SEARCH));
    $categorias = getCatalogCategorys('interface');
    $_categorias = getCatalogCategorys('sql');
    $subcategorias = getCatalogSubcategorys(null,'interface');
    $BuscadorLateralForm->setOptionsInput("categoria[]", $categorias);



    return render('widget.buscador.lateral.phtml',[
    'MyFrankyMonster' => $MyFrankyMonster,
    'MyRequest'  => $MyRequest,
    'BuscadorLateralForm' => $BuscadorLateralForm,
    'categorias' => $categorias,
    '_categorias' => $_categorias,
    'subcategorias' => $subcategorias
    ]);
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

function catalog_setPriceEcommerce($data)
{


    $PreciosModel   = new \Ecommerce\model\PreciosModel();
    $PreciosEntity  = new \Ecommerce\entity\PreciosEntity();
    $PreciosEntity2  = new \Ecommerce\entity\PreciosEntity();

    if($data['saleable'] == 1)
    {
        $PreciosEntity->precio($data['price']);
        $PreciosEntity->iva($data['iva']);
        $PreciosEntity->incluye_iva($data['incluye_iva']);
        $PreciosEntity2->id_producto($data['id']);
        $PreciosEntity->id_moneda(1);
        $PreciosEntity->id_producto($data['id']);

        if($PreciosModel->getData($PreciosEntity2->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            $result2 = $PreciosModel->updateByIdProdcuto($PreciosEntity->getArrayCopy());
        }
        else {
            $result2 = $PreciosModel->save($PreciosEntity->getArrayCopy());
        }

    }
}

function catalog_validaStockCarrito($id,$n)
{
    global $MyRequest;
    global $MyMessageAlert;
    $CatalogproductsModel = new \Catalog\model\CatalogproductsModel;
    $CatalogproductsModel->getInfoProdcuto($id);
    $registro = $CatalogproductsModel->getRows();

    if($registro['in_stock'] == 0 || $registro['saleable'] == 0)
    {

        echo json_encode(array("error" => true,"message" => $MyMessageAlert->Message("catalog_produt_no_saleable",$registro['nombre'])));


        die;
    }

    if($registro['stock_infinito'] ==  0 && $n > $registro['stock'])
    {

        echo json_encode(array("error" => true,"message" => $MyMessageAlert->Message("catalog_stock_no_disponible",$registro['nombre'])));


        die;
    }
    if( $n < $registro['min_qty'])
    {

        echo json_encode(array("error" => true,"message" => $MyMessageAlert->Message("catalog_stock_minimo",$registro['nombre'])));


        die;
    }
}

function catalog_validaStockCompra()
{
    global $MyRequest;
    global $MyMessageAlert;
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    $productos_comprados = getCarrito();

    $CatalogproductsModel = new \Catalog\model\CatalogproductsModel;
    if(!empty($productos_comprados)){
        foreach($productos_comprados['productos'] as $producto)
        {
            $CatalogproductsModel->getInfoProdcuto($producto['id']);
            $registro = $CatalogproductsModel->getRows();
            if($registro['in_stock'] ==  0 || $registro["saleable"] == 0)
            {
                eliminarProductoCarrito($Tokenizer->token('catalog_products',$producto['id']));
                if(!$MyRequest->isAjax())
                {
                    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("catalog_produt_no_saleable",$registro['nombre']));
                    $MyRequest->redirect($MyRequest->url(CATALOG_VIEW,['friendly' => $registro['url_key']]));

                }else{
                    echo json_encode(array("error" => true,"message" => $MyMessageAlert->Message("catalog_produt_no_saleables",$registro['nombre'])));
                }

                die;
            }
            if($registro['stock_infinito'] ==  0 && $producto["qty"] > $registro['stock'])
            {
                eliminarProductoCarrito($Tokenizer->token('catalog_products',$producto['id']));
                if(!$MyRequest->isAjax())
                {
                    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("catalog_stock_no_disponible",$registro['nombre']));
                    $MyRequest->redirect($MyRequest->url(CATALOG_VIEW,['friendly' => $registro['url_key']]));

                }else{
                    echo json_encode(array("error" => true,"message" => $MyMessageAlert->Message("catalog_stock_no_disponible",$registro['nombre'])));
                }

                die;
            }
        }
    }


}

function catalog_restaStock($pedido)
{
    global $MySession;
    $CatalogproductsModel          = new \Catalog\model\CatalogproductsModel();
    $CatalogproductsEntity         = new \Catalog\entity\CatalogproductsEntity();
    $USERS =  new \Base\model\USERS;
    $entityUser = new \Base\entity\users;

    $detalle_pedido = getPedido($pedido);

    foreach($detalle_pedido['productos'] as $producto)
    {
        $CatalogproductsEntity->exchangeArray([]);

        $CatalogproductsModel->getInfoProdcuto($producto['id']);
        $registro = $CatalogproductsModel->getRows();

        if($registro['stock_infinito'] == 0)
        {
            $stock = $registro['stock'] - $producto['qty'];
            $CatalogproductsEntity->stock($stock);
            if($stock == 0)
            {
                $CatalogproductsEntity->in_stock(0);
            }
            $CatalogproductsEntity->id($producto['id']);

            $CatalogproductsModel->save($CatalogproductsEntity->getArrayCopy());
        }


    }
}

function catalog_addStock($pedido)
{
    global $MySession;
    $CatalogproductsModel          = new \Catalog\model\CatalogproductsModel();
    $CatalogproductsEntity         = new \Catalog\entity\CatalogproductsEntity();
    $USERS =  new \Base\model\USERS;
    $entityUser = new \Base\entity\users;

    $detalle_pedido = getPedido($pedido);
    if($detalle_pedido['status'] == 'canceled')
    {
        if(!empty($detalle_pedido['productos']))
        {
            foreach($detalle_pedido['productos'] as $producto)
            {
                $CatalogproductsEntity->exchangeArray([]);

                $CatalogproductsModel->getInfoProdcuto($producto['id']);
                $registro = $CatalogproductsModel->getRows();

                if($registro['stock_infinito'] == 0)
                {
                    $stock = $registro['stock'] + $producto['qty'];
                    $CatalogproductsEntity->stock($stock);
                    if($stock > 0)
                    {
                        $CatalogproductsEntity->in_stock(1);
                    }
                    $CatalogproductsEntity->id($producto['id']);

                    $CatalogproductsModel->save($CatalogproductsEntity->getArrayCopy());
                }

            }
        }
    }
}
?>
