<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 7/26/16
 * Time: 11:00
 */
class Comment_video_model extends CI_Model
{
    const TBL_DB_NAME = 'tbl_comment_video';
    const TBL_COMMENT_ID = 'id';
    const TBL_COMMENT_USER_ID = 'user_id';
    const TBL_COMMENT_VIDEO_ID = 'video_id';
    const TBL_COMMENT_COMMENT_TEXT = 'comment';
    const TBL_COMMENT_CREATE_AT = 'create_at';
    const TBL_COMMENT_STATUS = 'status_comment';
    /**
     * CommentVideoModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getListCommentByVideoID($videoID, $limit = 0, $offset = 0)
    {
        $this->db->reconnect();

        $query = $this->db->order_by(Comment_video_model::TBL_COMMENT_ID, "desc")->get_where(Comment_video_model::TBL_DB_NAME, array(Comment_video_model::TBL_COMMENT_VIDEO_ID => $videoID, self::TBL_COMMENT_STATUS => COMMENT_STATUS_APPROVED), $limit, $offset);

        return $query->result_array();
    }

    public function getStatsComment($videoID)
    {
        $this->db->reconnect();

        $query = $this->db->get_where(Comment_video_model::TBL_DB_NAME, array(Comment_video_model::TBL_COMMENT_VIDEO_ID => $videoID));
        $rowCount = $query->num_rows();
        return $rowCount;
    }

    public function insertComment($data)
    {
        $this->db->reconnect();
        $data = replaceSqlString($data);

        $this->db->insert(Comment_video_model::TBL_DB_NAME, $data);

        $id = $this->db->insert_id();
        if ($id)
            return $id;

        return -1;
    }
    public function getAllComments()
    {
        $this->db->reconnect();
        $this->db->select('*');
        $this->db->from('tbl_comment_video');
        $this->db->join('users', 'users.UserId = tbl_comment_video.user_id', 'left');
        $this->db->join('videos', 'videos.VideoId = tbl_comment_video.video_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllCommentsByVideoID($videoID)
    {
        $this->db->reconnect();
        $this->db->select('*');
        $this->db->from('tbl_comment_video');
        $this->db->order_by(Comment_video_model::TBL_COMMENT_ID, "desc");
        $this->db->join('videos', 'videos.VideoId = tbl_comment_video.video_id', 'left');
        $this->db->join('users', 'users.UserId = tbl_comment_video.user_id', 'left');
        $this->db->where(self::TBL_COMMENT_VIDEO_ID, $videoID);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getListComments($videoID, $page = 1, $limit = 0)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $this->db->reconnect();
        $this->db->select('*');
        $this->db->from('tbl_comment_video');
        $this->db->limit($limit, $offset);
        $this->db->order_by(Comment_video_model::TBL_COMMENT_ID, "desc");
        $this->db->join('videos', 'videos.VideoId = tbl_comment_video.video_id', 'left');
        $this->db->join('users', 'users.UserId = tbl_comment_video.user_id', 'left');
        $this->db->where(self::TBL_COMMENT_VIDEO_ID, $videoID);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete($id)
    {
        $this->db->reconnect();
        $this->db->delete('tbl_comment_video', array('id' => $id));
        if ($this->db->delete(self::TBL_DB_NAME, array('id' => $id)))
            return true;

        return false;
    }
    public function changeStatus($status, $id)
    {
        $this->db->reconnect();
        $this->db->where('id', $id);
        $this->db->update('tbl_comment_video', array('status_comment' => $status));

        return true;
    }

    public function getCommentCounterBy($videoID)
    {
        $this->db->reconnect();
        $this->db->from(self::TBL_DB_NAME);
        $this->db->where(self::TBL_COMMENT_VIDEO_ID, $videoID);
        return $this->db->count_all_results();
    }
    
}