<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}

class BaseV1Controller extends MY_Controller
{    
    public $theme_config;
    public $customer_model;
    
    public function __construct()
    {
        parent::__construct();

                // user
        $this->customer_model = $this->session->userdata('customer');
        $this->data['customer_model'] = $this->customer_model;

        $this->load->model(THEME_VM_DIR.'/V1_theme_config_model');
        $this->load->model('Mcategories');
        $this->load->model('Mvideos');

        $this->theme_config = $this->V1_theme_config_model->getConfig();

        $this->data['head_title'] = $this->theme_config['site_title'].' - '.$this->theme_config['site_headding'];
        $this->data['meta_description'] = $this->theme_config['site_headding'];
        $this->data['meta_keywords'] = $this->theme_config['site_title'];
        $this->data['message'] = '';

        $this->data[THEME_VM_DIR.'_theme_path'] = THEME_VM_DIR;
        $this->data['themeConfig'] = $this->theme_config;
        $this->data['listParentCategories'] = $this->getCategoriesFooter();
        $this->data['upload'] = $this->theme_config['upload_enable'];
    }

    public function view_render($content)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->load->view(THEME_VM_DIR .'/' .$content, $this->data);
        }
    }

       

    private function getCategoriesFooter(){
        $result = $this->Mcategories->getList();
        $parentCategoies = array();

        foreach ($result as $value) {
            $value['url_list_video'] = site_url(sprintf(VIDEOS_BY_CATEGORY_PATH, $value['CategoryId']));
            $videos_by_cat = $this->Mvideos->get_video_counter_by_cat($value['CategoryId']);
            $value['videos_counter'] =  ($videos_by_cat)? $videos_by_cat:0;
            $parentCategoies[] = $value;
        }

        return $parentCategoies;
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


    public function formatVideo($video)
    {
        $video['likedCounter']      = $this->Like_video_model->getStatsLike($video['VideoId']);
        $video['commentedCounter']  = $this->Comment_video_model->getCommentCounterBy($video['VideoId']);
        $video['videoDetailPath']   = site_url(sprintf(VIDEO_DETAIL_PATH, to_slug($video['VideoTitle']), $video['VideoId']));
        $video['VideoImage']        = getImagePath($video['VideoImage']);
        $video['videoVip']          = $video["IsVip"];

        return $video;
    }

    public function formatCategories($listCat)
    {
        $content = array();
        if ($listCat) {
            foreach ($listCat as $v) {
                $v['url_list_video']    = site_url(sprintf(VIDEOS_BY_CATEGORY_PATH, $v['CategoryId']));
                $videos_by_cat          = $this->Mvideos->get_video_counter_by_cat($v['CategoryId']);
                $v['videos_counter']    =  ($videos_by_cat)? $videos_by_cat:0;
                $content[]              = $v;
            }
        }
        return $content;
    }

    public function formatNews($news)
    {   
        $content = array();
        if ($news) {
            foreach ($news as $value) {
                $content[]              = $this->formatNewsPost( $value);
            }
        }
        
        return $content;
    }

    public function formatNewsPost($news)
    {
        $news['newDetailPath'] = site_url(sprintf(BLOG_DETAIL_PATH, to_slug($news['title']), $news['id']));
        return $news;
    }
}
