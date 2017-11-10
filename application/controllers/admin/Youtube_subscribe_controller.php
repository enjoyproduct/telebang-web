<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Youtube_subscribe_controller extends CI_Controller
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
            $this->load->model('Youtube_playlist_subscribe_model');
            $data['user'] = $user;
            $data['items'] = $this->Youtube_playlist_subscribe_model->get();

            $this->load->view('video/youtube-playlist', $data);
        } else redirect('index.php/user');
    }

    public function delete($id)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($id > 0) {
                $this->load->model('Youtube_playlist_subscribe_model');
                $this->Youtube_playlist_subscribe_model->delete($id);
                $this->session->set_flashdata('txtSuccess', "Playlist Subscribed has been deleted");
            }
            redirect('index.php/youtube_subscribe_controller');
        } else redirect('index.php/user');
    }

    public function create()
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $models = array('Youtube_playlist_subscribe_model', 'Mcategories');
            foreach ($models as $model)
                $this->load->model($model);

            $data = $this->buildDataView();
            $this->load->view('video/youtube-playlist-detail', $data);
        } else
            redirect('index.php/user');
    }

    public function detail($id = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $models = array('Youtube_playlist_subscribe_model', 'Mcategories');
            foreach ($models as $model)
                $this->load->model($model);

            $data = array();
            if ($id > 0) {
                $item = $this->Youtube_playlist_subscribe_model->getByID($id);
                if ($item) {
                    $title = $item[Youtube_playlist_subscribe_model::TABLE_TITLE];
                    $playlistID = $item[Youtube_playlist_subscribe_model::TABLE_PLAYLIST_ID];
                    $strCategoryIdsSelected = $item[Youtube_playlist_subscribe_model::TABLE_CATEGORY_IDS];
                    $selectedCategories = $this->parseCategoryIds($strCategoryIdsSelected);
                    $auto = $item[Youtube_playlist_subscribe_model::TABLE_AUTO];

                    $data = $this->buildDataView($id, $title, $playlistID, $selectedCategories, $auto);
                } else {
                    $data['txtError'] = "Item not found!";
                }
            } else
                $data['txtError'] = "An error occurred in the implementation process!";

            $this->load->view('video/youtube-playlist-detail', $data);
        } else
            redirect('index.php/user');
    }

    public function submit($id = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $models = array('Youtube_playlist_subscribe_model', 'Mcategories');
            foreach ($models as $model)
                $this->load->model($model);

            $title = trim($this->input->post('Title'));
            $playlistID = trim($this->input->post('PlaylistID'));

            $listCategoryIds = $this->input->post('Categories');
            if (!is_array($listCategoryIds))
                $listCategoryIds = array();

            $auto = ($this->input->post('IsAuto') == 'on') ? 1 : 0;

            $strCategoryIds = implode(",", $listCategoryIds);

            $dataView = $this->buildDataView($id, $title, $playlistID, $listCategoryIds, $auto);
            
            // implement check $playlistID
            $playlistAvailable = $this->checkPlayListIdAvaible($playlistID);
            
            // /$playlistAvailable < 0 error, $playlistAvailable > 0 success

            if ($playlistAvailable) {
                $result = 0; // return id
                // call update database
                $playlistExists = $this->Youtube_playlist_subscribe_model->isExistsPlaylist($playlistID);
//                echo '<pre>';
//                print_r($playlistExists);
                if ($id > 0 && $playlistExists == true) {
                    if($auto) {
                        $this->updateListVideos($playlistID, $listCategoryIds);
                    }
                    $result = $this->Youtube_playlist_subscribe_model->update($id, $title, $playlistID, $strCategoryIds, $auto);
                }
                else {
                    if($auto) {
                        $this->createNewListVideos($playlistID, $listCategoryIds);
                    }
                    
                    $result = $this->Youtube_playlist_subscribe_model->insert($title, $playlistID, $strCategoryIds, $auto);
                }

                if ($result) {
                    $dataView['id'] = $result;
                    $dataView['txtSuccess'] = 'Update successfully!';
                } else
                    $dataView['txtError'] = 'An error occurred in the implementation process!';
            } else {
                $dataView['txtError'] = 'Playlist not exist!';
            }

            $this->load->view('video/youtube-playlist-detail', $dataView);
        } else
            redirect('index.php/user');
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
    
    public function buildDataView($id = 0, $title = '', $playlist_id = '', $categoryIdsChecked = array(), $auto = true)
    {
        $data = array();
        $data['id'] = $id;
        $data['listCategories'] = $this->Mcategories->getList(STATUS_ACTIVED);
        $data['title'] = $title;
        $data['playlistID'] = $playlist_id;
        $data['selectedCategories'] = $categoryIdsChecked;
        $data['isAuto'] = $auto;

        $user = $this->session->userdata('user');
        $data['user'] = $user;
        return $data;
    }

    /*
    * $strCategoryIds : 1,2,3,4...
    */
    private function parseCategoryIds($strCategoryIds)
    {
        $categoryIds = array();
        if ($strCategoryIds && trim($strCategoryIds)) {
            $categoryIds = explode(",", $strCategoryIds);
        }

        return $categoryIds;
    }

}


