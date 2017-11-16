<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvideos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function delete($videoId)
    {
        $this->db->reconnect();
        $this->db->trans_begin();
        $this->db->delete('categoryvideos', array('VideoId' => $videoId));
        $this->db->delete('videos', array('VideoId' => $videoId));
        $this->db->delete('tbl_comment_video', array('video_id' => $videoId));
        $this->db->delete('tbl_like_video', array('video_id' => $videoId));
        $this->db->delete('tbl_user_activity', array('video_id' => $videoId));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        return false;
    }

    public function get($videoId)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM videos WHERE VideoId=?", array($videoId));
        $videos = $query->result_array();
        if (!empty($videos)) return $videos[0];
        return false;
    }
    public function getDetail($videoId)
    {
        $this->db->reconnect();
         $this->db->select('*, users.IsVip as IsUserVip');
        $this->db->from('videos');
        $this->db->join('users', 'users.UserId = videos.CrUserId ', 'left');
        $this->db->where('VideoId',$videoId);
        $query = $this->db->get();
        $videos = $query->result_array();
        if (!empty($videos)) return $videos[0];
        return false;
    }

    public function insertOrUpdate($valueData, $videoId, $listCategoryIds)
    {
        $this->db->reconnect();
        $this->db->trans_begin();
        $valueData = replaceSqlString($valueData);
        if ($videoId > 0) {
            $this->db->where('VideoId', $videoId);
            $this->db->update('videos', $valueData);
            $this->db->query("DELETE FROM categoryvideos WHERE VideoId=?", array($videoId));
            $valueData1 = array();
            foreach ($listCategoryIds as $categoryId) {
                $valueData1[] = array(
                    'VideoId' => $videoId,
                    'CategoryId' => $categoryId
                );
            }
            if (!empty($valueData1)) $this->db->insert_batch('categoryvideos', $valueData1);
        } else {
            $this->db->insert('videos', $valueData);
            $videoId = $this->db->insert_id();
            $valueData1 = array();
            foreach ($listCategoryIds as $categoryId) {
                $valueData1[] = array(
                    'VideoId' => $videoId,
                    'CategoryId' => $categoryId
                );
            }
            if (!empty($valueData1)) $this->db->insert_batch('categoryvideos', $valueData1);
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $videoId;
        }
        return false;
    }

    public function getVideoBySeriesId($seriesId, $limit = 10, $offset = 0)
    {
        $this->db->reconnect();
        $query = $this->db->order_by('episode_no', "ASC")->get_where('videos', array('Series' => $seriesId), $limit, $offset);
        return $query->result_array();
    }
    

    public function updateStatistics($videoId, $fieldName, $userId)
    {
        $this->db->reconnect();
        $this->db->trans_begin();

        $query = $this->db->get_where('videos', array('VideoId' => $videoId));
        if($query->num_rows() <= 0){
            return false;
        }

        $this->db->query("UPDATE videos SET {$fieldName}={$fieldName}+1 WHERE VideoId=?", array($videoId));

        if ($fieldName == "ViewCount") {
            $dateNow = date('Y-m-d');
            $query = $this->db->get_where('tbl_video_view', array('create_at' => $dateNow, 'video_id' => $videoId));
            $count = $query->num_rows();

            if ($count > 0) {
                $this->db->set('view_counter', 'view_counter+1', FALSE)
                    ->where('create_at', $dateNow)
                    ->where('video_id', $videoId)
                    ->update('tbl_video_view');
            } else {
                $valueData = array();
                $valueData['video_id'] = $videoId;
                $valueData['create_at'] = $dateNow;
                $valueData['view_counter'] = 1;
                $this->db->insert('tbl_video_view', $valueData);
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        return false;
    }

    public function getAllVideo()
    {
        $this->db->reconnect();
        $query = $this->db->get('videos');
        return $query->result_array();
    }

    public function getMostViewThisWeek($page = 1, $limit = 0)
    {
        $this->db->reconnect();
        $this->db->trans_begin();

        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $dateNow = date('Y-m-d');
        $lastWeek = date("Y-m-d", strtotime("last week monday"));

        $query = $this->db->select('video_id')->get_where('tbl_video_view',array('create_at <=' => $dateNow, 'create_at >=' => $lastWeek), $limit, $offset);

        if($query->num_rows() > 0){
            $ids = array();
            foreach ($query->result() as $row)
            {
                $ids[] = $row->video_id;
            }

            $query = $this->db->where_in('VideoId', $ids)->order_by('ViewCount', "desc")->get('videos');
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

    public function getList($categoryId = 0, $displayHome = 0, $keyword = "", $userId = 0, $limit = 0, $orderBy = "CrDateTime", $offset = 0, $series = "")
    {
        $this->db->reconnect();
        $sql = "SELECT * FROM videos WHERE StatusId=" . STATUS_ACTIVED;
        if ($categoryId > 0) $sql .= " AND VideoId IN(SELECT VideoId FROM categoryvideos WHERE CategoryId={$categoryId})";
        if ($displayHome > 0) $sql .= " AND DisplayHome=1";
        if (!empty($keyword)) $sql .= " AND (VideoTitle LIKE '%{$keyword}%' OR CrUserId IN(SELECT UserId FROM users WHERE CONCAT(FirstName, ' ', LastName) LIKE '%{$keyword}%'))";
        if (!empty($series)) $sql .= " AND Series LIKE '%{$series}%'";
        if ($userId > 0) $sql .= " AND CrUserId = {$userId}";
        $sql .= " ORDER BY {$orderBy} DESC";
        if ($offset > 0 && $limit > 0) $sql .= " LIMIT {$offset}, {$limit}";
        elseif ($limit > 0) $sql .= " LIMIT {$limit}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getListByCategory($categoryId = 0, $limit = 0, $orderBy = "CrDateTime", $offset = 0)
    {
        $this->db->reconnect();
        $sql = "SELECT * FROM `videos` WHERE VideoId IN "
            . "(SELECT VideoId FROM categoryvideos WHERE categoryId IN "
            . "(SELECT categoryId FROM categories WHERE (categoryId = {$categoryId}) OR (categories.ParentCategoryId = {$categoryId} ))) "
            . "ORDER BY {$orderBy} DESC";
        if ($offset > 0 && $limit > 0) {
            $sql .= " LIMIT {$offset}, {$limit}";
        } elseif ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getListBySeries($seriesId = 0, $limit = 0, $orderBy = "CrDateTime", $offset = 0)
    {
        $this->db->reconnect();
        $sql = "SELECT * FROM `videos` WHERE (Series = {$seriesId}) "
            . "ORDER BY {$orderBy} DESC";
        if ($offset > 0 && $limit > 0) {
            $sql .= " LIMIT {$offset}, {$limit}";
        } elseif ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_video_counter_by_cat($categoryId = 0)
    {
        $this->db->reconnect();
        $sql = "SELECT VideoId FROM `videos` WHERE VideoId IN "
            . "(SELECT VideoId FROM categoryvideos WHERE categoryId IN "
            . "(SELECT categoryId FROM categories WHERE (categoryId = {$categoryId}) OR (categories.ParentCategoryId = {$categoryId} ))) ";
        return $this->db->query($sql)->num_rows();
    }

    public function getListTrending($page, $limit)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $this->db->reconnect();
        $query = $this->db->order_by('CrDateTime', "desc")->get_where('videos', array('IsTrending' => 1, 'StatusId' => STATUS_ACTIVED), $limit, $offset);

        return $query->result_array();
    }

    public function isVideoKeyExists($videoKey, $videoType)
    {
        $this->db->reconnect();
        $sql = "(SELECT 1 FROM videos WHERE VideoTypeId=? AND VideoKey=?)";
        $query = $this->db->query($sql, array($videoType, $videoKey));
        $result = $query->result_array();
        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }
    public function getVideosCounterBy($user_id)
    {
        $this->db->reconnect();
        $this->db->from('videos');
        $this->db->where('CrUserId', $user_id);
        return $this->db->count_all_results();
    }
   
}