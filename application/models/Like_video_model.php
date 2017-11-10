<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 7/26/16
 * Time: 11:00
 */
class Like_video_model extends CI_Model
{
    const TBL_DB_NAME = 'tbl_like_video';
    const TBL_LIKE_ID = 'id';
    const TBL_LIKE_USER_ID = 'user_id';
    const TBL_LIKE_VIDEO_ID = 'video_id';
    const TBL_LIKE_CREATE_AT = 'create_at';

    public function __construct()
    {
        parent::__construct();
    }

    public function checkLikedVideo($userID, $videoID)
    {
        $this->db->reconnect();

        $query = $this->db->get_where(Like_video_model::TBL_DB_NAME, array(Like_video_model::TBL_LIKE_USER_ID => $userID, Like_video_model::TBL_LIKE_VIDEO_ID => $videoID));
        $rowCount = $query->num_rows();
        if ($rowCount > 0)
            return true;

        return false;
    }

    public function getStatsLike($videoID)
    {
        $this->db->reconnect();
        $this->db->from(self::TBL_DB_NAME);
        $this->db->where(self::TBL_LIKE_VIDEO_ID, $videoID);
        return $this->db->count_all_results();;
    }

    public function insertLike($data)
    {
        $this->db->reconnect();
        $data = replaceSqlString($data);

        $this->db->insert(Like_video_model::TBL_DB_NAME, $data);

        $id = $this->db->insert_id();
        if ($id)
            return $id;

        return -1;
    }

    public function delete($userID, $videoID)
    {
        $this->db->reconnect();
        $this->db->trans_begin();
        $this->db->delete(Like_video_model::TBL_DB_NAME, array(Like_video_model::TBL_LIKE_VIDEO_ID => $videoID, Like_video_model::TBL_LIKE_USER_ID => $userID));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        return false;
    }
}