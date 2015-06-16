<?php

class Articles_view extends Webpage_view {
    public function view($articles) {
        $body = $this->create_table($articles);
        if($body == '')
            $body = '<p>Nema članaka</p>';
        
        $content = new Template('data/areas/view');
        $content->set('menu', $this->create_menu(array('c') ) );
        
        $content->set('title', 'Područja');
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        return $this->page('Područja', $cf);
    }
    
    public function read($article, $comments, $grade, $gradecnt, $rate=true) {
        $areaid = $article['id_podrucja'];
        $articleid = $article['id_clanka'];
        $article['article-comments'] = '<p>Nema komentara</p>';
        $article['article-controls'] = 
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/read/' . $areaid . '">Natrag</a> ' . 
            '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/comments/create/' . $articleid . '">Komentiraj</a> ';
        
        if($rate) {
            $lnkstart = '<a href="' . WEBSITE_ROOT_PATH . '/articles/grade/' . $articleid . '/';
            
            $article['ocjena-0'] = $lnkstart . '0"><span class="star">' . ($grade==0?'':'X') . '</span></a>';
            $article['ocjena-1'] = $lnkstart . '1"><span class="star">' . ($grade==1?'*':'+') . '</span></a>';
            $article['ocjena-2'] = $lnkstart . '2"><span class="star">' . ($grade==2?'*':'+') . '</span></a>';
            $article['ocjena-3'] = $lnkstart . '3"><span class="star">' . ($grade==3?'*':'+') . '</span></a>';
            $article['ocjena-4'] = $lnkstart . '4"><span class="star">' . ($grade==4?'*':'+') . '</span></a>';
            $article['ocjena-5'] = $lnkstart . '5"><span class="star">' . ($grade==5?'*':'+') . '</span></a> ';
        } else {
            $article['ocjena-0'] = '';
            $article['ocjena-1'] = '';
            $article['ocjena-2'] = '';
            $article['ocjena-3'] = '';
            $article['ocjena-4'] = '';
            $article['ocjena-5'] = '';
        }
        
        if($gradecnt == '')
            $gradecnt = '-';
        $article['ocjena'] = $gradecnt . ($rate ? ' | ' : '');
        
        $body = $this->view_standard($article);
        
        $content = new Template('data/areas/view');
        $content->set('menu', '');
        $content->set('title', $article['naslov']);
        $content->set('body', $body);
        $cf = $content->fill();
        unset($content);
        
        $data = array('articleid'=>$article['id_clanka'],
                      'elem'=>'#article-comments-container');
        return $this->page('Članci', $cf, $data);
    }
    
    
    public function crud_create($articleid) {
        $page = $this->view_prepare();
        
        $content = new Crud_articles();
        $content->set('link-back', 'areas/read/' . $articleid);
        $content->set('link', 'articles/create');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    
    
    
    
    public function create($article) {
        $body = $this->view_input($article);
        return $this->page('Članci', $body);
    }
    
    
    protected function page($title, $body, $data=null) {
        $footdata = '';
        if(!is_null($data) && is_array($data) ) {
            if(isset($data['articleid']) && isset($data['elem']) ) {
                $footdata = '<script>';
                $footdata .= 'var relurl="' . WEBSITE_ROOT_PATH . '"; ';
                $footdata .= 'var get_comments=true; ';
                $footdata .= 'var articleid=' . $data['articleid'] . '; ';
                $footdata .= 'var elem=$("' . $data['elem'] . '"); ';
                $footdata .= '</script>';
                $footdata .= '<script src="' . WEBSITE_ROOT_PATH . '/site/js/script-articles.js"></script>';
            }
        }
        
        $page = new Standard_template('Članci');
        $page->set('option-articles', ' selected');
        $page->set('body', $body);
        $page->set('foot-data', $footdata);
        $pf = $page->fill();
        unset($page);
        
        return $pf;
    }
    
    
    protected function view_mini($data, $ma=null) {
        $article = new Template('data/articles/article-mini');
        $menu = $this->create_menu($ma, $data['id_clanka']);
        $article->set('menu', $menu);
        $this->fill_data($article, $data);
        $fill = $article->fill();
        unset($article);
        return $fill;
    }
    protected function view_standard($data, $ma=null) {
        $article = new Template('data/articles/article');
        $menu = $this->create_menu($ma, $data['id_clanka']);
        $article->set('menu', $menu);
        $this->fill_data($article, $data);
        $fill = $article->fill();
        unset($article);
        return $fill;
    }
    protected function view_full($data, $ma=null) {
        $article = new Template('data/articles/article-full');
        $menu = $this->create_menu($ma, $data['id_clanka']);
        $article->set('menu', $menu);
        $this->fill_data($article, $data);
        $fill = $article->fill();
        unset($article);
        return $fill;
    }
    protected function view_input($data, $ma=null) {
        $article = new Template('data/articles/article-input');
        $menu = $this->create_menu($ma, $data['id_clanka']);
        $article->set('menu', $menu);
        $this->fill_data($article, $data);
        $fill = $article->fill();
        unset($article);
        return $fill;
    }
    protected function view_article_on_area($data, $ma=null) {
        $article = new Template('data/articles/article-on-area-guest');
        $menu = $this->create_menu($ma, $data['id_clanka']);
        $article->set('menu', $menu);
        $this->fill_data($article, $data);
        $fill = $article->fill();
        unset($article);
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
    
    
    
    
    public function ajax_view($articles) {
        $body = '<p>Nema članaka</p>';
        if(count($articles) ) {
            $body = '<ul>';
            foreach($articles as &$article)
                $body .= $this->view_article_on_area($article);
            $body .= '</ul>';
        }
        return $body;
    }
    public function ajax_view_reg($articles) {
        $body = '<p>Nema članaka</p>';
        if(count($articles) ) {
            $body = '<ul>';
            foreach($articles as &$article)
                $body .= $this->view_article_on_area($article, array('r') );
            $body .= '</ul>';
        }
        return $body;
    }
}

?>