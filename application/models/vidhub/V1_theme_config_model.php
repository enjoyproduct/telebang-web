<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class V1_theme_config_model extends CI_Model{

    const TABLE_NAME            = 'vidhub_theme_config';
    const COL_ID                = 'id';
    const COL_TITLE             = 'site_title';
    const COL_HEADDING          = 'site_headding';
    const COL_HEADER_LOGO       = 'header_logo';
    const COL_FAVICON_LOGO      = 'site_favicon';
    const COL_FOOTER_LOGO       = 'footer_logo';
    const COL_FOOTER_ABOUT      = 'footer_about';
    const COL_ANDROID_URL       = 'android_url';
    const COL_IOS_URL           = 'ios_url';
    const COL_FACEBOOK_URL      = 'facebook_url';
    const COL_GOOGLE_URL        = 'google_url';
    const COL_TWITTER_URL       = 'twitter_url';
    const COL_YOUTUBE_URL       = 'youtube_url';
    const COL_FOOTER_COPYRIGHT  = 'footer_copyright';
    const COL_CATEGORY_HOME_1   = 'home_category_1';
    const COL_CATEGORY_HOME_2   = 'home_category_2';
    const COL_KEY_PLAYER        = 'jwplayer_key';
    const COL_UPLOAD_ENABLE     = 'upload_enable';
    const COL_ABOUT_URL         = 'about_url';

	public function __construct(){
        parent::__construct();
    }
    
    public function get($id)
    {
        $this->db->reconnect();
        $query = $this->db->get_where(self::TABLE_NAME, array(self::COL_ID => $id));
        $model = $query->row_array();

        return $model;
    }

    public function getConfig()
    {
        $this->db->reconnect();
        $query = $this->db->get(self::TABLE_NAME);
        return $query->row_array();
    }

    public function update($id, $valueData){
        $id = 1;
        $this->db->reconnect();
        return $this->db->update(self::TABLE_NAME, $valueData);
    }
}