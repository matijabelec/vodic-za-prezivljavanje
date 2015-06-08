<?php

class Areas_model extends Model {
    public function get_areas() {
        $areas = Database::query('SELECT id_podrucja AS ID, naziv_podrucja AS Naziv, status AS Status FROM podrucja');
        return $areas;
    }
}

?>