<?php

class Auth_view extends Webpage_view {
    public function login() {
        $this->set_title('/ Login');
        //$this->add_js('jquery-2.1.3.min');
        
        $content = new Template('body/login');
        
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
    
    public function logout() {
        $this->set_title('/ Logout');
        //$this->add_js('jquery-2.1.3.min');
        
        $content = new Template('body/logout');
        
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