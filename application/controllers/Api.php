<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//http://stackoverflow.com/questions/18382740/cors-not-working-php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
require_once 'paystack.php';
class Api extends CI_Controller
{

    private $withAvatarFb = 256;
    private $heightAvatarFb = 256;

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        $this->db->close();
    }

    //user
    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if (!empty($username) && !empty($password)) {
            $this->load->model('Musers');
            $user = $this->Musers->login($username, $password);
            if ($user) {
                echo $this->responseSuccessJson($this->formatUserResponse($user));
            } else {
                echo $this->responseErrorJson('User is not activate or Username/ Password is wrong.');
            }
        } else {
            echo $this->responseErrorJson('UserName or Password is blank.');
        }
    }
     public function get_new_access_code() {
        $user_id = $this->input->post('user_id');
        $subs_type = $this->input->post('subscribed_type');
        $this->load->model('musers');
        $user = $this->musers->get($user_id);
        if (!$user) {
            echo json_encode(array(
                'code' => -1,
                'message' => "Unregistered user",
                'content' => ""
            ));
        } else {
            $data['email'] = $user['Email'];
            $data['amount'] = $this->count_subscription_amount($subs_type);
            $new_access_code = get_new_access_code($data);
            // var_dump(($new_access_code));exit();
            echo json_encode(array(
                'code' =>  $new_access_code['code'] ,
                'message' => $new_access_code['message'] ,
                'content' => $new_access_code['content'] 
            ));
            
        }
    }
    public function verify_subscription() {
        $paystack_reference = $this->input->post('paystack_auth_code');
        $response = verify_transaction($paystack_reference);
        echo json_encode($response);

    }
    public function update_subscription()
    {
        $user_id = $this->input->post('user_id');
        $paystack_auth_code = $this->input->post('paystack_auth_code');
        $subscribed_date = $this->input->post('subscribed_date');
        $card_number = $this->input->post('card_number');
        $subs_type = $this->input->post('subscribed_type');
        if (!empty($user_id)) {
            //add history
            $this->load->model('Msubscription');
            $result1 = $this->Msubscription->addSubscription($user_id, $subscribed_date, $this->count_subscription_amount($subs_type), $card_number);
            //update user table
            $this->load->model('Musers');
            $result = $this->Musers->updateSubscription($user_id, $paystack_auth_code, $subscribed_date, $subs_type);
            if ($result) {
                echo json_encode(array(
                        'code' => 1,
                        'message' => "Success to update subscription info",
                        'content' => ""
                    ));
            } else {
                echo json_encode(array(
                        'code' => -1,
                        'message' => "Failed to update subscription info",
                        'content' => ""
                    ));
            }
        } else {
            echo $this->responseErrorJson('UserName or Email is blank.');
        }
    }
   function count_subscription_amount($subs_type) {
        switch ($subs_type) {
            case 0:
                return 1 * SUBSCRIPTION_AMOUNT_PER_MONTH * 100;
            case 1:
                return 3 * SUBSCRIPTION_AMOUNT_PER_MONTH * 100;
            case 2:
                return 6 * SUBSCRIPTION_AMOUNT_PER_MONTH * 100;
            case 3:
                return 12 * SUBSCRIPTION_AMOUNT_PER_MONTH * 100;

        }
    }
    public function getSubscriptionHistory() {
        $user_id = $this->input->post('user_id');
        if (!empty($user_id)) {
            $this->load->model('Msubscription');
            $histories = $this->Msubscription->getSubscriptionsByUserID($user_id);
            echo $this->responseSuccessJson($histories);
        } else {
            echo $this->responseErrorJson('Invalid user id');
        }
    }
    public function loginFacebook()
    {
        $accessToken = $this->input->post('access-token');
        //CAACEdEose0cBADAU6YsiKBnmkvQ7m0ZCYs1ERBdL1ynh2hZCox1B3805HAlrlO1UwDscjO21WhVH6k4yJv9pCqiYuzQX1egPBxoCqOuXzafBsi11TxbEHDo8uM7tDd7REqFFMkc0svwDIERRKLgsPhumdImewMLkZAiuj1lz9vZA9i1AiLcBvIWdZCyZCMoSSaln8YUqTmEdj82ZB9y1p1V
        if (!empty($accessToken)) {
            $json = @file_get_contents("https://graph.facebook.com/me?fields=id,first_name,last_name,email&access_token=" . $accessToken);
            if ($json) {

                $json = json_decode($json, true);
                $id = isset($json['id']) ? $json['id'] : "";
                $firstName = isset($json['first_name']) ? $json['first_name'] : "";
                $lastName = isset($json['last_name']) ? $json['last_name'] : "";
                $email = isset($json['email']) ? $json['email'] : "";
                if (!empty($id) && !empty($firstName) && !empty($lastName)) {
                    $this->load->model('Musers');
                    $user = $this->Musers->getByFacebookId($id);
                    if ($user) {
                        $avatar = $user['Avatar'];
                        if (strpos($avatar, 'http') === false)
                            $avatar = base_url(USER_PATH . $avatar);
                        else
                            $avatar = "https://graph.facebook.com/{$id}/picture" . "?width=" . $this->withAvatarFb . "&height=" . $this->heightAvatarFb . "?width=" . $this->withAvatarFb . "&height=" . $this->heightAvatarFb;

                        $content = $this->formatUserResponse($user);
                        $content['avatar'] = $avatar;

                        echo $this->responseSuccessJson($content);
                    } else {
                        $avatar = "https://graph.facebook.com/{$id}/picture" . "?width=" . $this->withAvatarFb . "&height=" . $this->heightAvatarFb . "?width=" . $this->withAvatarFb . "&height=" . $this->heightAvatarFb;

                        $valueData = array(
                            'UserName' => $id,
                            'UserPass' => md5('123456789'),
                            'Email' => (empty($email)) ? $id . '@facebook.com' : $email,
                            'RoleId' => 3,
                            'IsVip' => 0,
                            'StatusId' => 2,
                            'FirstName' => $firstName,
                            'LastName' => $lastName,
                            'Avatar' => $avatar,
                            'Address' => '',
                            'PhoneNumber' => '',
                            'City' => '',
                            'Country' => '',
                            'Zip' => '',
                            'FacebookId' => $id,
                            'oauth_provider' => 'facebook'
                        );
                        $userId = $this->Musers->insertFacebookLogin($valueData);

                        if ($userId > 0) {
                            $user = $valueData;
                            $user['UserId'] = $userId;
                            $content = $this->formatUserResponse($user);
                            echo $this->responseSuccessJson($content);

                        } else {
                            echo $this->responseErrorJson('An error occurred in the implementation process.');
                        }
                        //
                    }
                } else {
                    echo $this->responseErrorJson('An error occurred in the implementation process.');
                }
            } else {
                echo $this->responseErrorJson('An error occurred in the implementation process.');
            }
        } else {
            echo $this->responseErrorJson('Access Token is blank.');
        }
    }

    public function change_password()
    {
        $userId = $this->input->post('user_id');
        $oldPass = trim($this->input->post('old_password'));
        $newPass = trim($this->input->post('new_password'));
        if ($userId > 0 && !empty($oldPass) && !empty($newPass)) {
            $this->load->model('Musers');
            $user = $this->Musers->get($userId);
            if ($user && $user['UserPass'] == md5($oldPass)) {
                $flag = $this->Musers->updatePassword($userId, $newPass);
                if ($flag) {
                    $json = json_encode(array(
                        'code' => 1,
                        'message' => 'The password is changed successfully.',
                        'content' => array()
                    ));
                    echo $this->responseSuccessJson($json);
                } else {
                    echo $this->responseErrorJson('An error occurred in the implementation process.');
                }
            } else {
                echo $this->responseErrorJson('User is not exist or old password is wrong.');
            }
        } else {
            echo $this->responseErrorJson('Input is blank.');
        }
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

                $content = $this->formatUserResponse($user);
                echo $this->responseSuccessJson($content);
            } else {
                echo $this->responseErrorJson('UserName or Email is exist.');
            }
        } else {
            echo $this->responseErrorJson('Input is blank.');
        }
    }

    public function change_profile()
    {
        $userId = $this->input->post('user_id');
        $valueData = array();
        $fields = array('UserName', 'Email', 'FirstName', 'LastName', 'Address', 'PhoneNumber', 'City', 'Country', 'Zip');
        foreach ($fields as $field) {
            $label = strtolower($field);
            if ($this->input->post($label))
                $valueData[$field] = trim($this->input->post($label));
        }
        if ($userId > 0 && !empty($valueData)) {
            $this->load->model('Musers');
            $flag = $this->Musers->update($valueData, $userId);
            if ($flag) {
                $user = $this->Musers->get($userId);
                $content = $this->formatUserResponse($user);
                echo $this->responseSuccessJson($content);

            } else {
                echo $this->responseErrorJson('There is a problem with the input data. Please try again.');
            }
        } else {
            echo $this->responseErrorJson('Input is empty.');
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
                    $content = $this->formatUserResponse($user);
                    echo $this->responseSuccessJson($content);
                } else {
                    echo $this->responseErrorJson('There is a problem with the images processing. Please try again.');
                }
            } else {
                echo $this->responseErrorJson('No avatar select.');
            }
        } else {
            echo $this->responseErrorJson('UserId must be greater than 0.');
        }
    }

    public function forgot_password()
    {
        $email = trim($this->input->post('email'));
        if (!empty($email)) {
            $models = array('Mconfigs', 'Musers');
            foreach ($models as $model)
                $this->load->model($model);
            $user = $this->Musers->getByEmail($email);
            if ($user) {
                $token = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_RANDOM));
                $emailFrom = $this->Mconfigs->getConfigValue('ADMIN_EMAIL');
                if (!$emailFrom)
                    $emailFrom = "contact@inspius.com";

                // $config['protocol'] = 'smtp';
                // $config['smtp_host'] = 'smtp.mailgun.org'; //change this with your smtp host
                // $config['smtp_port'] = '465';
                // $config['smtp_user'] = 'postmaster@inspius.com'; //your smtp user email
                // $config['smtp_pass'] = '80bba4b7dc2061f7532c366016eb02ee'; //your smtp password
                // $config['mailtype'] = 'html';
                // $config['charset'] = 'iso-8859-1';
                // $config['wordwrap'] = TRUE;
                // $config['newline'] = "\r\n";

                $this->load->library('email');
                // $this->email->initialize($config);

                $this->email->set_newline("\r\n");
                $this->email->from($emailFrom, 'YoVideo');
                $this->email->to($email);
                $this->email->subject('Forgot Password From ' . base_url());
                $message = "Dir {$user['FirstName']} {$user['LastName']}\r\nPlease click on "
                    . base_url('index.php/admin/user/forgotpass/' . $token) . ' to change password.';
                $this->email->message($message);
                $this->Musers->update(array('Token' => $token), $user['UserId']);
                if ($this->email->send()) {
                    $json = json_encode(array(
                        'code' => 1,
                        'message' => 'An email will be sent to you with reset password link.',
                        'content' => array()
                    ));
                } else {
                    $this->Musers->update(array('Token' => ''), $user['UserId']);
                    $json = json_encode(array(
                        'code' => -2,
                        'message' => 'An error occurred in the implementation process. Please try again.',
                        'content' => array()
                    ));
                }
            } else {
                $json = json_encode(array(
                    'code' => -3,
                    'message' => 'There is no account with the given email address. You can register a new account with this email address.',
                    'content' => array()
                ));
            }
        } else {
            $json = json_encode(array(
                'code' => -1,
                'message' => 'Email is empty.',
                'content' => array()
            ));
        }
        echo str_replace('"content":[]', '"content":{}', $json);
    }

    //category
    public function categories()
    {
        $this->load->model('Mcategories');
        $listCategories = $this->Mcategories->getList();
        $cates = $tops = array();
        foreach ($listCategories as $c) {
            $cates[] = array(
                'id' => intval($c['CategoryId']),
                'image' => (empty($c['CategoryImage'])) ? '' : base_url(IMAGE_PATH . $c['CategoryImage']),
                'icon' => (empty($c['CategoryIcon'])) ? '' : base_url(IMAGE_PATH . $c['CategoryIcon']),
                'name' => $c['CategoryName'],
                'parentID' => $c['ParentCategoryId'],
                'enable' => ($c['StatusId'] == STATUS_ACTIVED) ? 1 : 0
            );
            if ($c['IsTop'] == 1)
                $tops[] = intval($c['CategoryId']);
        }
        echo json_encode(array(
            'code' => 1,
            'message' => 'Get Categories Success.',
            'content' => array(
                'all_category' => $cates,
                'top_category' => $tops
            )
        ));
    }

    //video
    public function getListVideoByCategory($categoryId = 0, $page = 1, $limit = 0)
    {
        if ($categoryId > 0) {
            $this->loadModelGetVideo();
            if ($page < 1)
                $page = 1;
            $offset = ($page - 1) * $limit;
            $listVideos = $this->Mvideos->getListByCategory($categoryId, $limit, "CrDateTime", $offset);
            $content = array();
            foreach ($listVideos as $v) {
                $content[] = $this->formatVideoResponse($v);
            }
            echo $this->responseSuccessJson($content);
        } else {
            echo $this->responseErrorJson('CategoryId must be greater than 0.');
        }
    }

    public function getListVideoTrending($page = 1, $limit = 0)
    {
        $this->loadModelGetVideo();

        $listVideos = $this->Mvideos->getListTrending($page, $limit);
        $content = array();
        foreach ($listVideos as $v) {
            $content[] = $this->formatVideoResponse($v);
        }
        echo $this->responseSuccessJson($content);
    }

    public function getListVideoLasted($page = 1, $limit = 0)
    {
        $this->loadModelGetVideo();
        if ($page < 1)
            $page = 1;
        $offset = ($page - 1) * $limit;
        $listVideos = $this->Mvideos->getList(0, 0, "", 0, $limit, "CrDateTime", $offset);
        $content = array();
        foreach ($listVideos as $v) {
            $content[] = $this->formatVideoResponse($v);
        }
        echo $this->responseSuccessJson(array('videos' => $content));
    }

    public function getListVideoMostView($page = 1, $limit = 0)
    {
        $this->loadModelGetVideo();

        if ($page < 1)
            $page = 1;
        $offset = ($page - 1) * $limit;
        $listVideos = $this->Mvideos->getList(0, 0, "", 0, $limit, 'ViewCount', $offset);
        $content = array();
        foreach ($listVideos as $v) {
            $content[] = $this->formatVideoResponse($v);
        }
        echo $this->responseSuccessJson(array('videos' => $content));
    }

    public function getListVideoForHomepage($limit = 0)
    {
        $this->loadModelGetVideo();
        $listVideos = $this->Mvideos->getList(0, 0, "", 0, $limit);
        $latest = array();
        foreach ($listVideos as $v) {
            $latest[] = $this->formatVideoResponse($v);
        }

        $listVideos = $this->Mvideos->getList(0, 0, "", 0, $limit, 'ViewCount');
        $mostView = array();
        foreach ($listVideos as $v) {
            $mostView[] = $this->formatVideoResponse($v);
        }
        $content = array(
            'latest' => $latest,
            'most_view' => $mostView
        );
        echo $this->responseSuccessJson($content);
    }

    public function getWishlist($userId = 0)
    {
        if ($userId > 0) {
            $this->loadModelGetVideo();
            $listVideos = $this->Mvideos->getList(0, 0, "", $userId);
            $content = array();
            foreach ($listVideos as $v) {
                $content[] = $this->formatVideoResponse($v);
            }
            echo $this->responseSuccessJson($content);
        } else {
            echo $this->responseErrorJson('UserId must be greater than 0.');
        }
    }

    public function getListVideoByKeyword()
    {
        $keyword = trim($this->input->post('keyword'));
        $page = $this->input->post('page');
        $limit = $this->input->post('limit');
        if (!empty($keyword)) {
            $this->loadModelGetVideo();

            if ($page < 1)
                $page = 1;
            $offset = ($page - 1) * $limit;
            $listVideos = $this->Mvideos->getList(0, 0, $keyword, 0, $limit, "CrDateTime", $offset);
            $content = array();
            foreach ($listVideos as $v) {
                $content[] = $this->formatVideoResponse($v);
            }
            echo $this->responseSuccessJson($content);
        } else {
            echo $this->responseErrorJson('Keyword is empty.');
        }
    }

    public function getVideosBySeries()
    {
        $series = trim($this->input->post('series'));
        $page = $this->input->post('page');
        $limit = $this->input->post('limit');
        if (!empty($series)) {
            $this->loadModelGetVideo();

            if ($page < 1)
                $page = 1;
            $offset = ($page - 1) * $limit;
            $listVideos = $this->Mvideos->getList(0, 0, '', 0, $limit, "CrDateTime", $offset, $series);
            $content = array();
            foreach ($listVideos as $v) {
                $content[] = $this->formatVideoResponse($v);
            }
            echo $this->responseSuccessJson($content);
        } else {
            echo $this->responseErrorJson('Series is empty.');
        }
    }

    public function updateStatistics()
    {
        $videoId = $this->input->post('video_id');
        $userId = $this->input->post('user_id');
        $field = trim($this->input->post('field'));
        if ($videoId > 0 && !empty($field)) {
            $field = strtolower($field);
            $fieldName = "";
            switch ($field) {
                case 'view':
                    $fieldName = "ViewCount";
                    break;
                case 'share':
                    $fieldName = "ShareCount";
                    break;
                case 'like':
                    $fieldName = "LikeCount";
                    break;
                case 'download':
                    $fieldName = "DownloadCount";
                    break;
                default:
                    break;
            }
            if (!empty($fieldName)) {
                $this->load->model('Mvideos');
                $flag = $this->Mvideos->updateStatistics($videoId, $fieldName, $userId);
                if ($flag) {
                    $json = json_encode(array(
                        'code' => 1,
                        'message' => 'Update Statistics Success.',
                        'content' => array()
                    ));
                } else {
                    $json = json_encode(array(
                        'code' => -3,
                        'message' => 'An error occurred in the implementation process.',
                        'content' => array()
                    ));
                }
            } else {
                $json = json_encode(array(
                    'code' => -2,
                    'message' => 'Field update is invalid.',
                    'content' => array()
                ));
            }
        } else {
            $json = json_encode(array(
                'code' => -1,
                'message' => 'Input is empty.',
                'content' => array()
            ));
        }
        echo str_replace('"content":[]', '"content":{}', $json);
    }

    public function getListRecentVideo($userId = 0, $page = 1, $limit = 0)
    {
        if ($userId > 0) {
            $this->loadModelGetVideo();

            if ($page < 1)
                $page = 1;
            $offset = ($page - 1) * $limit;

            $listVideos = $this->Mvideos->getListRecentVideo($userId, $limit, $offset);

            $content = array();
            foreach ($listVideos as $v) {
                $content[] = $this->formatVideoResponse($v);
            }
            echo $this->responseSuccessJson($content);
        } else {
            $json = json_encode(array(
                'code' => -1,
                'message' => 'UserId must be greater than 0.',
                'content' => array()
            ));
            echo str_replace('"content":[]', '"content":{}', $json);
        }
    }

    public function getVideoById($videoId)
    {
        if ($videoId > 0) {
            $this->loadModelGetVideo();
            $v = $this->Mvideos->get($videoId);
            if ($v)
                echo $this->responseSuccessJson($this->formatVideoResponse($v));
            else
                echo $this->responseErrorJson('Video not found');

        } else {
            echo $this->responseErrorJson('VideoId must be greater than 0');
        }
    }

    public function getListVideoBySeries($seriesId, $page = 1, $limit = 0)
    {
        $this->loadModelGetVideo();
        $offset = ($page - 1) * $limit;
        $listVideos = $this->Mvideos->getVideoBySeriesId($seriesId, $limit, $offset);
        $content = array();
        foreach ($listVideos as $v) {
            $content[] = $this->formatVideoResponse($v);
        }
        echo $this->responseSuccessJson($content);

    }

    public function getListSeries($isCompleted = 0, $page = 1, $limit = 0)
    {
        $this->load->model('Mseries');
        $listSeries = $this->Mseries->getListSeries($isCompleted, $page, $limit);

        $content = array();
        foreach ($listSeries as $s) {
            $content[] = $this->formatSeriesResponse($s);
        }

        echo $this->responseSuccessJson($content);
    }

    private function loadModelGetVideo()
    {
        $models = array('Mvideos', 'Mmodels', 'Musers', 'Mcategoryvideos', 'Mseries');
        foreach ($models as $model)
            $this->load->model($model);
    }

    private function formatVideoResponse($video)
    {
        $videoUrl = $video['VideoUrl'];
        if (strpos($videoUrl, 'http') === false)
            $videoUrl = base_url(VIDEO_PATH . $videoUrl);

        $videoTypes = $this->Mmodels->getList('videotypes');
        $listVideoTypes = array();
        foreach ($videoTypes as $vt)
            $listVideoTypes[$vt['VideoTypeId']] = $vt['VideoTypeName'];

        $videoType = $listVideoTypes[$video['VideoTypeId']];

        $duration = $video['VideoLength'];
        $videoLength = floor($duration / 60) . ":" . ($duration % 60);

        $cateId = '';
        $cateIds = $this->Mcategoryvideos->getCategoryIdList($video['VideoId']);
        if (!empty($cateIds)) {
            $cateId = $cateIds[0];
            unset($cateIds[0]);
        }

        $author = null;
        $user = $this->Musers->get($video['CrUserId']);
        if ($user)
            $author = $this->formatUserResponse($user);

        $videoImage = $video['VideoImage'];
        if (strpos($videoImage, 'http') === false)
            $videoImage = base_url(IMAGE_PATH . $videoImage);

        $seriesID = $video['Series'];
        $series = null;
        if ($seriesID) {
            $item = $this->Mseries->get($seriesID);
            if ($item)
                $series = $this->formatSeriesResponse($item);
        }

        $content = array(
            'url_social' => $video['SocialUrl'],
            'video' => array(
                'url' => $videoUrl,
                'type' => $videoType,
                'length' => $videoLength
            ),
            'stats' => array(
                'views' => intval($video['ViewCount']),
                'shares' => intval($video['ShareCount']),
                'likes' => intval($video['LikeCount']),
                'downloads' => intval($video['DownloadCount'])
            ),
            'category_id' => intval($cateId),
            'another_category_ids' => array_values($cateIds),
            'series' => $series,
            'author' => $author,
            'url_image' => $videoImage,
            'description' => $video['VideoDesc'],
            'title' => $video['VideoTitle'],
            'update_at' => ddMMyyyy($video['UpdateDate'], 'm/d/Y'),
            'create_at' => ddMMyyyy($video['CrDateTime'], 'm/d/Y'),
            'id' => intval($video['VideoId']),
            'vip_play' => intval($video['IsVip'])
        );

        return $content;
    }

    private function formatSeriesResponse($series)
    {
        $thumbnail = $series['thumbnail'];
        if (!empty($thumbnail)) {
            if (strpos($thumbnail, 'http') == false)
                $thumbnail = base_url(IMAGE_PATH . $thumbnail);
        }
        return array(
            'id' => $series[Mseries::TABLE_ID],
            'title' => $series[Mseries::TABLE_SERIES_NAME],
            'thumbnail' => $thumbnail,
            'short_description' => $series[Mseries::TABLE_SERIES_SHORT_DESC],
            'completed' => $series[Mseries::TABLE_SERIES_COMPLETED],
        );
    }

    public function playFacebookVideo()
    {
        $videoUrl = $_REQUEST['video_url'];
        $data = array();
        $data['videoUrl'] = $videoUrl;
        $this->load->view('facebookvideo', $data);
    }

    public function playGoogleDriveVideo()
    {
//        $videoUrl = $_REQUEST['video_url'];
        $data = array();
//        $data['videoUrl'] = $videoUrl;
        $this->load->view('googledrive', $data);
    }

    public function uploadVideo()
    {
        $videoTitle = trim($this->input->post('video_title'));
        $userId = $this->input->post('user_id');
        if ($userId > 0 && !empty($videoTitle) && isset($_FILES['file_video'])) {
            $fileVideo = $_FILES['file_video'];

//            if (in_array($fileVideo['type'], array('video/mp4', 'video/3gp'))) {
//            if (strstr($fileVideo['type'], "video/")||strstr($fileVideo['type'], "audio/")) {
            //$fileName = date('YmdHis') . '_' . $fileVideo['name'];
            $fileName = date('YmdHis');
            if (move_uploaded_file($fileVideo["tmp_name"], VIDEO_PATH . $fileName)) {
                $models = array('Mvideos', 'Mmodels', 'Musers', 'Mcategoryvideos', 'Mconfigs');
                foreach ($models as $model)
                    $this->load->model($model);

                $statusId = $this->Mconfigs->getConfigValue('STATUS_VIDEO');
                if (!$statusId)
                    $statusId = 1;
                $crDateTime = date('Y-m-d H:i:s');
                $valueData = array(
                    'VideoTitle' => $videoTitle,
                    'VideoUrl' => $fileName,
                    'VideoLength' => $this->input->post('video_length') ? $this->input->post('video_length') : 0,
                    'Series' => trim($this->input->post('series')),
                    'VideoDesc' => trim($this->input->post('video_desc')),
                    'SocialUrl' => trim($this->input->post('social_url')),
                    'StatusId' => $statusId,
                    'VideoTypeId' => 1,
                    'IsVip' => $this->input->post('vip') ? $this->input->post('vip') : 0,
                    'DisplayHome' => 1,
                    'UpdateDate' => $crDateTime,
                    'CrUserId' => $userId,
                    'CrDateTime' => $crDateTime
                );
                /* $config = array(
                  'upload_path' => IMAGE_PATH,
                  'allowed_types' => "gif|jpg|png|jpeg",
                  'max_size' => "2048000", // 2 MB(2048 Kb)
                  );
                  $this->load->library('upload', $config);
                  if($this->upload->do_upload('video_image')){
                  $uploadData = $this->upload->data();
                  $valueData['VideoImage'] = $uploadData['file_name'];
                  } */
                if (isset($_FILES['video_image'])) {
                    $fileAvatar = $_FILES['video_image']; //size
                    if (in_array($fileAvatar['type'], array('image/jpeg', 'image/png'))) {
                        $fileName = date('YmdHis') . '_' . str_replace(' ', '_', $fileAvatar['name']);
                        if (move_uploaded_file($fileAvatar["tmp_name"], IMAGE_PATH . $fileName)) {
//                                $valueData['VideoImage'] = $fileName;
                            $valueData['VideoImage'] = base_url(IMAGE_PATH . $fileName);
                        }
                    }
                }
                $listCategoryIds = array();
                $cateIds = trim($this->input->post('category_ids'));
                if (!empty($cateIds))
                    $listCategoryIds = explode(',', $cateIds);

                $videoId = $this->Mvideos->insertOrUpdate($valueData, 0, $listCategoryIds);
                if ($videoId > 0) {
                    $v = $this->Mvideos->get($videoId);
                    if ($v) {
                        echo $this->responseSuccessJson($this->formatVideoResponse($v));
                    } else {
                        echo $this->responseErrorJson('Video not found');
                    }
                } else {
                    echo $this->responseErrorJson('Video not found.');
                }
            } else {
                echo $this->responseErrorJson('Sorry, there was an error uploading your video file.');
            }
//            } else {
//                echo $this->responseErrorJson('Your video file is wrong type');
//            }
        } else {
            echo $this->responseErrorJson('Input is empty');
        }
    }

    public function getListCommentVideo($videoID = 0, $page = 1, $limit = 20)
    {
        $this->load->model('Comment_video_model');
        $this->load->model('Musers');
        $this->load->model('Mconfigs');

        if ($page < 1)
            $page = 1;
        $offset = ($page - 1) * $limit;


        $listComment = $this->Comment_video_model->getListCommentByVideoID($videoID, $limit, $offset);

        $content = array();
        foreach ($listComment as $comment) {
            $content[] = $this->formatCommentVideoResponse($comment);
        }

        echo $this->responseSuccessJson($content);
    }

    public function likeVideo()
    {
        $userIDHeader = $this->input->post('customer_id');

        if (!$userIDHeader || $userIDHeader <= 0) {
            echo $this->responseErrorJson('Miss header customer_id');
            return;
        }

        $videoID = $this->input->post('video_id');

        if (!$videoID) {
            echo $this->responseErrorJson('Miss video_id or action params');
            return;
        }

        $this->load->model('Like_video_model');
        $this->load->model('Mvideos');

        $isLike = false;
        if ($userIDHeader)
            $isLike = $this->Like_video_model->checkLikedVideo($userIDHeader, $videoID);

        $content = array();
        if (!$isLike) {
            $data = array(
                Like_video_model::TBL_LIKE_USER_ID => $userIDHeader,
                Like_video_model::TBL_LIKE_VIDEO_ID => $videoID,
                Like_video_model::TBL_LIKE_CREATE_AT => (new DateTime())->getTimestamp()
            );

            $video = $this->Mvideos->get($videoID);

            if (!$video) {
                echo $this->responseErrorJson("Video not found");
                return;
            }

            $this->Like_video_model->insertLike($data);
            $content['action'] = 'liked';

        } else {
            $this->Like_video_model->delete($userIDHeader, $videoID);
            $content['action'] = 'unLike';
        }

        $likeStats = $this->Like_video_model->getStatsLike($videoID);
        $content['new_stats_like'] = $likeStats;
        echo $this->responseSuccessJson($content);
    }

    public function getLikeVideoStatus($videoID, $userIDHeader = 0)
    {
        if (!$userIDHeader || $userIDHeader <= 0) {
            echo $this->responseErrorJson('Miss header customer_id');
            return;
        }

        if (!$videoID) {
            echo $this->responseErrorJson('Miss video_id or action params');
            return;
        }

        $this->load->model('Like_video_model');
        $this->load->model('Mvideos');

        $isLike = false;
        if ($userIDHeader)
            $isLike = $this->Like_video_model->checkLikedVideo($userIDHeader, $videoID);

        $content = array();
        if ($isLike) {
            $content['action'] = 'liked';
        } else {
            $content['action'] = 'unLike';
        }

        $likeStats = $this->Like_video_model->getStatsLike($videoID);
        $content['new_stats_like'] = $likeStats;
        echo $this->responseSuccessJson($content);
    }

    public function insertCommentVideo()
    {
        $userIDHeader = $this->input->post('customer_id');
        $videoID = $this->input->post('video_id');
        $commentText = $this->input->post('comment_text');

        if (!$userIDHeader || $userIDHeader <= 0) {
            echo $this->responseErrorJson('Miss header customer_id');
            return;
        }

        $this->load->model('Comment_video_model');
        $this->load->model('Musers');
        $this->load->model('Mvideos');
        $this->load->model('Mconfigs');


        if (empty($videoID) || empty($commentText)) {
            echo $this->responseErrorJson("VideoId or CommentText is blank");
            return;
        }

        $video = $this->Mvideos->get($videoID);

        if (!$video) {
            echo $this->responseErrorJson("Video not found");
            return;
        }

        $statusId = $this->Mconfigs->getConfigValue('STATUS_COMMENT');
        if (!$statusId)
            $statusId = COMMENT_STATUS_APPROVED;

        $comment = array(
            Comment_video_model::TBL_COMMENT_USER_ID => $userIDHeader,
            Comment_video_model::TBL_COMMENT_VIDEO_ID => $videoID,
            Comment_video_model::TBL_COMMENT_COMMENT_TEXT => $commentText,
            Comment_video_model::TBL_COMMENT_CREATE_AT => (new DateTime())->getTimestamp(),
            Comment_video_model::TBL_COMMENT_STATUS => $statusId
        );

        $id = $this->Comment_video_model->insertComment($comment);

        if ($id <= 0)
            echo $this->responseErrorJson("Have an error insert comment");
        else {
            $comment[Comment_video_model::TBL_COMMENT_ID] = $id;

            echo $this->responseSuccessJson($this->formatCommentVideoResponse($comment));
        }
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

    private function formatCommentVideoResponse($comment)
    {
        $user = $this->Musers->get($comment[Comment_video_model::TBL_COMMENT_USER_ID]);

        return array(
            'id' => $comment[Comment_video_model::TBL_COMMENT_ID],
            'comment_text' => $comment[Comment_video_model::TBL_COMMENT_COMMENT_TEXT],
            'create_at' => (string)$comment[Comment_video_model::TBL_COMMENT_CREATE_AT],
            'video_id' => $comment[Comment_video_model::TBL_COMMENT_VIDEO_ID],
            'user' => $this->formatUserResponse($user)
        );
    }

    private function formatUserResponse($user)
    {
        $avatar = $user['Avatar'];
        if (!empty($avatar)) {
            if (strpos($avatar, 'http') === false)
                $avatar = base_url(USER_PATH . $avatar);
            else
                $avatar .= "?width=" . $this->withAvatarFb . "&height=" . $this->heightAvatarFb;
        }

        return array(
            'address' => $user['Address'],
            'avatar' => $avatar,
            'city' => $user['City'],
            'country' => $user['Country'],
            'email' => $user['Email'],
            'firstname' => $user['FirstName'],
            'id' => intval($user['UserId']),
            'lastname' => $user['LastName'],
            'phone' => $user['PhoneNumber'],
            'zip' => $user['Zip'],
            'vip' => intval($user['IsVip']),
            'username' => $user['UserName'],
            'paystack_auth_code' => $user['paystack_auth_code'],
            'subscribed_date' => $user['subscribed_date']
        );
    }

    private function insertActivityUser($userID, $authorID, $videoID, $action, $description)
    {
        $this->load->model('User_activity_model');
        $activity = $this->User_activity_model->insertActivity($userID, $authorID, $videoID, $action, $description);
        return $activity;
    }

    /**
     * MODULE
     */
    public function getListNews($page = 1, $limit = 0)
    {
        $this->load->model('Mnews');
        $listNews = $this->Mnews->getList($page, $limit);
        $content = array();

        foreach ($listNews as $news) {
            $content[] = $this->formatNewsResponse($news);
        }

        echo $this->responseSuccessJson($content);
    }

    public function getNewsCategories()
    {
        $this->load->model('Mnews_category');
        $listData = $this->Mnews_category->getList();
        $content = array();

        foreach ($listData as $cat) {
            $thumbnail = $cat['thumbnail'];
            if (!empty($thumbnail)) {
                if (strpos($thumbnail, 'http') == false)
                    $thumbnail = base_url(IMAGE_PATH . $thumbnail);
            }

            $icon = $cat['icon'];
            if (!empty($icon)) {
                if (strpos($icon, 'http') == false)
                    $icon = base_url(IMAGE_PATH . $icon);
            }

            $content[] = array(
                'id' => $cat['id'],
                'title' => $cat['title'],
                'thumbnail' => $thumbnail,
                'icon' => $icon,
                'create_at' => $cat['create_at'],
                'update_at' => $cat['update_at']
            );
        }

        echo $this->responseSuccessJson($content);
    }

    public function getNewsPage($newsID)
    {
        $this->load->model('Mnews');
        $news = $this->Mnews->get($newsID);

        $this->load->view('admin/news/pages', $news);
    }

    public function updateViewNewsCounter($newsID = 0)
    {
        if ($newsID <= 0) {
            echo $this->responseErrorJson("Miss newsID");
        } else {
            $this->load->model('Mnews');
            $this->Mnews->updateViewCounter($newsID);
            echo $this->responseSuccessJson("Update view counter successfully!");
        }
    }

    public function getNewsByCategoryID($catID = 0, $page = 1, $limit = 0)
    {
        if ($catID <= 0) {
            echo $this->responseSuccessJson('Miss cat_id');
            return;
        }

        $this->load->model('Mnews');
        $listNews = $this->Mnews->getListByCatID($catID, $page, $limit);
        $content = array();

        foreach ($listNews as $news) {
            $content[] = $this->formatNewsResponse($news);
        }

        echo $this->responseSuccessJson($content);
    }

    public function getNewsByID($id = 0)
    {
        if ($id <= 0) {
            echo $this->responseSuccessJson('Miss cat_id');
            return;
        }

        $this->load->model('Mnews');
        $news = $this->Mnews->get($id);
        if ($news) {
            $content = $this->formatNewsResponse($news);
            echo $this->responseSuccessJson($content);
        } else {
            echo $this->responseErrorJson("News not found");
        }

    }

    private function formatNewsResponse($news)
    {
        $urlDescription = '';

        $thumbnail = $news['thumbnail'];
        if (!empty($thumbnail)) {
            if (strpos($thumbnail, 'http') == false)
                $thumbnail = base_url(IMAGE_PATH . $thumbnail);
        }
        return array(
            'id' => $news['id'],
            'title' => $news['title'],
            'thumbnail' => $thumbnail,
            'short_description' => $news['short_description'],
            'description' => $urlDescription,
            'view' => $news['view'],
            'create_at' => $news['create_at'],
            'update_at' => $news['update_at']
        );
    }
}