function adjustStyle(width) {
    width = parseInt(width);
    if (width < 489) {
        $("#size-stylesheet").attr("href", "/skin/default/css/estilos_320.css");
    } else if ((width >= 490) && (width < 649)) {
        $("#size-stylesheet").attr("href", "/skin/default/css/estilos_640.css");
    } else if ((width >= 650) && (width < 979)) {
        $("#size-stylesheet").attr("href", "/skin/default/css/estilos_960.css");
    } else {
       $("#size-stylesheet").attr("href", "/skin/default/css/estilos_1200.css"); 
    }
}
$(function() {
    adjustStyle($(this).width());
    $(window).resize(function() {
        adjustStyle($(this).width());
    });
});
