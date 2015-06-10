<?php

class Users_model extends Model {
    public function get_users() {
        $users = Database::query('SELECT * FROM korisnici_ispis_view');
        return $users;
    }
    public function get_users_safe() {
        $users = Database::query('SELECT id_korisnika AS ID, korisnicko_ime AS "Korisničko ime", id_tipa_korisnika AS Tip, ime AS Ime, prezime AS Prezime, status AS Status FROM korisnici');
        return $users;
    }
}

?>