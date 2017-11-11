<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class V1_slider_model extends CI_Model{

    const TABLE_NAME = 'vidhub_slider';
    const COL_ID = 'sliderId';
    const COL_TITLE = 'title';
    const COL_DESC = 'description';
    const COL_TYPE = 'type';
    const COL_VALUE = 'value';
    const COL_IMAGE = 'image';
    const COL_ORDER = 'display_order';

	public function __construct(){
        parent::__construct();
    }
    
    public function get($id)
    {
        $this->db->reconnect();
        $query = $this->db->get_where(self::TABLE_NAME, array(self::COL_ID => $id));
        $model = $query->row_array();

        return $model;
    }

    public function getList($page = 1, $limit = 0)
    {
        $offset = ($page - 1) * $limit;

        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->order_by(self::COL_ORDER);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete($id){
        $this->db->reconnect();
        $this->db->trans_begin();
        $this->db->delete(self::TABLE_NAME, array(self::COL_ID => $id));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        return false;
    }

    public function update($id, $valueData){
        $this->db->reconnect();
        $this->db->trans_begin();
        if(is_array($valueData)) {
            $valueData = replaceSqlString($valueData);
        }
        if ($id > 0) {
            $this->db->where(self::COL_ID, $id);
            $this->db->update(self::TABLE_NAME, $valueData);
        } else {
            $this->db->insert(self::TABLE_NAME, $valueData);
            $id = $this->db->insert_id();
            
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $id;
        }
        return false;
    }
}