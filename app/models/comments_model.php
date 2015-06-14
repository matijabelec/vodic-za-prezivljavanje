<?php

class Comments_model extends Model {
    public function get_comments() {
        return Database::query('SELECT * FROM komentari');
    }
    
    public function get_active_comments() {
        return Database::query('SELECT * FROM komentari WHERE status > 0');
    }
    public function get_deleted_comments() {
        return Database::query('SELECT * FROM komentari WHERE status > 0');
    }
    
    
    public function get_comments_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        
        return Database::query('SELECT * FROM komentari WHERE id_clanka = :id_clanka AND status > 0',
                               array('id_clanka'=>$articleid) );
    }
    
    
    public function comment($comment) {
        if(!(isset($comment['id_korisnika']) &&  
             isset($comment['id_clanka']) && 
             isset($comment['sadrzaj']) && 
             isset($comment['datum_objave']) ) ) {
            return false;
        }
        return Database::insert('INSERT INTO komentari(id_korisnika, id_clanka, sadrzaj, datum_objave, status) VALUES(:id_korisnika, :id_clanka, :sadrzaj, now(), 1)',
                                array('id_korisnika'=>$comment['id_korisnika'], 
                                      'id_clanka'=>$comment['id_clanka'], 
                                      'sadrzaj'=>$comment['sadrzaj']) );//, 'datum_objave'=>$comment['datum_objave']) );
    }
    public function delete($commentid) {
        if(!isset($commentid) )
            return false;
        return Database::insert('UPDATE komentari SET status = 0 WHERE id_komentara = :id_komentara AND status > 0',
                                array('id_komentara'=>$commentid) );
    }
    public function undelete($commentid) {
        if(!isset($commentid) )
            return false;
        return Database::insert('UPDATE komentari SET status = 1 WHERE id_komentara = :id_komentara AND status = 0',
                                array('id_komentara'=>$commentid) );
    }
}

?>