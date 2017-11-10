<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends CI_Model
{
    const TABLE_NAME = 'tbl_devices';
    const COL_ID = 'id';
    const COL_TOKEN = 'token';

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

    //storing token in database
    public function registerDevice($token)
    {
        if($this->isTokenExist($token)){
            return - 2; //returning -2 means token already exist
        }
        $valueData = array();
        $valueData[self::COL_TOKEN] = $token;

        $this->db->reconnect();
        $this->db->insert(self::TABLE_NAME, $valueData);
        $id = $this->db->insert_id();
        if($id >0)
            return 1; //return 1 means success

        return -1; //return -1 means failure
    }

    //the method will check if email already exist
    private function isEmailexist($email){

    }

    //the method will check if email already exist
    private function isTokenExist($token){
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->select(self::COL_ID);
        $this->db->where(self::COL_TOKEN, $token);

        $query = $this->db->get();
        $result = $query->result_array();
        if($result && $result['0'] > 0) {
            return true;
        }
        return false;
    }

    //getting all tokens to send push to all devices
    public function getAllTokens(){
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $this->db->select(self::COL_TOKEN);
        $query = $this->db->get();
        return $query->result_array();
    }

    //getting a specified token to send push to selected device
    public function getTokenByEmail($email){

    }

    //getting all the registered devices from database
    public function getAllDevices(){
        $this->db->reconnect();
        $this->db->from(self::TABLE_NAME);
        $query = $this->db->get();
        return $query->result_array();
    }
}
