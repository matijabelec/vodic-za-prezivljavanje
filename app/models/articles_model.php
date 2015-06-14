<?php

class Articles_model extends Model {
    public function get_articles() {
        return Database::query('SELECT * FROM clanci');
    }
    public function get_article($articleid) {
        if(!isset($articleid) )
            return array();
        $articles = Database::query('SELECT * FROM clanci WHERE id_clanka = :id_clanka',
                                    array('id_clanka'=>$articleid) );
        if(count($articles) == 1)
            return $articles[0];
        return array();
    }
    
    public function get_active_articles() {
        return Database::query('SELECT * FROM clanci WHERE status = 1');
    }
    public function get_deleted_articles() {
        return Database::query('SELECT * FROM clanci WHERE status = 0');
    }
    
    public function get_comments_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        $comments_model = new Comments_model;
        $comments = $comments_model->get_comments_for_article($articleid);
        unset($comments_model);
        return $comments;
    }
    
    
    public function check_subscribed_to_articles_area($userid, $articleid) {
        if(!isset($userid) || !isset($articleid) )
            return false;
        
        $users = Database::query('SELECT * 
                                    FROM pretplate 
                                    WHERE id_podrucja = (SELECT id_podrucja 
                                                         FROM clanci 
                                                         WHERE id_clanka = :id_clanka) AND 
                                          id_korisnika = :id_korisnika AND 
                                          status > 0',
                                    array('id_korisnika'=>$userid,
                                          'id_clanka'=>$articleid) );
        if(count($users) > 0)
            return true;
        
        return false;
    }
    
    
    public function check_moderation_for_area($userid, $areaid) {
        if(!isset($userid) || !isset($areaid) )
            return false;
        
        $users = Database::query('SELECT * 
                                    FROM moderatori 
                                    WHERE id_podrucja = :id_podrucja AND 
                                          id_korisnika = :id_korisnika AND 
                                          status > 0',
                                    array('id_korisnika'=>$userid,
                                          'id_podrucja'=>$areaid) );
        if(count($users) > 0)
            return true;
        
        return false;
    }
}

?>