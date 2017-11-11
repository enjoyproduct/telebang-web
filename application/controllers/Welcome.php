<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function index()
    {
    	if(THEME_ENABLE){
        	redirect(site_url(HOME_PATH));
    	}else{
			redirect(site_url('admin/dashboard'));
    	}
    }
}