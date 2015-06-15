function pripremi_datatable() {
    $('#tablica_korisnici').DataTable({
        "bPaginate":true,
        "bSort":true,
        "bFilter":true,
        //"bLengthChange":true,
        //"bAutoWidth":true
    });
}

function dohvati_gen_ajax(elem) {
    var tablica = $('<table></table').attr('id', 'tablica_korisnici');
    var thead = $('<thead></thead>');
    thead.append('<tr><th>Ime</th> <th>Prezime</th> <th>Korisnicko ime</th> <th>Email</th> <th>Slika</th></tr>')
    tablica.append(thead);
    $.ajax({
        type: 'GET',
        url: 'http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnici.xml',
        //url: 'korisnici.xml',
        dataType: "xml",
        success: function(data) {
            var tbody = $('<tbody></tbody>');
            $(data).find('korisnik').each(function() {
                var red = $('<tr></tr>');
                red.append('<td>' + $(this).attr('ime') + '</td>');
                red.append('<td>' + $(this).attr('prezime') + '</td>');
                red.append('<td>' + $(this).attr('korisnicko_ime') + '</td>');
                red.append('<td>' + $(this).attr('email') + '"</td>');
                red.append('<td><img src="' + $(this).attr('slika') + '" alt="' + $(this).attr('slika') + '"/></td>');
                tbody.append(red);
            });
            tablica.append(tbody);
            elem.html(tablica);
            pripremi_datatable();
        },
        error: function(d) {
            //$('#greske').html('<p>Dogodila se greÅ¡ka kod izvrÅ¡avanja provjere!</p>');
        }
    });
}
function dohvati_gen_json(elem) {
    var tablica = $('<table></table').attr('id', 'tablica_korisnici');
    var thead = $('<thead></thead>');
    thead.append('<tr><th>Ime</th> <th>Prezime</th> <th>Korisnicko ime</th> <th>Slika</th> <th>Email</th></tr>')
    tablica.append(thead);
    $.getJSON('http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnici.json', function(data){
        var tbody = $('<tbody></tbody>');
        for(i=0; i<data.length; i++) {
            var red = $('<tr></tr>');
            red.append('<td>' + data[i].ime + '</td>');
            red.append('<td>' + data[i].prezime + '</td>');
            red.append('<td>' + data[i].korisnicko_ime + '</td>');
            red.append('<td><img src="' + data[i].slika + '" alt="' + data[i].slika + '"/></td>');
            red.append('<td>' + data[i].email + '"</td>');
            tbody.append(red);
        }
        tablica.append(tbody);
        elem.html(tablica);
        pripremi_datatable();
    });
}

$(document).ready(function(){
    /*var korisnici = $('#tablica_korisnici');
    if(korisnici.length)
        korisnici.DataTable({
            "bPaginate":true,
            "bSort":true,
            "bFilter":true,
            "bLengthChange":true,
            "bAutoWidth":true
        });
        
    var kontrola_gen = $('#kontrola_btn');
    if(kontrola_gen.length) {
        var tablica = $('#tablica_korisnici_outline');
        kontrola_gen.on('click', 'button', function(){
            switch($(this).attr('id') ) {
                case 'btn_ajax': dohvati_gen_ajax(tablica); break;
                case 'btn_json': dohvati_gen_json(tablica); break;
                default: break;
            }
        });
    }
    var registracija = $('#forma_registracija');
    if(registracija.length) {
        $('#korisnicko_ime').focusout(function() {
            var elem = $(this);
            var korisnik = $(this).val();
            $.get('http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnik.php?korisnik='+korisnik, function(data) {
                if($(data).find('korisnik').text() != 0) {
                    var zauzet = $('<p></p>').text('KorisniÄko je ime zauzeto!');
                    $(elem).after(zauzet);
                    zauzet.toggle('highlight');
                    $(elem).focus();
                }
            });
        });
        $('#ime, #prezime').focusout(function() {
            var ime = $('#ime').val();
            var prezime = $('#prezime').val();
            var url = 'http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnikImePrezime.php?ime='+ime+'&prezime='+prezime;
            if(''!==ime && ''!==prezime)
                $.get(url, function(data) {
                    if($(data).find('korisnicko_ime').text() != 0) {
                        var zauzet = $('<p></p>').text('Ime i prezime je zauzeto!');
                        $('#prezime').after(zauzet);
                        zauzet.toggle('highlight');
                        $('#ime').focus();
                    }
                });
        });
        var popis_gradova = new Array();
        $.getJSON("http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/gradovi.json", function(data) {
            $.each(data, function(k,v){popis_gradova.push(v);});
        });
        $("#grad").autocomplete({source: popis_gradova});
    }*/
});
