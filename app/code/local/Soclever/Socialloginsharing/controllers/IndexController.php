<?php
class Soclever_Socialloginsharing_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {  
  $this->loadLayout();     
  $this->renderLayout();
    }
    protected function getSession(){
		return Mage::getSingleton('customer/session');
	}
 public function fbloginAction()
{

if(isset($_GET['lc']) && $_GET['lc']!='')
{
    setcookie('lc',$_GET['lc'],time()+100,'/');
    setcookie('lch',$_GET['lch'],time()-100,'/');

}
 if(isset($_GET['lch']) && $_GET['lch']!='')
{
    setcookie('lch',$_GET['lch'],time()+100,'/');
    setcookie('lc',$_GET['lc'],time()-100,'/');

}  
   $get_fb=file_get_contents("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid')."");
   
   if($get_fb!='0')
   {
    
    $app_arr=explode("~",$get_fb);
   $app_id = $app_arr[0];
   $my_url="".Mage::getBaseUrl()."soclever_socialloginsharing/index/fblogin";
   $app_secret = $app_arr[1];
   $code = $_REQUEST["code"];
   if(isset($_REQUEST['error'])){
    if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason']=='user_denied'){
        
        echo $_REQUEST['error'];
        echo"<br/><a href='".Mage::getBaseUrl()."'>Go to site</a>";
       exit;
  }
}
 
 if(empty($code)) {
        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=email,user_birthday,user_relationships,user_location,user_hometown,user_friends,user_likes";

        echo("<script>top.location.href='".$dialog_url."'</script>");
    }

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
        . $app_secret . "&code=" . $code;

	$ch = curl_init();
                    	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	//Get Access Token
	curl_setopt($ch, CURLOPT_URL,$token_url);
	$access_token = curl_exec($ch);
  
	curl_close($ch);
	
	
    $graph_url = "https://graph.facebook.com/v2.2/me?" . $access_token."&fields=id,name,first_name,last_name,timezone,email,picture,gender,locale,birthday,relationship_status,location,hometown,friends.limit%280%29,likes{id,name}";
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $temp_user = curl_exec($ch);
    curl_close($ch);
	$fbuser_old = $temp_user;	
	$fbuser=json_decode($fbuser_old);
   
    if($fbuser_old && $fbuser->email!="")
	{
        $request_url="https://www.socleversocial.com/dashboard/track_register_new.php?app_id=".$app_id."&is_fb=1&friend_data=".$fbuser->friends->summary->total_count."&siteid=".Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid')."&other=".urlencode($fbuser_old);
        $resPonse=file_get_contents($request_url);
        if($resPonse)
        {
            $fb_data=json_decode($resPonse);
            
            $resource = Mage::getSingleton('core/resource');
  $tableName = $resource->getTableName('customer_entity');
  $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
  $sql        = "Select entity_id from ".$tableName." where email='".$fb_data->email."' limit 1";
  $rows= $connection->fetchAll($sql);
  
$customer = Mage::getModel("customer/customer");
  if(count($rows) > 0)
  {
    $is_new='0';
    $username=$fb_data->email;  
    $customer_id=$rows[0]['entity_id'];
  }
  else
  {
    $is_new='1';
    $store = Mage::app()->getStore();
    
    $customer->website_id = $websiteId;
    $customer->setStore($store);       
    $password=rand("111111","9999999");
    $customer->firstname = $fb_data->first_name;
    $customer->lastname = $fb_data->last_name;
    $customer->email =$fb_data->email;
    $customer->password_hash = md5($password);
    $customer->save();
    $username=$fb_data->email;
    $sql= "Select entity_id from ".$tableName." where email='".$fb_data->email."' limit 1";
    $rows= $connection->fetchAll($sql);
    $customer_id=$rows[0]['entity_id'];
  }
  
  file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?is_from=1&siteUid=".$customer_id."&is_new=".$is_new."&member_id=".$fb_data->member_id."&siteid=".Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid')."&action=notifycs");
  Mage::getModel('core/session', array('name' => 'frontend'));
  $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
  $customer->loadByEmail($username);
  $customer->setCustomerActivated(true);
  $customer->setData('password',$password);
  $customer->save();              
 if($is_new=='1' && Mage::getStoreConfig('socialloginsharing_options/displaysettings/socialloginregemail')=='1')
  {
    $customer->sendNewAccountEmail();
     
  }

  $redirect_location=($_COOKIE['lc']=='c')?Mage::getBaseUrl()."checkout/onepage/":Mage::getBaseUrl()."customer/account/";
  if(isset($_COOKIE['lch']) && $_COOKIE['lch']!='')
  {
    $redirect_location=$_COOKIE['lch'];
  }
  $is_from='1';
  Mage::getSingleton('core/session')->setSessionVariable($is_from); 
  ?>
  <script type="text/javascript">
  
  setTimeout(function(){
    
    
    window.location.href="<?php echo $redirect_location;?>";
    
    },1000);
    
  /*setTimeout(function(){
    
    
    window.close();
            //window.opener.location = window.opener.window.location;
    
    /*try{
        if(parent.window.opener != null && ! parent.window.opener)
    {
      alert("good");
    }

    }catch(e){ alert("message="+e.description);}  
*/

   //alert("called redirection=="+top.window.opener.document.URL+"=");
//top.window.location.assign("<?php echo Mage::getBaseUrl();?>customer/account/edit/");

//   top.window.location.href="<?php echo Mage::getBaseUrl();?>customer/account/edit/";
   //close();
   //return false;
    /*if(top.window.opener.document.URL.indexOf('login') > -1)
                            {
                                top.window.opener.location.href="<?php echo Mage::getBaseUrl();?>customer/account/edit/";
                                close();
                            }
                            else
                            {
                                top.window.opener.location.href="<?php echo Mage::getBaseUrl();?>checkout/onepage/";
                                close();
                                
                            }*/
                            
  /*}, 3000);*/
  </script>
  <?php
    //echo"<img src='https://www.socleversocial.com/dashboard/images/pw.gif' alt='wait!' title='wait!'>";  
   $this->getSession()->loginById($customer->getId());
   exit;
          }  
        }	   
	} 
    else
    {
        
        echo"<h1>Login failed.</h1><a href='".Mage::getBaseUrl()."'>Go back to site.</a>";
    }  
}    
 public function pploginAction()
{
  $paypal_data=json_decode($_GET['data']);
    
  $resource = Mage::getSingleton('core/resource');
  $tableName = $resource->getTableName('customer_entity');
  $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
  $sql        = "Select entity_id from ".$tableName." where email='".$paypal_data->email."' limit 1";
  $rows= $connection->fetchAll($sql);
  
$customer = Mage::getModel("customer/customer");
  if(count($rows) > 0)
  {
    $is_new='0';
    $username=$paypal_data->email;  
    $customer_id=$rows[0]['entity_id'];
  }
  else
  {
    $is_new='1';
    $store = Mage::app()->getStore();
    
    $customer->website_id = $websiteId;
    $customer->setStore($store);       
    $password=rand("111111","9999999");
    $customer->firstname = $paypal_data->first_name;
    $customer->lastname = $paypal_data->last_name;
    $customer->email =$paypal_data->email;
    $customer->password_hash = md5($password);
    $customer->save();
    $username=$paypal_data->email;
    $sql= "Select entity_id from ".$tableName." where email='".$paypal_data->email."' limit 1";
    $rows= $connection->fetchAll($sql);
    $customer_id=$rows[0]['entity_id'];
  }
  
  file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?is_from=7&siteUid=".$customer_id."&is_new=".$is_new."&member_id=".$paypal_data->member_id."&siteid=".Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid')."&action=notifycs");
  Mage::getModel('core/session', array('name' => 'frontend'));
  $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
  $customer->loadByEmail($username);
  $customer->setCustomerActivated(true);
  $customer->setData('password',$password);
  $customer->save();             
  if($is_new=='1' && Mage::getStoreConfig('socialloginsharing_options/displaysettings/socialloginregemail')=='1')
  {
    $customer->sendNewAccountEmail();
     
  }
 
 
  $redirect_location=($_GET['lc']=='c')?Mage::getBaseUrl()."checkout/onepage/":Mage::getBaseUrl()."customer/account/";
  $is_from='7';
  Mage::getSingleton('core/session')->setSessionVariable($is_from);
  ?>
  <script type="text/javascript">
  setTimeout(function(){ window.location.href="<?php echo $redirect_location; ?>"; },1000);
  </script>
  <?php
    //echo"<img src='https://www.socleversocial.com/dashboard/images/pw.gif' alt='wait!' title='wait!'>";  
   $this->getSession()->loginById($customer->getId());
   exit;
}


public function cs_redirect($red)
{
    echo $red;
    exit;
 }   
public function yahoologinAction()
{
    require 'openid.php';
 
try
{
   
    
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
     
    
    if(!$openid->mode)
    {
         
        //do the login
        if(isset($_GET['login']))
        {
            //The google openid url
            $openid->identity = 'https://me.yahoo.com';
             
            //Get additional google account information about the user , name , email , country
            $openid->required = array('contact/email','person/guid','dob','birthDate','namePerson' , 'person/gender' , 'pref/language' , 'media/image/default','birthDate/birthday');
             
            //start discovery
            
            
            header('Location: ' . $openid->authUrl());
        }
        
         
    }
     
    else if($openid->mode == 'cancel')
    {
        echo 'User has canceled authentication!';
        //redirect back to login page ??
    }
     
    //Echo login information by default
    else
    {
        if($openid->validate())
        {
            $is_from='5';
             Mage::getSingleton('core/session')->setSessionVariable($is_from);
            $d = $openid->getAttributes();
            //echo "https://www.socleversocial.com/dashboard/track_register_new.php?is_yh=1&is_from=5&siteid=".Mage::getStoreConfig('socialloginsharing_options_options/apisettings/scsl_siteid')."&other=".json_encode($d)."";
            /*$response_content=file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?is_yh=1&is_from=5&siteid=".Mage::getStoreConfig('socialloginsharing_options_options/apisettings/scsl_siteid')."&other=".json_encode($d)."");
            if($response_content)
            {
              $response_final=json_decode($response_content);
              print_r($response_final);
              exit;
            }*/
            ?>
            <script src="//ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js"></script>
            <script type="text/javascript">
            var xmlhttp;
        if(window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        function track_info_yh(info)
        {
             xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        var gobj=JSON.parse(xmlhttp.responseText);                          
                            var login_src='5';
            
            var request = new Ajax.Request("<?php echo Mage::getBaseUrl();?>soclever_socialloginsharing/index/login",
		    	  {
				    method: 'post',
				    parameters: {member_id: gobj.member_id, email:gobj.email,first_name:gobj.first_name,last_name:gobj.last_name,site_id:<?php echo Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid'); ?>,is_from:login_src},
				    onSuccess: function(transport){
				        if(transport.responseText)
                        {
                        
                            if(opener.document.URL.indexOf('checkout') > -1)
                            {
                                opener.location.href="<?php echo Mage::getBaseUrl();?>checkout/onepage/";
                                close();
                                
                            }
                            else
                            {
                                opener.location.href="<?php echo Mage::getBaseUrl();?>customer/account/";
                                close();
                                
                            }
                        }
                        
				    }
		    	  });
            
                            
    
    }
  }
xmlhttp.open("GET",'https://www.socleversocial.com/dashboard/track_register_new.php?is_yh=1&is_from=5&siteid=<?php echo Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid'); ?>&other='+encodeURIComponent(info),true);
xmlhttp.send();

        }
            track_info_yh('<?php echo json_encode($d); ?>');
            </script>
            
            
            <?php
            exit;
            
        
        }
        else
        {
            //user is not logged in
        }
    }
}
 
catch(ErrorException $e)
{
    echo $e->getMessage();
}
    
}    
public function loginAction()
{
    
  $resource   = Mage::getSingleton('core/resource');
  $tableName  = $resource->getTableName('customer_entity');
  $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
  $sql        = "Select entity_id from ".$tableName." where email='{$_POST['email']}' limit 1";
  $rows        =$connection->fetchAll($sql);
  
$customer = Mage::getModel("customer/customer");
  if(count($rows) > 0)
  {
    $is_new='0';
    $username=$_POST['email'];  
    $customer_id=$rows[0]['entity_id'];
  }
  else
  {
    $is_new='1';
    $store = Mage::app()->getStore();
    
    $customer->website_id = $websiteId;
    $customer->setStore($store);       
    $password=rand("111111","9999999");
    $customer->firstname = $_POST['first_name'];
    $customer->lastname = $_POST['last_name'];
    $customer->email = $_POST['email'];
    $customer->password_hash = md5($password);
    $customer->save();
    $username=$_POST['email'];
    $sql        = "Select entity_id from ".$tableName." where email='{$_POST['email']}' limit 1";
  $rows= $connection->fetchAll($sql);
  $customer_id=$rows[0]['entity_id'];
  }
  
  file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?is_from=".$_POST['is_from']."&siteUid=".$customer_id."&is_new=".$is_new."&member_id=".$_POST['member_id']."&siteid=".$_POST['site_id']."&action=notifycs");
  
  Mage::getModel('core/session', array('name' => 'frontend'));
  $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
  $customer->loadByEmail($username);
  $customer->setCustomerActivated(true);
  $customer->setData('password',$password);
  $customer->save();              
   if($is_new=='1' && Mage::getStoreConfig('socialloginsharing_options/displaysettings/socialloginregemail')=='1')
  {
    $customer->sendNewAccountEmail();
     
  }

  $this->getSession()->loginById($customer->getId());
  
  if(Mage::getSingleton('customer/session')->isLoggedIn())
  {
    $is_from=$_POST['is_from'];
  Mage::getSingleton('core/session')->setSessionVariable($is_from);
    exit("1");
  }
  
  
  
}
	
}
?>