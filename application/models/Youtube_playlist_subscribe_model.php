<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Youtube_playlist_subscribe_model extends CI_Model
{
    const TABLE_NAME = 'tbl_youtube_playlist_subscribe';
    const TABLE_ID = 'id';
    const TABLE_CHANEL_ID = 'chanel_id';
    const TABLE_TITLE = 'title';
    const TABLE_PLAYLIST_ID = 'playlist_id';
    const TABLE_AUTO = 'auto';
    const TABLE_CATEGORY_IDS = 'category_ids';
    const TABLE_UPDATE_AT = 'update_at';
    const TABLE_CREATE_AT = 'create_at';

    public function __construct()
    {
        parent::__construct();
    }

    public function delete($id)
    {
        $this->db->reconnect();
        $this->db->where(self::TABLE_ID, $id);
        $this->db->delete(self::TABLE_NAME);
    }

    public function insert($title, $playlist_id, $category_ids, $auto = true, $chanelId = 0)
    {
        $valueData = array();
        $valueData[self::TABLE_TITLE] = $title;
        $valueData[self::TABLE_PLAYLIST_ID] = $playlist_id;
        $valueData[self::TABLE_CHANEL_ID] = $chanelId;
        $valueData[self::TABLE_CATEGORY_IDS] = $category_ids;

        $valueData[self::TABLE_AUTO] = $auto;
        $currentDateTime = (new DateTime())->getTimestamp();
        $valueData[self::TABLE_CREATE_AT] = $currentDateTime;
        $valueData[self::TABLE_UPDATE_AT] = $currentDateTime;

        $this->db->reconnect();
        $this->db->insert(self::TABLE_NAME, $valueData);
        $id = $this->db->insert_id();
        return $id;
    }

    public function update($id = 0, $title = null, $playlist_id = null, $category_ids = null, $auto = true)
    {
        if ($id <= 0)
            return false;

        $valueData = array();

        if ($title)
            $valueData[self::TABLE_TITLE] = $title;

        if ($playlist_id)
            $valueData[self::TABLE_PLAYLIST_ID] = $playlist_id;

        $valueData[self::TABLE_CATEGORY_IDS] = $category_ids;

        $valueData[self::TABLE_AUTO] = $auto;

        $currentDateTime = (new DateTime())->getTimestamp();
        $valueData[self::TABLE_UPDATE_AT] = $currentDateTime;

        $this->db->where(self::TABLE_ID, $id);
        $this->db->update(self::TABLE_NAME, $valueData);

        return $id;
    }
    
    public function updateByPlaylistKeyAndChanelKey($title = null, $playlist_id = null, $category_ids = null, $auto = true, $chanelId = 0)
    {
        $valueData = array();

        if ($title) {
            $valueData[self::TABLE_TITLE] = $title;
        }
        $valueData[self::TABLE_CATEGORY_IDS] = $category_ids;

        $valueData[self::TABLE_AUTO] = $auto;

        $currentDateTime = (new DateTime())->getTimestamp();
        $valueData[self::TABLE_UPDATE_AT] = $currentDateTime;

        $this->db->where(self::TABLE_PLAYLIST_ID, $playlist_id);
        $this->db->where(self::TABLE_CHANEL_ID, $chanelId);
        $this->db->update(self::TABLE_NAME, $valueData);
    }

    public function get($limit = 0, $page = 0)
    {
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->order_by(self::TABLE_ID, "desc");

        if ($limit > 0) {
            if ($page < 1)
                $page = 1;

            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getByID($id)
    {
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->where(self::TABLE_ID, $id);

        $query = $this->db->get();
        $result = $query->result_array();

        if (!empty($result))
            return $result[0];

        return false;
    }
    
    public function getByChanelKey($chanelKey)
    {
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->where(self::TABLE_CHANEL_ID, $chanelKey);

        $query = $this->db->get();
        $result = $query->result_array();

        if (!empty($result))
            return $result[0];

        return false;
    }
    
    /**
     * Check if Playlist has existed in database. 
     */
    public function isExistsPlaylist($playListID)
    {
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->where(self::TABLE_PLAYLIST_ID, $playListID);
        
        $query = $this->db->get();
        $result = $query->result_array();
        if($result && $result['0'] > 0) {
            return true;
        }
        return false;
    }
    
    public function getPlaylistAutoUpdate()
    {
        $this->db->reconnect();
        $this->db->select(self::TABLE_PLAYLIST_ID);
        $this->db->from(self::TABLE_NAME);
        $this->db->where(self::TABLE_AUTO, 1);
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
        
    }
    
    public function getPlaylistCate($playlistID)
    {
        $this->db->reconnect();
        $this->db->select(self::TABLE_CATEGORY_IDS);
        $this->db->from(self::TABLE_NAME);
        $this->db->where(self::TABLE_PLAYLIST_ID, $playlistID);
        
        $query = $this->db->get();
        $result = $query->first_row('array');
        return $result;
    }
    
    public function isPlaylistYoutubeExist($chanelID, $playlistId) 
    {
        $this->db->reconnect();
        $sql = "(SELECT 1 FROM tbl_youtube_playlist_subscribe WHERE playlist_id=? AND chanel_id=?)";
        $query = $this->db->query($sql, array($playlistId, $chanelID));
        $result = $query->result_array();
        if(empty($result)) {
            return false;
        } else {
            return true;
        }
    }
}
