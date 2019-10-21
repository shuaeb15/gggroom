<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Service extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
    }
    /**
     * index function.
     *
     * @access public
     * @return void
     */
    public function index() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          $role_id =  $admin_data[0]['id'];
          $user_promotion =  $admin_data[0]['user_promotion'];

          if ($this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 1, 'is_deleted' => 0), 'result_array')) {
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 1, 'is_deleted' => 0), 'result_array');
          }else{
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 5, 'is_deleted' => 0), 'result_array');
          }
          $this->data['user_access_data'] = $user_access_data;

          $service_list = $this->general_model->get_services_data_by_category('services', array());
          foreach ($service_list as $key => $service) {
            $var =  $this->url_encrypt($service->id);
            $service_list[$key]->encrypt_id = $var;
          }

          foreach ($service_list as $key => $value) {

            if($value->parent_id != 0){
              $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
              $service_list[$key]->sub_category = $cat_list1;
              if($cat_list1->cat_parent_id != 0){
                $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
                if(!empty($cat_list2)){
                    $service_list[$key]->und_sub_category = $cat_list2;
                }
                else{
                    $service_list[$key]->und_sub_category = '';
                }
              }
            }
            // echo '<pre>';print_r($service_list);exit;
              if($value->user_id != 0){
                $user_list = $this->general_model->get_user_by_service( 'user', array('id' => $value->user_id));
                $service_list[$key]->user = $user_list;
              }
              if($value->shop_id != 0){
                  $user_list = $this->general_model->get_shop_by_service( 'shop', array('id' => $value->shop_id));
                  $service_list[$key]->shop = $user_list;
              }
              if($value->worker_id != 0){
                  $worker =  explode(',', $value->worker_id);
                  foreach ($worker as $key1 => $item) {
                    $worker_list = $this->general_model->get_service_by_service( 'workers', array('id' => $item));
                    $worker[$key1] = $worker_list->name;
                  }
                  $all_worker = implode(", ",$worker);
                  $service_list[$key]->worker = $all_worker;
            }
          }
          $this->data['service_list'] = $service_list;
          if($user_promotion != 3){
              $this->render('service_view');
          }else{
              redirect('dashboard', 'refresh');
          }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function active_user_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];
          $data = array(
            'is_active' => 1,
            'is_deleted' => 0
          );
          $update_id = $this->general_model->active_shop($data, 'services', array('id' => $sid));
          if (isset($update_id)) {
              $data['success'] = 'success';
              $data['id'] = $sid;
              echo json_encode($data);
              exit;
          }
      } else {
          $data['unsuccess'] = 'unsuccess';
          echo json_encode($data);
          exit;
      }
    }

    public function inactive_user_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];
          $data = array(
            'is_active' => 0,
            'is_deleted' => 1
          );
          $update_id = $this->general_model->inactive_shop($data, 'services', array('id' => $sid));
          if (isset($update_id)) {
              $data['success'] = 'success';
              $data['id'] = $sid;
              echo json_encode($data);
              exit;
          }
      } else {
          $data['unsuccess'] = 'unsuccess';
          echo json_encode($data);
          exit;
      }
    }

    public function service_info($id1) {

      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;
        $role_id =  $admin_data[0]['id'];
        $user_promotion =  $admin_data[0]['user_promotion'];

        $id1 = $this->url_decrypt($id1);
          if ($id1 != '') {
              $service_data = $this->general_model->get_services_data('services.*', 'services', array('id' => $id1));
              foreach ($service_data as $key => $value) {

                if($value->parent_id != 0){
                  $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
                  $service_data[$key]->sub_category = $cat_list1;
                  if($cat_list1->cat_parent_id != 0){
                    $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
                    if(!empty($cat_list2)){
                        $service_data[$key]->und_sub_category = $cat_list2;
                    }
                    else{
                        $service_data[$key]->und_sub_category = '';
                    }
                  }
                }
                // echo '<pre>';print_r($value);exit;
              if($value->shop_id != 0){
                  $user_list = $this->general_model->get_shop_by_service( 'shop', array('id' => $value->shop_id));
                  $service_data[$key]->shop = $user_list;
                }
                if($value->worker_id != 0){
                  $worker =  explode(',', $value->worker_id);
                  foreach ($worker as $key1 => $item) {
                    $worker_list = $this->general_model->get_service_by_service( 'workers', array('id' => $item));
                    $worker[$key1] = $worker_list->name;
                  }
                  $all_worker = implode(", ",$worker);
                  $service_data[$key]->worker = $all_worker;
                }
              }
              $this->data['service_data'] = $service_data;
              if($user_promotion != 3){
                  $this->render('service_info_view');
              }else{
                  redirect('dashboard', 'refresh');
              }
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('service', 'refresh');
          }
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function edit_service($id1) {
      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;
        $role_id =  $admin_data[0]['id'];
        $user_promotion =  $admin_data[0]['user_promotion'];

          $id1 = $this->url_decrypt($id1);
          if ($id1 != '') {
            $service_data = $this->general_model->get_services_data_id('*', 'services', array('id' => $id1));
            $var =  $this->url_encrypt($service_data->id);
            $service_data->encrypt_id = $var;

            $user_id = $service_data->user_id;
            $shop_list = $this->general_model->get_shop_data_by_service('*', 'shop', array('user_id' => $user_id, 'is_deleted' => 0));
            $this->data['shoplist'] = $shop_list;

            $worker_list = $this->general_model->get_worker_data1('workers', 'workers.shop_id = "'.$service_data->shop_id.'" AND workers.user_id = "'.$user_id.'" AND workers.is_deleted = "0"');
            $this->data['worker_list'] = $worker_list;

            $category_list = $this->general_model->get_shop_data_by_cat('*', 'category', array('flag' => 0, 'is_deleted' => 0));

            $cate_id = $service_data->cat_id;
            if($cate_id != ''){
              $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $cate_id));
              if($cat_list1->cat_parent_id != 0){
                $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
                  if($cat_list2->cat_parent_id != 0){
                      $cat_list3 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list2->cat_parent_id));
                  }
              }
            }
            if($cat_list1->cat_parent_id == 0){
              $parent_cat = $cat_list1->category_id;
              $sub_cat = '';
              $child_sub_cat = '';
            }else if($cat_list2->cat_parent_id == 0){
              $parent_cat = $cat_list2->category_id;
              $sub_cat = $cat_list1->category_id;
              $child_sub_cat = '';
            }else if($cat_list3->cat_parent_id == 0){
              $parent_cat = $cat_list3->category_id;
              $sub_cat = $cat_list2->category_id;
              $child_sub_cat = $cat_list1->category_id;
            }

            $service_data->main_sub_cat_id = $parent_cat;
            $service_data->sub_cat_id = $sub_cat;
            $service_data->und_sub_cat_id = $child_sub_cat;

            $sub_cat_list = $this->general_model->get_all_general_data1('*', 'category', array('flag' => 1, 'parent_id' => $parent_cat,'is_deleted' => 0));
            $this->data['sub_cat_list'] = $sub_cat_list;

            $und_cat_list = $this->general_model->get_all_general_data1('*', 'category', array('flag' => 2, 'parent_id' => $sub_cat,'is_deleted' => 0));
            $this->data['und_cat_list'] = $und_cat_list;

            $this->data['category_list'] = $category_list;
            $this->data['service_data'] = $service_data;

            if($user_promotion != 3){
                  $this->render('edit_service_view');
            }else{
                redirect('dashboard', 'refresh');
            }
          }else{
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('shop', 'refresh');
          }
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function update_service() {
      if (!$this->session->userdata('admin_id')) {
        $this->session->set_flashdata('error_message', "Something wents wrong!");
        redirect('service', 'refresh');
      }
      else{
          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');

                $service_id = $this->input->post('service_id');
                $main_category = $this->input->post('parent_category');
                $sub_category = $this->input->post('sub_category');
                $und_sub_category = $this->input->post('und_sub_category');
                $service_type = $this->input->post('radiog_dark_service_type');
                if(empty($service_type)){
                  $service_type = '';
                }
                else{
                  $service_type = $service_type;
                }

                $shop_type = $this->input->post('radiog_list_detail');
                $service_price = $this->input->post('range-price');
                $service_time = $this->input->post('range-time');

                $worker = $this->input->post('radiog_list_worker_time[]');
                if(!empty($worker)){
                      $worker_id = implode(",",$worker);
                }else{
                  $worker_id = '';
                }

                $cat = $main_category.','.$sub_category.','.$und_sub_category;
                if($und_sub_category != ''){
                  $cat_id = $und_sub_category;
                  $cat_name_get = $this->general_model->get_category_name1('cat_name','category', array('category_id' => $und_sub_category));
                }else{
                  $cat_id = $sub_category;
                  $cat_name_get = $this->general_model->get_category_name1('cat_name','category', array('category_id' => $sub_category));
                }

              $cat_name = $cat_name_get->cat_name;
              // echo $_FILES['imgupload1']['name'];exit;
              $image = $this->upload_shop_Image($_FILES['imgupload1']['name'], 'imgupload1', 'service_image', $service_id);
              // echo '<pre>';print_r($image);exit;
                $data = array(
                    // 'user_id' => $uid,
                    'worker_id' => $worker_id,
                    'service_name' => $cat_name,
                    'cat_id' => $cat_id,
                    'type' => $service_type,
                    'shop_id' => $shop_type,
                    'price' => $service_price,
                    'time' => $service_time,
                    'image' => $image,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );

                $updated_id = $this->general_model->update_all_services($data, 'services', array('id' => $service_id));
                // echo '<pre>';print_r($updated_id);exit;
                  if($service_id){
                    $this->session->set_flashdata('success_message', "Service updated successfully");
                    redirect('service', 'refresh');
                  }else{
                     $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                     redirect('service', 'refresh');
                    }

          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('service', 'refresh');
          }
      }
    }

    public function upload_shop_Image($path, $imagename, $upload_path, $service_id){
      $this->load->library('upload');
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);

      if($ext !='')
      {
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $temp_name = $randomString.'.'.$ext;
      }
      else {
          $temp_name = '';
      }
      $config = array();
      $config['upload_path']          = FCPATH.'../assets/uploads/'.$upload_path.'/';
      $config['file_name'] 						= $temp_name;
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        $this->db->select('image');
        $this->db->from('services');
        $this->db->where('id',$service_id);
        $count = $this->db->get()->row();
        // echo '<pre>';print_r($count);exit;
        $img = $count->image;
        $path = '../assets/uploads/'.$upload_path.'/'.$img;
        unlink($path);
        return $temp_name;
      }else{
        $this->db->select('image');
        $this->db->from('services');
        $this->db->where('id',$service_id);
        $count = $this->db->get()->row();
        return $count->image;
      }
    }

    public function GetShopWorkerData()
    {
      if($this->input->post())
      {
        $shopid = $this->input->post('shopid');
        $shop_list = $this->general_model->get_shop_data_by_service('user_id', 'shop', array('id' => $shopid));
        if(!empty($shopid))
        {
          $WorkersData = $this->general_model->get_all_general_data1('*', 'workers', array('user_id' => $shop_list[0]->user_id, 'shop_id' => $shopid,'is_deleted' => 0));

          $j=100;
          $workerHtml = '';

          foreach ($WorkersData as $key => $worker)
          {
            $workerHtml .= '<div class="col-md-7 cls_md_7"><div class="radio_list_item"><div class="col-md-10 cls_md_10"><label class="cls_label_list"><p>'.$worker['name'].'</p></label></div>
            <div class="col-md-2"><input type="checkbox" name="radiog_list_worker_time[]" id="radio'.$j.'" value="'.$worker['id'].'" class="cls_worker_lable"/></div></div></div>';
            $j++;
          }

          if(!empty($workerHtml))
          {
            echo $workerHtml;exit;
          }
          else
          {
            echo "No Worker for selected shop";exit;
          }
        }
      }
    }

    public function get_sub_cat()
    {
      if($this->input->post())
      {
        $parent_id = $this->input->post('parent_id');
        $WorkersData = $this->general_model->get_all_general_data1('*', 'category', array('flag' => 1, 'parent_id' => $parent_id,'is_deleted' => 0));

        $workerHtml = '';
        $j = 0;
        $workerHtml = '<option value="">select</option>';
        foreach ($WorkersData as $key => $worker)
        {
          $workerHtml .= '<option value="'.$worker['category_id'].'">'.$worker['cat_name'].'</option>';
          $j++;
        }
        echo $workerHtml;exit;
      }
    }

    public function get_und_sub_cat()
    {
      if($this->input->post())
      {
        $sub_id = $this->input->post('sub_id');
        $WorkersData = $this->general_model->get_all_general_data1('*', 'category', array('flag' => 2, 'parent_id' => $sub_id,'is_deleted' => 0));

        $workerHtml = '';
        $j = 0;
        $workerHtml = '<label class="control-label1 col-xs-12" for="product">Sub category</label><br><div class="col-xs-7"><select class="cat_id form-control" name="und_sub_category" id="und_sub_category"><option value="">select</option>';
        foreach ($WorkersData as $key => $worker)
        {
          $workerHtml .= '<option value="'.$worker['category_id'].'">'.$worker['cat_name'].'</option>';
          $j++;
        }
        $workerHtml .= '</select></div>';
        echo $workerHtml;exit;
      }
    }
  }
