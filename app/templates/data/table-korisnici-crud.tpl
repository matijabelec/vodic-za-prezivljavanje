<div>
    <form action="{@project_root_path}/{@link}" method="post">
        <label for="korisnicko_ime">Korisničko ime: </label>
        <input type="text" name="korisnicko_ime" value="{@korisnicko_ime}" {@readonly}>

        <label for="id_tipa_korisnika">Tip korisnika: </label>
        <select name="id_tipa_korisnika" {@readonly}>
            <option value="1" {@id_tipa_korisnika-1}>Administrator</option>
            <option value="2" {@id_tipa_korisnika-2}>Moderator</option>
            <option value="3" {@id_tipa_korisnika-3}>Registrirani korisnik</option>
        </select>

        <label for="mail">E-mail: </label>
        <input type="text" name="mail" value="{@mail}" {@readonly}>

        <label for="lozinka">Lozinka: </label>
        <input type="password" name="lozinka" value="{@lozinka}" {@readonly}>


        <label for="ime">Ime: </label>
        <input type="text" name="ime" value="{@ime}" {@readonly}>

        <label for="prezime">Prezime: </label>
        <input type="text" name="prezime" value="{@prezime}" {@readonly}>


        <label for="slika_korisnika">Slika: </label>
        <input type="text" name="slika_korisnika" value="{@slika_korisnika}" {@readonly}>


        <label for="datum_registracije">Datum registracije: </label>
        <input type="datetime" name="datum_registracije" value="{@datum_registracije}" {@readonly}>

        <label for="status">Status: </label>
        <select name="status" {@readonly}>
            <option value="1" {@status-1}>Registriran</option>
            <option value="2" {@status-2}>Aktiviran</option>
            <option value="3" {@status-3}>Blokiran</option>
            <option value="0" {@status-0}>Izbrisan</option>
        </select>

        <input type="hidden" name="id_korisnika" value='{@id_korisnika}' {@readonly}>
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="{@btn-submit}">
        </div>
    </form>
</div>