<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_category extends CI_Controller
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
            $this->load->model('Mnews_category');
            $data['user'] = $user;
            $data['items'] = $this->Mnews_category->getList();
            $this->load->view('admin/news/news-categories', $data);

        } else redirect('index.php/admin/user');
    }

    public function delete($id)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($id > 0) {
                $this->load->model('Mnews_category');
                $flag = $this->Mnews_category->delete($id);
                if ($flag) $this->session->set_flashdata('txtSuccess', "News has been deleted");
                else $this->session->set_flashdata('txtError', "Delete news failed");
            }
            redirect('index.php/admin/news_category');
        } else redirect('index.php/admin/user');
    }

    public function update($id = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            $this->load->model('Mnews_category');
            $data = array();
            $data['user'] = $user;
            $data['id'] = $id;
            $data['title'] = '';
            $data['thumbnail'] = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
            $data['icon'] = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";

            $flag = VIEW_ACTION_ERROR;
            if ($id > 0) {
                $flag = VIEW_ACTION_UPDATE;
                $item = $this->Mnews_category->get($id);
                if ($item) {
                    $data['title'] = $item[Mnews_category::TABLE_TITLE];

                    if (!empty($item[Mnews_category::TABLE_THUMBNAIL]))
                        $data['thumbnail'] = IMAGE_PATH . $item[Mnews_category::TABLE_THUMBNAIL];

                    if (!empty($item[Mnews_category::TABLE_ICON]))
                        $data['icon'] = IMAGE_PATH . $item[Mnews_category::TABLE_ICON];
                } else {
                    $data['txtError'] = "Page is not exist.";
                    $flag = VIEW_ACTION_ERROR;
                }
            } else $flag = VIEW_ACTION_ADD_NEW;

            $data['flag'] = $flag;
            if ($this->input->post('submit') && $flag != VIEW_ACTION_ERROR) {
                $currentDateTime = (new DateTime())->getTimestamp();

                $categoryThumb = trim($this->input->post('Thumbnail'));
                $data['thumbnail'] = $categoryThumb;
  
                $categoryIcon = trim($this->input->post('Icon'));
                $data['icon'] = $categoryIcon;

                $imageImage = str_replace(array(IMAGE_PATH, ROOT_PATH), '', $categoryThumb);
                $imageIcon = str_replace(array(IMAGE_PATH, ROOT_PATH), '', $categoryIcon);

                $valueData = array(
                    Mnews_category::TABLE_TITLE => trim($this->input->post('Title')),
                    Mnews_category::TABLE_UPDATE_AT => $currentDateTime,
                    'Thumbnail' => $imageImage,
                    'Icon' => $imageIcon
                );

                $config = array(
                    'upload_path' => IMAGE_PATH,
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'max_size' => "2048000", // 2 MB(2048 Kb)
                );

                

                if ($flag == VIEW_ACTION_ADD_NEW) {
                    $valueData[Mnews_category::TABLE_CREATE_AT] = $currentDateTime;
                }

                $id = $this->Mnews_category->insertOrUpdate($id, $valueData);
                if ($id > 0) {
                    $data['id'] = $id;
                    $data['txtSuccess'] = "News Saved";
                } else $data['txtError'] = "An error occurred in the implementation process!";
            }
            $this->load->view('admin/news/news-category', $data);
        } else redirect('index.php/admin/user');
    }
}


