<?php

function _galeria($txt)
{
    return dgettext("galeria",$txt);
}


function getFotoGaleria($id,$album,$foto,$descripcion,$fecha,$admin,$count_img)
{
    global $MyAccessList;
    global $MyConfigure;
    
    $html = "";
    $html .= "<div class='w-xxxx-2 w-xxx-3 w-xx-4 w-x-4 align_center img_foto_clientes foto_$id' id='foto_$id'>"
            .($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA) && $admin == 1 ? "<div><a href=\"javascript:void(0);\" onclick=\"eliminarFotoGaleria($id)\"><i class='icon icon-r-eliminar'></i></a></div>" : "")
            .($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA) && $admin == 1 ? "<div><a href=\"javascript:void(0);\" onclick=\"promptEditarFoto('Nombre de la foto:','Editar foto',$id )\"><i class='icon icon-editar'></i></a></div>": "")
            . "<div>".($admin == 0 ? "<a href=\"#gid=1&amp;pid=$count_img\" rel='galeria' title=\"$descripcion\">" : "").  makeHTMLImg(imageResize($MyConfigure->getUploadDir()."/galeria/$album/$foto",220,220,true), "100%", "", $descripcion).($admin == 0 ? "</a>" : "")."</div>"
            . "<p class='txt_gal_description label_descripcion_foto_$id'>$descripcion</p>" 
            . "</div>";
    return $html;
}



function getAlbumGaleria($id,$nombre,$fecha,$admin=0)
{
    global $MyAccessList;
    global $MyConfigure;
    global $MyRequest;
    $html = "";
    $html .= "<div class='w-xxxx-2 w-xxx-3 w-xx-4 w-x-4 align_center img_foto_clientes album_$id' id='album_$id'>"
            .($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA) && $admin == 1 ? "<div><a href=\"javascript:void(0);\" onclick=\"eliminarAlbumGaleria('$id')\"><i class='icon icon-r-eliminar'></i></a></div>" : "")
            .($MyAccessList->MeDasChancePasar(ADMINISTRAR_GALERIA) && $admin == 1 ? "<div><a href=\"javascript:void(0);\" onclick=\"promptEditarAlbum('Nombre del album:','Editar album',$id )\"><i class='icon icon-editar'></i></a></div>": "")
            . "<div><a href=\"".($admin == 1 ? $MyRequest->link(ADMIN_FOTOS_GALERIA."?album=".$id) : $MyRequest->url(GALERIA_DETALLE,array("album" => $id)))."\"  title=\"$nombre\">[__FOLDER___]/</a></div>"
            . "<p class='txt_gal_clientes label_nombre_album_$id'>$nombre</p>"
            . "</div>";
    return $html;
}
?>