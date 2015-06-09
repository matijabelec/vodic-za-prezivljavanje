<?php

class Admin_view extends Webpage_view {
    public function output() {
        
    }
    public function time($time='') {
        $userprofile = new Template('data/user_profile_menu_login');
        
        $content_time = new Body_table_template('Vrijeme', '<p>Virtualno vrijeme: '.$time.'s</p>');
        $content_stat = new Body_table_template('Statistika', '<p>...</p>');
        
        $content = $content_time->fill() . $content_stat->fill();
        
        $page = new Standard_template('Admin', '', 
                                      $content, 
                                      $userprofile->fill() );
        return $page->fill();
    }
}

?>