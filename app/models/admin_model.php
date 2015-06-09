<?php

class Admin_model extends Model {
    public function set_time() {
        Server_time::set_time();
    }
    public function get_time() {
        return Server_time::get_saved_time();
    }
}

?>