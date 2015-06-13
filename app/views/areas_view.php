<?php

class Areas_view extends Webpage_view {
    public function view_guest($areas=array() ) {
        $page = $this->view_prepare();
        
        $content = new Body_table_template('Područja');
        
        $ar = '';
        $areatpl = new Template('data/table-podrucja-0');
        foreach($areas as $area) {
            foreach($area as $key=>$val) {
                $areatpl->set($key, $val);
            }
            $ar .= $areatpl->fill();
        }
        
        $content->set_tabledata($ar);
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function view_registered($areas=array() ) {
        $page = $this->view_prepare();
        
        $content = new Body_table_template('Područja');
        
        $ar = '';
        $areatpl = new Template('data/table-podrucja-3');
        foreach($areas as $area) {
            foreach($area as $key=>$val) {
                $areatpl->set($key, $val);
            }
            $ar .= $areatpl->fill();
        }
        
        $content->set_tabledata($ar);
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    public function crud($areas=array() ) {
        $page = $this->view_prepare();
        
        $crud_create = '<div style="text-align:right">' . Crud::get_html_c('/areas') . '</div>';
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE, 'rud');
        $table2 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_DELETED, 'ru');
        
        $content = new Body_table_template('Područja');
        $content->set_tabledata(
            $crud_create . 
            '<h3>Aktivna područja</h3>' . $table1 . 
            '<h3>Izbrisana područja</h3>' . $table2);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function crud_create() {
        $page = $this->view_prepare();
        
        $content = new Crud_podrucja();
        $content->set('link-back', 'areas/view');
        $content->set('link', 'areas/create');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    public function crud_read($data, $controls=array() ) {
        $page = $this->view_prepare();
        
        if(isset($data['subscribes']) )
            $subsc = $data['subscribes'];
        
        $articles_data = $data['articles'];
        $area_data = $data['area'];
        $areaid = $area_data['id_podrucja'];
        
        $content = new Body_table_template('Područje ' . $areaid);
        
        $areatpl = new Template('data/table-podrucja-read');
        foreach($area_data as $key=>$val) {
            $areatpl->set($key, $val);
        }
        
        if(count($articles_data) > 0) {
            $article_tpl = new Template('data/table-clanci-small-1');
            $article_previewdata = '<ul class="area-articles">';
            foreach($articles_data as $article) {
                foreach($article as $key=>$val)
                    $article_tpl->set($key, $val);
                $article_previewdata .= $article_tpl->fill();
            }
            $article_previewdata .= '</ul>';
        } else
            $article_previewdata = '<p>Nema članaka</p>';
        $areatpl->set('area-articles', $article_previewdata);
        
        $ctrls = '';
        foreach($controls as $c)
            if($c == 'back')
                $ctrls .= '<a class="btn" href="{@project_root_path}/areas/view">Natrag</a>';
            elseif($c == 'update')
                $ctrls .= '<a class="btn" href="{@project_root_path}/areas/update/' . $areaid . '">Uredi</a>';
            elseif($c == 'delete')
                $ctrls .= '<a class="btn" href="{@project_root_path}/areas/delete/' . $areaid . '">Izbriši</a>';
            elseif($c == 'subscribe') {
                if($subsc != true) {
                    $subs_link = 'create';
                    $subs = 'Pretplati se';
                } else {
                    $subs_link = 'delete';
                    $subs = 'Prekini pretplatu';
                }
                
                $ctrls .= '<a class="btn" href="{@project_root_path}/subscribes/' . $subs_link . '/' . $areaid . '">' . $subs . '</a>';
            }
        
        $areatpl->set('area-controls', $ctrls);
        
        
        
        $content->set_tabledata($areatpl->fill() );
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    public function crud_update($data) {
        $page = $this->view_prepare();
        
        $content = new Crud_podrucja();
        $content->fill_data($data);
        $content->set('link-back', 'areas/view');
        $content->set('link', 'areas/update/'.$data['id_podrucja']);
        $content->set('status-'.$data['status'], 'selected');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    
    protected function create_table_areas($data='', $type=PROJECT_DATA_STATUS_ACTIVE, $crud=false, $headers=true) {
        $table = '';
        $cnt = 0;
        if(count($data) > 0) {
            $table = '<table>';
            if($headers == true) {
                $table .= '<tr>';
                foreach($data[0] as $key=>$val)
                    $table .= '<th>' . $key . '</th>';
                if($crud != false) {
                    $table .= '<th>CRUD</th>';
                }
                $table .= '</tr>';
            }
            
            foreach($data as $d) {
                if($d['Status'] == $type) {
                    $table .= '<tr>';
                    foreach($d as $key=>$val)
                        $table .= '<td>' . $val . '</td>';
                    if($crud != false) {
                        if($crud=='rud')
                            $table .= '<td style="white-space: nowrap">' . Crud::get_html_rud('/areas', '/'.$d['ID']) . '</td>';
                        else
                            $table .= '<td style="white-space: nowrap">' . Crud::get_html_ru('/areas', '/'.$d['ID']) . '</td>';
                    }
                    $table .= '</tr>';
                    $cnt++;
                }
            }
            $table .= '</table>';
        }
        if($cnt == 0)
            return '<p>Nema podataka</p>';
        return $table;
    }
    
    protected function view_prepare() {
        $page = new Standard_template('Područja');
        $page->set('option-areas', ' selected');
        
        return $page;
    }
}

?>