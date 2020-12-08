

carrucel_promptEditarFoto = function(msg,title,id)
{
    var now = $.now();
   
    var prompt = $('<div id="dialog-confirm'+now+'" title="'+title+'">\
    <p>'+msg+'</p>\
    <div><textarea name="input_descripcion_foto" rows="2" cols="15">'+$(".label_url_foto_"+id).text()+'</textarea></div>\
    </div>');

    $(function() {
        $( prompt ).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {
                Guardar: function() {
                    
                    var txt = prompt.children("div").children("textarea").val();
                    carrucel_editarFoto(id,txt);
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

function carrucel_setOrdenFoto(album,orden)
{
    var var_query = {
          "function": "carrucel_setOrdenFoto",
          "vars_ajax":[album,orden]
        };
    
    pasarelaAjax('GET', var_query, "carrucel_setOrdenHTML", '');
}


function carrucel_setOrdenHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);
       
    }

    return true;
}





function carrucel_ShowFotos(album)
{
     var var_query = {
          function: "carrucel_ShowFotos",vars_ajax:[album]
        };
    
    pasarelaAjax('GET', var_query, "carrucel_ShowFotosHTML", '');
    
}

function carrucel_ShowFotosHTML(response)
{
    var respuesta = null;
    
    if(response != "null")
    {
       
        respuesta = JSON.parse(response);
        $("#cont_fotos").html(respuesta["html"]);
        $(".no_hay_datos").hide();
        
    }

} 






function carrucel_editarFoto(id,txt)
{
    var var_query = {
          "function": "carrucel_editarFoto",
          "vars_ajax":[id,txt]
        };
    var var_function = [id];
    
    pasarelaAjax('POST', var_query, "carrucel_editarFotoHTML",var_function);
    
    
}

function carrucel_editarFotoHTML(response,id)
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




function carrucel_eliminarFoto(id)
{
    EliminarRegistro("carrucel_eliminarFoto",id,0,'¿Realmente quiere eliminar esta foto?',"carrucel_eliminarFotoHTML"); 

    
}

function carrucel_eliminarFotoHTML(response,id)
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

