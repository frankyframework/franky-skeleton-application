
function catalog_addWhishlist(id,status)
{

     var var_query = {
          "function": "catalog_addWhishlist",
          "vars_ajax":[id,status]
    };

    var var_function = [id,status];

    pasarelaAjax('GET',var_query,"catalog_addWhishlistHTML",var_function);
}

function catalog_addWhishlistHTML(response,id, status)
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
          $('[data-idlove='+id+']').addClass('active');
      }
      else{
          $('[data-idlove='+id+']').removeClass('active');
      }
    }
}


function catalog_getWhishlist()
{

     var var_query = {
          "function": "catalog_getWhishlist",
          "vars_ajax":[]
    };

    var var_function = [];

    pasarelaAjax('GET',var_query,"catalog_getWhishlistHTML",var_function);
}

function catalog_getWhishlistHTML(response)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);

        for(var i=0;i<respuesta.length;i++)
        {
          $('[data-idlove='+respuesta[i]+']').addClass('active');
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
