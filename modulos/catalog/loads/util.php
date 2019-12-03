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

?>