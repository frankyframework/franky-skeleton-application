<?php
use vendor\core\ObserverManager;
$ObserverManager = new ObserverManager;

include 'lca.php';
include 'util.php';
include 'paypal.php';

bindtextdomain("ecommerce", PROJECT_DIR .'/modulos/ecommerce/locale');


if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset("ecommerce", 'UTF-8');
}

if(getCoreConfig('ecommerce/conekta/enabled') == 1)
{
  require_once( PROJECT_DIR.'/modulos/ecommerce/vendor/SDK/Conekta/lib/Conekta.php' );
  \Conekta\Conekta::setApiKey((getCoreConfig('ecommerce/conekta/sandbox') == 1 ? getCoreConfig('ecommerce/conekta/keysandbox') :  getCoreConfig('ecommerce/conekta/key')));
  \Conekta\Conekta::setApiVersion("2.0.0");
  include 'conekta.php';
  $ObserverManager->addObserver('register_new_user','checkCustomerConekta');
  $ObserverManager->addObserver('login_user_'.NIVEL_USERSUSCRIPTOR,'checkCustomerConekta');
  $ObserverManager->addObserver('login_user_'.NIVEL_USERSUSCRIPTOR,'updateCustomerConekta');

}
else if(getCoreConfig('ecommerce/openpay/enabled') == 1)
{
  require_once( PROJECT_DIR.'/modulos/ecommerce/vendor/SDK/openpay/Openpay.php' );
  Openpay::setId((getCoreConfig('ecommerce/openpay/sandbox') == 1 ? getCoreConfig('ecommerce/openpay/idsandbox') :  getCoreConfig('ecommerce/openpay/id')));
  Openpay::setApiKey((getCoreConfig('ecommerce/openpay/sandbox') == 1 ? getCoreConfig('ecommerce/openpay/secretsandbox') :  getCoreConfig('ecommerce/openpay/secret')));
  Openpay::setProductionMode((getCoreConfig('ecommerce/openpay/sandbox') == 1 ? false : true));

  include 'openpay.php';
  $ObserverManager->addObserver('register_new_user','checkCustomerOpenpay');
  $ObserverManager->addObserver('login_user_'.NIVEL_USERSUSCRIPTOR,'checkCustomerOpenpay');
  $ObserverManager->addObserver('login_user_'.NIVEL_USERSUSCRIPTOR,'updateCustomerOpenpay');


}
$ObserverManager->addObserver('login_user_'.NIVEL_USERSUSCRIPTOR,'setCarritoUser');
$ObserverManager->addObserver('register_new_user','setCarritoUser');

$MyMetatag->setJs("/public/js/ecommerce.js");
$MyMetatag->setJs("/public/ajax/ecommerce/ajax.ecommerce.js");
$MyMetatag->setCss("/public/skin/ecommerce/css/cart.css");
?>
