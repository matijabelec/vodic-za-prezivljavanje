<?php

class Mod1_model extends Model {
    
    ///////////////////////////////////////////////////////////////////////
    // users
    public function get_users() {
        return Database::query('SELECT * FROM korisnici WHERE status>0');
    }
    public function get_registered_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=1');
    }
    public function get_activated_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=2');
    }
    public function get_blocked_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=3');
    }
    public function get_deleted_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=0');
    }
    
    
    
    ///////////////////////////////////////////////////////////////////////
    // areas
    public function get_areas() {
        return Database::query('SELECT * FROM podrucja WHERE status=1');
    }
    public function get_deleted_areas() {
        return Database::query('SELECT * FROM podrucja WHERE status=0');
    }
    
    public function create_area($area) {
        if(!isset($area) || !is_array($area) )
            return false;
        if(!isset($area['naziv_podrucja']) || 
           !isset($area['opis']) ||
           !isset($area['slika']) || 
           !isset($area['status']) )
            return false;
        return Database::insert('INSERT INTO podrucja 
                                (naziv_podrucja, opis, slika, status) 
                                VALUES(:aname, :adesc, :aimg, 1)', 
                               array('aname'=>$area['naziv_podrucja'], 
                                     'adesc'=>$area['opis'],
                                     'aimg'=>$area['slika']) );
    }
    public function delete_area($areaid) {
        if(!isset($areaid) )
            return false;
        return Database::insert('UPDATE podrucja 
                                 SET status=1 
                                 WHERE id_podrucja=:areaid AND 
                                 status=0', 
                               array('areaid'=>$areaid) );
    }
    public function undelete_area($areaid) {
        if(!isset($areaid) )
            return false;
        return Database::insert('UPDATE podrucja 
                                 SET status=0 
                                 WHERE id_podrucja=:areaid AND 
                                 status=1', 
                               array('areaid'=>$areaid) );
    }
    public function update_area($area) {
        if(!isset($area) || !is_array($area) )
            return false;
        if(!isset($area['id_podrucja']) || 
           !isset($area['naziv_podrucja']) || 
           !isset($area['opis']) ||
           !isset($area['slika']) )
            return false;
        return Database::insert('UPDATE podrucja 
                                 SET naziv_podrucja=:aname, 
                                 opis=:adesc, 
                                 slika=:aimg 
                                 WHERE id_podrucja=:areaid', 
                                array('areaid'=>$area['id_podrucja'], 
                                      'aname'=>$area['naziv_podrucja'],
                                      'adesc'=>$area['opis'],
                                      'aimg'=>$area['slika']) );
    }
    
    
    
    ///////////////////////////////////////////////////////////////////////
    // subscribes
    public function get_subscribes() {
        return Database::query('SELECT * FROM pretplate WHERE status=1');
    }
    public function get_moderations() {
        return Database::query('SELECT * FROM pretplate WHERE status=2');
    }
    public function get_subscribers_for_area($areaid) {
        if(!isset($areaid) )
            return array();
        return Database::query('SELECT k.* FROM pretplate p 
                                JOIN korisnici k ON k.id_korisnika=p.id_korisnika 
                                WHERE id_podrucja=:id_podrucja AND 
                                p.status=1 AND k.status>0',
                                array('id_podrucja'=>$areaid) );
    }
    public function get_moderators_for_area($areaid) {
        if(!isset($areaid) )
            return array();
        return Database::query('SELECT k.* FROM pretplate p 
                                JOIN korisnici k ON k.id_korisnika=p.id_korisnika 
                                WHERE id_podrucja=:id_podrucja AND 
                                p.status=2 AND k.status>0',
                                array('id_podrucja'=>$areaid) );
    }
    
    
    public function subscribe($areaid, $userid) {
        if(!isset($articleid) || !isset($userid) );
            return false;
        $ok = Database::insert('INSERT INTO pretplate 
                                (id_korisnika, id_podrucja, status) 
                                VALUES(:userid, :areaid, 1)',
                               array('userid'=>$userid, 
                                     'areaid'=>$areaid) );
        if(!$ok) {
            return Database::insert('UPDATE pretplate SET status=1 
                                    WHERE id_korisnika=:userid AND 
                                          id_podrucja=:areaid AND
                                          status=0', 
                                    array('userid'=>$userid, 
                                          'areaid'=>$areaid) );
        }
        return $ok;
    }
    public function unsubscribe($areaid, $userid) {
        if(!isset($articleid) || !isset($userid) );
            return false;
        return Database::insert('UPDATE pretplate SET status=0 
                                 WHERE id_korisnika=:userid AND 
                                       id_podrucja=:areaid AND
                                       status=1', 
                                 array('userid'=>$userid, 
                                       'areaid'=>$areaid) );
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    // articles
    public function get_articles() {
        return Database::query('SELECT * FROM clanci WHERE status=1');
    }
    public function get_deleted_articles() {
        return Database::query('SELECT * FROM clanci WHERE status=1');
    }
    
    public function check_article_restriction($articleid, $userid) {
        if(!isset($articleid) || !isset($user) )
            return 1;
        $res = Database::query('SELECT zp.* FROM zabrana_pristupa 
                                JOIN korisnici k ON k.id_korisnika=zp.id_moderatora 
                                JOIN clanci c ON c.id_korisnika=k.id_korisnika
                                WHERE c.id_korisnika=:moderatorid AND 
                                zp.id_korisnika=:userid AND 
                                zp.status=1 AND 
                                k.status>0 AND 
                                c.status=0',
                                array('moderatorid'=>$moderatorid,
                                      'userid'=>$userid) );
        if(count($res)>0)
            return 1;
        return 0;
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    // article grades
    public function get_grades() {
        return Database::query('SELECT * FROM ocjene_clanaka WHERE status=1');
    }
    public function get_article_grade($articleid) {
        if(!isset($articleid) )
            return 0;
        //TODO: ?? return Database::query('SELECT * FROM clanci WHERE status=1');
        return 0;
    }
    public function get_article_grade_count($articleid) {
        if(!isset($articleid) )
            return 0;
        //TODO: ?? return Database::query('SELECT * FROM clanci WHERE status=1');
        return 0;
    }
    
    public function grade_article($grade) {
        if(!isset($grade) || !is_array($grade) );
            return false;
        if(!isset($grade['id_korisnika']) || 
           !isset($grade['id_clanka']) || 
           !isset($grade['ocjena']) || 
           !isset($grade['datum']) )
            return false;
        $ok = Database::insert('INSERT INTO ocjene_clanaka 
                                (id_korisnika, id_clanka, ocjena, datum_ocjene, status) 
                                VALUES(:userid, :articleid, :grade, :date, 1)',
                               array('userid'=>$grade['id_korisnika'], 
                                     'articleid'=>$grade['id_clanka'], 
                                     'grade'=>$grade['ocjena'], 
                                     'date'=>$grade['datum_ocjene']) );
        if(!$ok) {
            return Database::insert('UPDATE ocjene_clanaka 
                                     SET ocjena=:grade, 
                                         datum_ocjene=:date, 
                                         status=1 
                                     WHERE id_korisnika=:userid AND 
                                           id_clanka=:articleid AND 
                                           status=0', 
                                    array('userid'=>$grade['id_korisnika'], 
                                          'articleid'=>$grade['id_clanka'], 
                                          'grade'=>$grade['ocjena'], 
                                          'date'=>$grade['datum_ocjene']) );
        }
        return $ok;
    }
    public function ungrade_article($grade) {
        if(!isset($grade) || !is_array($grade) );
            return false;
        if(!isset($grade['id_korisnika']) || 
           !isset($grade['id_clanka']) )
            return false;
        return Database::insert('UPDATE ocjene_clanaka SET status=0 
                                WHERE id_korisnika=:userid AND 
                                      id_clanka=:articleid AND 
                                      status=1', 
                               array('userid'=>$grade['id_korisnika'], 
                                     'articleid'=>$grade['id_clanka']) );
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    // comments
    public function get_comments() {
        return Database::query('SELECT * FROM komentari WHERE status=1');
    }
    public function get_deleted_comments() {
        return Database::query('SELECT * FROM komentari WHERE status=0');
    }
    public function get_comments_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT * FROM komentari 
                                WHERE id_clanka=:articleid AND status=1',
                                array('articleid'=>$articleid) );
    }
    public function get_comments_for_user($userid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT * FROM komentari 
                                WHERE id_korisnika=:userid AND status=1', 
                                array('userid'=>$userid) );
    }
    
    
    public function comment_article($comment) {
        if(!isset($comment) || !is_array($comment) )
            return false;
        if(!isset($comment['id_korisnika']) || 
           !isset($comment['id_clanka']) || 
           !isset($comment['sadrzaj']) || 
           !isset($comment['datum_objave']) )
            return false;
        return Database::insert('INSERT INTO komentari
                                (id_korisnika, id_clanka, sadrzaj, datum objave, status)
                                 VALUES(:userid, :articleid, :cdata, :date, 1)', 
                               array('userid'=>$comment['id_korisnika'], 
                                     'articleid'=>$comment['id_clanka'], 
                                     'cdata'=>$comment['sadrzaj'],
                                     'date'=>$comment['datum_objave']) );
    }
    public function delete_comment($commentid) {
        if(!isset($commentid) )
            return false;
        return Database::insert('UPDATE komentari SET status=0 
                                 WHERE id_komentara=:commentid',
                                array('commentid'=>$commentid) );
    }
    public function undelete_comment($commentid) {
        if(!isset($commentid) )
            return false;
        return Database::insert('UPDATE komentari SET status=1 
                                 WHERE id_komentara=:commentid',
                                array('commentid'=>$commentid) );
    }
    public function update_comment($comment) {
        if(!isset($comment) || !is_array($comment) )
            return false;
        if(!isset($comment['id_komentara']) || 
           !isset($comment['sadrzaj']) )
            return false;
        return Database::insert('UPDATE komentari SET sadrzaj=:cdata 
                                 WHERE id_komentara=:commentid',
                                array('commentid'=>$comment['id_komentara'],
                                      'cdata'=>$comment['sadrzaj']) );
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    // materials
    public function get_materials() {
        return Database::query('SELECT * FROM materijali WHERE status=1');
    }
    public function get_deleted_materials() {
        return Database::query('SELECT * FROM materijali WHERE status=0');
    }
    public function get_materials_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT * FROM materijali 
                                WHERE id_clanka=:$articleid AND status=1',
                               array('articleid'=>$articleid) );
    }
    
    public function get_images_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT m.*, ms.opis 
                                FROM materijali m 
                                JOIN materijali_slike ms 
                                    ON m.id_materijala=ms.id_materijala 
                                WHERE m.id_clanka=:$articleid AND 
                                m.id_tipa_materijala=3 AND 
                                m.status=1 AND 
                                ms.status=1',
                               array('articleid'=>$articleid) );
    }
    public function get_videos_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT m.*, mv.trajanje 
                                FROM materijali m 
                                JOIN materijali_videi mv 
                                    ON m.id_materijala=mv.id_materijala 
                                WHERE m.id_clanka=:$articleid AND 
                                m.id_tipa_materijala=2 AND 
                                m.status=1 AND 
                                mv.status=1',
                               array('articleid'=>$articleid) );
    }
    public function get_documents_for_article($type) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT m.*, md.opis 
                                FROM materijali m 
                                JOIN materijali_dokumenti md 
                                    ON m.id_materijala=md.id_materijala 
                                WHERE m.id_clanka=:$articleid AND 
                                m.id_tipa_materijala=3 AND 
                                m.status=1 AND 
                                md.status=1',
                               array('articleid'=>$articleid) );
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    // logins
    
    
    
    ///////////////////////////////////////////////////////////////////////
    // 
    ///////////////////////////////////////////////////////////////////////
    // 
}

?>