$.fn.transition = function(url,myhistory, type)
{
    if($("#loading_transition"))
    {
        $("#loading_transition").remove();
    }
    var loading = $('<div id="loading_transition">&nbsp;</div>').addClass("franky_mobile_loading");
    loading.css({ top:Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + 'px'})
    $("body").append(loading);

    var page_content = $("<div></div>").addClass("franky_mobile_new_page_content");

    $(page_content).load(url , function( response, status, xhr ) {
        if ( status == "error" ) {

        }
        else
        {
            var newPageTitle = response.match( /<title[^>]*>([^<]*)/ ) && RegExp.$1;
            var triggerData = {xhr : xhr, textStatus :status};

            page_content.html(( response.split( /<\/?body[^>]*>/gmi )[1] || "" ))
            page_content.on( "pageload", function() {
                loading.remove();


                if(myhistory){
                    if (typeof window.history.pushState == 'function') {

                        history.pushState({path:url}, url, url);
                    }
                }

                var pageWidth = $(window).width();

                var page_preview = $("<div></div>");
                $('body').children().appendTo(page_preview);
                $('body').append(page_preview);
                $('body').append(page_content);

                var css_1 = {};
                var css_2 = {};
                switch(type)
                {
                    case 'back':

                        css_1 = {left: "-=" + pageWidth + "px", display:'block'}
                        css_2 = {left: 0}
                        break;
                    case 'fade':

                        css_1 = {left: 0, display:'block', opacity: 0}
                        css_2 = {opacity: 1.0}
                         break;
                    default:
                        css_1 = {left: pageWidth, display:'block'}
                        css_2 = {left: "-=" + pageWidth + "px"}
                         break;
                }



                page_content.css(css_1).add('#body_back').animate(css_2, (myhistory ? 300 : 0)).promise().done(function()  {
                    page_content.css({position: 'relative','z-index': 0}).removeClass("franky_mobile_new_page_content");
                    $(document).scrollTop( 0 );
                    page_preview.remove();
                    $("title").text(newPageTitle);
                    $(window).trigger("load");

                });


            });


            page_content.trigger( "pageload",triggerData);




        }
    });
}


$.fn.buttonDelete = function(element)
{
    $(element).each(function(index,val)
    {
        var id = $(this).attr("id");

        if(id.search("{{") == -1)
        {
            $(this).addClass('switch');
            if($(this).attr("href") == "#desactivar")
            {
                $(this).addClass('switchOn');
            }
            else
            {
                $(this).removeClass('switchOn');
            }
            $(this).on("eliminar-registro",function()
            {
                if($(this).attr("href") == "#desactivar")
                {
                    $(this).addClass('switchOn');
                }
                else
                {
                    $(this).removeClass('switchOn');
                }
            });


        }

    });

}
