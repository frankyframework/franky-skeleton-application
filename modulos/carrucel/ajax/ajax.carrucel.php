<?php
function carrucel_DeleteCarrucel($id,$status)
{
    $CarrucelcarrucelesModel =  new \Carrucel\model\CarrucelcarrucelesModel();
    $CarrucelcarrucelesEntity =  new \Carrucel\entity\CarrucelcarrucelesEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_SLIDERS))
    {
        $CarrucelcarrucelesEntity->id(addslashes($Tokenizer->decode($id)));
        $CarrucelcarrucelesEntity->status($status);

        if($CarrucelcarrucelesModel->save($CarrucelcarrucelesEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("eliminar_generico_error");
              $respuesta["error"] = true;
        }
    }
    else
    {
         $respuesta["message"] = $MyMessageAlert->Message("sin_privilegios");
         $respuesta["error"] = true;
    }

    return $respuesta;
}


function carrucel_eliminarFoto($id,$status=0)
{
	
    $CarrucelfotosModel = new Carrucel\model\CarrucelfotosModel();
    $CarrucelfotosEntity = new Carrucel\entity\CarrucelfotosEntity();
    global $MyAccessList;
    global $MyMessageAlert;
    $respuesta =null;
    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
    {
        $CarrucelfotosEntity->id(addslashes($id));
        $CarrucelfotosEntity->status($status);


        if($CarrucelfotosModel->save($CarrucelfotosEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {
    
            $respuesta[] = array("message" => "success");
        }
        else
        {
    $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
        }
    }
    else
    {
            $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
    }
	
	return $respuesta;
}


function carrucel_editarFoto($id,$url)
{
	
    
    $CarrucelfotosModel = new Carrucel\model\CarrucelfotosModel();
    $CarrucelfotosEntity = new Carrucel\entity\CarrucelfotosEntity();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            $CarrucelfotosEntity->id(addslashes($id));
            $CarrucelfotosEntity->url($url);

        if($CarrucelfotosModel->save($CarrucelfotosEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {
		
               $respuesta[] = array("message" => "success", "url" => ($url));
            }
            else
            {
		$respuesta[] = array("message" => $MyMessageAlert->Message("editar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}



function carrucel_ShowFotos($carrucel)
{
    $Tokenizer = new \Franky\Haxor\Tokenizer;
	$CarrucelfotosModel = new Carrucel\model\CarrucelfotosModel();
        $CarrucelfotosEntity = new Carrucel\entity\CarrucelfotosEntity();
        global $MyAccessList;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            $carrucel = $Tokenizer->decode($carrucel);
            
            $CarrucelfotosModel->setOrdensql("orden ASC");
            $CarrucelfotosModel->setTampag(2000);
            $CarrucelfotosEntity->id_carrucel($carrucel);
            $CarrucelfotosEntity->status(1);
            if($CarrucelfotosModel->getData($CarrucelfotosEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {
                $i = 0;
                $html = "";
                while($registro = $CarrucelfotosModel->getRows())
                {
                    
                    $html .= carrucel_getFotoGaleria($registro["id"],$carrucel,$registro["foto"],$registro["url"]);
                    $i++;
                }
                $respuesta["html"] =  $html;
                
               
            }
        }
       
	
	return $respuesta;
}




function carrucel_setOrdenFoto($orden)
{
	$Tokenizer = new \Franky\Haxor\Tokenizer;
        $CarrucelfotosModel = new Carrucel\model\CarrucelfotosModel();
        $CarrucelfotosEntity = new Carrucel\entity\CarrucelfotosEntity();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
           
        
            $orden = explode(",",str_replace("foto_","",$orden));

            


           
            $v = "";
            foreach($orden as $key => $val)
            {
                $v .= ($key)." -> $val,";
                $CarrucelfotosEntity->id($val);
                $CarrucelfotosEntity->orden($key);
                $CarrucelfotosModel->save($CarrucelfotosEntity->getArrayCopy());
            }
          //  echo $v;
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}


/******************************** EJECUTA *************************/


$MyAjax->register("carrucel_DeleteCarrucel");
$MyAjax->register("carrucel_eliminarFoto");
$MyAjax->register("carrucel_editarFoto");
$MyAjax->register("carrucel_ShowFotos");
$MyAjax->register("carrucel_setOrdenFoto");
?>