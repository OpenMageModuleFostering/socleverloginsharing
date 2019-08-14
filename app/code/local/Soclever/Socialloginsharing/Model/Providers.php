<?php

class Soclever_Socialloginsharing_Model_Providers
{
    public function getbuttonstyles()
    {
        $buttonstylesarray=array("ic"=>"Icons","fc"=>"Full Logos - Colored","fg"=>"Full Logos - Grey");       
        return $buttonstylesarray;
        
    }
    public function getsizes()
    {
       
        $buttonsizearray=array("30"=>"30px","40"=>"40px","50"=>"50px","60"=>"60px","65"=>"65px");       
        return $buttonsizearray;
    }
    
    public function getproviders()
    {
        return array(
            array('value'=>0, 'label'=>'None'),
            array('value'=>2, 'label'=>'Facebook'),
            array('value'=>4, 'label'=>'Google+'),
            array('value'=>7, 'label'=>'LinkedIN'),            
            array('value'=>13, 'label'=>'Twitter'),
            array('value'=>17, 'label'=>'Pinterest'),
            array('value'=>18, 'label'=>'Whatsapp'),  
            array('value'=>19, 'label'=>'Stumbleupon'),
            array('value'=>20, 'label'=>'Reddit'),
            array('value'=>21, 'label'=>'Tumblr'),                      
        );
        /*$providers=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest");
        return $providers;*/
    }
    public function getloginproviders()
    {
        return array(
            array('value'=>0, 'label'=>'None'),
            array('value'=>2, 'label'=>'Facebook'),
            array('value'=>4, 'label'=>'Google+'),
            array('value'=>7, 'label'=>'LinkedIN'),            
            array('value'=>15, 'label'=>'Yahoo!'),
            array('value'=>16, 'label'=>'Paypal'),
            array('value'=>8, 'label'=>'Microsoft'),                       
        );
        /*$providers=array("2"=>"Facebook","4"=>"Google+","7"=>"LinkedIN","13"=>"Twitter","17"=>"Pinterest");
        return $providers;*/
    }
    public function getcounters()
    {
        /*return array(
            array('value'=>2, 'label'=>'No Counter'),
            array('value'=>1, 'label'=>'Vertical Counter'),
            array('value'=>0, 'label'=>'Horizontal Counter'),
        );*/
        $countersarray=array("2"=>"No Conter","1"=>"Vertical Counter","0"=>"Horizontal Counter");
        //$countersarray=array("2"=>"No Conter");
        return $countersarray;
    }
    public function getgaps()
    {
        $gaparr=array();
        for($i=0;$i<=20;$i++)
        {
            $gaparr[$i]=$i;
        }
        return $gaparr;
        
    }
    public function geticonsize()
    {
        $iconsize=array();
        $iconsize=array("30x30"=>"30X30","32x32"=>"32X32","40x40"=>"40X40","50x50"=>"50X50","60x60"=>"60X60","70x70"=>"70X70","85x85"=>"85X85","100x100"=>"100X100");
        return $iconsize;
        
    }
    public function displaystyle()
    {
        $displaysize=array();
        $displaysize=array("0"=>"Horizontal","1"=>"Vertical Left","2"=>"Vertical Right");
        return $displaysize;
        
    }
    public function yourstyle()
    {
        $yourstyle=array();
        $yourstyle=array("2"=>'Rounded Corner',"3"=>'Transparent Grey',"4"=>'Rounded Black',"5"=>'Flower',
                        "6"=>'Glossy',"7"=>'Leaf',"8"=>'Polygon',"10"=>'Rectangular',"11"=>'Waterdrop',"custom"=>'Custom');
        return $yourstyle;
        
    }
    public function sharewithautho()
    {
        $sharewithautho=array();
        $sharewithautho=array("0"=>"No","1"=>"Yes");
        return $sharewithautho;
        
    }
    public function showpoweredby()
    {
        $showpoweredby=array();
        $showpoweredby=array("1"=>"Yes","0"=>"No");
        return $showpoweredby;
        
    }
    public function getpreview()
    {
        return array("0"=>"Good");
    }
public function gethelphtml()
    {
        $help_date="<h1>Help..............</h1>";
        return array("0"=>$help_date);
    }

   

}


?>