<?php
class Soclever_Socialloginsharing_Model_Observer
{
    
     
      public function writejs(Varien_Event_Observer $observer)
      {
         
          $site_id=Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid');
          $api_secret=Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_appsecret');
          $api_key=Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_appid');
          
            
         
         $valid_data=file_get_contents("https://www.socleversocial.com/dashboard/mage_sharelogin_activate.php?site_id=".$site_id."&api_key=".$api_key."&api_secret=".$api_secret."&csplatform=magentologin&type=preview");
         if($valid_data!='0')
         {
            Mage::getModel('core/config')->saveConfig('socialloginsharing_options/apisettings/scsl_validated',"1");
            Mage::getModel('core/config')->saveConfig('socialloginsharing_options/apisettings/valid_networks',$valid_data);
            
         }
         else
         {
           Mage::getModel('core/config')->saveConfig('socialloginsharing_options/apisettings/scsl_validated',"0");
         }
         
         
     }
   
}


?>