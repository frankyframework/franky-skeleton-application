function AgregarCalificacionBlog(id,calificacion)
{
     var var_query = {
          "function": "AgregarCalificacionBlog",
          "vars_ajax":[id,calificacion]
    };
   
    pasarelaAjax('GET',var_query,"AgregarCalificacionBlogHTML",'');
}


function AgregarCalificacionBlogHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);
        if(respuesta[0]["messageErr"])
        {
            $('.define_rating').html("<div class='MsgErr'>"+respuesta[0]["messageErr"]+"</div>");
        }
        if(respuesta[0]["messageSas"])
        {
           $('.define_rating').html("<div class='MsgSas'>"+respuesta[0]["messageSas"]+"</div>"); 
        }
       
    }
    return true;
}
