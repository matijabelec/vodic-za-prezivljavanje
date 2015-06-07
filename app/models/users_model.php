<?php

class Users_model extends Model {
    public function get_users() {
        $users = Database::query('SELECT * FROM korisnici_ispis_view');
        /*$users2 = array();
        foreach($users as $user) {
            $user2['id_korisnika'] = $user['id_korisnika'];
            $user2['korisnicko_ime'] = $user['korisnicko_ime'];
            $user2['id_tipa_korisnika'] = $user['id_tipa_korisnika'];
            $user2['status'] = $user['status'];
            $users2[] = $user2;
        }*/
        return $users;
    }
}

?>