$(document).ready(function(){
    if(get_articles == true) {
        $.ajax({
            type: 'GET',
            url: relurl+'/articles/ajax/articles-for-area/'+areaid,
            beforeSend: function(){elem.html('<span class="loader">&nbsp</span>');},
            success: function(data){elem.html(data);},
            error: function(d){elem.html('<p>Dogodila se greška!</p>');}
        });
    }
});