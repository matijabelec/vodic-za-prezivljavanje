<?php

class Articles_model extends Model {
    public function get_articles() {
        return Database::query('SELECT * FROM clanci');
    }
}

?>