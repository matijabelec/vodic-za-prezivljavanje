<?php

class Admin_view extends Webpage_view {
    public function time($data) {
        $time = $data['time'];
        $timeoffset = $data['time-offset'];
        
        $content = new Template('body/admin-panel');
        $content->set('trenutno_vrijeme', $time);
        $content->set('pomak_vremena', $timeoffset);
        $cf = $content->fill();
        unset($content);
        
        return $this->page('Admin panel', $cf);
    }
    
    protected function page($title, $body) {
        $footdata = '<script>';
        $footdata .= 'var relurl="' . WEBSITE_ROOT_PATH . '"; ';
        $footdata .= '</script>';
        $footdata .= '<script src="' . WEBSITE_ROOT_PATH . '/site/js/script-admin.js"></script>';
        
        $page = new Standard_template('Područja');
        $page->set('option-admin', ' selected');
        $page->set('body', $body);
        $page->set('foot-data', $footdata);
        $pf = $page->fill();
        unset($page);
        
        return $pf;
    }
    
    public function view_table($tablename, $data) {
        $tablename = '<h3 class="table-name">' . $tablename . '</h3>';
        $table = $this->create_table($data);
        if($table == '')
            $table = '<p>Nema podataka</p>';
        return $tablename . $table;
    }
}

?>