<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends CI_Controller
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
            $data['user'] = $user;
            $models = array('Musers', 'Mmodels', 'Mseries');
            foreach ($models as $model)
                $this->load->model($model);
            $data['listSeries'] = $this->Mseries->getList();
            if ($this->session->flashdata('txtSuccess'))
                $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if ($this->session->flashdata('txtError'))
                $data['txtError'] = $this->session->flashdata('txtError');

            $this->load->view('admin/series/list', $data);
        } else
            redirect('index.php/admin/user');
    }

    public function delete($idSeries = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($idSeries > 0) {
                $this->load->model('Mseries');
                $flag = $this->Mseries->delete($idSeries);
                if ($flag)
                    $this->session->set_flashdata('txtSuccess', "Series has been deleted");
                else
                    $this->session->set_flashdata('txtError', "Delete series failed");
            }
            redirect('index.php/admin/series');
        } else
            redirect('index.php/admin/user');
    }

    public function update($id = 0)
    {
        $user = $this->session->userdata('user');
        if ($user) {
            if ($id) {
                $id = intval($id);
            }
            $this->load->model('Mseries');
            $data = array();
            $data['user'] = $user;
            $data['id'] = $id;
            $data['name'] = '';
            $data['desc'] = '';
            $data['thumbnail'] = base_url(NO_IMAGE_PATH);
            $data['isCompleted'] = 0;

            $flag = VIEW_ACTION_ERROR;
            if ($id > 0) {
                $flag = VIEW_ACTION_UPDATE;
                $item = $this->Mseries->get($id);
                if ($item) {
                    $data['name'] = $item[Mseries::TABLE_SERIES_NAME];
                    $data['desc'] = $item[Mseries::TABLE_SERIES_SHORT_DESC];
                    $data['isCompleted'] = $item[Mseries::TABLE_SERIES_COMPLETED];

                    $videoImage = $item[Mseries::TABLE_SERIES_THUMBNAIL];
                    if ($videoImage)
                        $data['thumbnail'] = base_url(IMAGE_PATH . $videoImage);

                } else {
                    $data['txtError'] = "Page is not exist.";
                    $flag = VIEW_ACTION_ERROR;
                }
            } else {
                $flag = VIEW_ACTION_ADD_NEW;
            }
            $data['flag'] = $flag;
            if ($this->input->post('submit') && $flag != VIEW_ACTION_ERROR) {
                $currentDateTime = date('Y-m-d H:i:s');
                $isCompleted = ($this->input->post('IsCompleted') == 'on') ? 1 : 0;
                $data['isCompleted'] = $isCompleted;

                $thumbnailSeries = trim($this->input->post('VideoImageFetch'));
                $data['thumbnail'] = $thumbnailSeries;
                $imageName = basename($thumbnailSeries);

                $valueData = array(
                    Mseries::TABLE_SERIES_NAME => trim($this->input->post('name')),
                    Mseries::TABLE_SERIES_SHORT_DESC => trim($this->input->post('desc')),
                    Mseries::TABLE_SERIES_UPDATED_AT => $currentDateTime,
                    Mseries::TABLE_SERIES_COMPLETED => $isCompleted,
                    Mseries::TABLE_SERIES_THUMBNAIL => $imageName,
                );

                if ($flag == VIEW_ACTION_ADD_NEW) {
                    $valueData[Mseries::TABLE_SERIES_CREATED_AT] = $currentDateTime;
                }
                $id = $this->Mseries->insertOrUpdate($id, $valueData);
                if ($id > 0) {
                    $data['id'] = $id;
                    $data['txtSuccess'] = "Series Saved";
                } else {
                    $data['txtError'] = "An error occurred in the implementation process!";
                }
            }
            $this->load->view('admin/series/create', $data);
        } else {
            redirect('index.php/admin/user');
        }
        return true;
    }

    public function getVideoCategories()
    {
        $this->load->model('Mcategories');
        $listCategories = $this->Mcategories->getList();

        $cats = array();
        $parents = array();
        foreach ($listCategories as $a) {
            $cats[$a['ParentCategoryId']][] = $a;

            if (!$a['ParentCategoryId'])
                $parents[] = $a;
        }

        $tree = array();
        $newList = $this->createCategoryTree($cats, $parents, "", $tree);

        return $newList;
    }

    private function createCategoryTree(&$list, $parent, $level = "", &$tree)
    {
        foreach ($parent as $k => $l) {
            $l['level'] = $level;
            $tree[] = $l;
            if (isset($list[$l['CategoryId']])) {
                $lv = $level . " - ";
                $this->createCategoryTree($list, $list[$l['CategoryId']], $lv, $tree);
            }
        }
        return $tree;
    }

    public function listVideoBySeriesId($seriesId)
    {
        redirect('index.php/admin/video/listVideoBySeriesId/' . $seriesId);
        return true;
    }

    public function createVideoForSeriesId($seriesId)
    {
        redirect('index.php/admin/video/createVideoForSeriesId/' . $seriesId);
        return true;
    }
}

