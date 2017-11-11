<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller
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
            $this->load->model('Mnews');
            $data['user'] = $user;
            $data['pages'] = $this->Mnews->getList();
            $this->load->view('admin/news/news-list', $data);

        } else redirect('index.php/admin/user');
    }

    public function delete($newsID)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($newsID > 0) {
                $this->load->model('Mnews');
                $flag = $this->Mnews->delete($newsID);
                if ($flag) $this->session->set_flashdata('txtSuccess', "News has been deleted");
                else $this->session->set_flashdata('txtError', "Delete news failed");
            }
            redirect('index.php/admin/news');
        } else redirect('index.php/admin/user');
    }

    public function update($newsID = 0)
    {
        $user = $this->session->userdata('user');

        if ($user) {
            $models = array('Mnews', 'Mnews_category');
            foreach ($models as $model)
                $this->load->model($model);

            $data = array();
            $data['user'] = $user;
            $data['id'] = $newsID;
            $data['title'] = '';
            $data['thumbnail'] = base_url(NO_IMAGE_PATH);
            $data['view'] = 0;
            $data['description'] = '';
            $data['short_description'] = '';
            $data['categories'] = $this->Mnews_category->getList();
            $data['categoryIdsSelected'] = array();

            $flag = 0;
            if ($newsID > 0) {
                $flag = 1;
                $page = $this->Mnews->get($newsID);
                if ($page) {
                    $data['title'] = $page['title'];

                    $videoImage = $page['thumbnail'];
                    if ($videoImage)
                        $data['thumbnail'] = base_url(IMAGE_PATH . $videoImage);

                    $data['view'] = 'view';
                    $data['description'] = $page['description'];
                    $data['short_description'] = $page['short_description'];

                    $categoriesSelected = $this->Mnews_category->getCategoriesByNewsID($newsID);
                    $retVal = array();
                    foreach ($categoriesSelected as $cat)
                        $retVal[] = intval($cat['category_id']);

                    $data['categoryIdsSelected'] = $retVal;
                } else {
                    $data['txtError'] = "Page is not exist.";
                    $flag = 2;
                }
            } else $flag = 3;

            $data['flag'] = $flag;

            if ($this->input->post('submit') && $flag != 2) {
                $currentDateTime = (new DateTime())->getTimestamp();

                $thumbnailImage = trim($this->input->post('Thumbnail'));
                $data['thumbnail'] = $thumbnailImage;
                $thumbnailNew = basename($thumbnailImage);

                $valueData = array(
                    'title' => trim($this->input->post('Title')),
                    'description' => $this->input->post('Description'),
                    'short_description' => $this->input->post('ShortDescription'),
                    'update_at' => $currentDateTime,
                    'thumbnail' => $thumbnailNew
                );

                if ($flag == 3)
                    $valueData['create_at'] = $currentDateTime;

                $listCategoryIds = $this->input->post('Categories');
                if (!is_array($listCategoryIds))
                    $listCategoryIds = array();

                $newsID = $this->Mnews->insertOrUpdate($newsID, $valueData, $listCategoryIds);
                if ($newsID > 0) {
                    $data['id'] = $newsID;
                    $data['categoryIdsSelected'] = $listCategoryIds;
                    $data['txtSuccess'] = "News Saved";
                } else $data['txtError'] = "An error occurred in the implementation process!";
            }
            $this->load->view('admin/news/news-update', $data);
        } else redirect('index.php/admin/user');
    }
}


