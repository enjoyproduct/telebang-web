<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    
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
            $this->load->model('Mmodels');
            $data['listStatus'] = $this->Mmodels->getList('status');

            $data['listCategories'] =  $this->getVideoCategories();

            if($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
            if($this->session->flashdata('txtError')) $data['txtError'] = $this->session->flashdata('txtError');
            $this->load->view('admin/category/categorylist', $data);
        }
        else redirect('index.php/admin/user');
    }

    public function delete($categoryId = 0){
        $user = $this->session->userdata('user');
        if($user){
            if($categoryId>0){
                $this->load->model('Mcategories');
                $flag = $this->Mcategories->delete($categoryId);
                if($flag) $this->session->set_flashdata('txtSuccess', "Category has been deleted");
                else $this->session->set_flashdata('txtError', "Delete category failed");
            }
            redirect('index.php/admin/category');
        }
        else redirect('index.php/admin/user');
    }

    public function update($categoryId = 0){
        $user = $this->session->userdata('user');
        if($user){
            $data = array();
            $data['user'] = $user;
            $data['categoryId'] = $categoryId;
            $models = array('Mcategories', 'Mmodels');
            foreach($models as $model) $this->load->model($model);
            $data['listStatus'] = $this->Mmodels->getList('status');
            $data['listCategories'] = $this->Mcategories->getList(STATUS_ACTIVED);
            $data['categoryName'] = '';
            $data['parentCategoryId'] = 0;
            $data['statusId'] = STATUS_ACTIVED;
            $data['displayOrder'] =  100;
            $data['isTop'] = 0;
            $data['categoryImage'] = $data['categoryIcon'] = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
            $flag = 0;
            
            if($categoryId>0){
                $category = $this->Mcategories->get($categoryId);
                if($category){
                    $flag = 1;
                    $data['categoryName'] = $category['CategoryName'];
                    if($category['ParentCategoryId']>0) $data['parentCategoryId'] =  $category['ParentCategoryId'];
                    $data['statusId'] = $category['StatusId'];
                    $data['displayOrder'] = $category['DisplayOrder'];
                    $data['isTop'] = $category['IsTop'];
                    if(!empty($category['CategoryImage'])) $data['categoryImage'] = IMAGE_PATH.$category['CategoryImage'];
                    if(!empty($category['CategoryIcon'])) $data['categoryIcon'] = IMAGE_PATH.$category['CategoryIcon'];
                }
                else{
                    $data['txtError'] = "Category is not exist.";
                    $flag = 2;
                }
            }
            else $flag = 3;
            if($this->input->post('submit') && $flag!=2){
                $isTop = ($this->input->post('IsTop')=='on') ? 1 : 0;
                $data['isTop'] = $isTop;

                $categoryImage = trim($this->input->post('CategoryImage'));
                $data['categoryImage'] = $categoryImage;

                $categoryIcon = trim($this->input->post('CategoryIcon'));
                $data['categoryIcon'] = $categoryIcon;

                $imageImage = str_replace(array(IMAGE_PATH, ROOT_PATH), '', $categoryImage);
                $imageIcon = str_replace(array(IMAGE_PATH, ROOT_PATH), '', $categoryIcon);
                
                $valueData = array(
                    'CategoryName' => trim($this->input->post('CategoryName')),
                    'StatusId' => $this->input->post('StatusId'),
                    'IsTop' => $isTop,
                    'DisplayOrder' => $this->input->post('DisplayOrder'),
                    'CategoryImage' => $imageImage,
                    'CategoryIcon' => $imageIcon
                );
                if($this->input->post('ParentCategoryId')>0) $valueData['ParentCategoryId'] = $this->input->post('ParentCategoryId');
//                $config = array(
//                    'upload_path' => IMAGE_PATH,
//                    'allowed_types' => "gif|jpg|png|jpeg",
//                    'max_size' => "2048000", // 2 MB(2048 Kb)
//                );
                
                $categoryId = $this->Mcategories->insertOrUpdate($valueData, $categoryId);
                if($categoryId>0){
                    $data['categoryId'] = $categoryId;
                    $data['txtSuccess'] = "Category Saved";
                }
                else $data['txtError'] = "An error occurred in the implementation process!";
            }
            $this->load->view('admin/category/categoryupdate', $data);
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
}