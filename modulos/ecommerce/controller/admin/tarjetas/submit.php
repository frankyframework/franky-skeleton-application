<?php
use Franky\Core\validaciones;
use modulos\ecommerce\vendor\model\CardsModel;
use modulos\ecommerce\vendor\entity\CardsEntity;

$CardsModel        = new CardsModel();
$CardsEntity       = new CardsEntity();

$callback = $MyRequest->getRequest("callback");
$error = false;


$validaciones =  new validaciones();
$valid = $validaciones->validRules($CardsEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if(!$MyAccessList->MeDasChancePasar(ADMINISTRAR_TARJETAS_ECOMMERCE))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}



if(!$error)
{




    $CardsEntity->uid($MySession->GetVar('id'));
    $CardsEntity->status(1);


    if($CardsModel->getData($CardsEntity->getArrayCopy())!= REGISTRO_SUCCESS)
    {
      if(getCoreConfig('ecommerce/conekta/enabled') == 1)
      {
        $data = $MyRequest->getRequest("card");
        $CardsEntity->numero(substr($data["number"],-4));
        $CardsEntity->nombre($data["name"]);
      	$source = addCardConekta($MyRequest->getRequest("conekta"),$MySession->GetVar('id'));
      }
      elseif(getCoreConfig('ecommerce/openpay/enabled') == 1)
      {
        $CardsEntity->numero(substr($MyRequest->getRequest("card_number"),-4));
        $CardsEntity->nombre($MyRequest->getRequest("holder_name"));
      	$source = addCardOpenpay($MyRequest->getRequest("conekta"),$MySession->GetVar('id'),$MyRequest->getRequest("device_session_id"));
      }



      $CardsEntity->fecha(date('Y-m-d H:i:s'));

      $CardsEntity->conekta($source['id']);

      $result = $CardsModel->save($CardsEntity->getArrayCopy());

      if($result == REGISTRO_SUCCESS)
      {
          $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
          $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_LISTA_TARJETAS_ECOMMERCE));
      }
      elseif($result == REGISTRO_ERROR)
      {
          $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));

          $location = $MyRequest->getReferer();
      }
      else
      {
          $MyFlashMessage->setMsg("error",$result);
          $location = $MyRequest->getReferer();
      }
    }
    else {
      $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("ecommerce_tarjeta_duplicado"));
      $location = $MyRequest->getReferer();
    }
}
else
{
    $location = $MyRequest->getReferer();
}


$MyRequest->redirect($location);
?>
