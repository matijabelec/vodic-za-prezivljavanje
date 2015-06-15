<?php

class Data_model extends Model {
    
    ///////////////////////////////////////////////////////////////////////
    // users
    public static function get_users() {
        return Database::query('SELECT * FROM korisnici WHERE status>1');
    }
    public static function get_registered_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=1');
    }
    public static function get_activated_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=2');
    }
    public static function get_blocked_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=3');
    }
    public static function get_deleted_users() {
        return Database::query('SELECT * FROM korisnici WHERE status=0');
    }
    
    public static function create_user($user) {
        if(!isset($user) || !is_array($user) )
            return false;
        if(!isset($user['id_tipa_korisnika']) || 
           !isset($user['korisnicko_ime']) || 
           !isset($user['mail']) || 
           !isset($user['lozinka']) || 
           !isset($user['ime']) || 
           !isset($user['prezime']) || 
           !isset($user['slika_korisnika']) || 
           !isset($user['datum_registracije']) || 
           !isset($user['aktivacijski_kod']) )
            return false;
        return Database::insert('INSERT INTO korisnici 
                                (id_tipa_korisnika, korisnicko_ime, mail, lozinka, 
                                 ime, prezime, slika_korisnika, datum_registracije, 
                                 aktivacijski_kod, status) 
                                 VALUES(:typeid, :uname, :mail, :pass, :fname, 
                                        :lname, :img, :date, :aclink, 1)', 
                                array('typeid'=>$user['id_tipa_korisnika'], 
                                      'uname'=>$user['korisnicko_ime'], 
                                      'mail'=>$user['mail'], 
                                      'pass'=>$user['lozinka'], 
                                      'fname'=>$user['ime'], 
                                      'lname'=>$user['prezime'], 
                                      'img'=>$user['slika_korisnika'], 
                                      'date'=>$user['datum_registracije'], 
                                      'aclink'=>$user['aktivacijski_kod']) );
    }
    public static function activate_user_by_aclink($aclink) {
        if(!isset($aclink) )
            return false;
        return Database::insert('UPDATE korisnici SET status=2 
                                 WHERE aktivacijski_kod=:aclink AND 
                                 status=1', 
                                array('aclink'=>$aclink) );
    }
    public static function block_user($userid) {
        if(!isset($userid) )
            return false;
        return Database::insert('UPDATE korisnici SET status=3 
                                 WHERE id_korisnika=:userid AND status=2', 
                                array('userid'=>$userid) );
    }
    public static function unblock_user($userid) {
        if(!isset($userid) )
            return false;
        return Database::insert('UPDATE korisnici SET status=2 
                                 WHERE id_korisnika=:userid AND status=3', 
                                array('userid'=>$userid) );
    }
    public static function delete_user($userid) {
        if(!isset($userid) )
            return false;
        return Database::insert('UPDATE korisnici SET status=0 
                                 WHERE id_korisnika=:userid AND status>1', 
                                array('userid'=>$userid) );
    }
    public static function undelete_user($userid) {
        if(!isset($userid) )
            return false;
        return Database::insert('UPDATE korisnici SET status=2 
                                 WHERE id_korisnika=:userid AND status=0', 
                                array('userid'=>$userid) );
    }
    public static function update_user($user) {
        if(!isset($user) || !is_array($user) )
            return false;
        if(!isset($user['id_korisnika']) || 
           !isset($user['korisnicko_ime']) || 
           !isset($user['mail']) || 
           !isset($user['lozinka']) || 
           !isset($user['ime']) || 
           !isset($user['prezime']) || 
           !isset($user['slika_korisnika']) )
            return false;
        return Database::insert('UPDATE korisnici 
                                 SET korisnicko_ime=:uname, 
                                 mail=:mail, 
                                 lozinka=:pass, 
                                 ime=:fname, 
                                 prezime=:lname, 
                                 slika_korisnika=:img 
                                 WHERE id_korisnika=:userid', 
                                array('userid'=>$user['id_korisnika'], 
                                      'uname'=>$user['korisnicko_ime'], 
                                      'mail'=>$user['mail'], 
                                      'pass'=>$user['lozinka'], 
                                      'fname'=>$user['ime'], 
                                      'lname'=>$user['prezime'], 
                                      'img'=>$user['slika_korisnika']) );
    }
    public static function get_activated_user_by_username($username) {
        if(!isset($username) )
            return array();
        $users = Database::query('SELECT * FROM korisnici 
                                  WHERE korisnicko_ime=:uname AND 
                                  status=2',
                                 array('uname'=>$username) );
        if(count($users) == 1)
            return $users[0];
        return array();
    }
    
    public static function check_username_exists($username) {
        if(!isset($username) )
            return false;
        $users = Database::query('SELECT * FROM korisnici
                                  WHERE korisnicko_ime=:uname', 
                                array('uname'=>$username) );
        if(count($users) > 0)
            return true;
        return false;
    }
    public static function check_mail_exists($mail) {
        $users = Database::query('SELECT * FROM korisnici
                                  WHERE mail=:mail', 
                                array('mail'=>$mail) );
        if(count($users) > 0)
            return true;
        return false;
    }
    
    ///////////////////////////////////////////////////////////////////////
    // areas
    public static function get_empty_area() {
        return array('id_podrucja'=>'',
                     'naziv_podrucja'=>'',
                     'opis'=>'',
                     'slika'=>'',
                     'status'=>'');
    }
    
    public static function get_areas() {
        return Database::query('SELECT * FROM podrucja WHERE status=1');
    }
    public static function get_deleted_areas() {
        return Database::query('SELECT * FROM podrucja WHERE status=0');
    }
    public static function get_area_by_id($areaid) {
        if(!isset($areaid) )
            return array();
        $areas = Database::query('SELECT * FROM podrucja 
                                WHERE id_podrucja=:areaid AND status=1', 
                               array('areaid'=>$areaid) );
        if(count($areas) == 1)
            return $areas[0];
        return array();
    }
    
    public static function get_areas_for_moderator($moderatorid) {
        if(!isset($moderatorid) )
            return array();
        return Database::query('SELECT p.* FROM podrucja p 
                                JOIN pretplate pr 
                                ON p.id_podrucja=pr.id_podrucja 
                                WHERE pr.id_korisnika=:modid AND 
                                pr.status=2 AND 
                                p.status=1', 
                               array('modid'=>$moderatorid) );
    }
    public static function get_areas_not_for_moderator($moderatorid) {
        if(!isset($moderatorid) )
            return array();
        return Database::query('SELECT p.* FROM podrucja p 
                                WHERE p.id_podrucja NOT IN 
                                    (SELECT pr.id_podrucja 
                                    FROM pretplate pr 
                                    WHERE pr.id_korisnika=:modid AND 
                                    pr.status=2) AND 
                                p.status=1 ', 
                               array('modid'=>$moderatorid) );
    }
    
    public static function get_areas_for_subscriber($userid) {
        if(!isset($userid) )
            return array();
        return Database::query('SELECT p.* FROM podrucja p 
                                JOIN pretplate pr 
                                ON p.id_podrucja=pr.id_podrucja 
                                WHERE pr.id_korisnika=:userid AND 
                                pr.status=1 AND 
                                p.status=1', 
                               array('userid'=>$userid) );
    }
    
    public static function get_areas_not_subscribed($userid) {
        if(!isset($userid) )
            return array();
        return Database::query('SELECT p.* FROM podrucja p 
                                WHERE p.id_podrucja NOT IN 
                                    (SELECT pr.id_podrucja 
                                    FROM pretplate pr 
                                    WHERE pr.id_korisnika=:userid AND 
                                    pr.status>0) AND 
                                p.status=1', 
                               array('userid'=>$userid) );
    }
    
    public static function check_area_moderation($areaid, $moderatorid) {
        if(!isset($areaid) || !isset($moderatorid) )
            return false;
        $res = Database::query('SELECT * FROM pretplate 
                                WHERE id_korisnika=:modid AND 
                                id_podrucja=:areaid AND 
                                status=2', 
                               array('areaid'=>$areaid, 
                                     'modid'=>$moderatorid) );
        if(count($res) > 0)
            return true;
        return false;
    }
    public static function check_area_subscription($areaid, $userid) {
        if(!isset($areaid) || !isset($userid) )
            return false;
        $res = Database::query('SELECT * FROM pretplate 
                                WHERE id_korisnika=:userid AND 
                                id_podrucja=:areaid AND 
                                status>0', 
                               array('areaid'=>$areaid, 
                                     'userid'=>$userid) );
        if(count($res) > 0)
            return true;
        return false;
    }
    
    public static function create_area($area) {
        if(!isset($area) || !is_array($area) )
            return false;
        if(!isset($area['naziv_podrucja']) || 
           !isset($area['opis']) ||
           !isset($area['slika']) )
            return false;
        return Database::insert('INSERT INTO podrucja 
                                (naziv_podrucja, opis, slika, status) 
                                VALUES(:aname, :adesc, :aimg, 1)', 
                               array('aname'=>$area['naziv_podrucja'], 
                                     'adesc'=>$area['opis'],
                                     'aimg'=>$area['slika']) );
    }
    public static function delete_area($areaid) {
        if(!isset($areaid) )
            return false;
        return Database::insert('UPDATE podrucja 
                                 SET status=0 
                                 WHERE id_podrucja=:areaid AND 
                                 status=1', 
                               array('areaid'=>$areaid) );
    }
    public static function undelete_area($areaid) {
        if(!isset($areaid) )
            return false;
        return Database::insert('UPDATE podrucja 
                                 SET status=1 
                                 WHERE id_podrucja=:areaid AND 
                                 status=0', 
                               array('areaid'=>$areaid) );
    }
    public static function update_area($area) {
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
    public static function get_subscribes() {
        return Database::query('SELECT * FROM pretplate WHERE status=1');
    }
    public static function get_moderations() {
        return Database::query('SELECT * FROM pretplate WHERE status=2');
    }
    public static function get_subscribers_for_area($areaid) {
        if(!isset($areaid) )
            return array();
        return Database::query('SELECT k.* FROM pretplate p 
                                JOIN korisnici k ON k.id_korisnika=p.id_korisnika 
                                WHERE id_podrucja=:id_podrucja AND 
                                p.status=1 AND k.status>1',
                                array('id_podrucja'=>$areaid) );
    }
    public static function get_moderators_for_area($areaid) {
        if(!isset($areaid) )
            return array();
        return Database::query('SELECT k.* FROM pretplate p 
                                JOIN korisnici k ON k.id_korisnika=p.id_korisnika 
                                WHERE id_podrucja=:id_podrucja AND 
                                p.status=2 AND k.status>1',
                                array('id_podrucja'=>$areaid) );
    }
    
    
    public static function subscribe($areaid, $userid) {
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
    public static function unsubscribe($areaid, $userid) {
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
    public static function get_articles() {
        return Database::query('SELECT * FROM clanci WHERE status=1');
    }
    public static function get_deleted_articles() {
        return Database::query('SELECT * FROM clanci WHERE status=1');
    }
    
    public static function get_article($articleid) {
        if(!isset($articleid) )
            return array();
        $articles = Database::query('SELECT * FROM clanci 
                                     WHERE id_clanka=:articleid AND 
                                     status=1',
                                    array('articleid'=>$articleid) );
        if(count($articles) == 1)
            return $articles[0];
        return array();
    }
    
    public static function get_articles_for_area($areaid) {
        if(!isset($areaid) )
            return array();
            
        return Database::query('SELECT *,
                        (SELECT count(*) FROM materijali 
                            WHERE clanci.id_clanka = materijali.id_clanka AND 
                            materijali.status=1 AND 
                            materijali.id_tipa_materijala = 1) AS broj_slika,
                        (SELECT count(*) FROM materijali 
                            WHERE clanci.id_clanka = materijali.id_clanka AND 
                            materijali.status=1 AND 
                            materijali.id_tipa_materijala = 2) AS broj_videa,
                        (SELECT count(*) FROM materijali 
                            WHERE clanci.id_clanka = materijali.id_clanka AND 
                            materijali.status=1 AND 
                            materijali.id_tipa_materijala = 3) AS broj_dokumenata
                    FROM clanci 
                    WHERE status = 1 AND 
                          id_podrucja = :areaid',
                    array('areaid'=>$areaid) );
    }
    
    public static function check_article_restriction($moderatorid, $userid) {
        if(!isset($moderatorid) || !isset($userid) )
            return 1;
        $res = Database::query('SELECT zp.* FROM zabrana_pristupa 
                                JOIN korisnici k ON k.id_korisnika=zp.id_moderatora 
                                JOIN clanci c ON c.id_korisnika=k.id_korisnika
                                WHERE c.id_korisnika=:moderatorid AND 
                                zp.id_korisnika=:userid AND 
                                zp.status=1 AND 
                                k.status>1 AND 
                                c.status=0',
                                array('moderatorid'=>$moderatorid,
                                      'userid'=>$userid) );
        if(count($res)>0)
            return 1;
        return 0;
    }
    
    public static function check_area_subscription_by_article($articleid, $userid) {
        if(!isset($articleid) || !isset($userid) )
            return 1;
        $res = Database::query('SELECT * FROM pretplate 
                                WHERE id_podrucja=(SELECT id_podrucja 
                                    FROM clanci 
                                    WHERE id_clanka=:articleid) AND 
                                id_korisnika=:userid AND 
                                status>0',
                                array('articleid'=>$articleid,
                                      'userid'=>$userid) );
        if(count($res)>0)
            return 1;
        return 0;
    }
    
    ///////////////////////////////////////////////////////////////////////
    // article grades
    public static function get_grades() {
        return Database::query('SELECT * FROM ocjene_clanaka WHERE status=1');
    }
    public static function get_article_grade($articleid) {
        if(!isset($articleid) )
            return 0;
        //TODO: ?? return Database::query('SELECT * FROM clanci WHERE status=1');
        return 0;
    }
    public static function get_article_grade_count($articleid) {
        if(!isset($articleid) )
            return 0;
        //TODO: ?? return Database::query('SELECT * FROM clanci WHERE status=1');
        return 0;
    }
    
    public static function grade_article($grade) {
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
    public static function ungrade_article($grade) {
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
    public static function get_comments() {
        return Database::query('SELECT * FROM komentari WHERE status=1');
    }
    public static function get_deleted_comments() {
        return Database::query('SELECT * FROM komentari WHERE status=0');
    }
    public static function get_comments_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT kom.*, k.korisnicko_ime, k.ime, 
                                        k.prezime, k.status AS status_korisnika 
                                FROM komentari kom 
                                JOIN korisnici k ON kom.id_korisnika=k.id_korisnika 
                                WHERE kom.id_clanka=:articleid AND 
                                kom.status=1',
                                array('articleid'=>$articleid) );
    }
    public static function get_comments_for_user($userid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT * FROM komentari 
                                WHERE id_korisnika=:userid AND status=1', 
                                array('userid'=>$userid) );
    }
    
    
    public static function comment_article($comment) {
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
    public static function delete_comment($commentid) {
        if(!isset($commentid) )
            return false;
        return Database::insert('UPDATE komentari SET status=0 
                                 WHERE id_komentara=:commentid',
                                array('commentid'=>$commentid) );
    }
    public static function undelete_comment($commentid) {
        if(!isset($commentid) )
            return false;
        return Database::insert('UPDATE komentari SET status=1 
                                 WHERE id_komentara=:commentid',
                                array('commentid'=>$commentid) );
    }
    public static function update_comment($comment) {
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
    public static function get_materials() {
        return Database::query('SELECT * FROM materijali WHERE status=1');
    }
    public static function get_deleted_materials() {
        return Database::query('SELECT * FROM materijali WHERE status=0');
    }
    public static function get_materials_for_article($articleid) {
        if(!isset($articleid) )
            return array();
        return Database::query('SELECT * FROM materijali 
                                WHERE id_clanka=:$articleid AND status=1',
                               array('articleid'=>$articleid) );
    }
    
    public static function get_images_for_article($articleid) {
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
    public static function get_videos_for_article($articleid) {
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
    public static function get_documents_for_article($type) {
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
    public static function get_logins() {
        return Database::query('SELECT * FROM prijave WHERE status=1');
    }
    public static function get_logins_for_user($userid) {
        if(!isset($userid) )
            return array();
        return Database::query('SELECT * FROM prijave 
                                WHERE id_korisnika=:userid AND 
                                status=1', 
                               array('userid'=>$userid) );
    }
    
    public static function get_login_failed_count($userid) {
        if(!isset($userid) )
            return -1;
        $counts = Database::query('SELECT count(*) prijave 
                                  WHERE id_korisnika=:userid AND 
                                  status=1', 
                                  array('userid'=>$userid) );
        if(count($counts) == 1)
            return $counts[0];
        return -1;
    }
    
    public static function insert_login($userid, $time) {
        if(!isset($userid) || !isset($time) )
            return false;
        Database::insert('UPDATE prijave 
                          SET status=0 
                          WHERE id_korisnika=:userid AND 
                          status=1', 
                          array('userid'=>$userid) );
        Database::insert('INSERT INTO prijave(id_korisnika, vrijeme_od, vrijeme_do, status) 
                          VALUES(:userid, :time, NULL, 1)', 
                         array('userid'=>$userid, 
                               'time'=>$time) );
        return true;
    }
    public static function insert_logout($userid, $time) {
        if(!isset($userid) || !isset($time) )
            return false;
        return Database::insert('UPDATE prijave SET vrijeme_do=:time, status=0
                                 WHERE id_korisnika=:userid AND 
                                 vrijeme_do IS NULL AND 
                                 status=1', 
                                array('userid'=>$userid, 
                                      'time'=>$time) );
    }
    public static function insert_login_fail($userid, $time) {
        if(!isset($userid) || !isset($time) )
            return false;
        return Database::insert('INSERT INTO prijave(id_korisnika, vrijeme_od, vrijeme_do, status) 
                                 VALUES(:userid, :time1, :time2, 1)', 
                                array('userid'=>$userid, 
                                      'time1'=>$time,
                                      'time2'=>$time) );
    }
    
    
    ///////////////////////////////////////////////////////////////////////
    // systemtime
    public static function get_systemtime() {
        $res = Database::query('SELECT trenutno_vrijeme FROM vrijeme_sustava WHERE id=1');
        if(count($res) == 1) {
            $tv = $res[0];
            return $tv['trenutno_vrijeme'];
        }
        return 0;
    }
    public static function set_systemtime($time) {
        if(!isset($time) )
            return false;
        return Database::insert('UPDATE vrijeme_sustava 
                                 SET trenutno_vrijeme=:time 
                                 WHERE id=1', 
                                array('time'=>$time) );
    }
    public static function set_systemtime_from_arka() {
        $time = Server_time::get_saved_time();
        if(!isset($time) )
            return false;
        return Database::insert('UPDATE vrijeme_sustava 
                                 SET trenutno_vrijeme=:time 
                                 WHERE id=1', 
                                array('time'=>$time) );
    }
}

?>