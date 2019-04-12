<?php
use modulos\sociallogin\vendor\model\configureGoogle;
use modulos\sociallogin\vendor\model\facebookx;
use modulos\sociallogin\vendor\model\google;

$MyConfigureGoogle = new configureGoogle();
$MyFacebook = new facebookx(getCoreConfig('sociallogin/facebook/api'),getCoreConfig('sociallogin/facebook/secret'));
$MyFacebook->setPermissions(getCoreConfig('sociallogin/facebook/permission'));

$MyGoogle = new google($MyConfigureGoogle->getConsumeKey(),$MyConfigureGoogle->getConsumerSecret());

$provider = $MyRequest->getUrlParam("provider","facebook");

if($provider == "facebook")
{
    $location = $MyFacebook->pasarela();
}
if($provider == "google")
{
    $location = $MyGoogle->pasarela();
}
if(!empty($location))
{
    $MyRequest->redirect($location);
}
