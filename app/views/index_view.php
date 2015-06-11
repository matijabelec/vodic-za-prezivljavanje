<?php

class Index_view extends Webpage_view {
    public function output() {
        $content = new Template('body/index');
        
        $page = new Standard_template('Početna');
        $page->set_body($content->fill() );
        $page->set('option-home', ' selected');
        
        return $page->fill();
    }
    
    public function admin() {
        $content = new Template('body/index-auth');
        
        $page = new Standard_template('Početna');
        $page->set_body($content->fill() );
        $page->set('option-home', ' selected');
        
        return $page->fill();
    }
}

?>