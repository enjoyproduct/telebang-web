<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msubscription extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    
    public function getSubscriptionsByUserID($user_id){
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM tbl_subscription WHERE user_id=?", $user_id);
        $page = $query->result_array();
        if(!empty($page)) return $page;
        return false;
    }

    public function addSubscription($user_id = 0, $time = 0, $amount = '0', $card_number = ''){
        $this->db->reconnect();
        $subscription['user_id'] = $user_id;
        $subscription['time'] = $time;
        $subscription['amount'] = $amount;
        $subscription['card_number'] = $card_number;
        $this->db->insert('tbl_subscription', $subscription);
        return true;
    }



}
