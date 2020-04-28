<?php
use \Base\model\CoreConfig;
use \Base\model\CoreConfigModel;
use \Base\entity\CoreConfigEntity;
use Franky\Filesystem\File;
use Franky\Core\validaciones;


$CoreConfig           = new CoreConfig();
$CoreConfigModel      = new CoreConfigModel();
$CoreConfigEntity     = new CoreConfigEntity();
$validaciones =  new validaciones();
$modulo = $modulos = getModulos("DESC");
$path = $MyRequest->getRequest('path');
$File = new File();
$core_config = [];

if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
        $module_core_config = $CoreConfig->getMap($modulo);
        if($module_core_config)
        {
          $core_config = array_merge($core_config,$module_core_config);
        }

    }
}


$core_config_db_actual = [];
$CoreConfigModel->setTampag(1000);
$CoreConfigModel->getData($CoreConfigEntity->getArrayCopy());
if($CoreConfigModel->getTotal() > 0)
{
    while($registro = $CoreConfigModel->getRows())
    {
        $core_config_db_actual[$registro['path']] = $registro['value'];
    }

}


$error = false;


if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_CORE_CONFIG))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)
{

        if(!empty($core_config)):
          foreach($core_config as $key_config => $val_config):

            if($key_config == $path)
            {
              foreach($val_config['config'] as $key =>$config):
                  if($config['type'] != 'file')
                  {
                      if($config['validation'])
                      {

                            $label = $config['label'].' de '.$val_config['menu'];
                            $validar = array($label => ['valor' =>  $MyRequest->getRequest(str_replace("/","_",$config['path']))]);
                            if(isset($config['validation']['required']) && $config['validation']['required'] == true)
                            {
                                $validar[$label][] = "required";
                            }
                            if(isset($config['validation']['maxlength']) && $config['validation']['maxlength'] !== "")
                            {
                                $validar[$label]["length"] = ['max' => $config['validation']['maxlength']];
                            }


                            $valid = $validaciones->validRules($validar);
                            if(!$valid)
                            {

                                $MyFlashMessage->setMsg("error",$validaciones->getMsg());
                                $MyRequest->redirect($MyRequest->getReferer());
                            }
                      }
                      $CoreConfigEntity->exchangeArray([]);
                      $CoreConfigEntity->path($config['path']);
                      $value = $MyRequest->getRequest(str_replace("/","_",$config['path']),'',true);
                      if(is_array($value))
                      {
                        $value = json_encode($value);
                      }
                      $CoreConfigEntity->value($value);


                      if(isset($core_config_db_actual[$config['path']]))
                      {


                          if($core_config_db_actual[$config['path']] != stripslashes($CoreConfigEntity->value()))
                          {
                            $result = $CoreConfigModel->updateByPath($CoreConfigEntity->getArrayCopy());
                          }
                          else{
                            $result = REGISTRO_SUCCESS;
                          }
                      }
                      else
                      {
                          $result = $CoreConfigModel->save($CoreConfigEntity->getArrayCopy());
                      }

                  }
                  else {

                      $File->mkdir($MyConfigure->getServerUploadDir()."/core_config/".$config['path']);

                      $handle = new \Franky\Filesystem\Upload($_FILES[str_replace("/","_",$config['path'])]);
                      if ($handle->uploaded)
                      {

                              if(isset($config['validation']['image']) && $config['validation']['image'] == true)
                              {
                                  if  (!in_array(strtolower(pathinfo($_FILES[str_replace("/","_",$config['path'])]["name"], PATHINFO_EXTENSION)),array("jpg","png","gif","bmp","jpe","jpeg","ico")))//($handle->file_is_image)
                                  {
                                      $MyFlashMessage->setMsg("error","Solo de admiten imagenes en ".$config['label'].' de '.$val_config['menu']);
                                      $MyRequest->redirect($MyRequest->getReferer());
                                  }
                              }




                              $handle->file_max_size = "2024288"; //1k(1024) x 512
                              
                              $handle->image_ratio_fill = false;
                              $handle->file_auto_rename = true;
                              $handle->file_overwrite = false;
                              $handle->image_x = 2500;
                              $handle->image_y = 2500;
                              $handle->image_ratio           = true;
                              if($handle->image_src_x > 2500 || $handle->image_src_y > 2500)
                                {
                                    $handle->image_resize = true;
                                }

                              $handle->Process($MyConfigure->getServerUploadDir()."/core_config/".$config['path']);

                              if ($handle->processed)
                              {
                                  $imagen = $handle->file_dst_name;
                                  $CoreConfigEntity->exchangeArray([]);
                                  $CoreConfigEntity->path($config['path']);
                                  $CoreConfigEntity->value($MyConfigure->getUploadDir()."/core_config/".$config['path'].'/'.$imagen);
                                  if(isset($core_config_db_actual[$config['path']]))
                                  {
                                    if($core_config_db_actual[$config['path']] != $CoreConfigEntity->value())
                                    {
                                      $result = $CoreConfigModel->updateByPath($CoreConfigEntity->getArrayCopy());
                                    }
                                    else{
                                      $result = REGISTRO_SUCCESS;
                                    }

                                  }
                                  else
                                  {
                                      $result = $CoreConfigModel->save($CoreConfigEntity->getArrayCopy());
                                  }
                          
                              }
                              else
                              {
                                  $MyFlashMessage->setMsg("error","imagen_error",$handle->error.' en '.$config['label'].' de '.$val_config['menu']);
                                  $MyRequest->redirect($MyRequest->getReferer());
                              }


                      }
                      else {
                        if(isset($config['validation']['required']) && $config['validation']['required'] == true && empty($core_config_db_actual[$config['path']]))
                        {
                          $MyFlashMessage->setMsg("error",'La imagen es requerida en '.$config['label'].' de '.$val_config['menu']);
                          $MyRequest->redirect($MyRequest->getReferer());
                        }
                        $result = REGISTRO_SUCCESS;
                      }
                  }


                  if($result == REGISTRO_SUCCESS)
                  {


                  }
                  elseif($result == REGISTRO_ERROR)
                  {


                      $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));

                      $location = $MyRequest->getReferer();
                      $MyRequest->redirect($location);
                  }
                  else
                  {
                      $MyFlashMessage->setMsg("error",$result);
                      $location = $MyRequest->getReferer();
                      $MyRequest->redirect($location);
                  }


              endforeach;
            }
          endforeach;
            
        endif;

    unlink($CoreConfig->getServerUploadDir().'/core_config/core_config.php');



      $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
      $location = $MyRequest->getReferer();

}
else
{
    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>
