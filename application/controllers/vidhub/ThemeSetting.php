<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ThemeSetting extends BaseV1Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mcategories');
        $this->load->model('Mstatic');
        $this->load->model(THEME_VM_DIR.'/V1_theme_config_model');

    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function index($tab_position = 1)
    {
        $user = $this->session->userdata('user');
         if(!$user){
            redirect('index.php/admin/user');
            return;
        }
        $slide = $this->V1_theme_config_model->getConfig();

        $dataView = $this -> initThemeData($slide);
        $dataView['user'] = $user;
        $dataView['listCategories'] = $this->Mcategories->getList(STATUS_ACTIVED);
        $dataView['listPage'] = $this->Mstatic->getList();
        $dataView['tab_position'] = $tab_position;
        if(!$slide){
            $dataView['txtError'] = 'Slider not found';
        }

        $this->load->view(THEME_VM_DIR.'/options/general_setting', $dataView);
    }
    public function update($id = 0, $tab_position ){
        $user = $this->session->userdata('user');
         if(!$user){
            redirect('index.php/admin/user');
            return;
        }

        $slide = $this->V1_theme_config_model->get($id);

        $dataView = $this -> initThemeData($slide);
        $dataView['user'] = $user;
        $dataView['listCategories'] = $this->Mcategories->getList(STATUS_ACTIVED);
        $dataView['listPage'] = $this->Mstatic->getList();
        $dataView['tab_position'] = $tab_position;
        if(!$slide){
            $dataView['txtError'] = 'Slider not found';
        }

        $this->load->view(THEME_VM_DIR.'/options/general_setting', $dataView);
    }

    public function submit($id = 0, $tab_position = 1){
        $user = $this->session->userdata('user');
        if(!$user){
            redirect('index.php/admin/user');
            return;
        }

        if (!$this->input->post('submit')){
            redirect(THEME_CONTROLLER_PATH.'ThemeSetting/update/'.$id);
        }

        $title              = $this->input->post('Title');
        $headding           = $this->input->post('Headding');
        $footerTitle        = $this->input->post('FooterTitle');
        $footerAbout        = $this->input->post('About');
        $copyright          = $this->input->post('Copyright');
        $android_url        = $this->input->post('Android');
        $ios_url            = $this->input->post('Ios');
        $facebook_url       = $this->input->post('Facebook');
        $google_url         = $this->input->post('Google');
        $youtube_url        = $this->input->post('Youtube');
        $twitter_url        = $this->input->post('Tiwtter');
        $category1          = $this->input->post('Category1');
        $category2          = $this->input->post('Category2');
        $key_play           = $this->input->post('JwplayerKey');
        $about_url           = $this->input->post('About_url');

        $upload_enable      = ($this->input->post('Upload_enable') == 'on') ? 1 : 0;

        $imagePathFavicon   = $this->input->post('Favicon');        
        $imageNameFavicon   = basename($imagePathFavicon);
        $imagePathLogo      = $this->input->post('Logo');        
        $imageNameLogo      = basename($imagePathLogo);
        
        $valueData = array(
            V1_theme_config_model::COL_TITLE                => $title,
            V1_theme_config_model::COL_HEADDING             => $headding,
            V1_theme_config_model::COL_FOOTER_LOGO          => $footerTitle,
            V1_theme_config_model::COL_FOOTER_ABOUT         => $footerAbout,
            V1_theme_config_model::COL_FOOTER_COPYRIGHT     => $copyright,
            V1_theme_config_model::COL_ANDROID_URL          => $android_url,
            V1_theme_config_model::COL_IOS_URL              => $ios_url,
            V1_theme_config_model::COL_FACEBOOK_URL         => $facebook_url,
            V1_theme_config_model::COL_GOOGLE_URL           => $google_url,
            V1_theme_config_model::COL_YOUTUBE_URL          => $youtube_url,
            V1_theme_config_model::COL_TWITTER_URL          => $twitter_url,
            V1_theme_config_model::COL_CATEGORY_HOME_1      => $category1,
            V1_theme_config_model::COL_CATEGORY_HOME_2      => $category2,
            V1_theme_config_model::COL_HEADER_LOGO          => $imageNameLogo,
            V1_theme_config_model::COL_FAVICON_LOGO         => $imageNameFavicon,
            V1_theme_config_model::COL_KEY_PLAYER           => $key_play,
            V1_theme_config_model::COL_UPLOAD_ENABLE        => $upload_enable,
            V1_theme_config_model::COL_ABOUT_URL            => $about_url
        );

        $dataView = $this -> initThemeData($valueData);
        $dataView['user'] = $user;
        $dataView['id'] = $id;
        $resultID = $this->V1_theme_config_model->update($id, $valueData);
        $dataView['listCategories'] = $this->Mcategories->getList(STATUS_ACTIVED);
        $dataView['listPage'] = $this->Mstatic->getList();
        $dataView['tab_position'] = $tab_position;
        if($resultID){
            $dataView['id'] = $resultID;
            $dataView['txtSuccess'] = "Update successfully!";
        }else{
            $dataView['txtError'] = "An error occurred in the implementation process!";
        }      

        $this->load->view(THEME_VM_DIR.'/options/general_setting', $dataView);
    }
    private function initThemeData($themeModel = null){
        $dataView = array();
        if($themeModel){
            if(isset($themeModel[V1_theme_config_model::COL_ID])){
                $dataView['id']             = $themeModel[V1_theme_config_model::COL_ID];
            }
            $dataView['site_title']             = $themeModel[V1_theme_config_model::COL_TITLE];
            $dataView['site_headding']          = $themeModel[V1_theme_config_model::COL_HEADDING];
            $dataView['footer_logo']            = $themeModel[V1_theme_config_model::COL_FOOTER_LOGO];
            $dataView['footer_about']           = $themeModel[V1_theme_config_model::COL_FOOTER_ABOUT];
            $dataView['footer_copyright']       = $themeModel[V1_theme_config_model::COL_FOOTER_COPYRIGHT];
            $dataView['android_url']            = $themeModel[V1_theme_config_model::COL_ANDROID_URL];
            $dataView['ios_url']                = $themeModel[V1_theme_config_model::COL_IOS_URL];
            $dataView['facebook_url']           = $themeModel[V1_theme_config_model::COL_FACEBOOK_URL];
            $dataView['google_url']             = $themeModel[V1_theme_config_model::COL_GOOGLE_URL];
            $dataView['youtube_url']            = $themeModel[V1_theme_config_model::COL_YOUTUBE_URL];
            $dataView['twitter_url']            = $themeModel[V1_theme_config_model::COL_TWITTER_URL];
            $dataView['home_category_1']        = $themeModel[V1_theme_config_model::COL_CATEGORY_HOME_1];
            $dataView['home_category_2']        = $themeModel[V1_theme_config_model::COL_CATEGORY_HOME_2];
            $dataView['jwplayer_key']           = $themeModel[V1_theme_config_model::COL_KEY_PLAYER];
            $dataView['upload_enable']          = $themeModel[V1_theme_config_model::COL_UPLOAD_ENABLE];
            $dataView['about_url']              = $themeModel[V1_theme_config_model::COL_ABOUT_URL];
            $dataView['site_favicon']           = getImagePath($themeModel[V1_theme_config_model::COL_FAVICON_LOGO]);
            $dataView['header_logo']            = getImagePath($themeModel[V1_theme_config_model::COL_HEADER_LOGO]);

        }else{
            $dataView['site_title']             = '';
            $dataView['site_headding']          = '';
            $dataView['footer_logo']            = '';
            $dataView['footer_about']           = '';
            $dataView['footer_copyright']       = '';
            $dataView['android_url']            = '';
            $dataView['ios_url']                = '';
            $dataView['facebook_url']           = '';
            $dataView['google_url']             = '';
            $dataView['youtube_url']            = '';
            $dataView['twitter_url']            = '';
            $dataView['home_category_1']        = '';
            $dataView['home_category_2']        = '';
            $dataView['jwplayer_key']           = '';
            $dataView['about_url']           = '';
            $dataView['upload_enable']          = 0;
            $dataView['site_favicon']           = base_url(NO_IMAGE_PATH);
            $dataView['header_logo']            = base_url(NO_IMAGE_PATH);
        }

        return $dataView;
    }
}