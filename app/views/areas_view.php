<?php

class Areas_view extends Webpage_view {
    public function view($areas) {
        $body = '';
        foreach($areas as &$area)
            $body .= $this->view_mini($area, array('r') );
        if($body == '')
            $body = '<p>Nema područja</p>';
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', 'Područja');
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        return $this->page('Područja', $cf);
    }
    public function view_reg($areas) {
        $body = '';
        foreach($areas as &$area)
            $body .= $this->view_mini($area, array('r') );
        if($body == '')
            $body = '<p>Nema područja</p>';
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', 'Područja');
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        return $this->page('Područja', $cf);
    }
    public function view_mod($areas, $areas2) {
        $body = '';
        foreach($areas as &$area)
            $body .= $this->view_mini($area, array('r', 'u') );
        if($body == '')
            $body = '<p>Nema područja</p>';
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', 'Područja za koja sam moderator');
        $content->set('body', $body);
        $cf = $content->fill();
        
        $body = '';
        foreach($areas2 as &$area)
            $body .= $this->view_mini($area, array('r') );
        if($body == '')
            $body = '<p>Nema područja</p>';
        
        $content->set('title', 'Ostala područja');
        $content->set('body', $body);
        $cf .= $content->fill();
        unset($content);
        
        return $this->page('Područja', $cf);
    }
    public function view_admin($areas, $areas2) {
        $menu = $this->create_menu(array('c') );
        
        $body = '';
        foreach($areas as &$area)
            $body .= $this->view_mini($area, array('r', 'u', 'd') );
        if($body == '')
            $body = '<p>Nema područja</p>';
        
        $content = new Template('data/areas/view');
        $content->set('menu', $menu);
        $content->set('title', 'Aktivna područja');
        $content->set('body', $body);
        $cf = $content->fill();
        
        $body = '';
        foreach($areas2 as &$area)
            $body .= $this->view_mini($area, array('a') );
        if($body == '')
            $body = '<p>Nema područja</p>';
        
        $content->set('menu', '');
        $content->set('title', 'Izbrisana područja');
        $content->set('body', $body);
        $cf .= $content->fill();
        unset($content);
        
        return $this->page('Područja', $cf);
    }
    
    
    public function create($area) {
        $body = $this->view_input($area);
        
        return $this->page('Područja', $body);
    }
    
    
    
    public function read($area, $articles) {
        $area['area-articles'] = '<p>Nema članaka</p>';
        $area['area-controls'] = 
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/view">Natrag</a> ';
        
        $body = $this->view_standard($area);
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', $area['naziv_podrucja']);
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        return $this->page('Područja', $cf);
    }
    public function read_reg($area, $articles, $subscribe) {
        $areaid = $area['id_podrucja'];
        $area['area-articles'] = '<p>Nema članaka</p>';
        $area['area-controls'] = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/view">Natrag</a>';
        if($subscribe)
            $area['area-controls'] .= ' <a class="btn" href="' . WEBSITE_ROOT_PATH . '/subscribes/create/' . $areaid . '">Pretplati se</a>';
        else
            $area['area-controls'] .= ' <a class="btn" href="' . WEBSITE_ROOT_PATH . '/subscribes/delete/' . $areaid . '">Ukloni pretplatu</a>';
        $body = $this->view_standard($area);
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', $area['naziv_podrucja']);
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        $data = array('areaid'=>$area['id_podrucja'],
                      'elem'=>'#articles-containter');
        return $this->page('Područja', $cf, $data);
    }
    public function read_mod($area, $articles) {
        $area['area-articles'] = '<p>Nema članaka</p>';
        $area['area-controls'] = 
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/view">Natrag</a> ' .
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/update/' . $area['id_podrucja'] . '">Uredi</a>';
        
        $body = $this->view_standard($area);
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', $area['naziv_podrucja']);
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        $data = array('areaid'=>$area['id_podrucja'],
                      'elem'=>'#articles-containter');
        return $this->page('Područja', $cf, $data);
    }
    public function read_admin($area, $articles) {
        $area['area-articles'] = '<p>Nema članaka</p>';
        $area['area-controls'] = 
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/view">Natrag</a> ' . 
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/update/' . $area['id_podrucja'] . '">Uredi</a>';
        
        $body = $this->view_standard($area);
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', $area['naziv_podrucja']);
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        $data = array('areaid'=>$area['id_podrucja'],
                      'elem'=>'#articles-containter');
        return $this->page('Područja', $cf, $data);
    }
    
    
    public function update($area) {
        $body = $this->view_input($area);
        return $this->page('Područja', $body);
    }
    
    
    
    
    
    
    protected function page($title, $body, $data=null) {
        $footdata = '';
        if(!is_null($data) && is_array($data) ) {
            if(isset($data['areaid']) && isset($data['elem']) ) {
                $footdata = '<script>';
                $footdata .= 'var relurl="' . WEBSITE_ROOT_PATH . '"; ';
                $footdata .= 'var get_articles=true; ';
                $footdata .= 'var areaid=' . $data['areaid'] . '; ';
                $footdata .= 'var elem=$("' . $data['elem'] . '"); ';
                $footdata .= '</script>';
                $footdata .= '<script src="/site/js/script-areas.js"></script>';
            }
        }
        
        $page = new Standard_template('Područja');
        $page->set('option-areas', ' selected');
        $page->set('body', $body);
        $page->set('foot-data', $footdata);
        $pf = $page->fill();
        unset($page);
        
        return $pf;
    }
    
    
    protected function view_mini($data, $ma=null) {
        $area = new Template('data/areas/area-mini');
        $menu = $this->create_menu($ma, $data['id_podrucja']);
        $area->set('menu', $menu);
        $this->fill_data($area, $data);
        $fill = $area->fill();
        unset($area);
        return $fill;
    }
    protected function view_standard($data, $ma=null) {
        $area = new Template('data/areas/area');
        $menu = $this->create_menu($ma, $data['id_podrucja']);
        $area->set('menu', $menu);
        $this->fill_data($area, $data);
        $fill = $area->fill();
        unset($area);
        return $fill;
    }
    protected function view_full($data, $ma=null) {
        $area = new Template('data/areas/area-full');
        $menu = $this->create_menu($ma, $data['id_podrucja']);
        $area->set('menu', $menu);
        $this->fill_data($area, $data);
        $fill = $area->fill();
        unset($area);
        return $fill;
    }
    protected function view_input($data, $ma=null) {
        $area = new Template('data/areas/area-input');
        $menu = $this->create_menu($ma, $data['id_podrucja']);
        $area->set('menu', $menu);
        $this->fill_data($area, $data);
        $fill = $area->fill();
        unset($area);
        return $fill;
    }
    
    
    protected function fill_data(&$tpl, &$data) {
        foreach($data as $key=>$val) {
            $tpl->set($key, $val);
        }
    }
    
    
    protected function create_menu($data, $areaid=null) {
        $create = '<p style="text-align:right"><a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/create">Novo</a></p> ';
        $read = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/read/' . $areaid . '">Više</a> ';
        $update = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/update/' . $areaid . '">Uredi</a> ';
        $delete = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/delete/' . $areaid . '">Izbriši</a> ';
        $activate = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/create/' . $areaid . '">Aktiviraj</a> ';
        
        $m = '';
        if(is_array($data) )
            foreach($data as &$d)
                switch($d) {
                    case 'c': $m  .= $create; break;
                    case 'r': $m  .= $read; break;
                    case 'u': $m  .= $update; break;
                    case 'd': $m  .= $delete; break;
                    case 'a': $m  .= $activate; break;
                    default: break;
                }
        return $m;
    }
}

?>