<?php
use Catalog\Form\CatalogImportForm;
use Franky\Filesystem\File;

$adminForm = new CatalogImportForm('frmimport');



$dir = $MyConfigure->getServerUploadDir()."/catalog/importar/";
$File = new File();
$File->mkdir($dir);




$handle = new \Franky\Filesystem\Upload($_FILES['archivo']);
if ($handle->uploaded)
{

    if(in_array($handle->file_src_mime,['application/xls']))
    {
        
        $handle->Process($dir);

        if ($handle->processed)
        {
            

            if ( $xls = SimpleXLS::parse($dir.'/'.$handle->file_dst_name) ) {
                print_r( $xls->rows() );
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
    else
    {
        $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("catalog_filetype_error"));
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