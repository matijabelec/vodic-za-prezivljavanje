<?php

class Standard_template extends Template {
    public function __construct($title, $head_data='', $body='', $userprofile='') {
        parent::__construct('page/standard');
        
        $this->set('head-data', $head_data);
        $this->set('title', $title);
        
        $this->set('project-title', PROJECT_TITLE);
        $this->set('copyright-info-data', PROJECT_COPYRIGHT_INFO);
        
        $this->set('body', $body);
        $this->set('user-profile-menu', $userprofile);
        
        $this->set('option1', '');
        $this->set('option2', '');
        $this->set('option3', '');
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
}

?>