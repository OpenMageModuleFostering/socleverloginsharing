<?php
ini_set("display_errors","1");
error_reporting(E_ALL);

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
    
    
    public function twloginAction()
{
$site_id=Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid');
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
if(isset($_POST['submit']) && $_POST['submit']=='Login' )
{
    $this->scsl_general_login($_POST['response_str'],'4',$_POST['email']);
    
    exit;
}


$get_fb=file_get_contents("https://www.socleversocial.com/dashboard/get_fb_data.php?siteid=".Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid')."&is_tw=1");

    $my_Api=explode("~",$get_fb);
    if($my_Api[0]!='0')
    {
       
require('http.php');    
require('oauth_client.php');
$client = new oauth_client_class;
    $client->server = 'Twitter';
    $client->redirect_uri = ''.Mage::getBaseUrl().'soclever_socialloginsharing/index/twlogin';
    
    $client->client_id = $my_Api[0]; 
    $application_line = __LINE__;
    $client->client_secret = $my_Api[1];
    
    

    if(strlen($client->client_id) == 0
    || strlen($client->client_secret) == 0)
        die('twitter failed.');

    /* API permissions
     */
    $client->scope = 'wl.basic wl.emails wl.birthday';
    if(($success = $client->Initialize()))
    {
        if(($success = $client->Process()))
        {
            if(strlen($client->authorization_error))
            {
                $client->error = $client->authorization_error;
                exit($client->error);
                $success = false;
            }
            elseif(strlen($client->access_token))
            {
                $success = $client->CallAPI(
                     'https://api.twitter.com/'. '1.1/account/'. 'verify_credentials.json',
                    'GET', array(), array('FailOnAccessError'=>true), $user);
            }
        }
        $success = $client->Finalize($success);
    }
    if($client->exit)
    {
        exit('82');
    }    
    if($success)
    {
      
        $your_data=json_encode($user);
        $content=json_decode($your_data);
        $twitter_arr=array();
  $twitter_arr['full_name']=$content->name;
  $twitter_arr['profile_id']=$content->id;
  $twitter_arr['screen_name']=$content->screen_name;
  $twitter_arr['location']=$content->location;
  $twitter_arr['description']=$content->description;
  $twitter_arr['following_count']=$content->friends_count;
  $twitter_arr['follower_count']=$content->followers_count;
  $twitter_arr['tweet_count']=$content->statuses_count;
  $twitter_arr['is_verified']=$content->verified;
  $twitter_arr['lang']=$content->lang;
  $twitter_arr['profile_pic']=$content->profile_image_url;
  $twitter_arr['time_zone']=$content->time_zone;
  


        $chk_twitter=file_get_contents("https://www.socleversocial.com/dashboard/track_twitter.php?site_id=".$site_id."&twitter_id=".$twitter_arr['profile_id']."&action=chk_tw");
        //$chk_twitter='1';
        if($chk_twitter=='0')
        {
         ?>
         <style>
         #container_demo{
	 text-align: left;
	 margin: 0;
	 padding: 0;
	 margin: 0 auto;
	 font-family: "Trebuchet MS","Myriad Pro",Arial,sans-serif;
}

#wrapper{
	
	right: 0px;
	height: 400px;	
	margin: 0px auto;	
	
	position: relative;	
}
#wrapper a{
	color: rgb(95, 155, 198);
	text-decoration: underline;
}

#wrapper h1{
	font-size: 48px;
	color: rgb(6, 106, 117);
	padding: 2px 0 10px 0;
	font-family: 'FranchiseRegular','Arial Narrow',Arial,sans-serif;
	font-weight: bold;
	text-align: center;
	padding-bottom: 30px;
}

#wrapper h1{
    background: -webkit-repeating-linear-gradient(-45deg, 
	rgb(18, 83, 93) , 
	rgb(18, 83, 93) 20px, 
	rgb(64, 111, 118) 20px, 
	rgb(64, 111, 118) 40px, 
	rgb(18, 83, 93) 40px);
	-webkit-text-fill-color: transparent;
	-webkit-background-clip: text;
}
#wrapper h1:after{
	content: ' ';
	display: block;
	width: 100%;
	height: 2px;
	margin-top: 10px;
	background: -moz-linear-gradient(left, rgba(147,184,189,0) 0%, rgba(147,184,189,0.8) 20%, rgba(147,184,189,1) 53%, rgba(147,184,189,0.8) 79%, rgba(147,184,189,0) 100%); 
	background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(147,184,189,0)), color-stop(20%,rgba(147,184,189,0.8)), color-stop(53%,rgba(147,184,189,1)), color-stop(79%,rgba(147,184,189,0.8)), color-stop(100%,rgba(147,184,189,0))); 
	background: -webkit-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
	background: -o-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
	background: -ms-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
	background: linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
}

#wrapper p{
	margin-bottom:15px;
}
#wrapper p:first-child{
	margin: 0px;
}
#wrapper label{
	color: rgb(64, 92, 96);
	position: relative;
}

/**** advanced input styling ****/
/* placeholder */
::-webkit-input-placeholder  { 
	color: rgb(190, 188, 188); 
	font-style: italic;
}
input:-moz-placeholder,
textarea:-moz-placeholder{ 
	color: rgb(190, 188, 188);
	font-style: italic;
} 
input {
  outline: none;
}

/* all the input except submit and checkbox */
#wrapper input:not([type="checkbox"]){
	width: 92%;
	margin-top: 4px;
	padding: 10px 5px 10px 32px;	
	border: 1px solid rgb(178, 178, 178);
	-webkit-appearance: textfield;
	-webkit-box-sizing: content-box;
	  -moz-box-sizing : content-box;
	       box-sizing : content-box;
	-webkit-border-radius: 3px;
	   -moz-border-radius: 3px;
	        border-radius: 3px;
	-webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
	   -moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
	        box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
	-webkit-transition: all 0.2s linear;
	   -moz-transition: all 0.2s linear;
	     -o-transition: all 0.2s linear;
	        transition: all 0.2s linear;
}

/*styling both submit buttons */
#wrapper p.button input{
	width: 30%;
	cursor: pointer;	
	background: rgb(61, 157, 179);
	padding: 8px 5px;
	font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;
	color: #fff;
	font-size: 24px;	
	border: 1px solid rgb(28, 108, 122);	
	margin-bottom: 10px;	
	text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
	-webkit-border-radius: 3px;
	   -moz-border-radius: 3px;
	        border-radius: 3px;	
	-webkit-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset,
	        0px 0px 0px 3px rgb(254, 254, 254),
	        0px 5px 3px 3px rgb(210, 210, 210);
	   -moz-box-shadow:0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset,
	        0px 0px 0px 3px rgb(254, 254, 254),
	        0px 5px 3px 3px rgb(210, 210, 210);
	        box-shadow:0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset,
	        0px 0px 0px 3px rgb(254, 254, 254),
	        0px 5px 3px 3px rgb(210, 210, 210);
	-webkit-transition: all 0.2s linear;
	   -moz-transition: all 0.2s linear;
	     -o-transition: all 0.2s linear;
	        transition: all 0.2s linear;
}
#wrapper p.button input:hover{
	background: rgb(74, 179, 198);
}
#wrapper p.button input:active,
#wrapper p.button input:focus{
	background: rgb(40, 137, 154);
	position: relative;
	top: 1px;
	border: 1px solid rgb(12, 76, 87);	
	-webkit-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.2) inset;
	   -moz-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.2) inset;
	        box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.2) inset;
}
p.login.button,
p.signin.button{
	text-align: right;
	margin: 5px 0;
}




#login{
	position: absolute;
	top: 0px;
	width: 88%;	
	padding: 18px 6% 60px 6%;
	margin: 0 0 35px 0;
	background: rgb(247, 247, 247);
	border: 1px solid rgba(147, 184, 189,0.8);
	-webkit-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
	   -moz-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
	        box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),	0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
	-webkit-box-shadow: 5px;
	-moz-border-radius: 5px;
		 border-radius: 5px;
}

#login{
	z-index: 22;
}
#toregister:target ~ #wrapper #register,
#tologin:target ~ #wrapper #login{
	z-index: 22;
	-webkit-animation-name: fadeInLeft;
	-moz-animation-name: fadeInLeft;
	-ms-animation-name: fadeInLeft;
	-o-animation-name: fadeInLeft;
	animation-name: fadeInLeft;
	-webkit-animation-delay: .1s;
	-moz-animation-delay: .1s;
	-o-animation-delay: .1s;
	-ms-animation-delay: .1s;
	animation-delay: .1s;
}

.lt8 #wrapper input{
	padding: 10px 5px 10px 32px;
    width: 92%;
}

         </style>
         
         <div class="container">
            
            <div class="codrops-top">
                <div class="clr"></div>
            </div>
            <section>				
                <div id="container_demo" >                    
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="" autocomplete="on" method="post">
                            <input type="hidden" name="response_str" value="<?php echo stripslashes(implode("~~~",$twitter_arr)); ?>" /> 
                                <h1>You are almost done!</h1> 
                                <p> 
                                    <label for="email" class="uname">Your email</label>
                                    <input id="email" name="email" required="required" type="text" placeholder="mymail@mail.com"/>
                                </p>
                                
                                
                                <p class="login button"> 
                                    <input type="submit" value="Login" name="submit" onclick="return chk_submit_email();"  /> 
								</p>
                                
                            </form>
                        </div>

                        
						
                    </div>
                </div>  
            </section>
        </div>
         <script type="text/javascript">
         
         
         function isvalidemail_form(str){
		
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-zA-Z]{2,6}(?:\.[a-zA-Z]{2})?)$/i	
		return (filter.test(str));
		}	

        function isWhitespace(charToCheck) {
        	var whitespaceChars = " \t\n\r\f";
        	return (whitespaceChars.indexOf(charToCheck) != -1);
        }
        function chk_submit_email()
        {
            var email=document.getElementById('email').value;
            if(!isWhitespace(email))
            {
                if(!isvalidemail_form(email))
                {
                  alert("Please enter valid email address");
                  return false;  
                }
            }
            else
            {
                alert("Please provide your email address.");
                return false;
            }
            
            
        }
            
         </script>
         <?php 
         exit;  
        }
        else
        {
          $this->scsl_general_login(stripslashes(implode("~~~",$twitter_arr)),'4',$chk_twitter);  
        }
        
    }
    
    }
    
    
    
      

}

public function scsl_general_login($response,$is_from,$email)
{
    
    
    $site_id=Mage::getStoreConfig('socialloginsharing_options/apisettings/scsl_siteid');
     if($is_from=='4')
     {
        
      $tw_login=file_get_contents("https://www.socleversocial.com/dashboard/track_twitter.php?action=trk_tw&siteid=".$site_id."&email=".urlencode($email)."&tw_data=".urlencode($response)."");
      if($tw_login)
      {
        $loginl_data=json_decode($tw_login);
    
  $resource = Mage::getSingleton('core/resource');
  $tableName = $resource->getTableName('customer_entity');
  $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
  $sql        = "Select entity_id from ".$tableName." where email='".$loginl_data->email."' limit 1";
  $rows= $connection->fetchAll($sql);
  
$customer = Mage::getModel("customer/customer");
  if(count($rows) > 0)
  {
    $is_new='0';
    $username=$loginl_data->email;  
    $customer_id=$rows[0]['entity_id'];
  }
  else
  {
    $is_new='1';
    $store = Mage::app()->getStore();
    
    $customer->website_id = $websiteId;
    $customer->setStore($store);       
    $password=rand("111111","9999999");
    $customer->firstname = $loginl_data->first_name;
    $customer->lastname = $loginl_data->last_name;
    $customer->email =$loginl_data->email;
    $customer->password_hash = md5($password);
    $customer->save();
    $username=$loginl_data->email;
    $sql= "Select entity_id from ".$tableName." where email='".$loginl_data->email."' limit 1";
    $rows= $connection->fetchAll($sql);
    $customer_id=$rows[0]['entity_id'];
  }
  
  file_get_contents("https://www.socleversocial.com/dashboard/track_register_new.php?is_from=7&siteUid=".$customer_id."&is_new=".$is_new."&member_id=".$loginl_data->member_id."&siteid=".Mage::getStoreConfig('socialloginsc_options/apisettings/scsl_siteid')."&action=notifycs");
  Mage::getModel('core/session', array('name' => 'frontend'));
  $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
  $customer->loadByEmail($username);
  $customer->setCustomerActivated(true);
  $customer->save(); 
  
  if($is_new=='1' && Mage::getStoreConfig('soclever_socialloginsharing/displaysettings/socialloginregemail')=='1')
  {
    $customer->sendNewAccountEmail();
  }             
 
  $redirect_location=($_GET['lc']=='c')?Mage::getBaseUrl()."checkout/onepage/":Mage::getBaseUrl()."customer/account/";
  $is_from='4';
  Mage::getSingleton('core/session')->setSessionVariable($is_from);
  $isIosChrome = (strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false) ? true : false;
  if(!$isIosChrome)
  {
  ?>
  <script type="text/javascript">
  setTimeout(function(){  opener.location.href="<?php echo $redirect_location; ?>";close(); },1000);
  </script>
  <?php
  }
  
    //echo"<img src='https://www.socleversocial.com/dashboard/images/pw.gif' alt='wait!' title='wait!'>";  
   $this->getSession()->loginById($customer->getId());
   
   if(Mage::getSingleton('customer/session')->isLoggedIn() && $isIosChrome)
   {
    ?>
    <script type="text/javascript">
    
    window.location.href="<?php echo $redirect_location; ?>";
    </script>
    <?php
    //header("location:".$redirect_location."");
    
   }
   exit;
      }   
          
      
     }   
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
  
  $isIosChrome = (strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false) ? true : false;
  
   if(!$isIosChrome) { ?>    
  
  <script type="text/javascript">
  
  setTimeout(function(){
    
    
    opener.location.href="<?php echo $redirect_location;?>";
    this.close();
    
    },1000);
  </script>
  <?php
  }
      
    //echo"<img src='https://www.socleversocial.com/dashboard/images/pw.gif' alt='wait!' title='wait!'>";  
   $this->getSession()->loginById($customer->getId());
   
   if(Mage::getSingleton('customer/session')->isLoggedIn() && $isIosChrome)
   {
    ?>
    <script type="text/javascript">
    
    window.location.href="<?php echo $redirect_location; ?>";
    </script>
    <?php
    //header("location:".$redirect_location."");
    
   }      
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
   
    
    $openid = new LightOpenID('eurekadigital.com.au');
     
    
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