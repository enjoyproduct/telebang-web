<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mnews extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function delete($id)
    {
        $this->db->reconnect();
        if ($this->db->delete('tbl_news', array('id' => $id)))
            return true;

        return false;
    }

    public function get($id)
    {
        $this->db->reconnect();
        $query = $this->db->order_by('id', "desc")->get_where('tbl_news', array('id' => $id));

        $page = $query->result_array();
        if (!empty($page)) return $page[0];
        return false;
    }

    public function insertOrUpdate($newsId, $valueData, $categoryIdsSelected)
    {
        $this->db->reconnect();
        $this->db->trans_start();
        $data = replaceSqlString($valueData);

        if ($newsId > 0) {
            $this->db->where('id', $newsId);
            $this->db->update('tbl_news', $data);
        } else {
            $this->db->insert('tbl_news', $data);
            $newsId = $this->db->insert_id();
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            $this->updateNewsCategory($newsId, $categoryIdsSelected);
        }

        return $newsId;
    }

    function updateNewsCategory($newsId, $categoryIdsSelected)
    {
        $this->db->delete('tbl_news_category_connect', array('news_id' => $newsId));
        $valueData = array();
        foreach ($categoryIdsSelected as $categoryId) {
            $valueData[] = array(
                'news_id' => $newsId,
                'category_id' => $categoryId
            );
        }
        if (!empty($valueData)) $this->db->insert_batch('tbl_news_category_connect', $valueData);
    }

    public function getList($page = 1, $limit = 0)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $this->db->reconnect();
        $query = $this->db->order_by('view', 'DESC')->get_where('tbl_news', array(), $limit, $offset);

        return $query->result_array();
    }

    public function getPreNews($id)
    {
        $query = $this->db->from('tbl_news')->order_by('create_at', 'DESC')->where('id <', $id)->limit(1)->get();
        return $query->row_array();
    }

    public function getNextNews($id)
    {
        $query = $this->db->from('tbl_news')->order_by('create_at', 'DESC')->where('id >', $id)->limit(1)->get();
        return $query->row_array();
    }
    
    public function getListByCatID($catID, $page = 1, $limit = 0)
    {
        $this->db->reconnect();

        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'DESC');
        $this->db->where('id IN','(SELECT news_id FROM tbl_news_category_connect WHERE category_id='.$catID.')',false);
        $query = $this->db->get('tbl_news');

        return $query->result_array();
    }
    public function getMostNewThisWeek($page = 1, $limit = 0)
    {
        $this->db->reconnect();
        $this->db->trans_begin();

        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $dateNow = date('Y-m-d');
        $lastWeek = date("Y-m-d", strtotime("last week monday"));

        $query = $this->db->select('id')->get_where('tbl_news',array('create_at <=' => $dateNow, 'create_at >=' => $lastWeek), $limit, $offset);

        if($query->num_rows() > 0){
            $ids = array();
            foreach ($query->result() as $row)
            {
                $ids[] = $row->news_id;
            }

            $query = $this->db->where_in('id', $ids)->order_by('view', "desc")->get('tbl_news');
        }else{
            return false;
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $query->result_array();
        }
        return false;
    }
    public function updateViewCounter($newsID)
    {
        $this->db->reconnect();
        $this->db->set('view', 'view+1', FALSE);
        $this->db->where('id', $newsID);
        $this->db->update('tbl_news');
    }
}
