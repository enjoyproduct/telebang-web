<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcategories extends CI_Model{

	public function __construct(){
        parent::__construct();
    }

    public function getList($statusId = 0){
        $this->db->reconnect();
        $sql = "SELECT * FROM categories WHERE 1=1";
        if($statusId>0) $sql.=" AND StatusId=".$statusId;
        $sql.=" ORDER BY DisplayOrder DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function delete($categoryId){
        $this->db->reconnect();
        $this->db->trans_begin();
        $this->db->delete('categoryvideos', array('CategoryId' => $categoryId));
        $this->db->delete('categories', array('CategoryId' => $categoryId));
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
        return false;        
    }

    public function insertOrUpdate($valueData, $categoryId){
        $this->db->reconnect();
        $valueData = replaceSqlString($valueData);
        if($categoryId>0){
            $this->db->where('CategoryId', $categoryId);
            if(!isset($valueData['ParentCategoryId'])) $this->db->set('ParentCategoryId', null);
            $this->db->update('categories', $valueData);
            return $categoryId;
        }
        else{
            $this->db->insert('categories', $valueData);
            if($this->db->insert_id()) return $this->db->insert_id();
        }
        return false;
    }

    public function get($categoryId){
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM categories WHERE CategoryId=?", array($categoryId));
        $categories = $query->result_array();
        if(!empty($categories)) return $categories[0];
        return false;
    }

    public function getCategoriesOfVideo($videoId)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM categoryvideos WHERE VideoId=?", array($videoId));
        $categories = $query->result_array();
        if(!empty($categories)) {
            return $categories;   
        }
        return false;
    }
}