<?php

class Areas_model extends Model {
    public function get_articles_for_area($id) {
        $articles = Database::query('SELECT *,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 1) AS broj_slika,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 2) AS broj_videa,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 3) AS broj_dokumenata
FROM clanci 
WHERE status = 1 AND id_podrucja = :id', array('id'=>$id) );
        return $articles;
    }
    
    public function get_areas_full() {
        $users = Database::query('SELECT * FROM podrucja');
        return $users;
    }
    
    
    
    
    public function get_areas() {
        return Database::query('SELECT * FROM podrucja');
    }
    
    public function get_active_areas() {
        return Database::query('SELECT * FROM podrucja WHERE status = 1');
    }
    public function get_deleted_areas() {
        return Database::query('SELECT * FROM podrucja WHERE status = 0');
    }
    
    public function get_area($areaid) {
        if(!isset($areaid) )
            return array();
        
        $areas = Database::query('SELECT * FROM podrucja WHERE id_podrucja = :areaid', array('areaid'=>$areaid) );
        if(count($areas) == 1)
            return $areas[0];
        
        return array();
    }
    public function get_active_area($areaid) {
        if(!isset($areaid) )
            return array();
        
        $areas = Database::query('SELECT * FROM podrucja WHERE id_podrucja = :areaid AND status = 1', array('areaid'=>$areaid) );
        if(count($areas) == 1)
            return $areas[0];
        
        return array();
    }
    
    public function get_area_articles($areaid) {
        if(!isset($areaid) )
            return array();
        
        $articles = Database::query('SELECT *,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 1) AS broj_slika,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 2) AS broj_videa,
(SELECT count(*) FROM materijali WHERE clanci.id_clanka = materijali.id_clanka AND materijali.status=1 AND materijali.id_tipa_materijala = 3) AS broj_dokumenata
FROM clanci WHERE status = 1 AND id_podrucja = :areaid',
                array('areaid'=>$areaid) );
        return $articles;
    }
    
    
    
    public function create_new_area($area) {
        if(!(isset($area['naziv_podrucja']) && 
           isset($area['opis']) && 
           isset($area['slika']) && 
           isset($area['status']) ) ) {
                return false;
        }
        
        if($area['status'] < 0 || $area['status'] > 1)
            return false;
        
        return Database::insert('INSERT INTO podrucja(naziv_podrucja, opis, slika, status) VALUES(:naziv_podrucja, :opis, :slika, :status)',
                                array('naziv_podrucja' => $area['naziv_podrucja'],
                                      'opis' => $area['opis'],
                                      'slika' => $area['slika'],
                                      'status' => $area['status']) );
    }
    
    public function update_area($area) {
        if(!(isset($area['id_podrucja']) &&
           isset($area['naziv_podrucja']) && 
           isset($area['opis']) && 
           isset($area['slika']) && 
           isset($area['status']) ) ) {
                return false;
        }
        
        if($area['status'] < 0 || $area['status'] > 1)
            return false;
        
        return Database::insert('UPDATE podrucja SET naziv_podrucja = :naziv_podrucja, opis = :opis, slika = :slika, status = :status WHERE id_podrucja = :id_podrucja',
                array('id_podrucja' => $area['id_podrucja'],
                      'naziv_podrucja' => $area['naziv_podrucja'],
                      'opis' => $area['opis'],
                      'slika' => $area['slika'],
                      'status' => $area['status']) );
    }
    
    public function delete_area($areaid) {
        if(!isset($areaid) )
            return false;
        
        return Database::insert('UPDATE podrucja SET status = 0 WHERE id_podrucja = :areaid AND status != 0',
                                array('areaid' => $areaid) );
    }
    public function undelete_area($areaid) {
        if(!isset($areaid) )
            return false;
        
        return Database::insert('UPDATE podrucja SET status = 1 WHERE id_podrucja = :areaid AND status = 0',
                                array('areaid' => $areaid) );
    }
}

?>