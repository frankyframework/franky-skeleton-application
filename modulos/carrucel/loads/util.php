<?php

function _gcarrucel($txt)
{
    return dgettext("carrucel",$txt);
}


function carrucel_getFotoGaleria($id,$id_carrucel,$foto,$url)
{
    global $MyAccessList;
    global $MyConfigure;
    
    $html = "";
    $html .= "<div class='_cont_img_carrousel img_foto_clientes foto_$id' id='foto_$id'>"
            . "<div class='_img_slider_panel'>".  makeHTMLImg(imageResize($MyConfigure->getUploadDir()."/carruceles/$id_carrucel/$foto",220,220,true), "100%", "", $url)."</div>"
            . "<div class='_controls'><div><a href=\"javascript:void(0);\" onclick=\"carrucel_eliminarFoto($id)\"><i class='icon icon-r-eliminar'></i></a></div>"
            . "<div><a href=\"javascript:void(0);\" onclick=\"carrucel_promptEditarFoto('URL:','Editar foto','$id' )\"><i class='icon icon-editar'></i></a></div></div>"
            . "<p class='txt_gal_description label_url_foto_$id'>$url</p>" 
            . "</div>";
    return $html;
}



function getCarrucel($clave)
{
   
    global $MyConfigure;
    global $MyFrankyMonster;
    global $MyMetatag;
    global $MyRequest;

    $uiCommand = $MyFrankyMonster->getUiCommand($MyFrankyMonster->MySeccion());
  
    if (is_array($uiCommand[3])) {
        if (!in_array('slick',$uiCommand[3])) 
        {
            $MyMetatag->setJs("/public/jquery/slick/js/slick.min.js");
            $MyMetatag->setCss("/public/jquery/slick/css/slick-theme.css");
            $MyMetatag->setCss("/public/jquery/slick/css/slick.css");
        }     
    }
    else{
        $MyMetatag->setJs("/public/jquery/slick/js/slick.min.js");
        $MyMetatag->setCss("/public/jquery/slick/css/slick-theme.css");
        $MyMetatag->setCss("/public/jquery/slick/css/slick.css");
    }
      

    $CarrucelcarrucelesModel = new Carrucel\model\CarrucelcarrucelesModel();
    $CarrucelcarrucelesEntity = new Carrucel\entity\CarrucelcarrucelesEntity();
    $Tokenizer = new \Franky\Haxor\Tokenizer;
    $CarrucelcarrucelesEntity->status(1);
    $CarrucelcarrucelesEntity->code($clave);
    $result	 = $CarrucelcarrucelesModel->getData($CarrucelcarrucelesEntity->getArrayCopy());
    
    if($result == REGISTRO_SUCCESS){
        
        $carrucel = $CarrucelcarrucelesModel->getRows();
        
        $CarrucelfotosModel = new Carrucel\model\CarrucelfotosModel();
        $CarrucelfotosEntity = new Carrucel\entity\CarrucelfotosEntity();
        $CarrucelfotosEntity->id_carrucel($carrucel['id']);
        $CarrucelfotosEntity->status(1);
        $CarrucelfotosModel->setTampag('100');
        $CarrucelfotosModel->setOrdensql('orden ASC');
        $CarrucelfotosModel->getData($CarrucelfotosEntity->getArrayCopy());

        if($CarrucelfotosModel->getTotal() > 0)
        {
            while($registro = $CarrucelfotosModel->getRows())
            {
                

                $registro['foto'] = $MyConfigure->getUploadDir()."/carruceles/".$carrucel["id"].'/'.$registro['foto'];


                
                $resultados_pagina[] = $registro;
            }  
            
            return render(PROJECT_DIR.'/modulos/carrucel/diseno/widget.carrucel.phtml',['resultados_pagina' => $resultados_pagina,'carrucel'=>$carrucel]);
        }
      
        
    }
    return  '';
}



?>