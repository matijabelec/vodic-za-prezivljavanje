<?php

class Error_view extends Webpage_view {
    public function output() {
        $content = new Template('body/error');
        
        $page = new Standard_template('Kriva adresa');
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
}

?>