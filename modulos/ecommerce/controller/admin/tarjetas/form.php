<?php
use modulos\ecommerce\Form\conektaForm;
use modulos\ecommerce\Form\openpayForm;
use modulos\ecommerce\vendor\model\CardsModel;

$CardsModel             = new CardsModel();

$id		= $MyRequest->getRequest('id');
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

if(getCoreConfig('ecommerce/conekta/enabled') == 1)
{
	$adminForm = new conektaForm("card-form");
}
elseif(getCoreConfig('ecommerce/openpay/enabled') == 1)
{
	$adminForm = new openpayForm("card-form");
}

if(!empty($id))
{

        $CardsModel->getData($id,$MySession->GetVar('id'));
				$data = $CardsModel->getRows();
        $conektaForm->addId();

}
$adminForm->setData($data);
$adminForm->setAtributoInput("pagar", "value", "Validar tarjeta");

$title_form = "Nueva tarjeta";

if(getCoreConfig('ecommerce/conekta/enabled') == 1)
{
		$MyMetatag->setCode('<script  src="https://cdn.conekta.io/js/latest/conekta.js"></script>');
}
elseif(getCoreConfig('ecommerce/openpay/enabled') == 1)
{
		$MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>');
		$MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>');
}
