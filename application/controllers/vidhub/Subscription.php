<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subscription extends BaseV1Controller {

	function Share() {
		parent::__construct();
        $this->data['head_title']           = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description']     = $this->theme_config['site_headding'];
        $this->data['meta_keywords']        = $this->theme_config['site_title'];
	}
	public function __destruct()
    {
        $this->db->close();
    }
	function index() {
		// $this->load->helper('share_helper');
		// $this->load->view(THEME_VM_DIR.'/elements/share-video');
	}
	function subscription_view() {
        $this -> view_render('subscription/subscription');
	}
	function subscription_history() {
        $this -> view_render('subscription/subscription_history');
	}
}