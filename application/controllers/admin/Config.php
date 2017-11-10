<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
    
	public function __construct(){
        parent::__construct();        
    }
    
    public function __destruct() {
        $this->db->close();
    }

    public function index(){
        $user = $this->session->userdata('user');
        if($user && $user['RoleId']==1){
            $data = array();
            $data['user'] = $user;
            $this->load->model('Mmodels');
            $data['listStatus'] = $this->Mmodels->getList('status');
            $configs = $this->Mmodels->getList('configs');
            $listConfigs = array();
            foreach ($configs as $cf) $listConfigs[$cf['ConfigCode']] = $cf['ConfigValue'];
            $data['listConfigs'] =  $listConfigs;
            if($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if($this->session->flashdata('txtError')) $data['txtError'] = $this->session->flashdata('txtError');
            $this->load->view('admin/config/configupdate', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function update(){
        $user = $this->session->userdata('user');
        if($user && $user['RoleId']==1){
            $models = array('Mconfigs', 'Mmodels');
            foreach($models as $model) $this->load->model($model);
            $listConfigs = $this->Mmodels->getList('configs');
            $valueData = array();
            foreach ($listConfigs as $cf) {
                if($this->input->post($cf['ConfigCode'])){
                    $valueData[] = array(
                        'ConfigId'=> $cf['ConfigId'],
                        'ConfigValue'  => $this->input->post($cf['ConfigCode'])
                      );
                }
            }
            $flag = $this->Mconfigs->update($valueData);
            //if($flag)
		$this->session->set_flashdata('txtSuccess', "Update Settings Success");
            //else $this->session->set_flashdata('txtError', "An error occurred in the implementation process!");
            redirect('index.php/admin/config');
        }
        else redirect('index.php/admin/user');
    }
}
