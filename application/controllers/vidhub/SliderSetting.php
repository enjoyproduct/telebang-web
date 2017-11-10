<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SliderSetting extends CI_Controller {
    
    public function __construct(){
        parent::__construct();        
    }
    
    public function __destruct() {
        $this->db->close();
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $data = array();
            $data['user'] = $user;
            $this->load->model(THEME_VM_DIR.'/V1_slider_model');

            $data['listSlider'] = $this->V1_slider_model->getList();
            if ($this->session->flashdata('txtSuccess'))
                $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if ($this->session->flashdata('txtError'))
                $data['txtError'] = $this->session->flashdata('txtError');

            $this->load->view(THEME_VM_DIR.'/options/slider_setting', $data);
        } else
            redirect('index.php/admin/user');
    }

    public function add(){
         $user = $this->session->userdata('user');
         if(!$user){
            redirect('index.php/admin/user');
            return;
        }
        
        $dataView = $this -> initSliderViewData();
        $dataView['user'] = $user;

        $this->load->view(THEME_VM_DIR.'/options/slider_update', $dataView);
    }

    public function update($id = 0){
         $user = $this->session->userdata('user');
         if(!$user){
            redirect('index.php/admin/user');
            return;
        }

        $this->load->model(THEME_VM_DIR.'/V1_slider_model');
        $slide = $this->V1_slider_model->get($id);

        $dataView = $this -> initSliderViewData($slide);
        $dataView['user'] = $user;

        if(!$slide){
            $dataView['txtError'] = 'Slider not found';
        }

        $this->load->view(THEME_VM_DIR.'/options/slider_update', $dataView);
    }

    public function submit($id = 0){
        $user = $this->session->userdata('user');
        if(!$user){
            redirect('index.php/admin/user');
            return;
        }

        if (!$this->input->post('submit')){
            redirect(THEME_CONTROLLER_PATH.'/SliderSetting/update/'.$id);
        }

        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $type = $this->input->post('type');
        $display_order = $this->input->post('display_order');
        $value = $this->input->post('value');

        $imagePath = $this->input->post('VideoImageFetch');        
        $imageName = basename($imagePath);
        
        $this->load->model(THEME_VM_DIR.'/V1_slider_model');
        $valueData = array(
            V1_slider_model::COL_TITLE   => $title,
            V1_slider_model::COL_DESC    => $description,
            V1_slider_model::COL_TYPE    => $type,
            V1_slider_model::COL_ORDER   => $display_order,
            V1_slider_model::COL_VALUE   => $value,
            V1_slider_model::COL_IMAGE   => $imageName
        );

        $dataView = $this -> initSliderViewData($valueData);
        $dataView['user'] = $user;
        $dataView['id'] = $id;
        $resultID = $this->V1_slider_model->update($id, $valueData);

        if($resultID){
            $dataView['id'] = $resultID;
            $dataView['txtSuccess'] = "Update successfully!";
        }else{
            $dataView['txtError'] = "An error occurred in the implementation process!";
        }      

        $this->load->view(THEME_VM_DIR.'/options/slider_update', $dataView);
    }

    public function delete($id = 0){
        $user = $this->session->userdata('user');
        if($user){
            if($id>0){
                $this->load->model(THEME_VM_DIR.'/V1_slider_model');
                $flag = $this->V1_slider_model->delete($id);
                if($flag) $this->session->set_flashdata('txtSuccess', "Slider has been deleted");
                else $this->session->set_flashdata('txtError', "Delete Slider failed");
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
        else redirect('index.php/admin/user');
    }

    private function initSliderViewData($sliderModel = null){
        $dataView = array();
        if($sliderModel){
            if(isset($sliderModel[V1_slider_model::COL_ID])){
                $dataView['id']             = $sliderModel[V1_slider_model::COL_ID];
            }

            $dataView['title']          = $sliderModel[V1_slider_model::COL_TITLE];
            $dataView['description']    = $sliderModel[V1_slider_model::COL_DESC];
            $dataView['type']           = $sliderModel[V1_slider_model::COL_TYPE];
            $dataView['value']          = $sliderModel[V1_slider_model::COL_VALUE];
            $dataView['display_order']  = $sliderModel[V1_slider_model::COL_ORDER];
            $dataView['image'] = getImagePath($sliderModel[V1_slider_model::COL_IMAGE]);

        }else{
            $dataView['id'] = 0;
            $dataView['title'] = '';
            $dataView['description'] = '';
            $dataView['type'] = V1_SLIDE_TYPE_VIDEO;
             $dataView['value'] = '';
            $dataView['display_order'] = 1;
            $dataView['image'] = base_url(NO_IMAGE_PATH);
        }

        return $dataView;
    }
}
