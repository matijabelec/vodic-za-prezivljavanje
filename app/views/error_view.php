<?php

class Error_view extends Webpage_view {
    public function output() {
        $page = $this->view_prepare();
        
        $content = new Template('body/error');
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    protected function view_prepare() {
        $page = new Standard_template('Greška');
        
        return $page;
    }
}

?>