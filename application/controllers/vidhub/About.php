<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends BaseV1Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['head_title']           = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description']     = $this->theme_config['site_headding'];
        $this->data['meta_keywords']        = $this->theme_config['site_title'];
    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {

        $this->load->model('Mstatic');
        $this->load->model( THEME_VM_DIR.'/V1_theme_config_model');
        $result = $this->V1_theme_config_model->get(1);
        $getSlug = $result['about_url'];
        $page = $this->Mstatic->get($getSlug);

        if ($page == 0  ) {
            $this->data['pageTitle'] = "Test";
            $this->data['pageDesc'] = "No Post";
        }else{
            $this->data['pageTitle'] = $page['PageTitle'];
            $this->data['pageDesc'] = $page['PageDesc'];
        }
        $this -> view_render('about');
    }
}