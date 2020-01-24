function setOrdenSlidersItems(orden)
{
    var var_query = {
          "function": "setOrdenSlidersItems",
          "vars_ajax":[orden]
        };
    
    pasarelaAjax('GET', var_query, "setOrdenSlidersItemsHTML", '');
}



function setOrdenSlidersItemsHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);
       
    }

    return true;
}
