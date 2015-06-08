<?php

class Areas_model extends Model {
    public function get_areas() {
        $areas = Database::query('SELECT * FROM podrucja');
        return $areas;
    }
}

?>