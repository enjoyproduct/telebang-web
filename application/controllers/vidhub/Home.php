<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends BaseV1Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel();
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {
        $this->data['head_title'] = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description'] = $this->theme_config['site_headding'];
        $this->data['meta_keywords'] = $this->theme_config['site_title'];

        // latest
        $this->data['videosLatest'] = $this->getListVideoLasted();

        // Most
        $this->data['videosMost'] = $this->getListVideoMostView();

        $this->data['videosMostThisWeek'] = $this->getListVideoMostViewThisWeek();

        // Trending
        $this->data['videoTrending'] = $this->getListVideoTrending();
        // New
        $this->data['newLatest'] = $this->getListNewsLasted();

        // Slider
        $this->data['sliderVideo'] = $this->getListSlider();
        // Sidebar Category

        $this->data['listCategoriesTree'] = $this->getCateTree();

        // Category
        $this->data['categories_selected'] = array();
        if (isset($this->theme_config['home_category_1'] ) && $this->theme_config['home_category_1']) {
            $catID = $this->theme_config['home_category_1'];
            $catModel = $this->Mcategories->get($catID);
            if($catModel){
                 $catModel['videos'] = $this->getListVideoByCategory($catID);
                 $this->data['categories_selected'][] = $catModel;
            }  
        }

        if (isset($this->theme_config['home_category_2'] ) && $this->theme_config['home_category_2']) {
            $catID = $this->theme_config['home_category_2'];
            $catModel = $this->Mcategories->get($catID);
            if($catModel){
                 $catModel['videos'] = $this->getListVideoByCategory($catID);
                 $this->data['categories_selected'][] = $catModel;
            }            
        }

        $this -> view_render('home');
    }

    private function getListVideoLasted($page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $listVideos = $this->Mvideos->getList(0, 0, "", 0, $limit, 'CrDateTime', $offset);
        return $this->formatVideoList($listVideos);
    }

    private function getListVideoMostView($page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $mostVideos = $this->Mvideos->getList(0, 0, "", 0, $limit, 'ViewCount', $offset);
        return $this->formatVideoList($mostVideos);
    }

    private function getListVideoMostViewThisWeek($page = 1, $limit = 9)
    {
        $mostVideos = $this->Mvideos->getMostViewThisWeek($page, $limit);
        return $this->formatVideoList($mostVideos);
    }

    //video
    public function getListVideoLiked($page = 1, $limit = 20)
    {
        if ($categoryId > 0) {
            if ($page < 1)
                $page = 1;
            $offset = ($page - 1) * $limit;
            $listVideosLiked = $this->Mvideos->getListVideoLiked($limit, $offset);
            $content = array();
            foreach ($listVideosLiked as $v) {
                $content[] = $this->formatVideoResponse($v);
            }
            echo $this->responseSuccessJson($content);
        } else {
            echo $this->responseErrorJson('CategoryId must be greater than 0.');
        }
    }

    // Category 1
    public function getListVideoByCategory($categoryId = 0, $page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;

        $listVideoByCategory = $this->Mvideos->getListByCategory($categoryId, $limit, "CrDateTime", $offset);

        return $this->formatVideoList($listVideoByCategory);
    }


    public function getListNewsLasted($page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $listNew = $this->Mnews->getList($page, $limit);
        return $this->formatNews($listNew);
    }

    public function getListSlider($page = 1, $limit = 5)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $result = $this->V1_slider_model->getList($page, $limit);


        $listSlider = array();

        foreach ($result as $model) {
            $slider = array();
            $slider['title'] = $model['title'];
            $slider['sub_title'] = $model['description'];
            $slider['image'] = getImagePath($model['image']);
            $type = $model['type'];
            $value = $model['value'];
            if($type == V1_SLIDE_TYPE_VIDEO){
                $value =  site_url(sprintf(VIDEO_DETAIL_PATH, $value, $value));
            }else if($type == V1_SLIDE_TYPE_NEWS){
                $value =  site_url(sprintf(BLOG_DETAIL_PATH, to_slug($slider['title']), $value));
            }

           $slider['url'] = $value;
           $slider['type'] = $type;
           
           $listSlider[] = $slider;
        }
        return $listSlider;
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
    public function login(){
        echo "fasdf";
    }

    /* START COMMON FUNCTION*/

    public function createCategoryTree(&$list, $parent, $level = "", &$tree){
        foreach ($parent as $k=>$l){
            $l['level'] = $level;
            $tree[] = $l;
            if(isset($list[$l['CategoryId']])){
                $lv = $level."-";
                $this->createCategoryTree($list, $list[$l['CategoryId']], $lv, $tree);
            }
        }
        return $tree;
    }

    public function loadModel()
    {
        $models = array('Mvideos', 'Like_video_model', 'Comment_video_model', THEME_VM_DIR.'/V1_slider_model', 'Mnews', 'Musers');
        foreach ($models as $model)
            $this->load->model($model);
    }

    /* END COMMON FUNCTION*/

}
