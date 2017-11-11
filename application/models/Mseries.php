<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Mseries extends CI_Model
    {

        const TABLE_NAME = 'series';
        const TABLE_ID = 'id_series';
        const TABLE_SERIES_NAME = 'name';
        const TABLE_SERIES_THUMBNAIL = 'thumbnail';
        const TABLE_SERIES_SHORT_DESC = 'short_desc';
        const TABLE_SERIES_CREATED_AT = 'created_at';
        const TABLE_SERIES_UPDATED_AT = 'updated_at';
        const TABLE_SERIES_COMPLETED = 'completed';

        public function __construct()
        {
            parent::__construct();
        }

        public function delete($idSeries)
        {
            $this->db->reconnect();
            $this->db->delete(self::TABLE_NAME, array (self::TABLE_ID => $idSeries));
            return true;
        }

        public function get($idSeries)
        {
            $this->db->reconnect();
            $query = $this->db->get_where(self::TABLE_NAME, array(self::TABLE_ID => $idSeries));
            $series = $query->row_array();

            return $series;
        }

        public function insertOrUpdate($idSeries, $valueData)
        {
            $this->db->reconnect();
            $this->db->trans_begin();
            if(is_array($valueData)) {
                $valueData = replaceSqlString($valueData);
            }
            if ($idSeries > 0) {
                $this->db->where(self::TABLE_ID, $idSeries);
                $this->db->update(self::TABLE_NAME, $valueData);
            } else {
                $this->db->insert(self::TABLE_NAME, $valueData);
                $idSeries = $this->db->insert_id();
                
            }
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return $idSeries;
            }
            return false;
        }

        public function getList($orderBy = self::TABLE_SERIES_CREATED_AT, $orderWay = 'DESC', $limit = 0, $offset = 0)
        {
            $this->db->reconnect();
            $this->db->from(self::TABLE_NAME);
            $this->db->limit($limit, $offset);
            $this->db->order_by($orderBy, $orderWay);
            $query = $this->db->get();
            return $query->result_array();
        }

        public function getListSeries($isCompleted = 0, $page = 1, $limit = 0)
        {
            $offset = ($page - 1) * $limit;

            $this->db->reconnect();
            $this->db->from(self::TABLE_NAME);
            $this->db->limit($limit, $offset);
            $this->db->order_by(self::TABLE_SERIES_UPDATED_AT, "desc");
            $this->db->where(self::TABLE_SERIES_COMPLETED, $isCompleted);
            $query = $this->db->get();
            return $query->result_array();
        }
    }