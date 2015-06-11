<?php

class Users_model extends Model {
    public function get_users() {
        $users = Database::query('SELECT id_korisnika AS ID, korisnicko_ime AS "Korisničko ime", lozinka AS Lozinka, slika_korisnika AS Slika, id_tipa_korisnika AS Tip, ime AS Ime, prezime AS Prezime, mail AS "E-mail", datum_registracije AS "Datum registracije", aktivacijski_kod AS "Aktivacijski kod", status AS Status FROM korisnici');
        return $users;
    }
    public function get_users_safe() {
        $users = Database::query('SELECT id_korisnika AS ID, korisnicko_ime AS "Korisničko ime", id_tipa_korisnika AS Tip, ime AS Ime, prezime AS Prezime, status AS Status FROM korisnici');
        return $users;
    }
    
    public function get_user_by_id($id) {
        $users = Database::query('SELECT * FROM korisnici WHERE id_korisnika = :id', array('id'=>$id) );
        if(count($users) == 1)
            return $users[0];
    }
    
    public function get_users_full() {
        $users = Database::query('SELECT * FROM korisnici');
        return $users;
    }
}

?>