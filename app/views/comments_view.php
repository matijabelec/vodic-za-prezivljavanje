<?php

class Comments_view extends Webpage_view {
    public function create($userid, $articleid, $page=true) {
        $comment = new Template('data/comments/comment-input');
        $data = array('id_clanka'=>$articleid, 
                      'id_korisnika'=>$userid, 
                      'sadrzaj'=>'', 
                      'link-back'=>'articles/read/' . $articleid, 
                      'link'=>'comments/create/'. $articleid);
        $this->fill_data($comment, $data);
        $comment->set('project_root_path', WEBSITE_ROOT_PATH);
        $fill = $comment->fill();
        unset($comment);
        
        if($page != true)
            return $fill;
        
        return $this->page('Novi komentar', $fill);
    }
    
    
    
    protected function view_comment_on_article($data) {
        $comment = new Template('data/comments/comment-on-article');
        $this->fill_data($comment, $data);
        $comment->set('project_root_path', WEBSITE_ROOT_PATH);
        $fill = $comment->fill();
        unset($comment);
        return $fill;
    }
    
    
    protected function fill_data(&$tpl, &$data) {
        foreach($data as $key=>$val) {
            $tpl->set($key, $val);
        }
    }
    
    
    protected function create_menu($data, $articleid=null, $areaid=null) {
        $create = '<p style="text-align:right"><a class="btn" href="' . WEBSITE_ROOT_PATH . '/articles/create">Novo</a></p> ';
        $read = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/articles/read/' . $articleid . '">Više</a> ';
        $update = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/articles/update/' . $articleid . '">Uredi</a> ';
        $delete = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/articles/delete/' . $articleid . '">Izbriši</a> ';
        $activate = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/articles/create/' . $articleid . '">Aktiviraj</a> ';
        $back = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/area/read/' . $areaid . '">Aktiviraj</a> ';
        
        $m = '';
        if(is_array($data) )
            foreach($data as &$d)
                switch($d) {
                    case 'c': $m  .= $create; break;
                    case 'r': $m  .= $read; break;
                    case 'u': $m  .= $update; break;
                    case 'd': $m  .= $delete; break;
                    case 'a': $m  .= $activate; break;
                    case 'b': $m  .= $back; break;
                    default: break;
                }
        return $m;
    }
    
    protected function page($title, $body) {
        $page = new Standard_template($title);
        $page->set('option-comments', ' selected');
        $page->set('body', $body);
        $pf = $page->fill();
        unset($page);
        
        return $pf;
    }
    
    
    public function ajax_view($comments) {
        $body = '<p>Nema komentara</p>';
        if(count($comments) ) {
            $body = '<ul>';
            foreach($comments as &$comment)
                $body .= $this->view_comment_on_article($comment);
            $body .= '</ul>';
        }
        return $body;
    }
}

?>