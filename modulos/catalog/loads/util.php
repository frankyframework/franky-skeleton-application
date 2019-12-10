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


    if(isset($eventos_pendientes['wishlist']))
    {
        $CatalogwishlistModel = new Catalog\model\CatalogwishlistModel;
        $CatalogwishlistEntity = new Catalog\entity\CatalogwishlistEntity($eventos_pendientes['wishlist']);

        if($CatalogwishlistEntity->status() == 1)
        {
          $CatalogwishlistEntity->fecha(date('Y-m-d H:i:s'));
          $CatalogwishlistEntity->uid($MySession->GetVar('id'));
          $result = $CatalogwishlistModel->save($CatalogwishlistEntity->getArrayCopy());
        }
        else{
          $CatalogwishlistEntity->uid($MySession->GetVar('id'));
          $CatalogwishlistModel->delete($CatalogwishlistEntity->getArrayCopy());
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

function catalog_restaStock()
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

            $CatalogproductsEntity->save($CatalogproductsEntity->getArrayCopy());
        }
        
        
    }
}

function catalog_addStock()
{
    
}
?>