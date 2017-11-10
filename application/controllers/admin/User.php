<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
	public function __construct(){
        parent::__construct();        
    }
    
    public function __destruct() {
        $this->db->close();
    }

    public function index(){
        $user = $this->session->userdata('user');
        if($user) redirect('index.php/admin/user/profile');
        else{
            $this->load->helper('cookie');
            $data = array();
            $data['userName'] = $this->input->cookie('userName', true);
            $data['userPass'] = $this->input->cookie('userPass', true);
            if($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if($this->session->flashdata('loginError')) $data['loginError'] = $this->session->flashdata('txtError');           
            $this->load->view('admin/user/login', $data);
        }
    }

    public function login(){
    	$username = $this->input->post('username');
        $password = $this->input->post('password');
        $loginError = "";
        if(!empty($username) && !empty($password)){
            $this->load->model('Musers');
            $user = $this->Musers->login($username, $password);
            if($user){
                if ($user['RoleId']==1){
                    $this->session->set_userdata('user', $user);
                    if($this->input->post('remember')=='on'){
                        $this->load->helper('cookie');
                        $this->input->set_cookie(array('name' => 'userName', 'value' => $username, 'expire' => '86400'));
                        $this->input->set_cookie(array('name' => 'userPass', 'value' => $password, 'expire' => '86400'));
                    }
                    redirect('index.php/admin/dashboard');
                }
                else $loginError = "You don't have permission to access.";
            }
            else $loginError = "User is not activate or Username/ Password is wrong.";
        }
        else $loginError = "Enter any username and password.";
        if(!empty($loginError)) {
            $data = array();
            $data['loginError'] = $loginError;
            $this->load->view('admin/user/login', $data);
        }
    }

    public function logout(){
        $this->session->unset_userdata('user');
        redirect('index.php/admin/user');
    }

    public function lookscreen(){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            if($this->input->post('submit')){
                $password = $this->input->post('password');
                if(md5($password)==$user['UserPass']){
                    redirect('index.php/admin/user/profile');
                    exit();
                }
            }
            $this->load->view('admin/user/lookscreen', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function forgotpass($token = ""){
        $data = array();
        $data['token'] = $token;
        if(!empty($token)){
            if($this->input->post('submit')){
                $userPass = trim($this->input->post('password'));
                $rePass = trim($this->input->post('rpassword'));
                if($userPass == $rePass){
                    $this->load->model('Musers');
                    $user = $this->Musers->getByToken($token);
                    if($user){
                        $flag = $this->Musers->updatePassword($user['UserId'], $userPass);
                        if($flag) $data['txtSuccess'] = "Change Password Success";
                        else $data['loginError'] = "An error occurred in the implementation process!";    
                    }
                    else $data['loginError'] = "Token not match";
                }
                else $data['loginError'] = "Password not match";
            }
        }
        else $data['loginError'] = "Token is empty";        
        $this->load->view('admin/user/forgotpass', $data);
    }

    public function sendEmailForgot(){
        $email = trim($this->input->post('email'));
        $this->load->helper('email');
        if(!empty($email) && valid_email($email)){
            $models = array('Mconfigs', 'Musers');
            foreach($models as $model) $this->load->model($model); 
            $user = $this->Musers->getByEmail($email);
            if($user){
                $token = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_RANDOM));
                $emailFrom = $this->Mconfigs->getConfigValue('ADMIN_EMAIL');
                if(!$emailFrom) $emailFrom = "contact@hoanmuada.com";
                $this->load->library('email');
                $this->email->set_newline("\r\n");
                $this->email->from($emailFrom, 'YoVideo');
                $this->email->to($email);
                $this->email->subject('Forgot Password From '.base_url());
                $message = "Dir {$user['FirstName']} {$user['LastName']}\r\nPlease click on "
                            .base_url('user/forgotpass/'.$token).' to change password.';
                $this->email->message($message);    
                $this->Musers->update(array('Token' => $token), $user['UserId']);
                if($this->email->send()) $this->load->view('admin/user/login', array('txtSuccess' => 'An email will be sent to you with reset password link.'));
                else{
                    $this->Musers->update(array('Token' => ''), $user['UserId']);
                    $this->load->view('admin/user/login', array('loginError' => 'An error occurred in the implementation process!'));
                }
            }
        }
        else $this->load->view('admin/user/login', array('loginError' => 'Email is invalid'));
    }

    public function profile(){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            $models = array('Musers', 'Mmodels');
            foreach($models as $model) $this->load->model($model);
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listRoles'] = $this->Mmodels->getList('roles');

            if(!empty($user['Avatar'])) 
                $data['avatar'] = USER_PATH.$user['Avatar'];
            else
                $data['avatar'] = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
            
            if($this->input->post('submit')){
                $avatarUser = trim($this->input->post('Avatar'));

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
                    'Zip' => trim($this->input->post('Zip'))
                );
                $config = array(
                    'upload_path' => USER_PATH,
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'max_size' => "2048000", // 2 MB(2048 Kb)
                );
                 $this->load->library('upload', $config);
                 if($this->upload->do_upload('Avatar')){
                     $uploadData = $this->upload->data();
                     $valueData['Avatar'] = $uploadData['file_name'];
                     $data['avatar'] = USER_PATH.$uploadData['file_name'];
                 }
                
                $flag = $this->Musers->update($valueData, $user['UserId']);
                if($flag){
                    if($flag===-1) $data['txtError'] = "Email already exists in the system!";
                    else{
                        $data['txtSuccess'] = "Profile Account Saved";
                        $user = array_merge($user, $valueData);
                        $data['user'] = $user;
                        $this->session->set_userdata('user', $user);
                    }
                }
                else $data['txtError'] = "An error occurred in the implementation process!";
            }
            $this->load->view('admin/user/profile', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function changepass(){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            $models = array('Musers', 'Mmodels');
            foreach($models as $model) $this->load->model($model);
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listRoles'] = $this->Mmodels->getList('roles');
            if($this->input->post('submit')){
                $oldPass = trim($this->input->post('OldPass'));
                if(md5($oldPass)==$user['UserPass']){
                    $newPass = trim($this->input->post('NewPass'));
                    $rePass = trim($this->input->post('RePass'));
                    if(!empty($newPass) && $newPass==$rePass){
                        $newPass = md5($newPass);
                        $flag = $this->Musers->update(array('UserPass' => $newPass), $user['UserId']);
                        //$flag = $this->Musers->changePass($newPass, $user['UserId']);
                        if($flag){
                            $data['txtSuccess'] = "User Password changed";
                            $user['UserPass'] = $newPass;
                            $data['user'] = $user;
                            $this->session->set_userdata('user', $user);
                        }
                        else $data['txtError'] = "An error occurred in the implementation process!";
                    }
                    else $data['txtError'] = "New Password is not match";
                }
                else $data['txtError'] = "Old Password is wrong";
            }
            $this->load->view('admin/user/profile', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function userlist(){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            $this->load->model('Mmodels');
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listRoles'] = $this->Mmodels->getList('roles');
            $data['listUsers'] =  $this->Mmodels->getList('users');
            if($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if($this->session->flashdata('txtError')) $data['txtError'] = $this->session->flashdata('txtError');
            $this->load->view('admin/user/userlist', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function delete($userId = 0){
        $user = $this->session->userdata('user');
        if($user){
            if($userId>0){
                $this->load->model('Musers');
                $flag = $this->Musers->delete($userId);
                if($flag) $this->session->set_flashdata('txtSuccess', "User has been deleted");
                else $this->session->set_flashdata('txtError', "Delete user failed");
            }
            redirect('index.php/admin/user/userlist');
        }
        else redirect('index.php/admin/user');
    }

    public function updatestatus($userId = 0){
        $user = $this->session->userdata('user');
        if($user){
            if($userId>0){
                $this->load->model('Musers');
                $valueData = array('StatusId' => STATUS_ACTIVED);
                $flag = $this->Musers->update($valueData, $userId);
                if($flag) $this->session->set_flashdata('txtSuccess', "User has been activated");
                else $this->session->set_flashdata('txtError', "An error occurred in the implementation process!");
            }
            redirect('index.php/admin/user/userlist');
        }
        else redirect('index.php/admin/user');
    }

    public function update($userId = 0){
        $user = $this->session->userdata('user');
        if($user) {
            $data = array();
            $data['user'] = $user;
            $data['userId'] = $userId;
            $models = array('Musers', 'Mmodels');
            foreach($models as $model) $this->load->model($model);
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listRoles'] = $this->Mmodels->getList('roles');
            $data['userName'] = $data['firstName'] = $data['lastName'] = $data['email'] = $data['phoneNumber'] = $data['password'] = $data['address'] = $data['country'] = $data['city'] = $data['zip'] = "";
            $data['statusId'] = STATUS_ACTIVED;
            $data['roleId'] = 3;
            $data['isVip'] = 0;
            $data['avatar'] = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
            $flag = 0;
            if($userId>0){
                $userEdit = $this->Musers->get($userId);
                if($userEdit){
                    $flag = 1;
                    $data['userName'] = $userEdit['UserName'];
                    $data['firstName'] = $userEdit['FirstName'];
                    $data['lastName'] = $userEdit['LastName'];
                    $data['email'] = $userEdit['Email'];
                    $data['phoneNumber'] = $userEdit['PhoneNumber'];
                    $data['password'] = $userEdit['UserPass'];
                    $data['address'] = $userEdit['Address'];
                    $data['country'] = $userEdit['Country'];
                    $data['city'] = $userEdit['City'];
                    $data['zip'] = $userEdit['Zip'];
                    $data['statusId'] = $userEdit['StatusId'];
                    $data['roleId'] = $userEdit['RoleId'];
                    $data['isVip'] = $userEdit['IsVip'];
                    if(!empty($userEdit['Avatar'])) $data['avatar'] = USER_PATH.$userEdit['Avatar'];
                }
                else{
                    $data['txtError'] = "User is not exist.";
                    $flag = 2;
                }
            }
            else $flag = 3;
            $data['flag'] = $flag;
            if($this->input->post('submit') && $flag!=2){
                $isVip = ($this->input->post('IsVip')=='on') ? 1 : 0;
                $data['isVip'] = $isVip;

                $valueData = array(
                    'UserName' => trim($this->input->post('UserName')),
                    'Email' => trim($this->input->post('Email')),
                    'RoleId' => $this->input->post('RoleId'),
                    'IsVip' => $isVip,
                    'StatusId' => $this->input->post('StatusId')
                );
                $fields = array('FirstName', 'LastName', 'Address', 'PhoneNumber', 'City', 'Country', 'Zip');
                foreach($fields as $field){
                    $value = trim($this->input->post($field));
                    if(!empty($value)) $valueData[$field] = $value;
                }
                $config = array(
                    'upload_path' => USER_PATH,
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'max_size' => "2048000", // 2 MB(2048 Kb)
                );
                 $this->load->library('upload', $config);
                 if($this->upload->do_upload('Avatar')){
                     $uploadData = $this->upload->data();
                     $valueData['Avatar'] = $uploadData['file_name'];
                     $data['avatar'] = USER_PATH.$uploadData['file_name'];
                 }
                if($flag==1){
                    if (md5($this->input->post('UserPass'))==$data['password'] && $this->input->post('NewPass')!='' && md5($this->input->post('NewPass'))==md5($this->input->post('RePass')))
                        $valueData['UserPass'] = md5($this->input->post('NewPass'));
                    $flag1 = $this->Musers->update($valueData, $userId);
                }
                else{
                    if ($this->input->post('UserPass')!='' && md5($this->input->post('UserPass'))==md5($this->input->post('RePass')))
                        $valueData['UserPass'] = md5($this->input->post('UserPass'));
                    $flag1 = $this->Musers->insert($valueData);
                    if($flag1>0){
                        $data['userId'] = $flag1;
                        $data['flag'] = 1;
                    }
                }
                if($flag1){
                    if($flag1===-1)  $data['txtError'] = "UserName or Email already exists in the system!";
                    else if ($flag==1){
                        if (md5($this->input->post('NewPass'))!=md5($this->input->post('RePass')))
                            $data['txtError'] = "Incorrect password confirmation!";
                        else if (md5($this->input->post('UserPass'))!=$data['password'] && $this->input->post('NewPass')!='')
                            $data['txtError'] = "Incorrect old password!";
                    }
                    else {
                        if (md5($this->input->post('UserPass'))!=md5($this->input->post('RePass')))
                            $data['txtError'] = "Incorrect password confirmation!";

                        else $data['txtSuccess'] = "User Saved";
                    }
                }
                else $data['txtError'] = "An error occurred in the implementation process!";

            }
            $this->load->view('admin/user/userupdate', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function register(){      
        $models = array('Mconfigs', 'Musers');
        foreach($models as $model) $this->load->model($model);  
        $statusId = 1;
        $configValue = $this->Mconfigs->getConfigValue('STATUS_USER');
        if($configValue>0) $statusId = $configValue;
        $valueData = array(
            'UserName' => trim($this->input->post('username')),
            'UserPass' => md5($this->input->post('password')),
            'Email' => trim($this->input->post('email')),
            'RoleId' => 3,
            'IsVip' => 0,
            'StatusId' => $statusId,
            'FirstName' => trim($this->input->post('firstname')),
            'LastName' => trim($this->input->post('lastname')),
            'Address' => trim($this->input->post('address')),
            'City' => trim($this->input->post('city')),
            'Country' => trim($this->input->post('country'))
        );
        $userId = $this->Musers->insert($valueData);
        if($userId>0) $this->session->set_flashdata('txtSuccess', "Thanks. We will comfirm and active you account soon");
        elseif($userId===-1) $this->session->set_flashdata('loginError', "UserName or Email already exists in the system!");
        else $this->session->set_flashdata('loginError', "An error occurred in the implementation process!");
        redirect('index.php/admin/user');
    }
}
