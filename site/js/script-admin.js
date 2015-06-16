function pripremi_datatable(elem) {
    elem.DataTable({
        "bPaginate":true,
        "bSort":true,
        "bFilter":true,
        //"bLengthChange":true,
        //"bAutoWidth":true
    });
}

$(document).ready(function(){
    function set_table($tbl) {
        var tablename = $tbl.attr('href');
        var elem = $tbl.closest('.main-section').find('.table-informations');
        $.ajax({
            type: 'GET',
            url: relurl+'/admin/ajax/table/'+tablename,
            beforeSend: function(){elem.html('<span class="loader">&nbsp</span>');},
            success: function(data){
                elem.html(data);
                pripremi_datatable(elem.children('table') );
            },
            error: function(d){elem.html('<p>Dogodila se greška!</p>');}
        });
    }
    
    $('.admin-table-controls').on('click', '.table-btn', function(e){
        e.preventDefault();
        e.stopPropagation();
        set_table($(this) );
    });
    
    /*$('.first-load').each(function(){
        set_table($(this) );
    });*/
});