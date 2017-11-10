<?php

/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 2/14/17
 * Time: 19:16
 */
require_once APPPATH.'models/Push.php';
class Notification_model extends CI_Model
{
    const TABLE_NAME = 'tbl_notification';
    const COL_ID = 'id';
    const COL_TITLE = 'title';
    const COL_MESSAGE = 'message';
    const COL_TYPE = 'type';
    const COL_CONTENT_ID = 'content_id';
    const COL_IMAGE = 'image';
    const COL_CREATE_AT = 'create_at';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function delete($id)
    {
        $this->db->reconnect();
        $this->db->where(self::COL_ID, $id);
        $this->db->delete(self::TABLE_NAME);
    }

    public function insert(Push $push){
        $valueData = array();
        $valueData[self::COL_TITLE] = $push->getTitle();
        $valueData[self::COL_MESSAGE] = $push->getMessage();
        $valueData[self::COL_TYPE] = $push->getType();
        $valueData[self::COL_CONTENT_ID] = $push->getContentID();
        $valueData[self::COL_IMAGE] = $push->getImage();

        $valueData = replaceSqlString($valueData);
        
        $this->db->reconnect();
        $this->db->insert(self::TABLE_NAME, $valueData);
        $id = $this->db->insert_id();
        if($id >0)
            return 1; //return 1 means success

        return -1; //return -1 means failure
    }
    public function getAllNotify()
    {
        $this->db->reconnect();
        $this->db->select('tbl_notification.* , tbl_news.title AS news_title, tbl_news.id AS news_id, videos.VideoTitle AS video_title, videos.VideoId AS video_id');
        $this->db->from('tbl_notification');
        $this->db->join('videos', 'videos.VideoId = tbl_notification.content_id', 'left');
        $this->db->join('tbl_news', 'tbl_news.id = tbl_notification.content_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }
}