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
}

?>