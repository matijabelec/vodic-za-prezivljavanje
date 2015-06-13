<?php

class Articles_view extends Webpage_view {
    public function view($articles=array() ) {
        $page = $this->view_prepare();
        
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
        $page->set_body($content->fill() );
        unset($content);
        
        return $page->fill();
    }
    
    public function read($article, $comments) {
        $page = $this->view_prepare();
        
        $content = new Template('data/table-article');
        
        $t = '';
        $tpl = new Template('data/table-comment-on-article');
        foreach($comments as $data) {
            foreach($data as $key=>$val) {
                $tpl->set($key, $val);
            }
            $t .= $tpl->fill();
        }
        unset($tpl);
        
        $page->set('article-comments', $t);
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