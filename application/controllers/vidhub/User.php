<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends BaseV1Controller {

	public function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }

    public function __destruct()
    {
        $this->db->close();
    }
    public function index(){

    }
    public function setting(){
    	$this->data['head_title'] = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description'] = $this->theme_config['site_headding'];
        $this->data['meta_keywords'] = $this->theme_config['site_title'];

        $user = $this->session->userdata('customer');
        if($user){
            $this->data['user'] = $user;
            $models = array('Musers', 'Mmodels', 'Mvideos');
            foreach($models as $model) $this->load->model($model);
            $this->data['listStatus'] = $this->Mmodels->getList('status');
            $this->data['listRoles'] = $this->Mmodels->getList('roles');

            $perPage = $this->theme_config['videos_limit'];
            $page = 1;
            if ($page < 1)
            $page = 1;
            $offset = ($page - 1) * $perPage;
            $this->data['listVideos'] = $this->formatVideoList($this->Mvideos->getList(0,0, "",$user['UserId'], $perPage, "CrDateTime", $offset));
            $this->data['page'] = $page;
            $this->data['perPage'] = $perPage;

            if($this->input->post('submit')){
                $valueData = array(
                    'Email' => trim($this->input->post('Email')),
                    'RoleId' => $this->input->post('RoleId'),
                    'IsVip' => ($this->input->post('IsVip')=='on') ? 1 : 0,
                    'StatusId' => $this->input->post('StatusId'),
                    'FirstName' => trim($this->input->post('FirstName')),
                    'LastName' => trim($this->input->post('LastName')),
                    'Address' => trim($this->input->post('Address')),
                    'PhoneNumber' => trim($this->input->post('PhoneNumber')),
                    'Country' => trim($this->input->post('Country')),
                    'City' => trim($this->input->post('City')),
                    'Zip' => trim($this->input->post('Zip')),
                );
              
                $flag = $this->Musers->update($valueData, $user['UserId']);
                if($flag){
                    if($flag===-1) $data['txtError'] = "Email already exists in the system!";
                    else{
                        $this->data['txtSuccess'] = "Profile Account Change";
                        $user = array_merge($user, $valueData);
                        $this->data['user'] = $user;
                        $this->session->set_userdata('user', $user);
                    }
                }
                else $this->data['txtError'] = "An error occurred in the implementation process!";
            }
            $this->load->view(THEME_VM_DIR.'/user/profile', $this->data);
        }
        else redirect(HOME_PATH);
    }

    public function loadModel()
    {
        $models = array('Mvideos', 'Like_video_model', 'Comment_video_model', THEME_VM_DIR.'/V1_slider_model', 'Mnews', 'Musers');
        foreach ($models as $model)
            $this->load->model($model);
    }
    public function loadMore($page = 1){
        $user = $this->session->userdata('customer');
            $perPage = $this->theme_config['videos_limit'];
            if ($page < 1)
            $page = 1;
            $offset = ($page - 1) * $perPage;

            $listVideos = $this->Mvideos->getList(0,0, "",$user['UserId'], $perPage, "CrDateTime", $offset);
            $this->data['listVideos'] = $this->formatVideoList($listVideos);
            $this->data['page'] = $page;
            $this->data['perPage'] = $perPage;

            if(!$listVideos || empty($listVideos))
                $this->data['message'] = 'No videos';
            echo json_encode($this->data['listVideos']);
    }    

}

