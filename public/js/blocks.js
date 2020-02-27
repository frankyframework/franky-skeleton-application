$(document).ready(function(){

    for(i=0;i < blocks_html.length; i++)
    {
        if(blocks_html[i].position == 'before')
        {
            $(blocks_html[i].reference).before(blocks_html[i].html)
        }
        if(blocks_html[i].position == 'after')
        {
            $(blocks_html[i].reference).after(blocks_html[i].html)
        }
        if(blocks_html[i].position == 'append')
        {
            $(blocks_html[i].reference).append(blocks_html[i].html)
        }
        if(blocks_html[i].position == 'prepend')
        {
            $(blocks_html[i].reference).prepend(blocks_html[i].html)
        }
    }

});