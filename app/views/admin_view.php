<?php

class Admin_view extends Webpage_view {
    public function time($time) {
        $vrijeme = '<p>Virtualno vrijeme: ' . $time . 's</p>';
        $vrijeme .= '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/admin/time">Ažuriraj</a>';
        $vrijeme .= '<a class="btn" href="http://arka.foi.hr/WebDiP/pomak_vremena/vrijeme.html" target="_blank">Postavi</a>';
        $content_time = new Body_table_template('Vrijeme', $vrijeme);
        $content_stat = new Body_table_template('Statistika', '<p>...</p>');
        
        $content = $content_time->fill() . $content_stat->fill();
        
        return $this->page('Admin panel', $content);
    }
    
    protected function page($title, $body, $data=null) {
        $footdata = '';
        /*if(!is_null($data) && is_array($data) ) {
            if(isset($data['areaid']) && isset($data['elem']) ) {
                $footdata = '<script>';
                $footdata .= 'var relurl="' . WEBSITE_ROOT_PATH . '"; ';
                $footdata .= 'var get_articles=true; ';
                $footdata .= 'var areaid=' . $data['areaid'] . '; ';
                $footdata .= 'var elem=$("' . $data['elem'] . '"); ';
                $footdata .= '</script>';
                $footdata .= '<script src="' . WEBSITE_ROOT_PATH . '/site/js/script-areas.js"></script>';
            }
        }*/
        
        $page = new Standard_template('Područja');
        $page->set('option-admin', ' selected');
        $page->set('body', $body);
        $page->set('foot-data', $footdata);
        $pf = $page->fill();
        unset($page);
        
        return $pf;
    }
}

?>