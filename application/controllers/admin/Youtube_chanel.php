<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Youtube_chanel extends CI_Controller
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
            $this->load->model('Youtube_chanel_model');
            $this->load->model('Mcategories');
            $data['user'] = $user;
            $data['items'] = $this->Youtube_chanel_model->get();
            $cates = $this->Mcategories->getList();
            $listCategories = array();
            foreach($cates as $c) {
                $listCategories[$c['CategoryId']] = $c['CategoryName'];
            }
            $data['listCategories'] = $listCategories;

            $this->load->view('admin/video/youtube-chanel', $data);
        } else redirect('index.php/admin/user');
    }

    public function delete($id)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($id > 0) {
                $this->load->model('Youtube_chanel_model');
                $this->Youtube_chanel_model->delete($id);
                $this->session->set_flashdata('txtSuccess', "Chanel has been deleted");
            }
            redirect('index.php/admin/youtube_chanel');
        } else {
            redirect('index.php/admin/user');
        }
    }

    public function create()
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Youtube_chanel_model');
            
            
            $data = $this->buildDataView();
            $this->load->view('admin/video/youtube-chanel-detail', $data);
        } else
            redirect('index.php/admin/user');
    }

    public function detail($id = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Youtube_chanel_model');

            $data = array();
            if ($id > 0) {
                $item = $this->Youtube_chanel_model->getByID($id);
                if ($item) {
                    $title = $item[Youtube_chanel_model::TABLE_TITLE];
                    $chanelId = $item[Youtube_chanel_model::TABLE_CHANEL_ID];
                    $listCates = explode(',', $item[Youtube_chanel_model::TABLE_CATEGORY_IDS]);
                    $isAuto =  $item[Youtube_chanel_model::TABLE_AUTO];
                    $username =  $item[Youtube_chanel_model::TABLE_USERNAME];
//                    die($username);
                    $data = $this->buildDataView($id, $title, $chanelId, $listCates, $isAuto, $username);
                } else {
                    $data['txtError'] = "Item not found!";
                }
            } else {
                $data['txtError'] = "An error occurred in the implementation process!";
            }
            $this->load->view('admin/video/youtube-chanel-detail', $data);
        } else {
            redirect('index.php/admin/user');
        }
    }
    
    public function submit($id = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Youtube_chanel_model');
            $this->load->model('Youtube_playlist_subscribe_model');

            $validParam = true;
            
            $chanelId = '';
            $username = '';
            
            $title = trim($this->input->post('Title'));
            if($this->input->post('youtube_type') == 'chanelkey') {
                $chanelId = trim($this->input->post('youtube_chanel'));
            } else {
                $username = $this->input->post('youtube_chanel');
            }
            
            $listCategoryIds = $this->input->post('Categories');
            
            $auto = ($this->input->post('IsAuto') == 'on') ? 1 : 0;
            
            $strCategoryIds = implode(",", $listCategoryIds);

            
            if($chanelId != '' && $username != '') {
                $validParam = false;
                $errParamType = 1;
            } elseif($chanelId == '' && $username == '') {
                $validParam = false;
                $errParamType = 2;
            }
            
            
            $dataView = $this->buildDataView($id, $title, $chanelId, $listCategoryIds, $auto, $username);
            $usernameUpdate = $username;
            if(!$chanelId) {
                $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=status&forUsername={$username}&key=".YOUTUBE_API_KEY);
                $response = json_decode($json,true);
                $chanelId = $response['items'][0]['id'];
                $username = '';
            }
            // implement check $playlistID
            $chanelAvailable = $this->checkChanelAvailable($chanelId);
            
            if(!$chanelId && $username) {
                $chanelAvailable = $this->checkUsernameAvailable($username);
            }

            if ($chanelAvailable && $validParam) {
                $result = 0; // return id
                
                
                # call update database
                $chanelExists = $this->Youtube_chanel_model->isExistsChanel($chanelId);
                
                if ($id > 0 || $chanelExists == true) {
                    if(!$id) {
                        $result = $this->Youtube_chanel_model->updateByChanelKey($chanelId, $title,  $strCategoryIds, $auto, $usernameUpdate);
                    } else {
                        $result = $this->Youtube_chanel_model->update($id, $title, $chanelId, $strCategoryIds, $auto, $usernameUpdate);
                    }
                } else {
                    $result = $this->Youtube_chanel_model->insert($title, $chanelId, $strCategoryIds, $auto, $usernameUpdate);
                }
                
                $playlistUploadKey = $this->getPlaylistUploadType($chanelId, $username);
                
                $playlistExists = $this->Youtube_playlist_subscribe_model->isPlaylistYoutubeExist($chanelId, $playlistUploadKey);
                
                if($playlistExists) {
                    $this->Youtube_playlist_subscribe_model->updateByPlaylistKeyAndChanelKey($title, $playlistUploadKey, $strCategoryIds, $auto, $chanelId);
                    if($auto == 1) {
//                        $this->updateListVideos($playlistUploadKey, $listCategoryIds);
                    }
                } else {
                    $this->Youtube_playlist_subscribe_model->insert($title, $playlistUploadKey, $strCategoryIds, $auto, $chanelId);
                    if($auto == 1) {
//                        $this->createNewListVideos($playlistUploadKey, $listCategoryIds);
                    }   
                }

                if ($result) {
                    $dataView['id'] = $result;
                    $dataView['txtSuccess'] = 'Update successfully!';
                } else {
                    $dataView['txtError'] = 'An error occurred in the implementation process!';
                }
                
            } elseif(!$chanelAvailable && $validParam) {
                $dataView['txtError'] = 'Chanel or username not exist!';
            } elseif(!$validParam) {
                if($errParamType == 1) {
                    $dataView['txtError'] = 'Chose specify one chanel id or username!';
                }
                if($errParamType == 2) {
                    $dataView['txtError'] = 'Fill in chanel id or username!';
                }
            }

            $this->load->view('admin/video/youtube-chanel-detail', $dataView);
        } else {
            redirect('index.php/admin/user');
        }
    }
    
    public function importNow($chanleId)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Youtube_chanel_model');
            $this->load->model('Youtube_playlist_subscribe_model');
            
            $data = array();
            $data['user'] = $user;
            $data['items'] = $this->Youtube_chanel_model->get();
                
            if ($chanleId > 0) {
                
                $chanel = $this->Youtube_chanel_model->getByID($chanleId);

                $playlistUpdload = $this->Youtube_playlist_subscribe_model->getByChanelKey($chanel[Youtube_chanel_model::TABLE_CHANEL_ID]);
                $listCategoryIds = explode(',', $playlistUpdload[Youtube_playlist_subscribe_model::TABLE_CATEGORY_IDS]);
                $this->updateListVideos($playlistUpdload[Youtube_playlist_subscribe_model::TABLE_PLAYLIST_ID], $listCategoryIds);
                $code = 1;
            } else {
                $code = -1;
            }
            redirect('index.php/admin/Youtube_chanel/reloadPageWithCode/'.$code);
        } else {
            redirect('index.php/admin/user');
        }
    }
    
    public function reloadPageWithCode($code){
            $data = array();
            $user = $this->session->userdata('user');
            $this->load->model('Youtube_chanel_model');
            $data['user'] = $user;
            $data['items'] = $this->Youtube_chanel_model->get();

            if($code > 0){
                $data['txtSuccess'] = "Chanel has been imported";
            }else{
                $data['txtError'] = "Chanel has been imported";
            }

            $this->load->view('admin/video/youtube-chanel', $data);
    }
    
    public function updatePlaylistOfChanel($chanelId, $username, $strCategoryIds) 
    {
        if(!$chanelId && !$username){
            return false;
        }
        if($chanelId) {
            $this->updatePlaylistOfChanelById($chanelId, $strCategoryIds);
        } elseif($username) {
            $this->updatePlaylistOfChanelByUsername($username);
        }
    }
    
    public function updatePlaylistOfChanelById($chanelID, $strCategoryIds)
    {
        $this->load->model('Youtube_playlist_subscribe_model');
        $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channelSections?part=snippet,contentDetails&channelId={$chanelID}&key=".YOUTUBE_API_KEY);
        $response = json_decode($json,true);
        $arrayPlaylistId = array();
        foreach($response['items'] as $item) {
            if($item['snippet']['type'] == 'singlePlaylist') {
                $arrayPlaylistId[] = $item['contentDetails']['playlists'][0];
            }
        }
        $listCate = explode(',', $strCategoryIds);
        foreach ($arrayPlaylistId as $plId) {
            $isExist = $this->Youtube_playlist_subscribe_model->isPlaylistYoutubeExist($chanelID, $plId);
            if($isExist == true) {
                $this->updateListVideos($plId, $listCate);
                continue;
            }
            $this->Youtube_playlist_subscribe_model->insert('',$plId,$strCategoryIds,true,$chanelID);
            $this->createNewListVideos($plId, $listCate);
        }
    }
    
    public function getPlaylistUploadType($chanelId, $username)
    {
        if($chanelId) {
            $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id={$chanelId}&key=".YOUTUBE_API_KEY);
            $response = json_decode($json,true);
            if($response['items'][0]['contentDetails']['relatedPlaylists']['uploads']) {
                $playlistUpload = $response['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
                return $playlistUpload;
            }
        } elseif (!$chanelId && $username) {
            $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername={$username}&key=".YOUTUBE_API_KEY);
            $response = json_decode($json,true);
            if($response['items'][0]['contentDetails']['relatedPlaylists']['uploads']) {
                $playlistUpload = $response['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
                return $playlistUpload;
            }
        }
    }
    
    public function updatePlaylistOfChanelByUsername($username, $strCategoryIds)
    {
        $json1 = @file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=status&forUsername={$username}&key=".YOUTUBE_API_KEY);
        $response1 = json_decode($json1,true);
        $chanelID = $response1['items'][0]['id'];
        $this->load->model('Youtube_playlist_subscribe_model');
        $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channelSections?part=snippet,contentDetails&channelId={$chanelID}&key=".YOUTUBE_API_KEY);
        $response = json_decode($json,true);
        $arrayPlaylistId = array();
        foreach($response['items'] as $item) {
            if($item['snippet']['type'] == 'singlePlaylist') {
                $arrayPlaylistId[] = $item['contentDetails']['playlists'][0];
            }
        }
        $listCate = explode(',', $strCategoryIds);
        foreach ($arrayPlaylistId as $plId) {
            $isExist = $this->Youtube_playlist_subscribe_model->isPlaylistYoutubeExist($chanelID, $plId);
            if($isExist == true) {
                $this->updateListVideos($plId, $listCate);
                continue;
            }
            $this->Youtube_playlist_subscribe_model->insert('',$plId, '', true, $chanelID);
            $this->createNewListVideos($plId, $listCate);
        }
    }
    
    public function checkUsernameAvailable($username)
    {
        $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=status&forUsername={$username}&key=".YOUTUBE_API_KEY);
        $response = json_decode($json,true);
        if(isset($response['items'][0]['kind']) && $response['items'][0]['kind'] == 'youtube#channel') {
            return true;
        }
        return false;
    }
    
    public function checkChanelAvailable($chanelID)
    {
        $json = @file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=status&id={$chanelID}&key=".YOUTUBE_API_KEY);
        $response = json_decode($json,true);
        if(isset($response['items'][0]['kind']) && $response['items'][0]['kind'] == 'youtube#channel') {
            return true;
        }
        return false;
    }
    
    public function checkPlayListIdAvaible($playlistID)
    {
        $json = @file_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=status&id={$playlistID}&key=".YOUTUBE_API_KEY);
        $response = json_decode($json,true);
        if(!$response['pageInfo']['totalResults']) {
            return false;
        }
        if(isset($response['items'][0]['kind']) && $response['items'][0]['kind'] == 'youtube#playlist') {
            return true;
        }
        return false;
    }
    
    public function createNewListVideos($playlistID, $listCategoryIds)
    {
        $this->load->model('Mvideos');
        $user = $this->session->userdata('user');
        $itemsRaw = array();
        $this->getPlaylistByID($playlistID, '', '', $itemsRaw);
        $items = array();
        array_walk($itemsRaw, function($v1) use (&$items){
            array_walk($v1, function($v2) use(&$items){
                $items[] = $v2;
            });
        });
        foreach ($items as $video) {
            $videoKey = $video['snippet']['resourceId']['videoId'];
            $isVideoExists = $this->Mvideos->isVideoKeyExists($videoKey,2);
            if($isVideoExists) {
                continue;
            }
            $contentDetailsRaw = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video['snippet']['resourceId']['videoId']}&key=".YOUTUBE_API_KEY."&part=contentDetails");
            $contentDetails = json_decode($contentDetailsRaw,true);
            try {
                $interval = new DateInterval($contentDetails['items'][0]['contentDetails']['duration']);
                $time = $interval->h * 3600 + $interval->i * 60 + $interval->s;
            } catch (Exception $ex) {
                $time = 0;
            }
            $dataVideo['VideoLength'] = $time;
            $dataVideo['VideoTitle'] = $video['snippet']['title'];
            $dataVideo['VideoDesc'] = $video['snippet']['description'];
            $dataVideo['VideoKey'] = $video['snippet']['resourceId']['videoId'];
            $dataVideo['VideoUrl'] = "https://www.youtube.com/watch?v={$video['snippet']['resourceId']['videoId']}";
            $dataVideo['VideoTypeId'] = 2;
            $dataVideo['StatusId'] = 2;
            $dataVideo['IsVip'] = 0;
            $dataVideo['IsTrending'] = 0;
            $dataVideo['DisplayHome'] = 1;
            $dataVideo['IsTrending'] = 0;
            $dataVideo['ViewCount'] = 0;
            $dataVideo['ShareCount'] = 0;
            $dataVideo['LikeCount'] = 0;
            $dataVideo['DownloadCount'] = 0;
            $dataVideo['UpdateDate'] = date('Y-m-d H:i:s');
            $dataVideo['CrDateTime'] = $dataVideo['UpdateDate'];
            $dataVideo['CrUserId'] = $user['UserId'];
            $dataVideo['VideoImage'] = '';
            if(isset($video['snippet']['thumbnails']['maxres']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['maxres']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['standard']['url'])) { 
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['standard']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['high']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['high']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['medium']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['medium']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['default']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['default']['url'];
            }
            if(!is_array($listCategoryIds)) {
                $listCategoryIds = array();
            }
            $this->Mvideos->insertOrUpdate($dataVideo, 0, $listCategoryIds);
        }
        
    }
    
    public function updateListVideos($playlistID, $listCategoryIds)
    {
        $this->load->model('Mvideos');
        if(!$this->session->userdata('user')) {
            $userID = 1;
        } else {
            $user = $this->session->userdata('user');
            $userID = $user['UserId'];
        }
        $itemsRaw = array();
        $this->getPlaylistByID($playlistID, '', '', $itemsRaw);
        $items = array();
        array_walk($itemsRaw, function($v1) use (&$items){
            array_walk($v1, function($v2) use(&$items){
                $items[] = $v2;
            });
        });
        
        foreach ($items as $video) {
            $videoKey = $video['snippet']['resourceId']['videoId'];
            $isVideoExists = $this->Mvideos->isVideoKeyExists($videoKey,2);
            if($isVideoExists) {
                continue;
            }
            $contentDetailsRaw = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video['snippet']['resourceId']['videoId']}&key=".YOUTUBE_API_KEY."&part=contentDetails");
            $contentDetails = json_decode($contentDetailsRaw,true);
            try {
                $interval = new DateInterval($contentDetails['items'][0]['contentDetails']['duration']);
                $time = $interval->h * 3600 + $interval->i * 60 + $interval->s;
            } catch (Exception $ex) {
                $time = 0;
            }
//            $interval = new DateInterval($contentDetails['items'][0]['contentDetails']['duration']);
            $dataVideo['VideoLength'] = $time;
            $dataVideo['VideoTitle'] = $video['snippet']['title'];
            $dataVideo['VideoDesc'] = $video['snippet']['description'];
            $dataVideo['VideoKey'] = $video['snippet']['resourceId']['videoId'];
            $dataVideo['VideoUrl'] = "https://www.youtube.com/watch?v={$video['snippet']['resourceId']['videoId']}";
            $dataVideo['VideoTypeId'] = 2;
            $dataVideo['StatusId'] = 2;
            $dataVideo['IsVip'] = 0;
            $dataVideo['IsTrending'] = 0;
            $dataVideo['DisplayHome'] = 1;
            $dataVideo['IsTrending'] = 0;
            $dataVideo['ViewCount'] = 0;
            $dataVideo['ShareCount'] = 0;
            $dataVideo['LikeCount'] = 0;
            $dataVideo['DownloadCount'] = 0;
            $dataVideo['UpdateDate'] = date('Y-m-d H:i:s');
            $dataVideo['CrDateTime'] = $dataVideo['UpdateDate'];
            $dataVideo['CrUserId'] = $userID;
            $dataVideo['VideoImage'] = '';
            if(isset($video['snippet']['maxres']['thumbnails']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['maxres']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['standard']['url'])) { 
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['standard']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['high']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['high']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['medium']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['medium']['url'];
            }
            elseif(isset($video['snippet']['thumbnails']['default']['url'])) {
                $dataVideo['VideoImage'] = $video['snippet']['thumbnails']['default']['url'];
            }
            if(!is_array($listCategoryIds)) {
                $listCategoryIds = array();
            }
            $this->Mvideos->insertOrUpdate($dataVideo, 0, $listCategoryIds);
        }
        unset($itemsRaw);
        unset($items);
    }
    
    /**
     * 
     *  Recursive function get an array has page element, which included number per_page video items.
     *  Ex: 2 page included 3 videos items per page:
     *      array(
     *          0 => array(
     *                  0 => [video items]
     *                  1 => [video items]
     *                  2 => [video items]
     *              ),
     *          1 => array(
     *                  0 => [video items]
     *                  1 => [video items]
     *                  2 => [video items]
     *              )
     *      ) 
     * 
     * @param string $playlistID
     * @param string $pageToken
     * @param string $prevPageToken
     * @param array $item reference
     * @return array
     */
    public function getPlaylistByID($playlistID, $pageToken = '', $prevPageToken = '', &$item)
    {
        if(($pageToken != $prevPageToken) || ($pageToken == '' && $prevPageToken == '')) {
            $json = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId={$playlistID}&key=".YOUTUBE_API_KEY."&maxResults=10&pageToken={$pageToken}");
            $response = json_decode($json,true);
            if($response['items'] && !empty($response['items'])) {
                $item[] = $response['items'];
                if(isset($response['nextPageToken'])) {
                    $this->getPlaylistByID($playlistID, $response['nextPageToken'], $pageToken, $item)[0];
                }
            }
        }
        return $item;
    }
    
    public function getPlaylistAutoUpdate()
    {
        $this->load->model('Youtube_playlist_subscribe_model');
        
        $playlistsRaw = $this->Youtube_playlist_subscribe_model->getPlaylistAutoUpdate();
        $playlists = array();
        if(!empty($playlistsRaw) && is_array($playlistsRaw)) {
            array_walk($playlistsRaw, function($pl) use(&$playlists) {
                $playlists[] = $pl['playlist_id'];
            });
        }
        return $playlists;
    }
    
    public function updatePlaylistCron()
    {
        $this->load->model('Youtube_playlist_subscribe_model');
        $playlistArray = $this->getPlaylistAutoUpdate();
        
        foreach($playlistArray as $plId) {
            
            $catesRaw = $this->Youtube_playlist_subscribe_model->getPlaylistCate($plId);
            $cates = array();
            if($catesRaw['category_ids']) {
                $cates = explode(',', $catesRaw['category_ids']);
            }
            $this->updateListVideos($plId, $cates);
        }
            
        $filename = APPPATH.'test.txt';
        $handle = fopen($filename, 'a');
        fwrite($handle, '++++Update at '.  json_encode($playlistArray).' '.date('Y_M_D - h:i:s',time()).'------\n');
        fclose($handle);return ;
    }
    
    public function runCronjob()
    {
        $this->load->library('crontab');
        $rootPath = dirname(BASEPATH);
        
        $fh = fopen(APPPATH.'crontab', 'a');
        fwrite($fh, '');
        fclose($fh);
        $this->crontab->add_job_custom('*/'.TIME_YOUTUBE_CRON.' * * * *', 'cd '.$rootPath.';  php  index.php  Youtube_subscribe_controller updatePlaylistCron');
    }
    
    public function buildDataView($id = 0, $title = '', $chanel_id = '', $categoryIdsChecked = array(),$auto = true, $username = '')
    {
        $this->load->model('Mcategories');
        $data = array();
        $data['id'] = $id;
        $data['listCategories'] = $this->Mcategories->getList(STATUS_ACTIVED);
        $data['title'] = $title;
        $data['chanelId'] = $chanel_id;
        if($username != '') {
            $data['username'] = $username;
        }
        $data['selectedCategories'] = $categoryIdsChecked;
        $data['isAuto'] = $auto;

        $user = $this->session->userdata('user');
        $data['user'] = $user;
        return $data;
    }

}


