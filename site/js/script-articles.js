$(document).ready(function(){
    if(get_comments == true) {
        $.ajax({
            type: 'GET',
            url: relurl+'/comments/ajax/comments-for-article/'+articleid,
            beforeSend: function(){elem.html('<span class="loader">&nbsp</span>');},
            success: function(data){elem.html(data);},
            error: function(d){elem.html('<p>Dogodila se greška!</p>');}
        });
    }
});