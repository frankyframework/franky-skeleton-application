<?php
use Ecommerce\Form\conektaForm;
use Ecommerce\Form\openpayForm;
use Ecommerce\model\CardsModel;

$CardsModel             = new CardsModel();

$id		= $MyRequest->getRequest('id');
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

if(getCoreConfig('ecommerce/conekta/enabled') == 1)
{
	if(in_array('conekta_tarjeta',getCoreConfig('ecommerce/conekta/methods')))
    {
		$adminForm = new conektaForm("card-form");
		$MyMetatag->setCode('<script  src="https://cdn.conekta.io/js/latest/conekta.js"></script>');

	}
}
elseif(getCoreConfig('ecommerce/openpay/enabled') == 1)
{
	if(in_array('openpay_tarjeta',getCoreConfig('ecommerce/openpay/methods')))
	{
		$adminForm = new openpayForm("card-form");
		$MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>');
		$MyMetatag->setCode('<script  src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>');

	}
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
