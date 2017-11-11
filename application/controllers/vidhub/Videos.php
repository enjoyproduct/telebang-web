<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends BaseV1Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel();
        $this->data['head_title']           = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description']     = $this->theme_config['site_headding'];
        $this->data['meta_keywords']        = $this->theme_config['site_title'];
        $this->data['listCategoriesTree']   = $this->getCateTree();
        $this->data['newLatest']            = $this->getListNewsLasted();
        $this->data['videoTrending']        = $this->getListVideoTrending();
        $this->data['videosMost']           = $this->getListVideoMostView();

    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {

    }

    public function video_detail_page($videoId)
    {
        if ($videoId > 0) {

            $videoDetail = $this->Mvideos->getDetail($videoId);
            $this->data['video_type']               = $videoDetail['VideoTypeId'];
            $this->data['update_at']                = $videoDetail['UpdateDate'];
            $this->data['avatar']                   = $videoDetail['Avatar'];
            $this->data['view']                     = $videoDetail['ViewCount'];
            $this->data['fullname']                 = $videoDetail['FirstName'].' '.$videoDetail['LastName'];
            $this->data['id']                       = $videoDetail['VideoId'];            

            $this->data['video_vid']                = $videoDetail['IsVip'];
            $this->data['user_vid']                 = $videoDetail['IsUserVip'];
            $this->data['paystack_auth_code']       = $videoDetail['paystack_auth_code'];
            $this->data['subscribed_date']          = $videoDetail['subscribed_date'];
            
            $perPage = $this->theme_config['comment_limit'];
            $page = 1;
            $commentList                            = $this->Comment_video_model->getListComments($videoId, $page, $perPage);
            $this->data['listComments']             = $commentList;
            $this->data['perPage']                  = $perPage;
            $this->data['page']                     = $page;

            $this->data['videos_counter_by_user']   = $this ->Mvideos->getVideosCounterBy($videoDetail['CrUserId']);
            $this->data['comments_counter']         = $this ->Comment_video_model->getCommentCounterBy($videoId);

            $this->data['like']                     = $this->Like_video_model->getStatsLike($videoId);
            $this->data['checkLike']                = $this->Like_video_model->checkLikedVideo($videoDetail['CrUserId'], $videoDetail['VideoId']);
            $this->data['upload']                   = $this->theme_config['upload_enable'];

            $videoUrl = $videoDetail['VideoUrl'];
            if (strpos($videoUrl, 'http') === false)
                $videoUrl = base_url(VIDEO_PATH . $videoUrl);

            $this->data['video_path']               = $videoUrl;
            $this->data['image']                    = getImagePath($videoDetail['VideoImage']);

            $this->data['relatedVideo']             = array();
            $arrayCates                             = $this->Mcategories->getCategoriesOfVideo($videoId);
            if ($arrayCates) {
                foreach ($arrayCates as $cate) {
                    $this->data['relatedVideo'][]       = $this->get_videos_by_category($cate['CategoryId']);
                }
            }
            else{
                $this->data['relatedVideo'] = array();
            }

            if(count($this->data['relatedVideo']) > 0) {
                $this->data['relatedVideo']         = call_user_func_array('array_merge', $this->data['relatedVideo']); 
            }

             $user = $this->session->userdata('user');
            if ($user) {
                $this->data['is_liked']             = $this->Like_video_model->checkLikedVideo($user['UserId'], $videoId);
            }else{
                $this->data['is_liked']             = true;
            }
            $this->data['head_title']               = $videoDetail['VideoTitle'].' - '.$this->theme_config['site_title'];
            $this->data['meta_description']         = $videoDetail['VideoDesc'];
            $this->data['meta_keywords']            = $videoDetail['VideoTitle'];

            
            $this->load->view(THEME_VM_DIR.'/videos/details', $this->data);
        } 
        $this->updateViewCounter($videoId);
        
    }

    private function updateViewCounter($videoId)
    {
        $fieldName = "ViewCount";
        $flag = $this->Mvideos->updateStatistics($videoId, $fieldName, 0);
    }

    public function video_category_page()
    {
        $data = array();
        $listCategory = $this->formatCategories($this->Mcategories->getList('status'));


        $this->data['listCategory'] = $listCategory;

        if ($this->session->flashdata('txtSuccess'))
            $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
        if ($this->session->flashdata('txtError'))
            $data['txtError'] = $this->session->flashdata('txtError');
        $this->load->view(THEME_VM_DIR.'/videos/category', $this->data);
    }

    public function search($page = 1, $limit = 15, $offset = 0)
    {
        $keyword = $this->input->get('keyword');
        if ($page < 1)
            $page = 1;
        $perPage = $this->theme_config['videos_limit'];
        $offset = ($page - 1) * $perPage;
        $listVideos = $this->Mvideos->getList(0, 0, $keyword, 0, $perPage, "CrDateTime", $offset);

        $this->data['listVideos'] = $this->formatVideoList($listVideos);
        $this->data['page'] = $page;
        $this->data['perPage'] = $perPage;

        if(!$listVideos || empty($listVideos))
            $this->data['message'] = 'No videos';

        $this->load->view(THEME_VM_DIR.'/search', $this->data);
    }

    public function searchAjax($page = 1, $limit = 15, $offset = 0)
    {
        $keyword = $this->input->get('keyword');
        if ($page < 1)
            $page = 1;
        $perPage = $this->theme_config['videos_limit'];
        $offset = ($page - 1) * $perPage;
        $listVideos = $this->Mvideos->getList(0, 0, $keyword, 0, $perPage, "CrDateTime", $offset);

        $this->data['listVideos'] = $this->formatVideoList($listVideos);
        $this->data['page'] = $page;
        $this->data['perPage'] = $perPage;

        if(!$listVideos || empty($listVideos))
            $this->data['message'] = 'No videos';
        echo json_encode($this->data['listVideos']);
    }

    public function videos_by_category_page($categoryId = 0)
    {
        if ($categoryId > 0) {
            $perPage = $this->theme_config['videos_limit'];
            $page = 1;
            $category = $this->Mcategories->get($categoryId);
            if($category){
                $listVideos = $this->Mvideos->getListByCategory($categoryId, ($perPage), "CrDateTime", ($page - 1)*$perPage);
                $this->data['category'] = $category;
                $this->data['listVideos'] = $this->formatVideoList($listVideos);
                $this->data['page'] = $page;
                $this->data['perPage'] = $perPage;
                if(!$listVideos || empty($listVideos))
                    $this->data['message'] = 'No videos';
                $this->load->view(THEME_VM_DIR.'/videos/list', $this->data);
            }else
                redirect(HOME_PATH);
        }else
            redirect(HOME_PATH);
    }

    public function getListVideosByCategory($categoryId = 0 , $page = 1, $limit = 20, $offset = 0)
    {
        if ($page < 1)
            $page = 1;
        $offset = ($page - 1) * $limit;
        $listVideos = $this->Mvideos->getListByCategory($categoryId, $limit, "CrDateTime", $offset);
        echo json_encode($this->formatVideoList($listVideos));return;
        
    }
    public function get_videos_by_category($categoryId = 0 , $page = 1, $limit = 20, $offset = 0)
    {
        if ($categoryId > 0) {
            if ($page < 1)
                $page = 1;
            $offset = ($page - 1) * $limit;
            $listVideos = $this->Mvideos->getListByCategory($categoryId, $limit, "CrDateTime", $offset);
            return $this->formatVideoList($listVideos);
        } else{
            echo "Get Video By Category";
        }
    }
    public function getListVideoTrending($page = 1, $limit = 10)
    {
        $VideoTrending = $this->Mvideos->getListTrending($page, $limit);
        return $this->formatVideoList($VideoTrending);
    }
    public function getCateTree()
    {
        $this->load->model('Mcategories');
        $listCategories = $this->Mcategories->getList();

        $rootCates = array();

        foreach ($listCategories as $key => &$cate) {
            if($cate['ParentCategoryId'] == NULL) {
                $cate['url_list_video'] = site_url(sprintf(VIDEOS_BY_CATEGORY_PATH, $cate['CategoryId']));
                $cate['videos_counter'] = $this->Mvideos->getVideosCounterBy($cate['CategoryId']) ;
                $rootCates[] = $cate;
            }
        }

        foreach ($rootCates as $key => &$rootCate) {
            $rootCate['children'] = $this->getChildrenCate($listCategories, $rootCate);
        }
        return $rootCates;
    }
    private function getListVideoMostView($page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $mostVideos = $this->Mvideos->getList(0, 0, "", 0, $limit, 'ViewCount', $offset);
        return $this->formatVideoList($mostVideos);
    }
    public function getChildrenCate($listCategories, &$rootCate)
    {
        $children = array();
        foreach ($listCategories as $key => &$cate) {
            if($cate['ParentCategoryId'] == $rootCate['CategoryId']) {
                $cate['url_list_video'] = site_url(sprintf(VIDEOS_BY_CATEGORY_PATH, $cate['CategoryId']));
                $cate['videos_counter'] = $this->Mvideos->getVideosCounterBy($cate['CategoryId']) ;
                $cate['children'] = $this->getChildrenCate($listCategories, $cate);
                $children[] = $cate;
            }
        }
        return $children;
    }
    
    public function getListNewsLasted($page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        
        $listNew = $this->Mnews->getList($page, $limit);
        return $this->formatNews($listNew);
    }

    public function loadModel()
    {
        $models = array('Mvideos', 'Like_video_model', 'Comment_video_model', 'Mnews', 'Mcategories', 'Mcategoryvideos','Musers');
        foreach ($models as $model)
            $this->load->model($model);
    }


    public function formatVideoList($listVideo)
    {
        $content = array();
        if ($listVideo) {
            foreach ($listVideo as $v) {
                $content[] = $this->formatVideo($v);
            }
        }
        return $content;
    }
    public function insertCommentVideo($videoID = '')
    {
        $user = $this->session->userdata('user');
       
        if (!$user) {
            redirect('index.php/admin/user');
            return;
        }

        $userIDHeader = $user['UserId'];

        $commentText = $this->input->post('comment_text');
        if (empty($videoID) || empty($commentText)) {
            echo 'VideoId or CommentText is blank';
            return;
        }

        $video = $this->Mvideos->get($videoID);

        if (!$video) {
            echo $this->responseErrorJson("Video not found");
            return;
        }

        $comment = array(
            Comment_video_model::TBL_COMMENT_USER_ID => $userIDHeader,
            Comment_video_model::TBL_COMMENT_VIDEO_ID => $videoID,
            Comment_video_model::TBL_COMMENT_COMMENT_TEXT => $commentText,
            Comment_video_model::TBL_COMMENT_CREATE_AT => (new DateTime())->getTimestamp(),
            Comment_video_model::TBL_COMMENT_STATUS => $statusId
        );

        $id = $this->Comment_video_model->insertComment($comment);

        if ($id <= 0)
            echo 'Have an error insert comment';
        else {
            $comment[Comment_video_model::TBL_COMMENT_ID] = $id;
            redirect(V1_VIDEO_PATH.'/'.$videoID);
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


        $listComment = $this->Comment_video_model->getListComments($videoID, $limit, $offset);

        
        return $listComment;

    }

}