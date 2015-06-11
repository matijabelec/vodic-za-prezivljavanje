<?php

class Crud_podrucja extends Template {
    public function __construct() {
        parent::__construct('data/table-podrucja-crud');
        
        $this->set('link-back', '');
        $this->set('link', '');
        
        $this->set('id_podrucja', '0');
        $this->set('naziv_podrucja', '');
        
        $this->set('status-1', '');
        $this->set('status-2', '');
        
        $this->set('readonly', '');
        
        $this->set('title', '');
        $this->set('data', '');
        $this->set('btn-submit', 'Potvrdi');
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
    
    public function fill_data($data) {
        if(isset($data) && is_array($data) ) {
            foreach($data as $key=>$val) {
                $this->set($key, $val);
            }
        }
    }
}

?>