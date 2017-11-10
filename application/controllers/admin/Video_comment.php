<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_comment extends CI_Controller
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
            $this->load->model('Comment_video_model');
            $data['user'] = $user;
            $data['pages'] = $this->Comment_video_model->getAllComments();
            $data['videoID'] = 0;
            $this->load->view('admin/video/videocomment', $data);
        } else redirect('index.php/admin/user');
    }

    public function delete($commentID)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($commentID > 0) {
                $this->load->model('Comment_video_model');
                $flag = $this->Comment_video_model->delete($commentID);
                if ($flag) $this->session->set_flashdata('txtSuccess', "Comment has been deleted");
                else $this->session->set_flashdata('txtError', "Delete comment failed");
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else redirect('index.php/admin/user');
    }

    public function updateStatus($status, $commentID){
        $user = $this->session->userdata('user');
        if ($user) {
            if ($commentID > 0) {
                $this->load->model('Comment_video_model');
                $flag = $this->Comment_video_model->changeStatus($status, $commentID);
                if ($flag) $this->session->set_flashdata('txtSuccess', "Comment has been approved");
                else $this->session->set_flashdata('txtError', "Approved comment failed"); 
            }

            redirect($_SERVER['HTTP_REFERER']);
        }else redirect('index.php/admin/user');
    }

    public function viewCommentListByVideoID($videoID)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $data = array();
            $this->load->model('Comment_video_model');
            $data['user'] = $user;
            $data['pages'] = $this->Comment_video_model->getAllCommentsByVideoID($videoID);
            $data['videoID'] = $videoID;
            $this->load->view('admin/video/videocomment', $data);
        } else redirect('index.php/admin/user');
    }
}