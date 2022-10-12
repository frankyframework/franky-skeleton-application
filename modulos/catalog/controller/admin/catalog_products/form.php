<?php
use Catalog\Form\ProductsForm;
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Base\model\CustomattributesModel;
use Base\entity\CustomattributesEntity;
use Base\model\CustomattributesvaluesModel;
use Base\entity\CustomattributesvaluesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$CatalogproductsModel  = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$CustomattributesModel = new CustomattributesModel();
$CustomattributesEntity = new CustomattributesEntity();
$CustomattributesvaluesModel              = new CustomattributesvaluesModel();
$CustomattributesvaluesEntity             = new CustomattributesvaluesEntity();


$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();
$galeria_frm = "";
$album = $MySession->GetVar('addProduct');

$album = md5(session_id().time());

$data_category = [];
$data_subcategory = [];
$adminForm = new ProductsForm("frmproduct");


$custom_attr = getDataCustomAttribute($id,'catalog_products');


if(!empty($custom_attr['custom_imputs']))
{

    foreach($custom_attr['custom_imputs'] as $key => $data_attrs)
    {

        
        if(in_array($data_attrs['type'],['file']))
        {
            
            $adminForm->add(array(
                'name' => $data_attrs['name'],
                'label' => $data_attrs['label'],
                'type'  => $data_attrs['type'],
                'required'  => $data_attrs['required'],
                'atributos' => array(
                    'class'       => ($data_attrs['required'] && empty($custom_attr['custom_values'][$data_attrs['name']]) ? 'required' : ''),
                //   'maxlength' => 60
                ),
                'label_atributos' => array(
                    'class'       => ($data_attrs['required'] ? 'desc_form_obligatorio' : 'desc_form_no_obligatorio')
                )
                )
            );
        }
        if(in_array($data_attrs['type'],['multifile']))
        {
            
            $adminForm->add(array(
                'name' => $data_attrs['name'],
                'label' => $data_attrs['label'],
                'type'  => 'file',
                'required'  => $data_attrs['required'],
                'atributos' => array(
                    'class'       => ($data_attrs['required'] && empty($custom_attr['custom_values'][$data_attrs['name']]) ? 'required' : ''),
                   'multiple' => true
                ),
                'label_atributos' => array(
                    'class'       => ($data_attrs['required'] ? 'desc_form_obligatorio' : 'desc_form_no_obligatorio')
                )
                )
            );
        }
        if(in_array($data_attrs['type'],['text','textarea']))
        {
            
            $adminForm->add(array(
                'name' => $data_attrs['name'],
                'label' => $data_attrs['label'],
                'type'  => $data_attrs['type'],
                'required'  => $data_attrs['required'],
                'atributos' => array(
                    'class'       => ($data_attrs['required'] ? 'required' : '').' '.($data_attrs['type'] == 'textarea'? 'editor_html' : ''),
                //   'maxlength' => 60
                ),
                'label_atributos' => array(
                    'class'       => ($data_attrs['required'] ? 'desc_form_obligatorio' : 'desc_form_no_obligatorio')
                )
                )
            );
        }
        if(in_array($data_attrs['type'],['radio','select','checkbox']))
        {
            $adminForm->add(array(
                'name' => $data_attrs['name'],
                'label' => $data_attrs['label'],
                'type'  => $data_attrs['type'],
                'required'  => $data_attrs['required'],
                'atributos' => array(
                    'class'       =>  ($data_attrs['required'] ? 'required' : ''),
                //   'maxlength' => 60
                ),
                'options' => $data_attrs['data'],
                'label_atributos' => array(
                    'class'       => ($data_attrs['required'] ? 'desc_form_obligatorio' : 'desc_form_no_obligatorio')
            
                )
                )
            );
        }

    }
}



$title = "Nuevo producto";
if(!empty($id))
{
    $CatalogproductsEntity->id($id);
    $CatalogproductsModel->getData($CatalogproductsEntity->getArrayCopy());

    $data = $CatalogproductsModel->getRows();
    $galeria_frm = "";
    $album = $data['id'];
    $CatalogproductsEntity->id($id);
    $data['id'] = $Tokenizer->token('catalog_products', $data['id']);;
  
    $title = "Editar producto";
    //$data["videos"] = (!empty($data['videos']) ? implode(",",json_decode($data["videos"],true)) : '');
    $data["images"] = json_decode($data["images"],true);
    $data["category"] = json_decode($data["category"],true);

    $_SESSION['album_'.$album] = $data["images"];
    if(!empty($data['images']))
    {
        foreach($data["images"] as $foto)
        {

            $galeria_frm .= getFotoCatalogProduct($id,$foto['img'],md5($foto['img']),$foto['principal']);
        }
    }
   
    foreach($data["category"] as $cat => $sub)
    {
        $data_category[] = $cat;
        foreach($sub as $_sub)
        {
            $data_subcategory[] = $_sub;
        }
    }
    
 
    if(!empty($custom_attr['custom_values']))
    {
        $data = array_merge($data,$custom_attr['custom_values']);
    }

    

}
//print_r($data); exit;

$adminForm->setData($data);
$categorias = getCatalogCategorys('sql',['status' => 1]);
$subcategorias = getCatalogSubcategorys(null,'sql');

$adminForm->setAtributoInput("callback","value", urldecode($callback));
$adminForm->setOptionsInput("category", $categorias);
$adminForm->setOptionsInput("subcategory", $subcategorias);

$title_form = "$title";
$MySession->SetVar('addProduct',$album);

$MyMetatag->setCode("<script  src='/public/plugins/tinymce/tinymce.min.js'></script>");
