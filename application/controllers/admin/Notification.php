<?php

/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 2/14/17
 * Time: 17:25
 */

require_once APPPATH.'libraries/Firebase.php';
require_once APPPATH.'models/Push.php';

class Notification extends CI_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function index(){

    }

    public function registerDevice()
    {
        $token = $this->input->post('token');
        if (empty($token)) {
            echo $this->responseErrorJson('Token is blank.');
            return;
        }

        $this->load->model('Device_model');
        $result = $this->Device_model->registerDevice($token);

        if($result == 1){
            echo $this->responseSuccessJson("Device registered successfully");
        }elseif($result == -1){
            echo $this->responseErrorJson('Device not registered');
        }elseif($result == -2){
            echo $this->responseErrorJson('Device already registered');
        }
    }

    public function create($type, $contentID    )
    {
        $user = $this->session->userdata('user');
        $title = '';
        $message = '';
        if($type == NOTIFICATION_NEWS_TYPE){
            $this->load->model('Mnews');
            $news = $this->Mnews->get($contentID);
            if($news) {
                $title = $news['title'];
                $message = $news['short_description'];
            }

        }else if($type == NOTIFICATION_VIDEO_TYPE){
            $this->load->model('Mvideos');
            $video = $this->Mvideos->get($contentID);
            if($video)
                $title = $video['VideoTitle'];
        }
        if ($user) {
            $data = array();
            $data['user'] = $user;
            $data['type'] = $type;
            $data['content_id'] = $contentID;
            $data['title'] = $title;
            $data['message'] = $message;
            $data['image'] = '';

            $this->load->view('admin/notification/create', $data);
        } else redirect('index.php/user');
    }

    public function sendMultiplePush($type, $contentID)
    {

        $title = trim($this->input->post('Title'));
        $message = trim($this->input->post('Message'));
        $image = trim($this->input->post('Image'));;

        $dataView = array();
        $user = $this->session->userdata('user');
        $dataView['user'] = $user;
        $dataView['type'] = $type;
        $dataView['content_id'] = $contentID;
        $dataView['image'] = $image;
        $dataView['title'] = $title;
        $dataView['message'] = $message;

        $push = new Push($title, $message, $type, $contentID);
        $imageName = str_replace(array(IMAGE_PATH, ROOT_PATH), '', $image);
        if(!empty($image)){
            $push->setImage($imageName);
        }

        //getting the token from database object
        $this->load->model('Device_model');
        $devicetoken = $this->Device_model->getAllTokens();

        $target = array();
        foreach ($devicetoken as $device){
            $target[] = $device[Device_model::COL_TOKEN];
        }
        
        if(empty($target)){
            $dataView['txtError'] = 'No Devices';
            $this->load->view('admin/notification/create', $dataView);
            return;
        }

        //creating firebase class object
        $firebase = new Firebase();
        //getting the push from push object
        $mPushNotification = $push->getPush();

        $response = $firebase->send($target, $mPushNotification);

        $result = json_decode($response);

        if($result->success){
            $this->load->model('Notification_model');
            $this->Notification_model->insert($push);
            $dataView['txtSuccess'] = 'Send push successfully!';
        }else{
            $dataView['txtError'] = $result -> results[0]-> error;
        }

        $this->load->view('admin/notification/create', $dataView);
    }

    private function responseErrorJson($message)
    {
        return json_encode(array(
            'code' => -1,
            'message' => $message,
            'content' => array()
        ));
    }

    private function responseSuccessJson($content)
    {
        return json_encode(array(
            'code' => 1,
            'message' => "Request successfully",
            'content' => $content
        ));
    }
    public function viewList(){
        $user = $this->session->userdata('user');
        if ($user) {
            $data = array();
            $this->load->model('Notification_model');
            $data['user'] = $user;
            $data['pages'] = $this->Notification_model->getAllNotify();
            $this->load->view('admin/notification/list', $data);

        } else redirect('index.php/user');
    }
     public function delete($notificationID)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($notificationID > 0) {
                $this->load->model('Notification_model');
                $flag = $this->Notification_model->delete($notificationID);
                if ($flag) $this->session->set_flashdata('txtSuccess', "Comment has been deleted");
                else $this->session->set_flashdata('txtError', "Delete comment failed");
            }
            redirect('index.php/admin/notification/viewList');
        } else redirect('index.php/user');
    }
}