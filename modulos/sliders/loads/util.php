<?php

function _sliders($txt)
{
    return dgettext("sliders",$txt);
}


function getSlider($code)
{
    global $MyConfigure;
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