$.get = function(key)   {
        key = key.replace(/[\[]/, '\\[');
        key = key.replace(/[\]]/, '\\]');
        var pattern = "[\\?&]" + key + "=([^&#]*)";
        var regex = new RegExp(pattern);
        var url = unescape(window.location.href);
        var results = regex.exec(url);
        if (results === null) {
            return null;
        } else {
            return results[1];
        }
    }

$.fn.maximaLongitud = function(maxlong, elemento)
{

    var out_value;
    var total;

    $(this).on('keyup keypress',function(){

        var texto = $(this).val();

        if (texto.length > maxlong)
        {
                    in_value = texto;

                    out_value = in_value.substring(0,maxlong);

                    texto = out_value;

                    $("#"+elemento).html('0');

                    $(this).val(texto);

                    return false;
        }


        total = maxlong - texto.length;

        $("#"+elemento).html(total);

        if(total < 20)
        {
            $("#"+elemento).addClass('contador_min');
        }
    });

    return true;
}

$.fn.addAllParentClass = function(className)
{
    var element = $(this);
    element.each(function() {

        $(this).parents().each(function() {

            if(this.tagName != "HTML")
            {
                $(this).addClass(className);
            }


        });

    });

    return true;
}

$.fn.newplaceholder = function(){
    var  p = $(this).attr("placeholder");
    if($(this).length > 0)
    {

        if($(this).val().length > 0)
        {
            if($(this).prev("span").length == 0)
            {
                $(this).parent().prepend("<span class='label_fade'>"+p+"</span>");
                $(this).prev(".label_fade").css("display","none").fadeIn("slow");
            }
        }
        else
        {
            $(this).prev(".label_fade").remove();
        }
    }
};


$.fn.imgLoadAlive = function()
{
      window_top = $(window).scrollTop();
      $('img[data-alive]').each(function(index,val)
      {
            if($(this).attr('data-alive').length > 0 )
            {
                imagen = $(this).offset();

                if (window_top > (imagen.top - $(window).height() - 100)) {

                    $(this).attr('src',$(this).attr('data-alive'));
                    $(this).attr('data-alive','');
                    $(this).hide();
                    $(this).fadeIn( "slow" );
                  }

            }
      });

}


$.fn.textToIcon = function() {
      $(this).each(function(index,value){

        var _class = $(this).attr('class');
        if(_class)
        {
          if(_class.search('email') > -1)
          {
              var email = $(this).text();
              $(this).empty().append($('<a>').attr('href','mailto:'+email).attr('title',email).html('<i class="icon icon-contacto"></i>').addClass('jquery-tooltip'));
          }
          if(_class.search('telephone') > -1)
          {
              var telephone = $(this).text();
              $(this).empty().append($('<a>').attr('href',(!isMobile() ? 'javascript:void(0)' : 'tel:'+telephone)).attr('title',telephone).html('<i class="icon icon-telefono"></i>').addClass('jquery-tooltip'));
          }

           if(_class.search('url') > -1)
          {
              var url = $(this).text();
              $(this).empty().append($('<a>').attr('href',url).attr('title',url).attr('target','_blank').html('<i class="icon icon-lupa"></i>').addClass('jquery-tooltip'));
          }


        }

      });

      $( ".jquery-tooltip" ).tooltip({
            show: null,
            position: {
            my: "left top",
            at: "left bottom"
            },
            open: function( event, ui ) {
            ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
            }
      });

};

_alert = function(msg,title)
{
     var now = $.now();

    var confirm = $('<div id="dialog-confirm'+now+'" title="'+title+'">\
    <p>'+msg+'</p>\
    </div>');


    $(function() {
        $( confirm ).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {
                "Aceptar": function() {

                     $( this ).dialog( "close" );
                    $( this ).remove();
                }

            }
        });
    });

}




$.fn.imagesresize = function(width){

    $(this).each(function(index,val){

        var parent = $(this);
        var src = $(this).attr('src').replace("_desk.",".").replace("_smart.",".");

        var fileExtension = src.substring(src.lastIndexOf('.'));

        if($(window).width() >= parseInt(width))
        {
            parent.attr("src",src.replace(fileExtension,"_desk"+fileExtension));
        }
        else
        {
            parent.attr("src",src.replace(fileExtension,"_smart"+fileExtension));
        }

    })
}

var getFormatoPrecio = function(number, fractional=true,simbol = true) {

    if(!fractional || fractional.length == 0)
    {

    }
    if(!simbol || simbol.length == 0)
    {

    }
    if(!number || number.lenght == 0)
    {
      number = 0;
    }
    if (fractional ) {
        number.toFixed(2);
    }
    while (true) {
        //console.log(number);
        replaced = number.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
        if (replaced != number) {
            number = replaced;
        } else {
            break;
        }
    }
    number = number.toString().split(".");
    return (simbol ? '$MXN ' : '')+number[0]+((number[1]) ? '.<sup>'+number[1]+'</sup>': '');
};

var importarScript = function(nombre, callback) {
    var s = document.createElement("script");
    s.onload = callback;
    s.src = nombre;
    document.querySelector("head").appendChild(s);
};

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}




$(document).ready(function(){

    $(".imprimible").addAllParentClass("imprimible");
    




    $("a").each(function(index,val){
        if($(location).attr('href').search($(this).attr('href')) > -1)
        {
            $(this).addClass('active').parent().addClass('active');
        }
    });


});



$(window).load(function() {


    if($("#dialog-message"))
    {
        setTimeout(function(){
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
              Ok: function() {
                $( this ).dialog( "close" );
                $("#dialog-message").remove();
              }
            }
        });},300);
    }

    $('.ancla').click(function(event)
    {
      var ancla = $(this).attr('data-ancla');

      if($('#'+ancla).length > 0)
      {
        event.preventDefault();
        $('html, body').animate({scrollTop:$('#'+ancla).offset().top}, 500,function(){

        });
      }
    });

    $('.ancla').each(function(index,val){

       var pathname = window.location.pathname;

       if($(this).attr('href') == pathname)
       {
         $(this).trigger('click');
       }

    });


});



if (window.location.protocol == "https:") {

    $.ajax({
        url:'/service_worker.js',
        type:'HEAD',
        success: function()
        {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('./service_worker.js').then(function()
                {
                    console.log('Service Worker Registered');
                });
            }
        }
    });

}
