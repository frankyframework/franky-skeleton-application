<?php
use Base\model\AvataresModel;
use Base\entity\AvataresEntity;


$AvataresEntity = new AvataresEntity();
$AvataresModel = new AvataresModel();

$error = false;

$dir = $MyConfigure->getServerUploadDir()."/avatar/";

if (!file_exists($dir))
{
 	mkdir($dir, 0777);
}

if($error == false){

    $handle = new \Franky\Filesystem\Upload($_FILES['avatar']);

    if ($handle->uploaded && $_FILES['avatar']["name"] != "")
    {

        if (in_array(strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION)),array("jpg","png","gif","bmp","jpeg")))// (!$handle->file_is_image)
        {
            $handle->file_max_size = "524288"; //1k(1024) x 512

            $handle->image_resize= true;
            $handle->image_x = "90";
            $handle->image_y = "90";
            $handle->image_ratio_fill = true;
            $handle->file_auto_rename = true;
            $handle->file_overwrite = true;
            $handle->file_new_name_body = "avatar_".$MySession->GetVar('id').md5(time());

            $handle->Process($dir);

            if ($handle->processed)
            {
                $avatar = $handle->file_dst_name;

                $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("avatar_success"));
            }
            else
            {
                $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("avatar_error", $handle->error));
                $error = true;
            }
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("solo_imagen"));
            $error = true;
        }
    }
    else
    {
        $error = true;
    }

}

if($error == false)
{
        $AvataresEntity->id_user($MySession->GetVar('id'));
        $AvataresEntity->name('local');
        $AvataresEntity->status(1);

        if($AvataresModel->getData($AvataresEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
            $registro = $AvataresModel->getRows();
            $AvataresEntity->id($registro["id"]);
        }

        $AvataresEntity->url($MyRequest->link($MyConfigure->getUploadDir()."/avatar/".$avatar,false,true));


        if($AvataresModel->save($AvataresEntity->getArrayCopy()) != REGISTRO_SUCCESS)
        {
             $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("avatar_error"));
        }

}

$_SESSION["cookie_http_vars"] = $http_vars;

$MyRequest->redirect($MyRequest->getReferer());
?>
