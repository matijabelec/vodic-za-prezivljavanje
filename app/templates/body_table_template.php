<?php

class Body_table_template extends Template {
    public function __construct($title, $tabledata='') {
        parent::__construct('body/table');
        
        $this->set('title', $title);
        $this->set('table-data', $tabledata);
    }
    
    public function set_title($title) {
        $this->set('title', $title);
    }
    public function set_tabledata($tabledata) {
        $this->set('table-data', $tabledata);
    }
}

?>