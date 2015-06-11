<?php

class Admin_view extends Webpage_view {
    public function output() {
        
    }
    public function time($time='') {
        $page = $this->view_prepare();
        
        $content_time = new Body_table_template('Vrijeme', '<p>Virtualno vrijeme: '.$time.'s</p>');
        $content_stat = new Body_table_template('Statistika', '<p>...</p>');
        
        $content = $content_time->fill() . $content_stat->fill();
        
        $page->set_body($content);
        
        return $page->fill();
    }
    
    protected function view_prepare() {
        $page = new Standard_template('Admin panel', '');
        $page->set('option-admin', ' selected');
        
        return $page;
    }
}

?>