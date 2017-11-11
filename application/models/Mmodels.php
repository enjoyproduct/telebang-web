<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmodels extends CI_Model{

	public function __construct(){
        parent::__construct();
    }

    public function getList($tableName){
        $this->db->reconnect();
        return $this->db->get($tableName)->result_array();
    }
}