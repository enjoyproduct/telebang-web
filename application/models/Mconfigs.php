<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfigs extends CI_Model{

	public function __construct(){
        parent::__construct();
    }
    
    public function update($valueData){
    	$this->db->reconnect();
    	$this->db->update_batch('configs', $valueData, 'ConfigId'); 
    	if($this->db->affected_rows()>0) return true;
    	return false;
    }

    public function getConfigValue($configCode){
        $this->db->reconnect();
        $query = $this->db->query("SELECT ConfigValue FROM configs WHERE ConfigCode=? LIMIT 1", array($configCode));
        $configs = $query->result_array();
        if(!empty($configs)) return $configs[0]['ConfigValue'];        
        return false;
    }
}