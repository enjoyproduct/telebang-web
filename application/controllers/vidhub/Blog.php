<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends BaseV1Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel();
        $this->data['head_title']           = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description']     = $this->theme_config['site_headding'];
        $this->data['meta_keywords']        = $this->theme_config['site_title'];
        $this->data['newLatest']            = $this->getListNewsLasted();
        $this->data['newMost']              = $this->getListNewMostView();

       
    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {
        $perPage = $this->theme_config['blogs_limit'];
        $page = 1;
        $listBlogs                  = $this->formatNews($this->Mnews->getList($page, $perPage));
        $this->data['listBlogs']    = $listBlogs;
        $this->data['perPage']      = $perPage;
        $this->data['page']         = $page;

        $this -> view_render('blog/list');
    }
    public function detail($id = 0)
    {
        $newDetail   = $this->Mnews->get($id);
        if ($newDetail) {
            $this->data['title']        = $newDetail['title'];
            $this->data['description']  = $newDetail['description'];
            $this->data['view']         = $newDetail['view'];
            $this->data['date']         = $newDetail['update_at'];
            $this->data['images']       = getImagePath($newDetail['thumbnail']);
            $pre_post = $this->Mnews->getPreNews($id);
            if($pre_post)
                $pre_post =  $this->formatNewsPost($pre_post);
            $this->data['preNews']     = $pre_post;

            $next_post = $this->Mnews->getNextNews($id);
            if($next_post)
                $next_post =  $this->formatNewsPost($next_post);
            $this->data['nextNews']     = $next_post;
            
            $this -> view_render('blog/detail');
        }else
            $this->updateViewCounter($id);

    }
    
    public function getChildrenCate($listCategories, &$rootCate)
    {
        $children = array();
        foreach ($listCategories as $key => &$cate) {
            if($cate['ParentCategoryId'] == $rootCate['CategoryId']) {
                $cate['url_list_video']     = V1_CATEGORY_PATH.'/'.$cate['CategoryId'];
                $cate['videos_counter']     = $this->Mvideos->getVideosCounterBy($cate['CategoryId']) ;
                $cate['children']           = $this->getChildrenCate($listCategories, $cate);
                $children[]                 = $cate;
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
        return $listNew;
    }
    private function getListNewMostView($page = 1, $limit = 20)
    {
        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $mostNews = $this->Mnews->getList(0, 0, "", 0, $limit, 'view', $offset);
        return $this->formatNews($mostNews);
    }
    public function loadModel()
    {
        $models = array('Mvideos', 'Like_video_model', 'Comment_video_model', 'Mnews', 'Mcategories', 'Mcategoryvideos','Musers');
        foreach ($models as $model)
            $this->load->model($model);
    }
    private function updateViewCounter($newId)
    {
        $fieldName = "ViewCount";
        $flag = $this->Mnews->updateViewCounter($newId);
    }
    
    
    
}