<?php

class Comments_model extends Model {
    public function get_comments() {
        return Database::query('SELECT * FROM komentari');
    }
}

?>