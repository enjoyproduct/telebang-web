<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function __destruct()
    {
        $this->db->close();
    }

    function index()
    {
        $user = $this->session->userdata('customer');
        if ( !$user)
        {
            redirect(HOME_PATH);
        }
        else
        {
            // $this->load->view(THEME_VM_DIR.'/includes/user/profile');
        }
    }
    
    public function login()
    {
        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));
        $user = $this->session->userdata('customer');
        if ( !$user)
        {
            if(!empty($username) && !empty($password)){
                $this->load->model('Musers');
                $user = $this->Musers->login($username, $password);
                if($user){
                        $this->session->set_userdata('customer', $user);

                        $this->load->helper('cookie');
                        $this->input->set_cookie(array('name' => 'userName', 'value' => $username, 'expire' => '86400'));
                        $this->input->set_cookie(array('name' => 'userPass', 'value' => $password, 'expire' => '86400'));

                    echo $this-> fmResponseData( 1, 'Login Successflly!', $user);
                    return;
                }
                else $loginError = "User is not activate or Username/ Password is wrong.";
            }
            else $loginError = "Enter any username and password.";
            echo $this-> fmResponseData( 1, $loginError, $user);
        }else{
            echo $this-> fmResponseData(1,'Login Successflly!', $user);
        }
    }
    public function logout(){
        $this->session->unset_userdata('customer');
        $this->load->library('user_agent');
        // redirect($this->agent->referrer());
        redirect(site_url(HOME_PATH));
    }
    public function register()
    {
        $userName = trim($this->input->post('username'));
        $userPass = trim($this->input->post('password'));
        $email = trim($this->input->post('email'));
        if (!empty($userName) && !empty($userPass) && !empty($email)) {
            $models = array('Mconfigs', 'Musers');
            foreach ($models as $model)
                $this->load->model($model);
            $statusId = 1;
            $configValue = $this->Mconfigs->getConfigValue('STATUS_USER');
            if ($configValue > 0){
                $statusId = $configValue;
            }
            $valueData = array(
                'UserName' => $userName,
                'UserPass' => md5($userPass),
                'Email' => $email,
                'RoleId' => 3,
                'IsVip' => 0,
                'StatusId' => $statusId,
                'FirstName' => trim($this->input->post('firstname')),
                'LastName' => trim($this->input->post('lastname')),
                'Address' => trim($this->input->post('address')),
                'PhoneNumber' => trim($this->input->post('phone')),
                'City' => trim($this->input->post('city')),
                'Country' => trim($this->input->post('country')),
                'Zip' => trim($this->input->post('zip')),
                'oauth_provider' => 'default'
            );
            $userId = $this->Musers->insert($valueData);
            if ($userId > 0) {
                $user = $valueData;

                $user['UserId'] = $userId;
                $user['Avatar'] = '';

                $this->session->set_userdata('customer', $user);

                $content = $this->fmResponseData($user);
                echo $this->fmResponseData($content);
            } else {
                echo $this->fmResponseData('UserName or Email is exist.');
            }
        } else {
            echo $this->fmResponseData('Input is blank.');
        }
    }
    
    public function change_password()
    {
        $userId = $this->input->post('user_id');
        $oldPass = $this->input->post('old_password');
        $newPass = $this->input->post('new_password');

        if ($userId > 0 && !empty($oldPass) && !empty($newPass)) {
            $this->load->model('Musers');
            $user = $this->Musers->get($userId);
            if ($user && $user['UserPass'] == md5($oldPass)) {
                $flag = $this->Musers->updatePassword($userId, $newPass);
                if ($flag) {
                    $this->load->helper('cookie');
                    $this->input->set_cookie(array('name' => 'userPass', 'value' => $newPass, 'expire' => '86400'));
                    echo $this->fmResponseData(1,'The password is changed successfully.');
                } else {
                    echo $this->fmResponseData(-1 , 'An error occurred in the implementation process.');
                }
            } else {
                echo $this->fmResponseData(-2 , 'User is not exist or old password is wrong.');
            }
        } else {
            echo $this->fmResponseData(-3 ,'Input is blank.');
        }
    }

    public function change_avatar()
    {
        // print_r($_REQUEST);die;
        // echo 'sddssdf123121321515'.json_encode($_REQUEST);die;
        $userId = $this->input->post('user_id');
        if ($userId > 0) {
            $this->load->model('Musers');
            $valueData = array();
            if (isset($_FILES['avatar'])) {
                $fileAvatar = $_FILES['avatar']; //size
                if (in_array($fileAvatar['type'], array('image/jpeg', 'image/png'))) {
                    $fileName = date('YmdHis').'.png';
                    if (move_uploaded_file($fileAvatar["tmp_name"], USER_PATH . $fileName)) {
                        $valueData['Avatar'] = $fileName;
                    }
                }
            }
            if (!empty($valueData)) {
                $flag = $this->Musers->update($valueData, $userId);
                if ($flag) {
                    $user = $this->Musers->get($userId);
                    $this->session->set_userdata('customer', $user);
                    echo $this->fmResponseData(1,'Change avatar successfully', $user['Avatar']);
                } else {
                    echo $this->fmResponseData(-1 ,'There is a problem with the images processing. Please try again.');
                }
            } else {
                echo $this->fmResponseData(-2 ,'No avatar select.');
            }
        } else {
            echo $this->fmResponseData(-3 ,'UserId must be greater than 0.');
        }
    }
    public function update_session_for_subscription() {
        $user = $this->session->userdata('customer');
        $user['IsVip'] = 1;
        $this->session->set_userdata('customer', $user);
    }
    private function fmResponseData($code = 0, $message = '', $content = array())
    {
        return json_encode(array(
            'code' => $code,
            'message' => $message,
            'content' => $content
        ));
    }
}