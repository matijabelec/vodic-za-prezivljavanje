<?php

class Index_view extends Webpage_view {
    public function output() {
        $this->set_title('I piceki to znaju');
        //$this->add_js('jquery-2.1.3.min');
        
        $content = new Template('body/index');
        
        $page = new Template('page/standard');
        $page->set('head-data', $this->get_head_data() );
        $page->set('title', $this->get_title() );
        $page->set('body', $content->fill() );
        
        $page->set('option1', ' selected');
        $page->set('option2', '');
        $page->set('option3', '');
        $page->set('option4', '');
        $page->set('option5', '');
        
        return $page->fill();
    }
}

?>