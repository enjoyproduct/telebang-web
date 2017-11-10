<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Share extends BaseV1Controller {

	function Share(){
		parent::__construct();
	}

	function index(){
		$this->load->helper('share_helper');
		$this->load->view(THEME_VM_DIR.'/elements/share-video');
	}
}

