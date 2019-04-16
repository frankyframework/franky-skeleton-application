<?php
namespace Sociallogin\model;

require_once(PROJECT_DIR.'/modulos/sociallogin/vendor/sdk/google/Google_Client.php');
require_once(PROJECT_DIR.'/modulos/sociallogin/vendor/sdk/google/contrib/Google_Oauth2Service.php');


class google{
    	 
   
    private $g_api_key;
    private $g_api_secret;
    
    public function __construct($key, $secret){
        $this->g_api_key = $key;
        $this->g_api_secret = $secret;
           
    }
    
    public function pasarela()
    {
        
        $google = new \Google_Client();
        $google->setClientId($this->g_api_key);
        $google->setClientSecret($this->g_api_secret);
        // $google->setDeveloperKey(CONSUMER_DEVELOP_GOOGLE);
        $google->setAccessType('offline');
        $google->setRedirectUri($this->getUrlCallback());
        $google->setApprovalPrompt('force');
        $oauth2 = new \Google_Oauth2Service($google);
 
        return  $google->createAuthUrl();

    }
    
    
    public function callback()
    {
        $google = new \Google_Client();
        $google->setClientId($this->g_api_key);
        $google->setClientSecret($this->g_api_secret);
        // $google->setDeveloperKey(CONSUMER_DEVELOP_GOOGLE);
        $google->setAccessType('offline');
        $google->setRedirectUri($this->getUrlCallback());
        $google->setApprovalPrompt('force');
        $oauth2 = new \Google_Oauth2Service($google);
        
        $google->authenticate();
        $_SESSION['token_login_google'] = $google->getAccessToken();
       
        if (isset($_SESSION['token_login_google'])) 
        {
           $google->setAccessToken($_SESSION['token_login_google']);
        }
        if ($google->getAccessToken()){
           $social_data = $oauth2->userinfo->get(); 
           
            $me["id"]     = $social_data['id'];
            $me['name']   = $social_data['name'];
            $me["nickname"]= $social_data['nickname'];
            $me["link"] = $social_data['link'];
            $me["birthday"] = "";
            $me['gender'] = $social_data['gender'];
            $me['email']  = $social_data['email'];
            $me["avatar"] = $social_data['picture'];  
            $me["token"] = json_decode($google->getAccessToken(),true);
            
            $_SESSION['my_social_data']["provider"] = "google";
            $_SESSION['my_social_data']["google"] = $me;
            return "success";

        }
        else
        {
           return "error";
        }
        
    }
    
    
    
    private function getUrlCallback()
    {
        global $MyRequest;
        return 'http://'.$MyRequest->getSERVER()."/social-login/callback/google/";
    }

}