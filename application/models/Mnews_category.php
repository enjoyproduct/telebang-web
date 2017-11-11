<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mnews_category extends CI_Model
{
    const TABLE_NAME = 'tbn_news_category';
    const TABLE_ID = 'id';
    const TABLE_TITLE = 'title';
    const TABLE_THUMBNAIL = 'thumbnail';
    const TABLE_ICON = 'icon';
    const TABLE_UPDATE_AT = 'update_at';
    const TABLE_CREATE_AT = 'create_at';

    public function __construct()
    {
        parent::__construct();
    }

    public function delete($id)
    {
        $this->db->reconnect();
        $this->db->delete('tbl_news_category_connect', array('category_id' => $id));
        if ($this->db->delete(self::TABLE_NAME, array('id' => $id)))
            return true;

        return false;
    }

    public function get($id)
    {
        $this->db->reconnect();
        $query = $this->db->order_by(self::TABLE_ID, "desc")->get_where(self::TABLE_NAME, array(self::TABLE_ID => $id));

        $page = $query->result_array();
        if (!empty($page)) return $page[0];
        return false;
    }

    public function insertOrUpdate($newsId, $valueData)
    {
        $this->db->reconnect();
        $data = replaceSqlString($valueData);
        if ($newsId > 0) {
            $this->db->where(self::TABLE_ID, $newsId);
            $this->db->update(self::TABLE_NAME, $valueData);
            return $newsId;
        }
        $this->db->insert(self::TABLE_NAME, $data);
        if ($this->db->insert_id()) return $this->db->insert_id();
    }

    public function getList()
    {
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->order_by(self::TABLE_TITLE, "asc");
        $query = $this->db->get();
        return $query->result_array();
    }
    


    public function getCategoriesByNewsID($newsID)
    {
        $this->db->reconnect();
        $query = $this->db->get_where('tbl_news_category_connect', array('news_id'=>$newsID));
        return $query->result_array();
    }
}
