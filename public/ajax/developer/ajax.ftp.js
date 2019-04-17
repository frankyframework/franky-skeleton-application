function connect()
{
    var var_query = {
                        function: "changeDir",
                        vars_ajax:[]
                    };
    pasarelaAjax('POST',var_query,"connectHTML",var_query.vars_ajax);
    return true;
}

function changeDir(path)
{
    var var_query = {
                        function: "changeDir",
                        vars_ajax:[path]
                    };
    pasarelaAjax('POST',var_query,"connectHTML",var_query.vars_ajax);
    return true;
}

function renameFile(path,name)
{
    var newname = prompt("¿Cuál es el nuevo nobre de archivo?", name);

    if (newname != null)
    {
      if(newname != name)
      {

            var var_query = {
                            function: "renameFile",
                            vars_ajax:[path+"/"+name,path+"/"+newname]
                        };

            pasarelaAjax('POST',var_query,"simpleResponseFTPHTML",var_query.vars_ajax);


            changeDir(path)
        }
        if(newname.length == 0) {
            _alert("No has ingresado un nombre");
        }
    }
    return true;
}

function nuevaCarpeta(path)
{
    var newname = prompt("¿Cuál es el nuevo nobre de archivo?", "");

    if (newname != null)
    {
        var var_query = {
                        function: "nuevaCarpeta",
                        vars_ajax:[path+"/"+newname]
                    };

        pasarelaAjax('POST',var_query,"simpleResponseFTPHTML",var_query.vars_ajax);

         changeDir(path);
    }


    return true;
}


function eliminarCarpeta(path,name)
{
    var respuesta = confirm("¿Estas seguro de eliminar esta carpeta y todo su contenido?", "");

    if(respuesta)
    {

        var data = $.ajax({
        url: '/public/ajax/ajax.php?function=getAllFiles&vars_ajax[]='+path+"/"+name,
        dataType: "json",
        async: false
        }).responseText;


        data = JSON.parse(data);
        if(data['file'])
        {
            for(var i = data['file'].length-1; i >= 0; i--)
            {
                $.ajax({
                url: '/public/ajax/ajax.php?function=eliminarArchivo&vars_ajax[]='+data['file'][i],
                dataType: "json",
                async: false
                }).responseText;

            }
        }

        for(var i = data['dir'].length-1; i >= 0; i--)
        {
            $.ajax({
                url: '/public/ajax/ajax.php?function=eliminarCarpeta&vars_ajax[]='+data['dir'][i],
                dataType: "json",
                async: false
                }).responseText;
        }


        changeDir(path);
    }

    return true;
}


function eliminarArchivo(path,name)
{
    var respuesta = confirm("¿Estas seguro de eliminar este archivo?", "");

    if(respuesta)
    {
        var var_query = {
                        function: "eliminarArchivo",
                        vars_ajax:[path+"/"+name]
                    };

        pasarelaAjax('POST',var_query,"simpleResponseFTPHTML",var_query.vars_ajax);

        changeDir(path);
    }

    return true;
}


function descargarCarpeta(path,name)
{

    return true;
}
function descargarArchivo(path,name)
{
    var var_query = {
                            function: "descargarArchivo",
                            vars_ajax:[path+"/"+name]
                        };

    pasarelaAjax('POST',var_query,"simpleResponseFTPHTML",var_query.vars_ajax);


}

function simpleResponseFTPHTML(response)
{
    if (response != "null")
    {
        var respuesta = JSON.parse(response);

        if(respuesta.dowload)
        {
            window.open("/admin/ftp/descargar.php?file="+respuesta['dowload']);
        }
    }
}

function connectHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {

        var html_button_ftp = '<div class="w-xxxx-4  w-xxx-4 w-xx-4 w-x-4"><i class="icon icon-c-editar"></i> <i class="icon icon-descargar"></i>  <i class="icon icon-r-eliminar"></i></div>';

        respuesta = JSON.parse(response);

        if(respuesta['connect'] == true)
        {
            $("#status_ftp").html("Conectado");


            if(respuesta['pwd_remoto'])
            {
                $("#path_ftp").html(respuesta['pwd_remoto']);
            }

            if(respuesta['ls_remoto'])
            {
                $("#contenedor_archivos_remotos").empty();
                if($("#path_ftp").text() != "/")
                {
                    $("#contenedor_archivos_remotos").append("<div class='w-xxxx-12'> <i class='icon icon-retroceder'></i><a href='#' class='ftp_directory'>..</a></div>");
                }
                for(var i = 0; i < respuesta['ls_remoto'].length; i++)
                {
                    if(respuesta['ls_remoto'][i][1] != 'file')
                    {

                        $("#contenedor_archivos_remotos").append('<div class="w-xxxx-8 w-xxx-8 w-xx-8 w-x-8"><a href="#" class="ftp_'+(respuesta['ls_remoto'][i][1])+'">'+respuesta['ls_remoto'][i][0]+'</a></div>'+html_button_ftp+'');

                    }
                }
                for(var i = 0; i < respuesta['ls_remoto'].length; i++)
                {
                    if(respuesta['ls_remoto'][i][1] == 'file')
                    {
                        $("#contenedor_archivos_remotos").append('<div class="w-xxxx-8  w-xxx-8 w-xx-8 w-x-8"> <i class="icon icon-documento"></i><span class="ftp_'+(respuesta['ls_remoto'][i][1])+'">'+respuesta['ls_remoto'][i][0]+'</span></div>'+html_button_ftp+'');
                    }
                }

                $( ".ftp_directory" ).click(function(e) {
                    e.preventDefault();
                    changeDir($("#path_ftp").text()+"/"+$(this).text(),'ftp');
                });

                $("#contenedor_archivos_remotos .icon-c-editar" ).click(function(e) {
                    e.preventDefault();
                    renameFile($("#path_ftp").text(), $(this).parent().prev('div').children(".ftp_directory,.ftp_file").text(),'ftp');
                });

                $("#contenedor_archivos_remotos .icon-r-eliminar" ).click(function(e) {
                    e.preventDefault();

                    if( $(this).parent().prev('div').children("a").attr("class") == "ftp_directory")
                    {
                        eliminarCarpeta($("#path_ftp").text(), $(this).parent().prev('div').children(".ftp_directory").text(),'ftp');
                    }
                    else
                    {
                        eliminarArchivo($("#path_ftp").text(), $(this).parent().prev('div').children(".ftp_file").text(),'ftp');
                    }
                });

                $("#contenedor_archivos_remotos .icon-descargar" ).click(function(e) {
                    e.preventDefault();
                    descargarArchivo($("#path_ftp").text(), $(this).parent().prev('div').children(".ftp_directory,.ftp_file").text());


                });


            }


            if(respuesta['msg'] && respuesta['msg'].length > 0)
            {
                _alert(respuesta['msg']);
            }


            $("#nueva_carpeta_ftp").unbind('click').show();


            $("#nueva_carpeta_ftp").click(function()
            {
                nuevaCarpeta($("#path_ftp").text(),'ftp');
            })


        }
        else
        {
            $("#status_ftp").html("Desconectado");
            $("#path_ftp").empty();
            $("#contenedor_archivos_remotos").empty();
            $("#nueva_carpeta_ftp").hide();

        }
    }
}
