<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function index(){
        $this->db->reconnect();
        $this->db->query("ALTER TABLE users ADD COLUMN FacebookId VARCHAR(45) NULL  AFTER Token ;");
        echo 'ok';
    }
}