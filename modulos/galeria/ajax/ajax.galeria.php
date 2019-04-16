<?php
function eliminarAlbumGaleria($id,$status=0)
{
	
	$MyAlbum = new Galeria\model\albumes();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            if($MyAlbum->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {
		
               $respuesta[] = array("message" => "success");
            }
            else
            {
		$respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}
function eliminarFotoGaleria($id,$status=0)
{
	
	$MyFoto = new Galeria\model\fotos();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            if($MyFoto->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {
		
               $respuesta[] = array("message" => "success");
            }
            else
            {
		$respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}


function editarFotoGaleria($id,$descripcion)
{
	
	$MyFoto = new Galeria\model\fotos();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            if($MyFoto->editCampo(addslashes($id),"descripcion",addslashes($descripcion)) == REGISTRO_SUCCESS)
            {
		
               $respuesta[] = array("message" => "success", "descripcion" => ($descripcion));
            }
            else
            {
		$respuesta[] = array("message" => $MyMessageAlert->Message("editar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}

function editarAlbumGaleria($id,$nombre)
{
	
	$MyAlbum = new Galeria\model\albumes();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        $error = false;
        if($MyAlbum->existeAlbum($nombre,$id) == REGISTRO_SUCCESS)
        {
            $respuesta = array("message" => $MyMessageAlert->Message("galeria_album_duplicado"));
            $error = true;
        }
        if(!$error)
        {
            if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
            {
                if($MyAlbum->edit(addslashes($id),addslashes($nombre),  getFriendly($nombre)) == REGISTRO_SUCCESS)
                {

                   $respuesta = array("message" => "success","nombre" => ($nombre));
                }
                else
                {
                    $respuesta = array("message" => $MyMessageAlert->Message("editar_generico_error"));
                }
            }
            else
            {
                 $respuesta = array("message" => $MyMessageAlert->Message("sin_privilegios"));
            }
        }
	return $respuesta;
}


function ShowFotosGaleria($album)
{
        
	$MyFoto = new Galeria\model\fotos();
        global $MyAccessList;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            
            $MyFoto->setOrdensql("orden ASC");
            $MyFoto->setTampag(2000);
            if($MyFoto->get($album,1) == REGISTRO_SUCCESS)
            {
                $i = 0;
                $html = "";
                while($registro = $MyFoto->getRows())
                {
                    
                    $html .= getFotoGaleria($registro["id"],$album,$registro["foto"],$registro["descripcion"],$registro["fecha"],1,$i);
                    $i++;
                }
                $respuesta["html"] =  $html;
                
               
            }
        }
       
	
	return $respuesta;
}

function guardarAlbumGaleria($nombre)
{
        
	$MyAlbum = new Galeria\model\albumes();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        
        $error = false;
        $rules = array(
                    "Nombre del album" => array("valor" => $nombre,"required","length" => array("max" => "200"))
                    );


        $validaciones =  new Franky\Core\validaciones();
        $valid = $validaciones->validRules($rules);
        if(!$valid)
        {
            
            $respuesta = array("message" => $validaciones->getMsg());
            $error = true;
        }
        
        if($MyAlbum->existeAlbum($nombre) == REGISTRO_SUCCESS)
        {
            $respuesta = array("message" => $MyMessageAlert->Message("galeria_album_duplicado"));
            $error = true;
        }
        
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA) && !$error)
        {
            if($MyAlbum->save(addslashes($nombre),  getFriendly($nombre)) == REGISTRO_SUCCESS)
            {
                $MyAlbum->get($MyAlbum->getUltimoID(),1);
            
		
                $registro = $MyAlbum->getRows();
                
                $html = getAlbumGaleria($registro["id"],$registro["nombre"],$registro["fecha"],1);
                
                $respuesta = array("message" => "success","html" => $html);
            }
            else
            {
		$respuesta = array("message" => $MyMessageAlert->Message("editar_generico_error"));
            }
           
        }
       
	
	return $respuesta;
}



function setOrdenFotoGaleria($album, $orden)
{
	
	$MyFoto = new Galeria\model\fotos();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
           
        
            $orden = explode(",",str_replace("foto_","",$orden));

            


           
            $v = "";
            foreach($orden as $key => $val)
            {
                $v .= ($key)." -> $val,";
                
                $MyFoto->editCampo($val,"orden",$key);
            }
            //echo $v;
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}



function setOrdenAlbumGaleria($orden)
{
	
	$MyAlbum = new Galeria\model\albumes();
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta =null;
        if($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA))
        {
            $orden = explode(",",str_replace("album_","",$orden));

            $v = "";
            foreach($orden as $key => $val)
            {
                $v .= ($key)." -> $val,";

                $MyAlbum->editCampo($val,"orden",$key);
            }
            
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}

/******************************** EJECUTA *************************/

$MyAjax->register("eliminarAlbumGaleria");
$MyAjax->register("eliminarFotoGaleria");
$MyAjax->register("editarFotoGaleria");
$MyAjax->register("editarAlbumGaleria");
$MyAjax->register("ShowFotosGaleria");
$MyAjax->register("guardarAlbumGaleria");
$MyAjax->register("setOrdenFotoGaleria");
$MyAjax->register("setOrdenAlbumGaleria");
?>