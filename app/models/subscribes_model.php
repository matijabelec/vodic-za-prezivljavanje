<?php

class Subscribes_model extends Model {
    public function get_subscribes() {
        $subscribes = Database::query('SELECT * FROM pretplate');
        return $subscribes;
    }
    public function get_active_subscribes() {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE status = 1');
        return $subscribes;
    }
    public function get_deleted_subscribes() {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE status = 0');
        return $subscribes;
    }
    public function get_restricted_subscribes() {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE status = 0');
        return $subscribes;
    }
    
    
    public function get_subscribes_for_area($areaid) {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE id_podrucja = :areaid',
                                    array('areaid'=>$areaid) );
        return $subscribes;
    }
    public function get_active_subscribes_for_area($areaid) {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE id_podrucja = :areaid AND status = 1',
                                    array('areaid'=>$areaid) );
        return $subscribes;
    }
    public function get_deleted_subscribes_for_area($areaid) {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE id_podrucja = :areaid AND status = 0',
                                    array('areaid'=>$areaid) );
        return $subscribes;
    }
    public function get_restricted_subscribes_for_area($areaid) {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE id_podrucja = :areaid AND status = 2',
                                    array('areaid'=>$areaid) );
        return $subscribes;
    }
    
    
    public static function subscribe($userid, $areaid) {
        $ok = Database::insert('INSERT INTO pretplate(id_podrucja, id_korisnika, status) VALUES(:areaid, :userid, 1)',
                            array('userid'=>$userid, 'areaid'=>$areaid) );
        if(!$ok) {
            return Database::insert('UPDATE pretplate SET status = 1 WHERE id_korisnika = :userid AND id_podrucja = :areaid AND status = 0',
                                    array('userid'=>$userid, 'areaid'=>$areaid) );
        }
        return false;
    }
    
    public static function unsubscribe($userid, $areaid) {
        return Database::insert('UPDATE pretplate SET status = 0 WHERE id_korisnika = :userid AND id_podrucja = :areaid AND status = 1',
                                array('userid'=>$userid, 'areaid'=>$areaid) );
    }
    
    
    public static function restrict_access($userid, $areaid) {
        return Database::insert('UPDATE pretplate SET status = 2 WHERE id_korisnika = :userid AND id_podrucja = :areaid',
                                array('userid'=>$userid, 'areaid'=>$areaid) );
    }
    
    
    public static function check_subscription($userid, $areaid) {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE id_korisnika = :userid AND id_podrucja = :areaid AND status = 1',
                                    array('userid'=>$userid, 'areaid'=>$areaid) );
        if(count($subscribes) == 0)
            return false;
        return true;
    }
    public static function check_subscription_restricted($userid, $areaid) {
        $subscribes = Database::query('SELECT * FROM pretplate WHERE id_korisnika = :userid AND id_podrucja = :areaid AND status = 2',
                                    array('userid'=>$userid, 'areaid'=>$areaid) );
        if(count($subscribes) == 0)
            return false;
        return true;
    }
}

?>