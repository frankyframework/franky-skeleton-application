<?php
use Catalog\Form\ProductsForm;
use Catalog\model\CatalogproductsModel;
use Catalog\entity\CatalogproductsEntity;
use Base\model\CustomattributesModel;
use Base\entity\CustomattributesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$CatalogproductsModel  = new CatalogproductsModel();
$CatalogproductsEntity = new CatalogproductsEntity();
$CustomattributesModel = new CustomattributesModel();
$CustomattributesEntity = new CustomattributesEntity();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();
$galeria_frm = "";
$album = $MySession->GetVar('addProduct');

if(empty($album))
{
   $album = md5(session_id().time());

}
else{
    if(isset($_SESSION['album_'.$album]) && !empty($_SESSION['album_'.$album]))
    {

        foreach($_SESSION['album_'.$album]  as $foto)
        {

            $galeria_frm .= getFotoCatalogProduct($album,$foto['img'],md5($foto['img']),$foto['principal']);
        }
    }
}

$data_category = [];
$data_subcategory = [];
$adminForm = new ProductsForm("frmproduct");

$custom_imputs = [];
$CustomattributesEntity->entity("catalog_products");
$CustomattributesEntity->status(1);
$CustomattributesModel->setTampag(100);
$result	 = $CustomattributesModel->getData($CustomattributesEntity->getArrayCopy());
while($data_attrs = $CustomattributesModel->getRows()){
    
    $custom_imputs[] = $data_attrs['name'];
    $data_attrs['data'] = json_decode($data_attrs['data'],true);

    if(!empty($data_attrs['source'])){
        $objData = new $data_attrs['source'];
        $data_attrs['data'] = $objData->getCollection();
    }

    if(in_array($data_attrs['type'],['text','textarea','file']))
    {
        $adminForm->add(array(
            'name' => $data_attrs['name'],
            'label' => $data_attrs['label'],
            'type'  => $data_attrs['type'],
           // 'required'  => true,
            'atributos' => array(
            //    'class'       => 'required',
             //   'maxlength' => 60
            ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
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
           // 'required'  => true,
            'atributos' => array(
            //    'class'       => 'required',
             //   'maxlength' => 60
            ),
            'options' => $data_attrs['data'],
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
            )
            )
        );
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
    $data['id'] = $Tokenizer->token('experiencia', $data['id']);;
  
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


}
//print_r($data); exit;

$adminForm->setData($data);
$categorias = getCatalogCategorys('sql');
$subcategorias = getCatalogSubcategorys(null,'sql');

$adminForm->setAtributoInput("callback","value", urldecode($callback));
$adminForm->setOptionsInput("category", $categorias);
$adminForm->setOptionsInput("subcategory", $subcategorias);

$title_form = "$title";
$MySession->SetVar('addProduct',$album);

$MyMetatag->setCode("<script  src='/public/plugins/tinymce/tinymce.min.js'></script>");
