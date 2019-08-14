<?php
class Soclever_Socialloginsharing_Block_Adminhtml_System_Config_Form_Field_Customopt1toggle extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /**
     * Get element ID of the dependent field to toggle
     *
     * @param object $element
     * @return String
     */
    protected function _getToggleElementId($element)
    {
        return substr($element->getId(), 0, strrpos($element->getId(), 'mbcustomopt1')) . 'mbcustomopt2';
    }
    /**
     * Get element ID of the dependent field's parent row
     *
     * @param object $element
     * @return String
     */
    protected function _getToggleRowElementId($element)
    {
        return 'row_'.$this->_getToggleElementId($element);
    }
    /**
     * Override method to output our custom HTML with JavaScript
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
       
        // Get the default HTML for this option
        $html = parent::_getElementHtml($element);
        // Set up additional JavaScript for our toggle action. Note we are using the two helper methods above
        // to get the correct field ID's. They are hard-coded and depend on your option names in system.xml
        $javaScript = "
            <script type=\"text/javascript\">
                Event.observe(window, 'load', function() {
                    enabled=document.getElementById('socialloginsharing_options_displaysettingshare_yourstyle').value;
                    if (enabled=='custom') {
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylefb').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylegp').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylepi').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylewa').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylesu').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyleli').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylerd').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletw').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletm').show();
                    } else {
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylefb').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylegp').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylepi').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylewa').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylesu').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyleli').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylerd').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletw').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletm').hide();
                    }
                    enabledlogin=document.getElementById('socialloginsharing_options_displaysettings_buttonstyle').value;
                    if (enabledlogin=='custom') {
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylefb').show();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylegp').show();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleli').show();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyletw').show();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleyh').show();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylepp').show();
                    } else {
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylefb').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylegp').hide();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleli').hide();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyletw').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleyh').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylepp').hide();
                    }
                });
                Event.observe('socialloginsharing_options_displaysettingshare_yourstyle', 'change', function(){
                    enabled=document.getElementById('socialloginsharing_options_displaysettingshare_yourstyle').value;                    
                    if (enabled=='custom') {
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylefb').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylegp').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylepi').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylewa').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylesu').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyleli').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylerd').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletw').show();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletm').show();
                    } else {
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylefb').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylegp').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylepi').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylewa').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylesu').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyleli').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstylerd').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletw').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettingshare_yourstyletm').hide();
                    }
                });
                Event.observe('socialloginsharing_options_displaysettings_buttonstyle', 'change', function(){
                    enabledlogin=document.getElementById('socialloginsharing_options_displaysettings_buttonstyle').value;                    
                    if (enabledlogin=='custom') {
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylefb').show();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylegp').show();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleli').show();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyletw').show();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleyh').show();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylepp').show();
                    } else {
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylefb').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylegp').hide();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleli').hide();                        
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyletw').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstyleyh').hide();
                        document.getElementById('row_socialloginsharing_options_displaysettings_buttonstylepp').hide();
                    }
                });
            </script>";

        $html .= $javaScript;
        return $html;
    }
}

?>