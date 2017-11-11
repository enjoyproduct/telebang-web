<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staticpage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $data = array();
            $this->load->model('Mstatic');
            $data['user'] = $user;
            $data['pages'] = $this->Mstatic->getList();
            $this->load->view('admin/staticpage/pagelist', $data);

        } else redirect('index.php/admin/user');
    }

    public function delete($slug)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Mstatic');
            $flag = $this->Mstatic->delete($slug);
            if ($flag) {
                $staticPagePath = FCPATH . STATICS_PAGE_PATH . $slug . '.html';
                $isDeleted = unlink($staticPagePath);
                if ($isDeleted)
                    $this->session->set_flashdata('txtSuccess', "Page has been deleted");
                else
                    $this->session->set_flashdata('txtError', "Delete page failed");
            } else
                $this->session->set_flashdata('txtError', "Delete page failed");

            redirect('index.php/admin/staticpage');
        } else redirect('index.php/admin/user');
    }

    public function display($slug)
    {
        //$user = $this->session->userdata('user');
        //if($user){
        $staticPagePath = base_url(STATICS_PAGE_PATH . $slug . '.html');
        redirect($staticPagePath);
        //}
    }

    public function update($slug = '')
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Mstatic');
            $data = array();
            $data['user'] = $user;
            $data['slug'] = $slug;
            $data['old_slug'] = $slug;
            $data['PageTitle'] = $data['PageDesc'] = '';
            $flag = 0;
            if ($slug != '') {
                $flag = 1;
                $page = $this->Mstatic->get($slug);
                if ($page) {
                    $data['PageTitle'] = $page['PageTitle'];
                    $data['PageDesc'] = $page['PageDesc'];
                } else {
                    $data['txtError'] = "Page is not exist.";
                    $flag = 2;
                }
            } else $flag = 3;
            $data['flag'] = $flag;
            if ($this->input->post('submit') && $flag != 2) {
                //$this->Mstatic->delete($slug);
                $pageTitle = trim($this->input->post('PageTitle'));
                if ($pageTitle != $data['PageTitle']) {
                    if ($flag == 1) $this->Mstatic->delete($data['old_slug']);
                    $data['PageTitle'] = $pageTitle;
                    $config = array(
                        'table' => 'staticpages',
                        'field' => 'slug',
                        'title' => 'PageTitle',
                        'replacement' => 'dash' // Either dash or underscore
                    );
                    $this->load->library('slug', $config);
                    $data['slug'] = $this->slug->create_uri(array('PageTitle' => $data['PageTitle']));
                }
                $pageDesc = trim($this->input->post('PageDesc'));
                $data['PageDesc'] = $pageDesc;
                $flag = true;

                $slug = $data['slug'];
                //echo $str;
                $this->load->helper('file');
                $str = $this->load->view('admin/staticpage/pages', $data, true);

                $staticPagePath = FCPATH . STATICS_PAGE_PATH . $slug . '.html';
                $isSuccess = write_file($staticPagePath, $str);
                if ($isSuccess)
                    $this->Mstatic->update($data);
            }
            $this->load->view('admin/staticpage/pageupdate', $data);
        } else redirect('index.php/admin/user');
    }
}


