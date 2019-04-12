<?php

function checkCustomerConekta($id)
{

    $CustomerModel = new \modulos\ecommerce\vendor\model\CustomersModel();
    $CustomerEntity = new \modulos\ecommerce\vendor\entity\CustomersEntity();
    $CustomerEntity->id_user($id);

    if($CustomerModel->getData($CustomerEntity->getArrayCopy()) != REGISTRO_SUCCESS)
    {

        $UserModel = new \modulos\base\vendor\model\USERS();
        if($UserModel->getData($id)==REGISTRO_SUCCESS)
        {

            $registro = $UserModel->getRows();
            try{
                $customer = \Conekta\Customer::create(
                array(
                        'name'  => $registro["nombre"],
                        'email' => $registro["email"]
                    )
                );

              //  print_r($customer);  exit;

                $CustomerEntity->conekta($customer->id);
                $CustomerEntity->id_categoria(1);
                $CustomerModel->save($CustomerEntity->getArrayCopy());

                return $customer;

            } catch (\Conekta_Error $e) {
                //echo $e->getMessage();
                //El pago no pudo ser procesado
            }
        }


    }

    return true;
}

function updateCustomerConekta($id)
{

    $CustomerModel = new \modulos\ecommerce\vendor\model\CustomersModel();
    $CustomerEntity = new \modulos\ecommerce\vendor\entity\CustomersEntity();
    $CustomerEntity->id_user($id);

    if($CustomerModel->getData($CustomerEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
        $registro = $CustomerModel->getRows();
        $UserModel = new \modulos\base\vendor\model\USERS();
        if($UserModel->getData($id)==REGISTRO_SUCCESS)
        {
            $_registro = $UserModel->getRows();
            try{
                $customer = \Conekta\Customer::find($registro["conekta"]);
                $customer->update(
                  array(
                        'name'  => $_registro["nombre"],
                        'email' => $_registro["email"]
                  )
                );
                return $customer;
            } catch (\Conekta_Error $e) {
                //echo $e->getMessage();
                //El pago no pudo ser procesado
            }

        }


    }

    return true;
}

function deleteCustomerConekta($id)
{

    $CustomerModel = new \modulos\ecommerce\vendor\model\CustomersModel();
    $CustomerEntity = new \modulos\ecommerce\vendor\entity\CustomersEntity();
    $CustomerEntity->id_user($id);

    if($CustomerModel->getData($CustomerEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
        $registro = $CustomerModel->getRows();
        try{
            $customer = \Conekta\Customer::find($registro["conekta"]);
            $customer->delete();
            $CustomerEntity->id($registro["id"]);
            $CustomerModel->delete();
            return $customer;
        } catch (\Conekta_Error $e) {
            //echo $e->getMessage();
            //El pago no pudo ser procesado
        }

    }

    return true;
}


function getCustomerConekta($id)
{
    $CustomerModel = new \modulos\ecommerce\vendor\model\CustomersModel();
    $CustomerEntity = new \modulos\ecommerce\vendor\entity\CustomersEntity();
    $CustomerEntity->id_user($id);

    if($CustomerModel->getData($CustomerEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
        $registro = $CustomerModel->getRows();

        return $registro["conekta"];
    }
    return false;
}

function deleteCardConekta($token,$user)
{
    try{
        $customer = \Conekta\Customer::find(getCustomerConekta($user));

        foreach($customer->payment_sources as $k => $source)
        {

          if($token == $source['id'])
          {
             $source   = $customer->payment_sources[$k]->delete();
          }
        }
    } catch (\Conekta_Error $e) {
        //echo $e->getMessage();
        //El pago no pudo ser procesado
    }
}

function addCardConekta($token,$user)
{
    try{
        $customer = \Conekta\Customer::find(getCustomerConekta($user));
        $source = $customer->createPaymentSource(array(
          'token_id' => $token,
          'type'     => 'card'
        ));
        return $source;
    } catch (\Conekta_Error $e) {
        //echo $e->getMessage();
        //El pago no pudo ser procesado
    }
}
?>
