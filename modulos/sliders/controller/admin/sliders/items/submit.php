<?php
use Franky\Filesystem\File;
use Franky\Core\validaciones; 
use Sliders\model\SlidersitemsModel;
use Sliders\entity\SlidersitemsEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$SlidersitemsModel = new SlidersitemsModel();
$SlidersitemsEntity = new SlidersitemsEntity($MyRequest->getRequest());

$id       = $Tokenizer->decode($MyRequest->getRequest('id'));
$id_slider       = $Tokenizer->decode($MyRequest->getRequest('id_slider'));
$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$code       = $MyRequest->getRequest('code','',true);
$boton_link       = $MyRequest->getRequest('boton_link',0);

$SlidersitemsEntity->id($id);
$SlidersitemsEntity->id_slider($id_slider);
$SlidersitemsEntity->code($code);
$SlidersitemsEntity->boton_link($boton_link);
$error = false;

$validaciones =  new validaciones();
$valid = $validaciones->validRules($SlidersitemsEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_SLIDERS))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}


$dir = $MyConfigure->getServerUploadDir()."/sliders/".$SlidersitemsEntity->id_slider()."/";
$File = new File();
$File->mkdir($dir);

if($SlidersitemsEntity->tipo() == 'imagen')
{
    $handle = new \Franky\Filesystem\Upload($_FILES['file']);
    if ($handle->uploaded)
    {
        if($handle->file_is_image)
        {
            $handle->file_max_size = "2024288"; //1k(1024) x 512

            if($handle->image_src_x > 1600 || $handle->image_src_y > 1600)
            {
                $handle->image_resize = true;
            }
            $handle->image_x = 1600;
            $handle->image_y = 1600;
            $handle->image_ratio           = true;
        //    $handle->image_ratio_fill = true;
            $handle->file_auto_rename = true;
            $handle->file_overwrite = false;
            $handle->image_background_color = '#FFFFFF';


            $handle->Process($dir);

            if ($handle->processed)
            {
                $SlidersitemsEntity->file($handle->file_dst_name);

            }
            else
            {
                $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("imagen_error",$handle->error));
                $error = true;
            }

         }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("solo_imagen"));
            $error = true;

        }
    }
    $handle2 = new \Franky\Filesystem\Upload($_FILES['file_responsive']);
    if ($handle2->uploaded)
    {
        if($handle2->file_is_image)
        {
            $handle2->file_max_size = "2024288"; //1k(1024) x 512

            if($handle2->image_src_x > 1600 || $handle2->image_src_y > 1600)
            {
                $handle2->image_resize = true;
            }
            $handle2->image_x = 1600;
            $handle2->image_y = 1600;
            $handle2->image_ratio           = true;
        //    $handle2->image_ratio_fill = true;
            $handle2->file_auto_rename = true;
            $handle2->file_overwrite = false;
            $handle2->image_background_color = '#FFFFFF';


            $handle2->Process($dir);

            if ($handle2->processed)
            {
                $SlidersitemsEntity->file_responsive($handle2->file_dst_name);

            }
            else
            {
                $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("slider_imagen_responseive_error",$handle->error));
                $error = true;
            }

         }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("solo_imagen"));
            $error = true;

        }
    }
}



if($SlidersitemsEntity->tipo() == 'video')
{
    $handle = new \Franky\Filesystem\Upload($_FILES['file']);
    if ($handle->uploaded)
    {
        //if($handle->file_is_image)
        {
            
            $handle->file_auto_rename = true;
            $handle->file_overwrite = false;
          

            $handle->Process($dir);

            if ($handle->processed)
            {
                $SlidersitemsEntity->file($handle->file_dst_name);

            }
            else
            {
                $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("slider_video_error",$handle->error));
                $error = true;
            }

         }
        //else
        //{
          //  $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("solo_video"));
          //  $error = true;

        //}
    }
    $handle2 = new \Franky\Filesystem\Upload($_FILES['file_responsive']);
    if ($handle2->uploaded)
    {
      //  if($handle2->file_is_image)
        {
           
     
            $handle2->file_auto_rename = true;
            $handle2->file_overwrite = false;


            $handle2->Process($dir);

            if ($handle2->processed)
            {
                $SlidersitemsEntity->file_responsive($handle2->file_dst_name);

            }
            else
            {
                $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sider_video_responsive_error",$handle->error));
                $error = true;
            }

         }
      //  else
        //{
          //  $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("solo_video"));
            //$error = true;

        //}
    }
}


if($error == false)        
{
    if(empty($id))
    {

        $SlidersitemsEntity->createdAt(date('Y-m-d H:i:s'));
        $SlidersitemsEntity->status(1);
    }
    else
    {
        $SlidersitemsEntity->updateAt(date('Y-m-d H:i:s'));
    }
    $result = $SlidersitemsModel->save($SlidersitemsEntity->getArrayCopy());
    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        }
        else
        {
             $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }

        $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_SLIDERS_ITEMS).'?id='.$Tokenizer->token("sliders",$SlidersitemsEntity->id_slider()));

    }
    elseif($result == REGISTRO_ERROR)
    {

        if(empty($id))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
        }
        $location = $MyRequest->getReferer();
    }
    else
    {
        $MyFlashMessage->setMsg("error",$result);
        $location = $MyRequest->getReferer();
    }
}
else
{

    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>