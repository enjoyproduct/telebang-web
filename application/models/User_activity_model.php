<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 7/26/16
 * Time: 11:00
 */
class User_activity_model extends CI_Model
{
    const TBL_DB_NAME = 'tbl_user_activity';
    const TBL_ACTIVITY_USER_ID = 'id';
    const TBL_ACTIVITY_USER_USER_ID = 'user_id';
    const TBL_ACTIVITY_USER_VIDEO_ID = 'video_id';
    const TBL_ACTIVITY_USER_CREATE_AT = 'create_at';
    const TBL_ACTIVITY_USER_ACTION = 'action';
    const TBL_ACTIVITY_USER_DESCRIPTION = 'description';
    const TBL_ACTIVITY_USER_AUTHOR_ID = 'author_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function getListActivityUser($authorID, $limit, $offset)
    {
        $this->db->reconnect();

        $query = $this->db->order_by(User_activity_model::TBL_ACTIVITY_USER_ID, "desc")->get_where(User_activity_model::TBL_DB_NAME, array(User_activity_model::TBL_ACTIVITY_USER_AUTHOR_ID => $authorID), $limit, $offset);

        return $query->result_array();
    }


    public function insertActivity($userID, $authorID, $videoID, $action, $description)
    {
        $this->db->reconnect();

        $data = array(
            User_activity_model::TBL_ACTIVITY_USER_USER_ID => $userID,
            User_activity_model::TBL_ACTIVITY_USER_AUTHOR_ID => $authorID,
            User_activity_model::TBL_ACTIVITY_USER_VIDEO_ID => $videoID,
            User_activity_model::TBL_ACTIVITY_USER_ACTION => $action,
            User_activity_model::TBL_ACTIVITY_USER_DESCRIPTION => $description,
            User_activity_model::TBL_ACTIVITY_USER_CREATE_AT => (new DateTime())->getTimestamp(),
        );

        $data = replaceSqlString($data);

        $this->db->insert(User_activity_model::TBL_DB_NAME, $data);

        $id = $this->db->insert_id();
        if ($id) {
            $data[User_activity_model::TBL_ACTIVITY_USER_ID] = $id;
            return $data;
        }
        return false;
    }
}