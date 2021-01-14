<?php
use Catalog\Form\CatalogImportForm;
use Franky\Filesystem\File;

$adminForm = new CatalogImportForm('frmimport');
$adminForm->setAtributoInput("my_url_friendly","value", $MyFrankyMonster->MySeccion());


$dir = $MyConfigure->getServerUploadDir()."/catalog/importar/";
$File = new File();
$File->mkdir($dir);




$handle = new \Franky\Filesystem\Upload($_FILES['archivo']);
if ($handle->uploaded)
{


        
        $handle->Process($dir);

        if ($handle->processed)
        {
            

            if ( $xls = SimpleXLS::parse($dir.'/'.$handle->file_dst_name) ) {




                $atributos_xls = [
                    "name","sku","category","description","visible_in_search","stock","in_stock","stock_infinito","saleable","min_qty","price",
                    "iva","incluye_iva","envio_requerido","meta_title","meta_description","meta_keyword","url_key","status"
                ];

                $atributos_xls_json = ["category"];
                $custom_attr = getDataCustomAttribute(0,'catalog_products');



                if(!empty($custom_attr['custom_imputs']))
                {

                    foreach($custom_attr['custom_imputs'] as $key => $data_attrs)
                    {
                        if(!in_array($data_attrs['type'],['file','multifile']))
                        {

                            $atributos_xls[] = $data_attrs['name'];

                            if(in_array($data_attrs['type'],['checkbox']))
                            {

                                $atributos_xls_json[] = $data_attrs['name'];
                            }
                        }

                        
                        
                    }
                }

               
              //  print_r( $xls->rows() );

                $data_productos = [];
          
                foreach($xls->rows() as $key => $val)
                {
                    if($key > 0)
                    {
                        
                        foreach($val as $_key => $_val){




                            if(in_array($atributos_xls[$_key],$atributos_xls_json)){
                                $_val = json_decode($_val,true);
                            }
                            $data_productos[$key-1][$atributos_xls[$_key]] = $_val; 
                        }

                       
                    }

                }
                $titulo_columnas_grid = array("name" =>  "Nombre","sku" => "SKU");
                $value_columnas_grid = array("name","sku");

                $css_columnas_grid = array("name" => "w-xxxx-4", "sku" => "w-xxxx-4");


                print_r($data_productos); die;

            } else {
                
                $MyFlashMessage->setMsg("error",SimpleXLS::parseError());
                $error = true;
            }
            
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("catalog_upload_import_error",$handle->error));
            $error = true;
        }

}


/*


Array
(
    [0] => Array
        (
            [0] => ISBN
            [1] => title
            [2] => author
            [3] => publisher
            [4] => ctry
        )

    [1] => Array
        (
            [0] => 618260307
            [1] => The Hobbit
            [2] => J. R. R. Tolkien
            [3] => Houghton Mifflin
            [4] => USA
        )

)

*/