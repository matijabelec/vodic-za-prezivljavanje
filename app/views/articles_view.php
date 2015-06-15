<?php

class Articles_view extends Webpage_view {
    public function view($articles=array(), $ajax=false) {
        if($ajax == true) {
            $content = new Body_table_template('Članci');
            
            $t = '';
            $tpl = new Template('data/table-article-small');
            foreach($articles as $data) {
                foreach($data as $key=>$val) {
                    $tpl->set($key, $val);
                }
                $t .= $tpl->fill();
            }
            unset($tpl);
            
            if($t == '')
                $t = '<p>Nema članaka</p>';
            
            $content->set_tabledata($t);
            $content->set('project_root_path', WEBSITE_ROOT_PATH);
            $cf = $content->fill();
            unset($content);
            return $cf;
        }
        
        
        $content = new Body_table_template('Članci');
        
        $t = '';
        $tpl = new Template('data/table-article-small');
        foreach($articles as $data) {
            foreach($data as $key=>$val) {
                $tpl->set($key, $val);
            }
            $t .= $tpl->fill();
        }
        unset($tpl);
        
        $content->set_tabledata($t);
        $page = $this->view_prepare();
        $page->set_body($content->fill() );
        unset($content);
        return $page->fill();
    }
    
    public function read($article, $comments) {
        $page = $this->view_prepare();
        
        $content = new Template('data/table-article');
        foreach($article as $key=>$val) {
            $content->set($key, $val);
        }
        
        $t = '';
        if(count($comments) ) {
            $t = '<ul>';
            $tpl = new Template('data/table-comment-on-article');
            $tpl->set('project_root_path', WEBSITE_ROOT_PATH);
            foreach($comments as $data) {
                foreach($data as $key=>$val)
                    $tpl->set($key, $val);
                $t .= $tpl->fill();
            }
            unset($tpl);
            $t .= '</ul>';
        }
        
        $page->set('article-comments', $t);
        $page->set_body($content->fill() );
        unset($content);
        
        return $page->fill();
    }
    
    
    public function crud_create($areaid) {
        $page = $this->view_prepare();
        
        $content = new Crud_articles();
        $content->set('link-back', 'areas/read/' . $areaid);
        $content->set('link', 'articles/create');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    protected function view_prepare() {
        $page = new Standard_template('Članci');
        $page->set('option-articles', ' selected');
        
        return $page;
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
                $footdata .= '<script src="' . WEBSITE_ROOT_PATH . '/site/js/script-areas.js"></script>';
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