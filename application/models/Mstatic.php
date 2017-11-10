<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mstatic extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public function delete($slug){
        $this->db->reconnect();
        if ($this->db->delete('staticpages', array('slug' => $slug))){
            return true;
        }
        
        return false;
    }

    public function get($slug){
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM staticpages WHERE slug=?", array($slug));
        $page = $query->result_array();
        if(!empty($page)) return $page[0];
        return false;
    }

    public function update($data){
        $this->db->reconnect();
        $data = replaceSqlString($data);

        $flag = $data['flag'];
        $slug = $data['slug'];
        $old_slug = $data['old_slug'];
        $PageTitle = $data['PageTitle'];
        $PageDesc = $data['PageDesc'];
        if ($flag==3 || $slug != $old_slug){
            $this->db->insert('staticpages', array(
                'slug' => $slug,
                'PageTitle' => $PageTitle,
                'PageDesc' => $PageDesc
            ));
        }
        else {
            $this->db->set(array('PageDesc' => $PageDesc));
            $this->db->where('slug',$slug);
            $this->db->update('staticpages');

        }
    }

    public function getList(){
        $this->db->reconnect();
        $this->db->select('slug, PageTitle');
        $query = $this->db->get('staticpages');
        return $query->result_array();
    }

}
