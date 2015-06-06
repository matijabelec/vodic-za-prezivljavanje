<?php

class Story_model extends Model {
    public function get_story_by_id($id) {
        $db = Database::connect();
        
        $st = $db->prepare("SELECT * FROM stories_view WHERE id = :id");
        $st->execute(['id'=>$id]);
        $res = $st->fetchAll();
        
        $st = $db->prepare("SELECT DISTINCT * FROM story_authors_view WHERE story_id = :id");
        $st->execute(['id'=>$id]);
        $res_au = $st->fetchAll();
        
        Database::disconnect();
        
        if(0 == count($res) )
            return RET_ERR;
        
        $authors = [];
        foreach($res_au as $row)
            $authors[] = [
                'id' => $row['member_id'],
                'name' => $row['member_name']
            ];
        $r = $res[0];
        $data = [
            'id' => $r['id'],
            'title' => $r['story_name'],
            'authors' => $authors,
            'date' => $r['date']
        ];
        
        $sections = [];
        foreach($res as $row) {
            $sections[$row['section_num']][$row['subsection_num']] = [
                'type' => $row['type'],
                'data' => json_decode($row['data'], true)
            ];
        }
        
        $story = [
            'head' => $data,
            'body' => $sections
        ];
        
        return $story;
    }
    
    public function create_story($story) {
        $db = Database::connect();
        
        $st = $db->prepare("SELECT * FROM stories_view WHERE id = :id");
        $st->execute(['id'=>$id]);
        $res = $st->fetchAll();
        
        $st = $db->prepare("SELECT DISTINCT * FROM story_authors_view WHERE story_id = :id");
        $st->execute(['id'=>$id]);
        $res_au = $st->fetchAll();
        
        Database::disconnect();
        
        if(0 == count($res) )
            return RET_ERR;
        
        $authors = [];
        foreach($res_au as $row)
            $authors[] = [
                'id' => $row['member_id'],
                'name' => $row['member_name']
            ];
        $r = $res[0];
        $data = [
            'id' => $r['id'],
            'title' => $r['story_name'],
            'authors' => $authors,
            'date' => $r['date']
        ];
        
        $sections = [];
        foreach($res as $row) {
            $sections[$row['section_num']][$row['subsection_num']] = [
                'type' => $row['type'],
                'data' => json_decode($row['data'], true)
            ];
        }
        
        $story = [
            'head' => $data,
            'body' => $sections
        ];
        
        return $story;
    }
    public function update_story($story) {
        $db = Database::connect();
        
        $st = $db->prepare("SELECT * FROM stories_view WHERE id = :id");
        $st->execute(['id'=>$id]);
        $res = $st->fetchAll();
        
        $st = $db->prepare("SELECT DISTINCT * FROM story_authors_view WHERE story_id = :id");
        $st->execute(['id'=>$id]);
        $res_au = $st->fetchAll();
        
        Database::disconnect();
        
        if(0 == count($res) )
            return RET_ERR;
        
        $authors = [];
        foreach($res_au as $row)
            $authors[] = [
                'id' => $row['member_id'],
                'name' => $row['member_name']
            ];
        $r = $res[0];
        $data = [
            'id' => $r['id'],
            'title' => $r['story_name'],
            'authors' => $authors,
            'date' => $r['date']
        ];
        
        $sections = [];
        foreach($res as $row) {
            $sections[$row['section_num']][$row['subsection_num']] = [
                'type' => $row['type'],
                'data' => json_decode($row['data'], true)
            ];
        }
        
        $story = [
            'head' => $data,
            'body' => $sections
        ];
        
        return $story;
    }
}

?>