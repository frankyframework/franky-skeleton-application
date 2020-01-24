<?php

function DeleteSliders($id,$status)
{
    global $MySession;
    $SlidersModel =  new \Catalog\model\SlidersModel();
    $SlidersEntity =  new \Catalog\entity\SlidersEntity();
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
    $SlidersitemsModel =  new \Catalog\model\SlidersitemsModel();
    $SlidersitemsEntity =  new \Catalog\entity\SlidersitemsEntity();
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


$MyAjax->register("DeleteSliders");
$MyAjax->register("DeleteSlidersItems");