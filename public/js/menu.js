$.fn.navFixed = function(altura_personalizada,altura_inicial,modify_margin)
{
    var altura_header = $("header").height();
    var top = $("header").offset().top + altura_header + altura_personalizada;

    $(window).scroll(function () {
	if ($(this).scrollTop() > top) {

            $("body").addClass("fixed_nav");
            if(modify_margin)
            {
                $("section .page_wrapper").css("margin-top",altura_header+"px" )
            }
	}
        else {
            $("body").removeClass("fixed_nav");
            if(modify_margin)
            {
                $("section .page_wrapper").css("margin-top",altura_inicial+"px" )
            }

	}
    });
}



$(document).ready(function(){


    $(".cont_nav_movil").click(
        function(){

            $(".menu_web").fadeToggle("fast",function()
            {
                $(".cont_nav_movil").toggleClass("active")
                $(".hamburguer").toggleClass("active")
                $("body").toggleClass("active_nav")

                $(".menu_web").toggleClass("despliegue")
                if(!$(".menu_web").is(":visible") ) {
                     $(".menu_web").css('display','')
                }
            })
    });

});


 
$(window).on('load',function() { 
 
    setTimeout(function(){

        
        $('._nav_menu').find('li').each(function(index,val)
        {   
            if($(this).children('ul').length > 0)
            {
                $(this).addClass('parent_menu');
                $(this).children('a').addClass('parent_menu')

                $(this).children('a').click(function(e){
                
                    if($('.cont_nav_movil').is(':visible'))
                    {
                        if($(this).next('ul').is(':visible'))
                        {

                        }
                        else{
                            e.preventDefault();
                            $('._nav_menu').find('li.active').children('ul').slideUp();
                            $('._nav_menu').find('.active').removeClass('active');
                            $(this).next('ul').slideDown();
                            $(this).addClass('active').parent('li').addClass('active');
                        }
                       
                    }
                });
            }

        });
        

    },1000);

});

$(window).resize(function(){
    if(!$('.cont_nav_movil').is(':visible'))
    {
        $('._nav_menu').find('li.active').children('ul').css('display','');
        $('._nav_menu').find('li.active').children('a').removeClass('active');
        $('._nav_menu').find('li.active').removeClass('active');
    }
});