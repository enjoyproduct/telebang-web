<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcategoryvideos extends CI_Model{

	public function __construct(){
        parent::__construct();
    }
    
    public function getCategoryIdList($videoId){
        $retVal = array();
        $this->db->reconnect();
        $query = $this->db->query("SELECT CategoryId FROM categoryvideos WHERE VideoId=?", array($videoId));
        $categoryIds = $query->result_array();
        foreach($categoryIds as $id) $retVal[]= intval($id['CategoryId']);        
        return $retVal;
    }
}