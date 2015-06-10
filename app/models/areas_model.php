<?php

class Areas_model extends Model {
    public function get_areas() {
        $areas = Database::query('SELECT id_podrucja AS ID, naziv_podrucja AS Naziv, status AS Status FROM podrucja');
        return $areas;
    }
    public function get_area_by_id($id) {
        if(!isset($id) )
            return;
        $area = Database::query('SELECT id_podrucja AS ID, naziv_podrucja AS Naziv, status AS Status FROM podrucja WHERE id_podrucja = :id', array('id'=>$id) );
        return $area;
    }
}

?>