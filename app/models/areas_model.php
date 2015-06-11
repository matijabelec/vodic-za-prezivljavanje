<?php

class Areas_model extends Model {
    public function get_areas() {
        $areas = Database::query('SELECT id_podrucja AS ID, naziv_podrucja AS Naziv, status AS Status FROM podrucja');
        return $areas;
    }
    public function get_area_by_id($id) {
        $areas = Database::query('SELECT * FROM podrucja WHERE id_podrucja = :id', array('id'=>$id) );
        if(count($areas) == 1)
            return $areas[0];
    }
    
    public function get_areas_full() {
        $users = Database::query('SELECT * FROM podrucja');
        return $users;
    }
}

?>