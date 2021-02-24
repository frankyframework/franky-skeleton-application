<?php

function _sliders($txt)
{
    return dgettext("sliders",$txt);
}


function getSlider($code)
{
    global $MyConfigure;
    global $MyFrankyMonster;
    global $MyMetatag;

    $plugins = $MyFrankyMonster->MyJQueyfile();
    
  
    if (is_array($plugins)) {
        if (!in_array('flexslider',$plugins)) 
        {
            $MyMetatag->setJs("/public/jquery/flexslider/js/jquery.flexslider.min.js");
            $MyMetatag->setCss("/public/jquery/flexslider/css/flexslider.css");
        }     
    }
    else{
        $MyMetatag->setJs("/public/jquery/flexslider/js/jquery.flexslider.min.js");
        $MyMetatag->setCss("/public/jquery/flexslider/css/flexslider.css");
    }
      


    $SlidersModel = new \Sliders\model\SlidersModel();
    $SlidersEntity = new \Sliders\entity\SlidersEntity();
    $SlidersitemsModel = new \Sliders\model\SlidersitemsModel();
    $SlidersitemsEntity = new \Sliders\entity\SlidersitemsEntity();
    $SlidersitemsEntity->status(1);
    $SlidersEntity->status(1);
    $SlidersEntity->code($code);
    $result	 = $SlidersModel->getData($SlidersEntity->getArrayCopy());
    
    if($result == REGISTRO_SUCCESS){
        
        $slider = $SlidersModel->getRows();
        
        $SlidersitemsModel->setTampag(20);
        $SlidersitemsModel->setOrdensql("orden ASC");
        $SlidersitemsEntity->id_slider($slider['id']);
        $SlidersitemsModel->getData($SlidersitemsEntity->getArrayCopy());



        if($SlidersitemsModel->getTotal() > 0)
        {
            while($registro = $SlidersitemsModel->getRows())
            {
                $slider['items'][] = $registro;
            }  
            
            return render(PROJECT_DIR.'/modulos/sliders/diseno/slider.phtml',['slider' => $slider,'MyConfigure' => $MyConfigure]);
        }
      
        
    }
    return  '';
}
?>