promptEditarAlbum = function(msg,title,id)
{
    var now = $.now();
   
    var prompt = $('<div id="dialog-confirm'+now+'" title="'+title+'">\
    <p>'+msg+'</p>\
    <div><textarea name="input_nombre_album" rows="2" cols="15">'+$(".label_nombre_album_"+id).text()+'</textarea></div>\
    </div>');

    $(function() {
        $( prompt ).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {
                Guardar: function() {
                    
                    var txt = prompt.children("div").children("textarea").val();
                    editarAlbumGaleria(id,txt);
                    $(".label_nombre_album_"+id).html(txt)
                     $( this ).dialog( "close" );
                },
                Cancelar: function() {
                   
                     $( this ).dialog( "close" );
                } 
            }
        });
    });
}

promptEditarFoto = function(msg,title,id)
{
    var now = $.now();
   
    var prompt = $('<div id="dialog-confirm'+now+'" title="'+title+'">\
    <p>'+msg+'</p>\
    <div><textarea name="input_descripcion_foto" rows="2" cols="15">'+$(".label_descripcion_foto_"+id).text()+'</textarea></div>\
    </div>');

    $(function() {
        $( prompt ).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {
                Guardar: function() {
                    
                    var txt = prompt.children("div").children("textarea").val();
                    editarFotoGaleria(id,txt);
                    $(".label_descripcion_foto_"+id).html(txt)
                     $( this ).dialog( "close" );
                },
                Cancelar: function() {
                   
                     $( this ).dialog( "close" );
                } 
            }
        });
    });
}

function setOrdenFotoGaleria(album,orden)
{
    var var_query = {
          "function": "setOrdenFotoGaleria",
          "vars_ajax":[album,orden]
        };
    
    pasarelaAjax('GET', var_query, "setOrdenGaleriaHTML", '');
}


function setOrdenAlbumGaleria(orden)
{
    var var_query = {
          "function": "setOrdenAlbumGaleria",
          "vars_ajax":[orden]
        };
    
    pasarelaAjax('GET', var_query, "setOrdenGaleriaHTML", '');
}

function setOrdenGaleriaHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);
       
    }

    return true;
}





function ShowFotosGaleria(album)
{
     var var_query = {
          function: "ShowFotosGaleria",vars_ajax:[album]
        };
    
    pasarelaAjax('GET', var_query, "ShowFotosGaleriaHTML", '');
    
}

function ShowFotosGaleriaHTML(response)
{
    var respuesta = null;
    
    if(response != "null")
    {
       
        respuesta = JSON.parse(response);
        $("#cont_fotos").html(respuesta["html"]);
        $(".no_hay_datos").hide();
        
    }

} 

function guardarAlbumGaleria()
{
     var var_query = {
          function: "guardarAlbumGaleria",vars_ajax: [$("input[name=nombre_album]").val()]
        };
    
    pasarelaAjax('GET', var_query, "guardarAlbumGaleriaHTML", '');
    
}

function guardarAlbumGaleriaHTML(response)
{
    var respuesta = null;
    
    if(response != "null")
    {
        respuesta = JSON.parse(response);
        if(respuesta.message != "success")
        {
            _alert(respuesta.message,"")
            return false;
        }
        respuesta = JSON.parse(response);
        $("#contenedor_albumes").prepend(respuesta["html"]);
        $(".no_hay_datos, .contenedor_form_album").hide();
        $("input[name=nombre_album]").val('');
        
    }
   

} 



function editarFotoGaleria(id,txt)
{
    var var_query = {
          "function": "editarFotoGaleria",
          "vars_ajax":[id,txt]
        };
    var var_function = [id];
    
    pasarelaAjax('POST', var_query, "editarFotoGaleriaHTML",var_function);
    
    
}

function editarFotoGaleriaHTML(response,id)
{
    var respuesta = null;
    
    if(response != "null")
    {
        respuesta = JSON.parse(response);
        
        if(respuesta[0]["message"] == "success")
        {
 
        }
        else
        {
             _alert(respuesta[0]["message"],"Error")
        }
        
    }
} 



function editarAlbumGaleria(id,txt)
{
    var var_query = {
          "function": "editarAlbumGaleria",
          "vars_ajax":[id,txt]
        };
    var var_function = [id];
    
    pasarelaAjax('POST', var_query, "editarAlbumGaleriaHTML",var_function);
    
    
}

function editarAlbumGaleriaHTML(response,id)
{
    var respuesta = null;
    
    if(response != "null")
    {
        respuesta = JSON.parse(response);
        
        if(respuesta["message"] == "success")
        {
            
        }
        else
        {
             _alert(respuesta["message"],"Error")
        }
        
    }
} 


function eliminarFotoGaleria(id)
{
    EliminarRegistro("eliminarFotoGaleria",id,0,'¿Realmente quiere eliminar esta foto?',"eliminarFotoGaleriaHTML"); 

    
}

function eliminarFotoGaleriaHTML(response,id)
{
    var respuesta = null;
    
    if(response != "null")
    {
        respuesta = JSON.parse(response);
        
        if(respuesta[0]["message"] == "success")
        {
         
            $(".foto_"+id).fadeOut(500,function(){
                $(".foto_"+id).remove();
            });
        }
        else
        {
             _alert(respuesta[0]["message"],"Error")
        }
        
    }
} 


function eliminarAlbumGaleria(id)
{
    EliminarRegistro("eliminarAlbumGaleria",id,0,'¿Realmente quiere eliminar este album?',"eliminarAlbumGaleriaHTML"); 
}

function eliminarAlbumGaleriaHTML(response,id)
{
    var respuesta = null;
    
    if(response != "null")
    {
        respuesta = JSON.parse(response);
        
        if(respuesta[0]["message"] == "success")
        {
         
            $(".album_"+id).fadeOut(500,function(){
                $(".album_"+id).remove();
            });
        }
        else
        {
             _alert(respuesta["message"],"Error")
        }
        
    }
} 