<?php

class Areas_model extends Model {
    public function get_areas() {
        $areas = Database::query('SELECT id_podrucja AS ID, naziv_podrucja AS Naziv, opis AS Opis, slika AS Slika, status AS Status FROM podrucja');
        return $areas;
    }
    public function get_area_by_id($id) {
        $areas = Database::query('SELECT * FROM podrucja WHERE id_podrucja = :id', array('id'=>$id) );
        if(count($areas) == 1)
            return $areas[0];
    }
    
    public function get_articles_for_area($id) {
        $articles = Database::query('SELECT *,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 1) AS broj_slika,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 2) AS broj_videa,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 3) AS broj_dokumenata
FROM clanci 
WHERE status = 1 AND id_podrucja = :id', array('id'=>$id) );
        return $articles;
    }
    
    public function get_active_areas() {
        $areas = Database::query('SELECT * FROM podrucja WHERE status = :status', array('status'=>PROJECT_DATA_STATUS_ACTIVE) );
        return $areas;
    }
    
    public function get_areas_full() {
        $users = Database::query('SELECT * FROM podrucja');
        return $users;
    }
}

?>