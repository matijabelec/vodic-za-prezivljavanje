<?php

class Users_model extends Model {
    public function get_users() {
        $users = Database::query('SELECT * FROM korisnici_ispis_view');
        return $users;
    }
}

?>