<?php
class Soclever_Socialloginsharing_Model_Info extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{

   
    public function render(Varien_Data_Form_Element_Abstract $element)
    {

        
        $this->render_module_thanks_message_container();

        
        $this->render_module_info_container();

        
        $this->render_module_help_and_documentations_container();

        
        $this->render_module_support_us_container();

        
    }

    public function render_module_thanks_message_container()
    {
        ?>
        <fieldset>
            <h4><strong><?php echo $this->__('Thank you for installing SoClever Extension!') ?></strong></h4>

            <p>
                <?php echo $this->__('To activate the extension, you will need to first configure it (manage your desired social networks apps, etc.) from your SoCLever account. If you do not have an account, click') ?>
                <a target="_blank" href="https://www.socleversocial.com/"><?php echo $this->__('here') ?></a> <?php echo $this->__('and create one for FREE!') ?>
            </p>
            </br>
            <div style="margin-top:10px">
                <a style="text-decoration:none;margin-right:10px;" href="https://www.socleversocial.com/" target="_blank">
                    <input class="form-button" type="button" value="<?php echo $this->__('Set up my FREE account!') ?>">
                </a>
            </div>
        </fieldset>
    <?php
    }

    public function render_module_info_container()
    {
        ?>
        <fieldset class="ss_admin_configuration_info_fieldsets ss_configuration_info_fieldsets_right" id="ss_extension_info_container">
            <h4 class="ss_admin_fieldset_title"><strong><?php echo $this->__('Extension Information!') ?></strong></h4>

            <div style="margin:5px 0">
                <strong>Version: </strong>1.0.0 <br/>
                <strong>Author:</strong> Soclever<br/>
                <strong>Website:</strong> <a href="https://www.socleversocial.com" target="_blank">www.socleversocial.com</a>
                <br/>

                <div id="sociallogin_get_update" style="float:left;">To receive updates on new features and releases, Please follow us on one of our social media pages
                </div>
                <div id="ss_media_pages_container">
                    <a target="_blank" href="https://www.facebook.com/socleversocial"><img
                            src="https://www.socleversocial.com/dashboard/img/social_icon/30x30/30x30_facebook.png"></a>
                    <a target="_blank" href="http://twitter.com/socleversocial"><img
                            src="https://www.socleversocial.com/dashboard/img/social_icon/30x30/30x30_twitter.png"></a>
                    <a target="_blank" href="https://plus.google.com/u/4/b/100077356381531929431"> <img
                            src="https://www.socleversocial.com/dashboard/img/social_icon/30x30/30x30_google_plus.png"></a>
                    <a target="_blank" href="http://www.linkedin.com/company/soclever"> <img
                            src="https://www.socleversocial.com/dashboard/img/social_icon/30x30/30x30_linkedin.png"></a>
                </div>
            </div>
        </fieldset>
    <?php
    }

    public function render_module_help_and_documentations_container()
    {
        ?>
        <fieldset class="ss_admin_configuration_info_fieldsets ss_configuration_info_fieldsets_left" id="ss_extension_help_container">
            <h4 class="ss_admin_fieldset_title"><strong><?php echo $this->__('Help & Documentations') ?></strong></h4>
            <ul style="float:left; margin-right:43px">
                <li><a target="_blank" href="http://developers.socleversocial.com/magento-social-login-extension/">Extension Installation and Configuration</a></li>
                <li><a target="_blank" href="http://developers.socleversocial.com/how-to-get-api-key-and-secret/">How to get SoClever API Key &amp; Secret</a></li>
                <li><a target="_blank" href="http://developers.socleversocial.com/category/social-network-set-up/">How to create Social Network Apps</a></li>
                <li><a target="_blank" href="https://www.socleversocial.com/">SoClever Products</a></li>
            </ul>
            <ul style="float:left; margin-right:43px">
                <li><a target="_blank" href="http://developers.socleversocial.com/">Developer Forum</a></li>
                <li><a target="_blank" href="https://www.socleversocial.com/about-us/">About SoCleverSocial</a></li>
                <li><a target="_blank" href="http://developers.socleversocial.com/category/cms-plugins/">Social Plugins</a></li>
            </ul>
        </fieldset>
    <?php
    }

    public function render_module_support_us_container()
    {
        ?>
        <fieldset class="ss_admin_configuration_info_fieldsets ss_configuration_info_fieldsets_right" id="ss_extension_support_container">
            <h4 class="ss_admin_fieldset_title"><strong><?php echo $this->__('Support') ?></strong></h4>

            <p>
                <?php echo $this->__('<a target="_blank" href="https://www.socleversocial.com/contact-us/">Click Here</a>') ?> to contact us. You can also email our support team at 
                <a href="mailto:info@socleversocial.com">info@socleversocial.com</a> </p>
        </fieldset>
        <div style='clear:both'></div>
        
       
    <?php
    }
    }
    ?>