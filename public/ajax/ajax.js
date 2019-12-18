function peticion_ajax(method,query,funcion,function_vars,area_loader)
{
    var rand_id = Math.random().toString(36).substring(7);
    console.log(area_loader);
    $.ajax({
            type: method.toUpperCase(),
            url: "public/ajax/ajax.php",
            data: query,
            cache: false,
            beforeSend: function(){
              if(area_loader != null)
              {

                  if(area_loader == 'body')
                  {
                       var loader = $('<div id="preloaderfullpage'+rand_id+'" style="position: '+(area_loader == 'body' ? 'fixed' :'absolute')+';top:0;left:0;right:0; bottom:0;z-index: 100;">\
                       <div style="'+window.loaderStyle+'">&nbsp;</div>\
                        </div>');
                        $(area_loader).prepend(loader);

                        $(area_loader).css({'overflow':'hidden'});
                       
                  }
                  else
                  {
                       var loader = $('<div id="preloaderfullpage'+rand_id+'" style="'+window.loaderStyle.replace('absolute','relative')+'">&nbsp;</div>');

                        $(area_loader).prepend(loader);


                  }




              }

            },
            success: function(response){


              var args = new Array(response);
              for (var i = 0; i < function_vars.length; i++)
              {
                    args.push(function_vars[i]);
              }



                if($('#preloaderfullpage'+rand_id))
                {
                  $('#preloaderfullpage'+rand_id).fadeOut('slow',function(){
                        $(this).remove();
                        $(area_loader).css({'overflow':'visible'});
                    });

                }
                  window[funcion].apply(this, args);
            },
            error: function(){
              if($('#preloaderfullpage'+rand_id))
              {
                $('#preloaderfullpage'+rand_id).fadeOut('slow',function(){
                    $(this).remove();
                    $(area_loader).css({'overflow':'visible'});
                });

              }
        //      _alert("Error de peticion AJAX","Error");
            }
    });

    return true;
}


function pasarelaAjax(method,var_query,funcion,function_vars,area_loader)
{


    if(typeof area_loader ==  'undefined')
    {
        area_loader = "body";
    }

    var query = 'function='+var_query.function;
    if(var_query.vars_ajax)
    {
        for(var x = 0; x < var_query.vars_ajax.length; x++)
        {
            query += "&vars_ajax[]="+var_query.vars_ajax[x];
        }
    }

    peticion_ajax(method,var_query,funcion,function_vars,area_loader);
}
