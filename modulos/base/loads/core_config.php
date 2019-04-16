<?php
use \Base\model\CoreConfig;
use \Base\model\CoreConfigModel;
use \Base\entity\CoreConfigEntity;
use Franky\Filesystem\File;

$CoreConfig      = new CoreConfig();


$core_config_render  = $CoreConfig->getMapRender();

if(!$core_config_render):

      $CoreConfigModel      = new CoreConfigModel();
      $CoreConfigEntity      = new CoreConfigEntity();


      $modulo = $modulos = getModulos("DESC");
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



      $core_config_db = [];
      $CoreConfigModel->setTampag(1000);
      $CoreConfigModel->getData($CoreConfigEntity->getArrayCopy());
      if($CoreConfigModel->getTotal() > 0)
      {
          while($registro = $CoreConfigModel->getRows())
          {
              $core_config_db[$registro['path']] = $registro['value'];
          }

      }

      if(!empty($core_config)):
        foreach($core_config as $key_config => $val_config):

            foreach($val_config['config'] as $key =>$config):
                if(!isset($core_config_db[$config['path']]))
                {
                    $CoreConfigEntity->exchangeArray(null);
                    $CoreConfigEntity->path($config['path']);

                    $CoreConfigEntity->value((is_array($config['value']) ? json_encode($config['value']) : $config['value']));
                    $CoreConfigModel->save($CoreConfigEntity->getArrayCopy());
                    $core_config_db[$config['path']] = $config['value'];
                  

                }
                else {
                  if(isset($config['multiple']) && $config['multiple'] == true)
                  {
                    $core_config_db[$config['path']] = json_decode($core_config_db[$config['path']],true);
                  }
                }
            endforeach;
        endforeach;
      endif;

      $dir = $MyConfigure->getServerUploadDir()."/core_config/";
      $File = new File();
      $File->mkdir($dir);


      $fopen = fopen($CoreConfig->getServerUploadDir().'/core_config/core_config.php', 'w');
      fwrite($fopen,'<?php return '.var_export($core_config_db,true).' ?>');
      fclose($fopen);

endif;
