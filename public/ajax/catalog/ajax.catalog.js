
function catalog_addWishlist(id,status)
{

     var var_query = {
          "function": "catalog_addWishlist",
          "vars_ajax":[id,status]
    };

    var var_function = [id,status];

    pasarelaAjax('GET',var_query,"catalog_addWishlistHTML",var_function);
}

function catalog_addWishlistHTML(response,id, status)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);

        if(respuesta[0] && respuesta[0]["message"] == 'login')
        {
            window.location = respuesta[0]["path"];
        }
        else if(respuesta[0] && respuesta[0]["message"])
        {
            _alert(respuesta[0]["message"],"");
        }
    }
    else
    {
      if(status == 1)
      {
          $('[data-idlove='+id+']').addClass('active').children('span').text('Quitar de favorito');
      }
      else{
          $('[data-idlove='+id+']').removeClass('active').children('span').text('Guardar como favorito');
      }
    }
}


function catalog_getWishlist()
{

     var var_query = {
          "function": "catalog_getWishlist",
          "vars_ajax":[]
    };

    var var_function = [];

    pasarelaAjax('GET',var_query,"catalog_getWishlistHTML",var_function);
}

function catalog_getWishlistHTML(response)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);

        for(var i=0;i<respuesta.length;i++)
        {
          $('[data-idlove='+respuesta[i]+']').addClass('active').children('span').text('Quitar de favorito');
        }
    }
}


function catalog_addProductoCarrito(id,qty)
{
    var caracteristicas = {};
     var var_query = {
          "function": "catalog_addProductoCarrito",
          "vars_ajax":[id,qty,JSON.stringify(caracteristicas)]
    };

    pasarelaAjax('GET',var_query,"addProductoCarritoHTML",[qty]);
}

$(window).load(function(){
    ajax_calificaciones_getPendientesRevisar('administrar_catalog_calificaciones_pendientes','catalog_products','catalog');
});