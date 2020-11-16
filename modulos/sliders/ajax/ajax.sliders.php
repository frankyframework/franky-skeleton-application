<?php

function DeleteSliders($id,$status)
{
    global $MySession;
    $SlidersModel =  new \Sliders\model\SlidersModel();
    $SlidersEntity =  new \Sliders\entity\SlidersEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_SLIDERS))
    {
        $SlidersEntity->id(addslashes($Tokenizer->decode($id)));
        $SlidersEntity->status($status);

        if($SlidersModel->save($SlidersEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("sliders_sliders_error_delete");
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

function DeleteSlidersItems($id,$status)
{
    global $MySession;
    $SlidersitemsModel =  new \Sliders\model\SlidersitemsModel();
    $SlidersitemsEntity =  new \Sliders\entity\SlidersitemsEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    global $MyAccessList;
    global $MyMessageAlert;

    $respuesta = null;

    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_SLIDERS))
    {
        $SlidersitemsEntity->id(addslashes($Tokenizer->decode($id)));
        $SlidersitemsEntity->status($status);

        if($SlidersitemsModel->save($SlidersitemsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
        {

        }
        else
        {
              $respuesta["message"] = $MyMessageAlert->Message("sliders_sliders_items_error_delete");
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

function setOrdenSlidersItems($orden)
{
	
	$SlidersitemsModel =  new \Sliders\model\SlidersitemsModel();
    $SlidersitemsEntity =  new \Sliders\entity\SlidersitemsEntity();
    $Tokenizer = new Franky\Haxor\Tokenizer();
    global $MyAccessList;
    global $MyMessageAlert;
    $respuesta =null;
    if($MyAccessList->MeDasChancePasar(ADMINISTRAR_SLIDERS))
    {
        $orden = explode(",",str_replace("cat_","",$orden));

        $v = "";
        $new_order = [];
        
        foreach($orden as $key => $val)
        {
            $v .= ($key)." -> $val,";
            $SlidersitemsEntity->id($Tokenizer->decode($val));
            $SlidersitemsEntity->orden($key);
            $SlidersitemsModel->save($SlidersitemsEntity->getArrayCopy());
    
        } 
        
    }
    else
    {
            $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
    }

	return $respuesta;
}


$MyAjax->register("DeleteSliders");
$MyAjax->register("DeleteSlidersItems");
$MyAjax->register("setOrdenSlidersItems");