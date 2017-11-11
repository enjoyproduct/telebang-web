<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function index(){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            $models = array('Musers', 'Mmodels', 'Mcategories', 'Mcategoryvideos', 'Mvideos');
            foreach($models as $model) $this->load->model($model);
            $data['listVideoTypes'] = $this->Mmodels->getList('videotypes');
            $data['listStatus'] = $this->Mmodels->getList('status');
            $cates = $this->Mcategories->getList();
            $listCategories = array();
            foreach($cates as $c) $listCategories[$c['CategoryId']] = $c['CategoryName'];
            $data['listCategories'] = $listCategories;
            $data['listVideos'] =  $this->Mvideos->getAllVideo();
            if($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if($this->session->flashdata('txtError')) $data['txtError'] = $this->session->flashdata('txtError');
            $this->load->view('admin/video/videolist', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function quickUpload()
    {
        $user = $this->session->userdata('user');
        if($user){
            $this->load->model('Mcategories');
            $this->load->model('Mmodels');
            $url = $this->input->post('uploadUrl');
            $dataVideo['videoTypeId'] = 1;
            $dataVideo['videoLength'] = 0;
            $dataVideo['videoTitle'] = '';
            $dataVideo['videoDesc'] = '';
            $data['videoImage'] = base_url(NO_IMAGE_PATH);
            $dataVideo['user'] = $user;
            $dataVideo['videoId'] = 0;
            $dataVideo['videoUrl'] = $url;
            $dataVideo['socialUrl'] = '';
            $dataVideo['series'] = '';
            $dataVideo['viewCount'] = '';
            $dataVideo['shareCount'] = '';
            $dataVideo['likeCount'] = '';
            $dataVideo['downloadCount'] = '';
            $dataVideo['isVip'] = '';
            $dataVideo['isTrending'] = '';
            $dataVideo['listStatus'] = $this->Mmodels->getList('status');
            $dataVideo['categoryIds'] = array();
            $dataVideo['statusId'] = STATUS_ACTIVED;
            $dataVideo['listCategories'] =  $this->getVideoCategories();
            if($dataVideo != false && is_array($dataVideo)) {
                $this->load->view('admin/video/videoupdate', $dataVideo);
            }
        } else {
            redirect('index.php/admin/user');
        }
    }

    public function quickAddUrl()
    {
        $user = $this->session->userdata('user');
        if($user){
            $this->load->model('Mcategories');
            $this->load->model('Mmodels');
            $videoUrl = $this->input->post('videoUrl');
            $dataVideo = $this->fetchVideoByUrl($videoUrl);
            $dataVideo['videoTypeId'] = 1;
            $dataVideo['videoLength'] = 0;
            $dataVideo['videoTitle'] = '';
            $dataVideo['videoDesc'] = '';
            $data['videoImage'] = base_url(NO_IMAGE_PATH);
            $dataVideo['user'] = $user;
            $dataVideo['videoId'] = 0;
            $dataVideo['videoUrl'] = $videoUrl;
            $dataVideo['socialUrl'] = '';
            $dataVideo['series'] = '';
            $dataVideo['viewCount'] = '';
            $dataVideo['shareCount'] = '';
            $dataVideo['likeCount'] = '';
            $dataVideo['downloadCount'] = '';
            $dataVideo['isVip'] = '';
            $dataVideo['isTrending'] = '';
            $dataVideo['listStatus'] = $this->Mmodels->getList('status');
            $dataVideo['categoryIds'] = array();
            $dataVideo['statusId'] = STATUS_ACTIVED;
            $dataVideo['listCategories'] =  $this->getVideoCategories();
            if($dataVideo != false && is_array($dataVideo)) {
                $this->load->view('admin/video/videoupdate', $dataVideo);
            }
        } else {
            redirect('index.php/admin/user');
        }
    }

    public function fetchVideoByUrl($videoUrl)
    {
        $dataVideo = array();
        if(!empty($videoUrl)){
            $videoTypeId = 0;
            if(strpos($videoUrl, 'youtube.com/')!==false) {
                $videoTypeId = 2;
            }
            elseif(strpos($videoUrl, 'vimeo.com')!==false) {
                $videoTypeId = 3;
            }
            elseif(strpos($videoUrl, '.mp3')!==false) {
                $videoTypeId = 4;
            }
            elseif (strpos($videoUrl, 'facebook.com')!==false) {
                $videoTypeId = 5;
            }
            elseif(strpos($videoUrl,'daylymotion.com') !== false) {
                $videoTypeId =6;
            }
            if($videoTypeId>0){
                switch($videoTypeId){

                    #youtube
                    case 2:
                        $start = strpos($videoUrl, '?v=');
                        if($start > 0) {
                            $videoIdRaw = substr($videoUrl, $start);
                            $videoId = str_replace('?v=', '', $videoIdRaw);
                            $result = @file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$videoId}&key=".YOUTUBE_API_KEY."&part=snippet,contentDetails");
                            if($result){
                                $resultRawArray = json_decode($result, true);
                                $items = $resultRawArray['items'];
                                if(count($items)==1){
                                    $video = $items[0];
                                    try {
                                        $interval = new DateInterval($video['contentDetails']['duration']);
                                        $retVal = array(
                                            'videoTypeId'=>2,
                                            'videoLength'=>$interval->h * 3600 + $interval->i * 60 + $interval->s
                                        );
                                    } catch (Exception $ex) {
                                        $retVal = array(
                                            'videoTypeId'=>2,
                                            'videoLength'=>0
                                        );
                                    }
                                    $snippet = $video['snippet'];
                                    $retVal['videoTitle'] = $snippet['title'];
                                    $retVal['videoDesc'] = $snippet['description'];
                                    $retVal['videoImage'] = "";
                                    $thumbnails = $video['snippet']['thumbnails'];
                                    if(isset($thumbnails['maxres'])) {
                                        $retVal['videoImage'] = $thumbnails['maxres']['url'];
                                    } elseif(isset($thumbnails['standard'])) {
                                        $retVal['videoImage'] = $thumbnails['standard']['url'];
                                    } elseif(isset($thumbnails['high'])) {
                                        $retVal['videoImage'] = $thumbnails['high']['url'];
                                    } elseif(isset($thumbnails['medium'])) {
                                        $retVal['videoImage'] = $thumbnails['medium']['url'];
                                    } elseif(isset($thumbnails['default'])) {
                                        $retVal['videoImage'] = $thumbnails['default']['url'];
                                    }
                                    return $retVal;
                                }
                                else {
                                    return false;
                                }
                            }
                            else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                        break;

                    #vimeo
                    case 3:
                        $videoId = parse_vimeo($videoUrl);
                        if(!empty($videoId)){
                            $result = @file_get_contents("http://vimeo.com/api/v2/video/{$videoId}.json");
                            if($result){
                                $resultArray = json_decode($result, true);
                                if(count($resultArray)==1){
                                    $video = $resultArray[0];
                                    return array(
                                        'videoTypeId' => 3,
                                        'videoLength' => $video['duration'],
                                        'videoTitle' => $video['title'],
                                        'videoDesc' => strip_tags($video['description']),
                                        'videoImage' => $video['thumbnail_large']
                                    );
                                } else {
                                    return false;
                                }
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                        break;

                    #facebook
                    case 5 :

                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete($videoId = 0){
        $user = $this->session->userdata('user');
        if($user){
            if($videoId>0){
                $this->load->model('Mvideos');
                $flag = $this->Mvideos->delete($videoId);
                if($flag) $this->session->set_flashdata('txtSuccess', "Video has been deleted");
                else $this->session->set_flashdata('txtError', "Delete video failed");
            }
            redirect('index.php/admin/video');
        }
        else redirect('index.php/admin/user');
    }

    public function update($videoId = 0){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            $data['videoId'] = $videoId;
            $models = array('Mvideos', 'Mmodels', 'Mcategories', 'Mcategoryvideos');
            foreach($models as $model) $this->load->model($model);
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listCategories'] = $this->getVideoCategories();
            $data['videoTitle'] = $data['videoUrl'] = $data['series'] = $data['videoDesc'] = $data['socialUrl'] = "";
            $data['videoTypeId'] = 1;
            $data['videoLength'] = $data['isVip']= $data['isTrending'] = $data['displayHome'] = $data['viewCount'] = $data['shareCount'] = $data['likeCount'] = $data['downloadCount'] = 0;
            $data['statusId'] = STATUS_ACTIVED;
            $data['videoImage'] = base_url(NO_IMAGE_PATH);
            $data['categoryIds'] = array();
            $data['episodeNo'] = 1;

            $flag = 0;
            if($videoId>0){
                $video = $this->Mvideos->get($videoId);
                if($video){
                    $flag = 1;
                    $data['videoTitle'] = $video['VideoTitle'];
                    $data['videoUrl'] = $video['VideoUrl'];
                    $data['videoLength'] = $video['VideoLength'];
                    $data['series'] = $video['Series'];
                    $data['videoDesc'] = $video['VideoDesc'];
                    $data['socialUrl'] = $video['SocialUrl'];
                    $data['statusId'] = $video['StatusId'];
                    $data['videoTypeId'] = $video['VideoTypeId'];
                    $data['isVip'] = $video['IsVip'];
                    $data['isTrending'] = $video['IsTrending'];
                    //$data['displayHome'] = $video['DisplayHome'];
                    $data['viewCount'] = $video['ViewCount'];
                    $data['shareCount'] = $video['ShareCount'];
                    $data['likeCount'] = $video['LikeCount'];
                    $data['downloadCount'] = $video['DownloadCount'];
                    $data['episodeNo'] = $video['episode_no'];

                    $videoImage = $video['VideoImage'];
                    if($videoImage && strpos($videoImage, 'http') === false)
                        $data['videoImage'] = base_url(IMAGE_PATH.$videoImage);
                    else
                        $data['videoImage'] = $videoImage;

                    $data['categoryIds'] = $this->Mcategoryvideos->getCategoryIdList($videoId);
                }
                else{
                    $data['txtError'] = "Video is not exist.";
                    $flag = 2;
                }
            }
            else
                $flag = 3;

            if($this->input->post('submit') && $flag!=2){
                $isVip = ($this->input->post('IsVip')=='on') ? 1 : 0;
                $isTrending = ($this->input->post('IsTrending')=='on') ? 1 : 0;

                //$displayHome = ($this->input->post('DisplayHome')=='on') ? 1 : 0;
                $videoImage = trim($this->input->post('VideoImageFetch'));

                $data['videoImage'] = $videoImage;
                $data['isVip'] = $isVip;
                $data['isTrending'] = $isTrending;
                //$data['displayHome'] = $displayHome;
                $videoTypeId = 1;

                $videoUrl = trim($this->input->post('VideoUrl'));
                if(strpos($videoUrl, 'youtube.com')!==false)
                    $videoTypeId = 2;
                elseif(strpos($videoUrl, 'vimeo.com')!==false){
                    $videoTypeId = 3;
                    $videoUrl = 'https://player.vimeo.com/video/'.parse_vimeo($videoUrl);
                } elseif(strpos($videoUrl, '.mp3')!==false)
                    $videoTypeId = 4;

                if(strpos($videoUrl, 'facebook.com')!==false)
                    $videoTypeId = 5;

                if(strpos($videoUrl,'dailymotion.com') !== false)
                    $videoTypeId = 6;

                if($videoTypeId == 1 || $videoTypeId == 4) {
                    $videoUrl = str_replace(array(VIDEO_PATH, ROOT_PATH), '', $videoUrl);
                }
                
                $crDateTime = date('Y-m-d H:i:s');
                if(strpos($videoImage, IMAGE_PATH) === false ){

                }else{
                    $videoImage = basename($videoImage);
                }

                $valueData = array(
                    'VideoTitle' => trim($this->input->post('VideoTitle')),
                    'VideoUrl' => $videoUrl,
                    'VideoLength' => trim($this->input->post('VideoLength')),
                    'Series' => trim($this->input->post('Series')),
                    'VideoImage' => $videoImage,
                    'VideoDesc' => trim($this->input->post('VideoDesc')),
                    'SocialUrl' => '',
                    'StatusId' => $this->input->post('StatusId'),
                    'VideoTypeId' => $videoTypeId,
                    'IsVip' => $isVip,
                    'IsTrending' => $isTrending,
                    'DisplayHome' => 1,//$displayHome,
                    'ViewCount' => $this->input->post('ViewCount'),
                    'ShareCount' => $this->input->post('ShareCount'),
                    'LikeCount' => $this->input->post('LikeCount'),
                    'DownloadCount' => $this->input->post('DownloadCount'),
                    'UpdateDate' => $crDateTime,
                    'episode_no' => $this->input->post('EpisodeNo'),
                );

                if($flag === 3){
                    $valueData['CrUserId'] = $user['UserId'];
                    $valueData['CrDateTime'] = $crDateTime;
                }

                if($flag){
                    $listCategoryIds = $this->input->post('Categories');
                    if(!is_array($listCategoryIds)) $listCategoryIds = array();
                    $videoId = $this->Mvideos->insertOrUpdate($valueData, $videoId, $listCategoryIds);
                    if($videoId>0){
                        $data['videoId'] = $videoId;
                        $data['categoryIds'] = $listCategoryIds;
                        $data['txtSuccess'] = "Video Saved";
                    }
                    else $data['txtError'] = "Please complete all the required field!";
                }
                $data['txtError'] = "Sorry, your file is invalid.";
            }
            $this->load->view('admin/video/videoupdate', $data);
        }
        else redirect('index.php/admin/user');
    }

    private function createCategoryTree(&$list, $parent, $level = "", &$tree){
        foreach ($parent as $k=>$l){
            $l['level'] = $level;
            $tree[] = $l;
            if(isset($list[$l['CategoryId']])){
                $lv = $level." - ";
                $this->createCategoryTree($list, $list[$l['CategoryId']], $lv, $tree);
            }
        }
        return $tree;
    }

    public function createVideoForSeriesId($seriesId)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $data['user'] = $user;
            $data['videoId'] = 0;
            $models = array('Mvideos', 'Mmodels', 'Mcategories', 'Mcategoryvideos', 'Mseries');
            foreach ($models as $model) $this->load->model($model);
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listCategories'] =  $this->getVideoCategories();
            $data['videoTitle'] = $data['videoUrl'] = $data['series'] = $data['videoDesc'] = $data['socialUrl'] = "";
            $data['videoTypeId'] = 1;
            $data['videoLength'] = $data['isVip'] = $data['isTrending'] = $data['displayHome'] = $data['viewCount'] = $data['shareCount'] = $data['likeCount'] = $data['downloadCount'] = 0;
            $data['statusId'] = STATUS_ACTIVED;
            $data['videoImage'] = base_url(NO_IMAGE_PATH);
            $data['categoryIds'] = array();
            $data['series'] = $seriesId;
            $data['episodeNo'] = 1;

            $this->load->view('admin/video/videoupdate', $data);

        } else {
            redirect('index.php/admin/user');
        }
    }

    public function listVideoBySeriesId($seriesId)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $data = array();
            $data['user'] = $user;
            $models = array('Mmodels', 'Mcategories', 'Mcategoryvideos', 'Mvideos', 'Mseries');
            foreach ($models as $model) {
                $this->load->model($model);
            }
            $data['listVideoTypes'] = $this->Mmodels->getList('videotypes');
            $data['listStatus'] = $this->Mmodels->getList('status');
            $cates = $this->Mcategories->getList();
            $listCategories = array();
            foreach ($cates as $c) {
                $listCategories[$c['CategoryId']] = $c['CategoryName'];
            }
            $data['listCategories'] = $listCategories;
            $data['listVideos'] = $this->Mvideos->getVideoBySeriesId($seriesId);

            if ($this->session->flashdata('txtSuccess')) {
                $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            }
            if ($this->session->flashdata('txtError')) {
                $data['txtError'] = $this->session->flashdata('txtError');
            }
            $data['series'] = $this->Mseries->get($seriesId);
            $this->load->view('admin/video/seriesvideolist', $data);

        } else {
            redirect('index.php/admin/user');
        }
    }


    public function getVideoCategories()
    {
        $this->load->model('Mcategories');
        $listCategories = $this->Mcategories->getList();

        $cats = array();
        $parents = array();
        foreach ($listCategories as $a){
            $cats[$a['ParentCategoryId']][] = $a;

            if(!$a['ParentCategoryId'])
                $parents[] = $a;
        }

        $tree = array();
        $newList = $this->createCategoryTree($cats, $parents, "", $tree);

        return $newList;
    }
    function fetchVideoInfo(){
        $videoUrl = $this->input->post('url');
        if(!empty($videoUrl)){
            $videoTypeId = 0;
            if(strpos($videoUrl, 'youtube.com/')!==false) $videoTypeId = 2;
            elseif(strpos($videoUrl, 'vimeo.com')!==false) $videoTypeId = 3;
            elseif(strpos($videoUrl, '.mp3')!==false) $videoTypeId = 4;
            elseif (strpos($videoUrl, 'facebook.com')!==false) $videoTypeId = 5;
            elseif(strpos($videoUrl,'daylymotion.com') !== false) $videoTypeId =6;
            if($videoTypeId>0){
                switch($videoTypeId){
                    case 2: //youtube
                        $start = strpos($videoUrl, '?v=');
                        if($start>0){
                            $videoId = substr($videoUrl, $start);
                            $videoId = str_replace('?v=', '', $videoId);
                            $json = @file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$videoId}&key=".YOUTUBE_API_KEY."&part=snippet,contentDetails");
                            if($json){
                                $json = json_decode($json, true);
                                $json = $json['items'];
                                if(count($json)==1){
                                    $json = $json[0];
                                    $interval = new DateInterval($json['contentDetails']['duration']);
                                    $retVal = array('type'=>2,'duration'=>$interval->h * 3600 + $interval->i * 60 + $interval->s);
                                    $json = $json['snippet'];
                                    $retVal['title'] = $json['title'];
                                    $retVal['description'] = $json['description'];
                                    $retVal['image'] = "";
                                    $json = $json['thumbnails'];
                                    if(isset($json['maxres'])) $retVal['image'] = $json['maxres']['url'];
                                    elseif(isset($json['standard'])) $retVal['image'] = $json['standard']['url'];
                                    elseif(isset($json['high'])) $retVal['image'] = $json['high']['url'];
                                    elseif(isset($json['medium'])) $retVal['image'] = $json['medium']['url'];
                                    elseif(isset($json['default'])) $retVal['image'] = $json['default']['url'];
                                    echo json_encode($retVal);
                                }
                                else echo '2';
                            }
                            else echo '2';
                        }
                        else echo '1';
                        break;
                    case 3://vimeo
                        $videoId = parse_vimeo($videoUrl);
                        if(!empty($videoId)){
                            $json = @file_get_contents("http://vimeo.com/api/v2/video/{$videoId}.json");
                            if($json){
                                $json = json_decode($json, true);
                                if(count($json)==1){
                                    $json = $json[0];
                                    echo json_encode(array(
                                        'type' => 3,
                                        'duration' => $json['duration'],
                                        'title' => $json['title'],
                                        'description' => strip_tags($json['description']),
                                        'image' => $json['thumbnail_large']
                                    ));
                                }
                                else echo '2';
                            }
                            else echo '2';
                        }
                        else echo '1';
                        break;
                    case 5 ://facebook

                }
            }
            else echo '1';
        }
        else echo '0';
    }
}