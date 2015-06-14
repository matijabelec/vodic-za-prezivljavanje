<?php

class Moderators_model extends Model {
    public function get_moderators() {
        return Database::query('SELECT k.korisnicko_ime, p.naziv_podrucja, m.status 
                                FROM moderatori m 
                                JOIN korisnici k ON m.id_korisnika = k.id_korisnika 
                                JOIN podrucja p ON m.id_podrucja = p.id_podrucja');
    }
    
    public function get_active_moderators() {
        return Database::query('SELECT * FROM moderatori WHERE status = 1');
    }
    public function get_deleted_moderators() {
        return Database::query('SELECT * FROM moderatori WHERE status = 0');
    }
    
    public function get_moderators_for_area($areaid) {
        return Database::query('SELECT * 
                                FROM moderatori 
                                WHERE id_podrucja = :id_podrucja AND 
                                      status = 1',
                              array('id_podrucja'=>$areaid) );
    }
    
    public function get_users_for_moderation($areaid) {
        return Database::query('SELECT * FROM korisnici WHERE status > 0');
    }
    
    public function add_moderation($userid, $areaid) {
        if(!isset($userid) || !isset($areaid) )
            return false;
        
        $ok = Database::insert('INSERT INTO moderatori(id_korisnika, id_podrucja, status) 
                               VALUES(:id_korisnika, :id_podrucja, 1)',
                               array('id_korisnika'=>$userid, 'id_podrucja'=>$areaid) );
        if(!$ok) {
            $ok = Database::insert('UPDATE moderatori 
                                   SET status = 1 
                                   WHERE id_korisnika = :id_korisnika AND
                                         id_podrucja = :id_podrucja AND
                                         status = 0',
                                   array('id_korisnika'=>$userid, 'id_podrucja'=>$areaid) );
        }
        return $ok;
    }
    public function delete_moderation($userid, $areaid) {
        if(!isset($userid) || !isset($areaid) )
            return false;
        
        return Database::insert('UPDATE moderatori 
                                 SET status = 0 
                                 WHERE id_korisnika = :id_korisnika AND
                                       id_podrucja = :id_podrucja AND
                                       status = 1',
                                   array('id_korisnika'=>$userid, 'id_podrucja'=>$areaid) );
    }
    public function undelete_moderation($userid, $areaid) {
        if(!isset($userid) || !isset($areaid) )
            return false;
        
        return Database::insert('UPDATE moderatori 
                                 SET status = 1 
                                 WHERE id_korisnika = :id_korisnika AND
                                       id_podrucja = :id_podrucja AND
                                       status = 0',
                                array('id_korisnika'=>$userid, 'id_podrucja'=>$areaid) );
    }
}

?>