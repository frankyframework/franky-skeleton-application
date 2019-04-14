<?php
use Base\model\UrlInternacionalModel;
use Base\entity\UrlInternacionalEntity;
use Base\model\paginasModel;


$UrlInternacionalModel = new UrlInternacionalModel;
$UrlInternacionalEntity = new UrlInternacionalEntity();
$paginasModel = new paginasModel();

$UrlInternacionalEntity->status(1);
$UrlInternacionalModel->setTampag(500);

$result	= $UrlInternacionalModel->getData($UrlInternacionalEntity->getArrayCopy());


$urlInternacional = array();
if($UrlInternacionalModel->getTotal() > 0)
{
	$iRow = 0;

	while($registro = $UrlInternacionalModel->getRows())
	{
      $urlInternacional[$registro['lang']][$registro['id_franky']] = $registro['url'];
  }
}


$modulos = getModulos();

$idiomas =  getCoreConfig('base/theme/langs');

$paginasModel->setTampag(1000);
$paginasModel->setOrdensql("id ASC");
if($paginasModel->getData() == REGISTRO_SUCCESS)
{

    while($registro = $paginasModel->getRows())
    {

			if(in_array($registro['modulo'],$modulos))
			{

	        foreach ($idiomas as $idioma)
	        {
	          if(!isset($urlInternacional[$idioma][$registro["id"]]))
	          {
	              if($registro["constante"] == 'HOME')
	              {
	                  $registro["url"] = "";
	              }

	              $urlInternacional[$idioma][$registro["id"]] = $registro["url"];


	          }

	    	}

		    if(isset($urlInternacional[$_SESSION['lang']][$registro["id"]]))
		    {
		      $registro["url"] =$urlInternacional[$_SESSION['lang']][$registro["id"]];
		    }



		    $keyCommand = (PREFIDIOMA !="" ? PREFIDIOMA."/".$registro["url"] : $registro["url"]);
		    define($registro["constante"],$keyCommand);

		    $MyFrankyMonster->pushCommand($keyCommand,array(
		            json_decode($registro["permisos"],true),
		            json_decode($registro["js"],true),
		            json_decode($registro["css"],true),
		            json_decode($registro["jquery"],true),
		            json_decode($registro["ajax"],true),
		            $registro["php"],
		        $registro["modulo"],
		        $registro["id"],
		        $registro["nombre"]
						));
				}
	}

}
else
{
    define(HOME,	"home");

    $MyFrankyMonster->pushCommand(HOME,array(
            array(),
            array(),
            array(),
            array(),
            "ajax.archivo.js",
            "home.php",
            "base",
            0));
}

//print_r($MyFrankyMonster->getUiCommand());
//print_r($urlInternacional); exit;
?>
