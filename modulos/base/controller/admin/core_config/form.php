<?php
use \modulos\base\vendor\model\CoreConfig;
use \modulos\base\vendor\model\CoreConfigModel;
use \modulos\base\vendor\entity\CoreConfigEntity;
use \Franky\Form\Form;

$CoreConfig           = new CoreConfig();
$CoreConfigModel      = new CoreConfigModel();
$CoreConfigEntity     = new CoreConfigEntity();
$Form     = new Form();


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


$Form->setAtributos(array(
     'name' => 'frmConfig',
     'action' => "/public/php/admin/core-config/submit.php",
     'method' => 'post',
    'enctype' => "multipart/form-data"
 ));

$Form->add(array(
        'name' => 'guardar',
        'type'  => 'submit',
        'atributos' => array(
            'class'       => '_btn _primary',
            'value' => "Guardar"
         )
    )
 );
