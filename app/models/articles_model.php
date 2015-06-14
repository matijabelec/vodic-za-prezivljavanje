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
}

?>