<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Category extends Admin_Controller {
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

          $f_result = $this->general_model->get_category( 'category', array('is_deleted' => 0, 'parent_id' => 0));

          foreach ($f_result as $key => $value) {
            if($value->parent_id != 0 && $value->flag == 1){
                $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                $f_result[$key]->sub_category = $cat_list1;
                $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $value->parent_id,'is_deleted'=>0));
                $f_result[$key]->parent_category = $cat_list2;
                $data1 = new stdClass;
                $data1->cat_name = '-';
                $f_result[$key]->child_category = $data1;
              }
              else if($value->parent_id != 0 && $value->flag == 2){
                  $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                  $f_result[$key]->child_category = $cat_list1;
                  $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $cat_list1->parent_id,'is_deleted'=>0));
                  $f_result[$key]->sub_category = $cat_list2;
                  $cat_list3 = $this->general_model->get_category_name( 'category', array('category_id' => $cat_list2->parent_id,'is_deleted'=>0));
                  $f_result[$key]->parent_category = $cat_list3;
                }
                else if($value->parent_id == 0 && $value->flag == 0){
                    $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                    $f_result[$key]->parent_category = $cat_list1;
                    $data1 = new stdClass;
                    $data1->cat_name = '-';
                    $f_result[$key]->sub_category = $data1;
                    $f_result[$key]->child_category = $data1;
                  }
          }
          // echo '<pre>';print_r($f_result);exit;
          $this->data['category_list'] = $f_result;
            $this->render('category_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    /**
     * subcategory function.
     *
     * @access public
     * @return void
     */
    public function subcategory() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $f_result = $this->general_model->get_category( 'category', array('is_deleted' => 0, 'parent_id !=' => 0));

          foreach ($f_result as $key => $value) {
            if($value->parent_id != 0 && $value->flag == 1){
                $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                $f_result[$key]->sub_category = $cat_list1;
                $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $value->parent_id,'is_deleted'=>0));
                $f_result[$key]->parent_category = $cat_list2;
                $data1 = new stdClass;
                $data1->cat_name = '-';
                $f_result[$key]->child_category = $data1;
              }
              else if($value->parent_id != 0 && $value->flag == 2){
                  $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                  $f_result[$key]->child_category = $cat_list1;
                  $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $cat_list1->parent_id,'is_deleted'=>0));
                  $f_result[$key]->sub_category = $cat_list2;
                  $cat_list3 = $this->general_model->get_category_name( 'category', array('category_id' => @$cat_list2->parent_id,'is_deleted'=>0));
                  $f_result[$key]->parent_category = $cat_list3;
                }
                else if($value->parent_id == 0 && $value->flag == 0){
                    $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                    $f_result[$key]->parent_category = $cat_list1;
                    $data1 = new stdClass;
                    $data1->cat_name = '-';
                    $f_result[$key]->sub_category = $data1;
                    $f_result[$key]->child_category = $data1;
                  }
          }
          // echo '<pre>';print_r($f_result);exit;
          $this->data['category_list'] = $f_result;
            $this->render('sub_category_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    /**
     * subcategory function.
     *
     * @access public
     * @return void
     */
    public function childcategory() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $f_result = $this->general_model->get_category( 'category', array('is_deleted' => 0));

          foreach ($f_result as $key => $value) {
            if($value->parent_id != 0 && $value->flag == 1){
                $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                $f_result[$key]->sub_category = $cat_list1;
                $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $value->parent_id,'is_deleted'=>0));
                $f_result[$key]->parent_category = $cat_list2;
                $data1 = new stdClass;
                $data1->cat_name = '-';
                $f_result[$key]->child_category = $data1;
              }
              else if($value->parent_id != 0 && $value->flag == 2){
                  $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                  $f_result[$key]->child_category = $cat_list1;
                  $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $cat_list1->parent_id,'is_deleted'=>0));
                  $f_result[$key]->sub_category = $cat_list2;
                  $cat_list3 = $this->general_model->get_category_name( 'category', array('category_id' => @$cat_list2->parent_id,'is_deleted'=>0));
                  $f_result[$key]->parent_category = @$cat_list3;
                }
                else if($value->parent_id == 0 && $value->flag == 0){
                    $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id,'is_deleted'=>0));
                    $f_result[$key]->parent_category = $cat_list1;
                    $data1 = new stdClass;
                    $data1->cat_name = '-';
                    $f_result[$key]->sub_category = $data1;
                    $f_result[$key]->child_category = $data1;
                  }
          }
          // echo '<pre>';print_r($f_result);exit;
          $this->data['category_list'] = $f_result;
            $this->render('child_category_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    // public function get_categories()
    // {
    //   $draw = intval($this->input->get("draw"));
    //   $start = intval($this->input->get("start"));
    //   $length = intval($this->input->get("length"));
    //
    //   // $this->db->where('is_deleted', '0');
    //   $this->db->where('is_deleted', '0');
    //   $this->db->order_by('category_id', 'desc');
    //   $query = $this->db->get("category");
    //   $f_result = $query->result();
    //
    //
    //   // echo $this->db->last_query();exit;
    //   foreach ($f_result as $key => $value) {
    //     if($value->parent_id != 0 && $value->flag == 1){
    //         $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id));
    //         $f_result[$key]->sub_category = $cat_list1;
    //         $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $value->parent_id));
    //         $f_result[$key]->parent_category = $cat_list2;
    //         $data1 = new stdClass;
    //         $data1->cat_name = '-';
    //         $f_result[$key]->child_category = $data1;
    //       }
    //       else if($value->parent_id != 0 && $value->flag == 2){
    //           $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id));
    //           $f_result[$key]->child_category = $cat_list1;
    //           $cat_list2 = $this->general_model->get_category_name( 'category', array('category_id' => $cat_list1->parent_id));
    //           $f_result[$key]->sub_category = $cat_list2;
    //           $cat_list3 = $this->general_model->get_category_name( 'category', array('category_id' => $cat_list2->parent_id));
    //           $f_result[$key]->parent_category = $cat_list3;
    //         }
    //         else if($value->parent_id == 0 && $value->flag == 0){
    //             $cat_list1 = $this->general_model->get_category_name( 'category', array('category_id' => $value->category_id));
    //             $f_result[$key]->parent_category = $cat_list1;
    //             $data1 = new stdClass;
    //             $data1->cat_name = '-';
    //             $f_result[$key]->sub_category = $data1;
    //             $f_result[$key]->child_category = $data1;
    //           }
    //   }
    //   // echo '<pre>';print_r($f_result);exit;
    //   // echo '<pre>';print_r($f_result);exit;
    //
    //   // foreach ($f_result as $key => $value) {
    //   //     $u_id = $f_result[$key]->category_id;
    //   //     $f_result[$key]->action = '<a href='. site_url("category/edit_category/$u_id").'><i class="fa fa-pencil"></i></a><a href="javascript:void(0)" onclick="CategoryConfirmDelete('.$u_id.')" data-original-title="View" id=".$u_id." data-toggle="tooltip"><i class="fa fa-remove"></i></a>';
    //   // }
    //
    //   // $data = [];
    //
    //   // foreach($f_result as $r) {
    //   //      $data[] = array(
    //   //           $r->parent_category->cat_name,
    //   //           $r->sub_category->cat_name,
    //   //           $r->child_category->cat_name,
    //   //           $r->action,
    //   //      );
    //   // }
    //
    //   // $result = array(
    //   //          "draw" => $draw,
    //   //            "recordsTotal" => $query->num_rows(),
    //   //            "recordsFiltered" => $query->num_rows(),
    //   //            "data" => $data
    //   //       );
    //
    //   // echo json_encode($f_result);
    //   exit();
    // }

    public function add_category() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $parent_cat_list = $this->general_model->get_parent_category_list('*', 'category', array('parent_id' =>  '0', 'flag' =>  '0', 'is_deleted' =>  '0'));
          $this->data['parent_cat_list'] = $parent_cat_list;

          $this->render('add_category_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function add_sub_category() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $parent_cat_list = $this->general_model->get_parent_category_list('*', 'category', array('parent_id' =>  '0', 'flag' =>  '0', 'is_deleted' =>  '0'));
          $this->data['parent_cat_list'] = $parent_cat_list;

          $this->render('add_subcategory_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function add_child_category() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $parent_cat_list = $this->general_model->get_parent_category_list('*', 'category', array('parent_id' =>  '0', 'flag' =>  '0', 'is_deleted' =>  '0'));
          $this->data['parent_cat_list'] = $parent_cat_list;

          $this->render('add_childcategory_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function get_parent_category() {
      $parent_cat_id = $this->input->post('parent_category');
      $parent_cat_list = $this->general_model->get_parent_category_list('*', 'category', array('parent_id' =>  $parent_cat_id, 'flag' =>  '1','is_deleted'=>0));
      echo json_encode($parent_cat_list);
    }

    public function insert_category() {
        if ($this->session->userdata('admin_id')) {
              $this->load->helper('form','url');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('category_name', 'Category name', 'required');
              if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error_message', "Please fill required fields.");
                $this->session->set_userdata('CATEGORY_DETAIL', $_POST);
                redirect('category/add_category', 'refresh');
              } else {
                $uid = $this->session->userdata('admin_id');
                $category_name = $this->input->post('category_name');
                $service_name = $this->input->post('parent_category');
                $sub_category = $this->input->post('sub_category');

                $cat = $this->general_model->check_exist_data('category_id', 'category', array('cat_name' => $category_name, 'parent_id' => 0, 'flag' => 0));
                if(!empty($cat)){
                  $this->session->set_flashdata('error_message', "Category already exist.");
                  redirect('category/add_category', 'refresh');
                }
                else{

                  $parent_id = '0';
                  $flag = '0';

                  $data = array(
                      'cat_name' => $category_name,
                      'parent_id' => $parent_id,
                      'flag' => $flag,
                      'user_id' => $uid,
                      'permission' => 1,
                      'flag_user_admin' => 2,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );

                  $inserted_id = $this->general_model->insert_category($data, 'category');
                  if($inserted_id){
                      $this->session->set_flashdata('success_message', "Category added successfully");
                      redirect('category', 'refresh');
                    }else{
                      $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                      redirect('category', 'refresh');
                    }
                }

            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function insert_sub_category() {
        if ($this->session->userdata('admin_id')) {
              $this->load->helper('form','url');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('category_name', 'Category name', 'required');
              if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error_message', "Please fill required fields.");
                $this->session->set_userdata('CATEGORY_DETAIL', $_POST);
                redirect('category/add_sub_category', 'refresh');
              } else {
                $uid = $this->session->userdata('admin_id');
                $category_name = $this->input->post('category_name');
                $service_name = $this->input->post('parent_category');

                $cat = $this->general_model->check_exist_data('category_id', 'category', array('cat_name' => $category_name, 'parent_id' => $service_name, 'flag' => 1));
                if(!empty($cat)){
                  $this->session->set_flashdata('error_message', "Category already exist.");
                  redirect('category/add_sub_category', 'refresh');
                }
                else{
                  $parent_id = $service_name;
                  $flag = '1';
                  $data = array(
                      'cat_name' => $category_name,
                      'parent_id' => $parent_id,
                      'flag' => $flag,
                      'user_id' => $uid,
                      'permission' => 1,
                      'flag_user_admin' => 2,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );

                  $inserted_id = $this->general_model->insert_category($data, 'category');
                  if($inserted_id){
                      $this->session->set_flashdata('success_message', "Category added successfully");
                      redirect('category/subcategory', 'refresh');
                    }else{
                      $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                      redirect('category/subcategory', 'refresh');
                    }
                }

            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function insert_child_category() {
        if ($this->session->userdata('admin_id')) {
              $this->load->helper('form','url');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('category_name', 'Category name', 'required');
              if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error_message', "Please fill required fields.");
                $this->session->set_userdata('CATEGORY_DETAIL', $_POST);
                redirect('category/add_child_category', 'refresh');
              } else {
                $uid = $this->session->userdata('admin_id');
                $category_name = $this->input->post('category_name');
                $service_name = $this->input->post('parent_category');
                $sub_category = $this->input->post('sub_category');
                $cat = $this->general_model->check_exist_data('category_id', 'category', array('cat_name' => $category_name,  'parent_id' => $sub_category, 'flag' => 2));
                if(!empty($cat)){
                  $this->session->set_flashdata('error_message', "Category already exist.");
                  redirect('category/add_child_category', 'refresh');
                }
                else{
                  $parent_id = $sub_category;
                  $flag = '2';
                  $data = array(
                      'cat_name' => $category_name,
                      'parent_id' => $parent_id,
                      'flag' => $flag,
                      'user_id' => $uid,
                      'permission' => 1,
                      'flag_user_admin' => 2,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );

                  $inserted_id = $this->general_model->insert_category($data, 'category');
                  if($inserted_id){
                      $this->session->set_flashdata('success_message', "Category added successfully");
                      redirect('category/childcategory', 'refresh');
                    }else{
                      $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                      redirect('category/childcategory', 'refresh');
                    }
                }

            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_category($id) {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($id != '') {
                $cat_data = $this->general_model->get_category_all_data_list('*', 'category', array('category_id' => $id));
                $this->data['category_list'] = $cat_data;

                if($cat_data->parent_id != 0 && $cat_data->flag == 1){
                  $parent_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => 0, 'flag' => 0));
                  $this->data['parent_category_list'] = $parent_cat_list;
                  $this->data['parent_category_id'] = $cat_data->parent_id;
                }
                if($cat_data->parent_id != 0 && $cat_data->flag == 2){
                  $parent_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => 0, 'flag' => 0));
                  $this->data['parent_category_list'] = $parent_cat_list;

                  $parent_cat_list1 = $this->general_model->get_category_all_data_list('*', 'category', array('category_id' => $cat_data->parent_id, 'flag' => 1));
                  $parent_category = $parent_cat_list1->parent_id;
                  $this->data['parent_category_id'] = $parent_category;
                  $this->data['sub_category_id'] = $parent_cat_list1->category_id;

                  $sub_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => $parent_category, 'flag' => 1));
                  $this->data['sub_category_list'] = $sub_cat_list;
                }
                $this->render('edit_category_view');
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('category', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_sub_category($id) {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($id != '') {
                $cat_data = $this->general_model->get_category_all_data_list('*', 'category', array('category_id' => $id));
                $this->data['category_list'] = $cat_data;

                $parent_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => 0, 'flag' => 0, 'is_deleted'=>0));
                $this->data['parent_category_list'] = $parent_cat_list;
                $this->data['parent_category_id'] = $cat_data->parent_id;
                $this->render('edit_subcategory_view');
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('category/subcategory', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_child_category($id) {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($id != '') {
                $cat_data = $this->general_model->get_category_all_data_list('*', 'category', array('category_id' => $id));
                $this->data['category_list'] = $cat_data;

                if($cat_data->parent_id != 0 && $cat_data->flag == 1){
                  $parent_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => 0, 'flag' => 0, 'is_deleted'=> 0));
                  $this->data['parent_category_list'] = $parent_cat_list;
                  $this->data['parent_category_id'] = $cat_data->parent_id;
                }
                if($cat_data->parent_id != 0 && $cat_data->flag == 2){
                  $parent_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => 0, 'flag' => 0, 'is_deleted'=> 0));
                  $this->data['parent_category_list'] = $parent_cat_list;

                  $parent_cat_list1 = $this->general_model->get_category_all_data_list('*', 'category', array('category_id' => $cat_data->parent_id, 'flag' => 1, 'is_deleted'=> 0));
                  $parent_category = $parent_cat_list1->parent_id;
                  $this->data['parent_category_id'] = $parent_category;
                  $this->data['sub_category_id'] = $parent_cat_list1->category_id;

                  $sub_cat_list = $this->general_model->get_category_all_data_list1('*', 'category', array('parent_id' => $parent_category, 'flag' => 1, 'is_deleted'=> 0));
                  $this->data['sub_category_list'] = $sub_cat_list;
                }
                $this->render('edit_childcategory_view');
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('category/childcategory', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function update_category() {
      if ($this->session->userdata('admin_id')) {
            $this->load->helper('form','url');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_name', 'Category name', 'required');
            if ($this->form_validation->run() == false) {
              $this->session->set_flashdata('error_message', "Please fill required fields.");
              $this->session->set_userdata('CATEGORY_DETAIL', $_POST);
              redirect('category/add_category', 'refresh');
            } else {

              $category_main_id = $this->input->post('category_main_id');
              $category_name = $this->input->post('category_name');
              /*$service_name = $this->input->post('parent_category');
              $sub_category = $this->input->post('sub_category');*/

                $parent_id = '0';
                $flag = '0';

                $data = array(
                    'cat_name' => $category_name,
                    'parent_id' => $parent_id,
                    'flag' => $flag,
                );

                $updated_id = $this->general_model->update_category_data($data, 'category', array('category_id' => $category_main_id));
                // echo $updated_id;exit;
                if($updated_id == 0 || $updated_id == 1){
                    $this->session->set_flashdata('success_message', "Category update successfully");
                    redirect('category', 'refresh');
                  }else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('category', 'refresh');
                  }
          }
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function update_sub_category() {
      if ($this->session->userdata('admin_id')) {
            $this->load->helper('form','url');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_name', 'Category name', 'required');
            if ($this->form_validation->run() == false) {
              $this->session->set_flashdata('error_message', "Please fill required fields.");
              $this->session->set_userdata('CATEGORY_DETAIL', $_POST);
              redirect('category/add_sub_category', 'refresh');
            } else {

              $category_main_id = $this->input->post('category_main_id');
              $category_name = $this->input->post('category_name');
              $service_name = $this->input->post('parent_category');
              $parent_id = $service_name;
              $flag = '1';

              $data = array(
                  'cat_name' => $category_name,
                  'parent_id' => $parent_id,
                  'flag' => $flag,
              );

              $updated_id = $this->general_model->update_category_data($data, 'category', array('category_id' => $category_main_id));
              // echo $updated_id;exit;
              if($updated_id == 0 || $updated_id == 1){
                  $this->session->set_flashdata('success_message', "Category update successfully");
                  redirect('category/subcategory', 'refresh');
                }else{
                  $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                  redirect('category/subcategory', 'refresh');
                }
          }
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function update_child_category() {
      if ($this->session->userdata('admin_id')) {
            $this->load->helper('form','url');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_name', 'Category name', 'required');
            if ($this->form_validation->run() == false) {
              $this->session->set_flashdata('error_message', "Please fill required fields.");
              $this->session->set_userdata('CATEGORY_DETAIL', $_POST);
              redirect('category/add_child_category', 'refresh');
            } else {

              $category_main_id = $this->input->post('category_main_id');
              $category_name = $this->input->post('category_name');
              $service_name = $this->input->post('parent_category');
              $sub_category = $this->input->post('sub_category');
              $parent_id = $sub_category;
              $flag = '2';
              $data = array(
                  'cat_name' => $category_name,
                  'parent_id' => $parent_id,
                  'flag' => $flag,
              );

              $updated_id = $this->general_model->update_category_data($data, 'category', array('category_id' => $category_main_id));
              // echo $updated_id;exit;
              if($updated_id == 0 || $updated_id == 1){
                  $this->session->set_flashdata('success_message', "Category update successfully");
                  redirect('category/childcategory', 'refresh');
                }else{
                  $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                  redirect('category/childcategory', 'refresh');
                }
          }
      } else {
          redirect('Login', 'refresh');
      }
    }


    public function Delete_category() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];
        $data = array(
          'is_deleted' => 1
        );
        $all_data = $this->general_model->check_subcat_data('*', 'category', array('parent_id' => $sid, 'flag' => 1, 'is_deleted' => 0));
        if(count($all_data) != '0'){
            $data['norecord'] = 'norecord';
            echo json_encode($data);
            exit;
        }else{
          $update_id = $this->general_model->delete_category($data, 'category', array('category_id' => $sid));
          if (isset($update_id)) {
             $data['success'] = 'success';
             $data['id'] = $sid;
             echo json_encode($data);
             exit;
          }
          else{
            $data['unsuccess'] = 'unsuccess';
            echo json_encode($data);
            exit;
          }
        }
    }
  }

  public function Delete_sub_category() {
    $data = array();
    if ($_POST['id'] != '') {
      $sid = $_POST['id'];
      $data = array(
        'is_deleted' => 1
      );
      $all_data = $this->general_model->check_subcat_data('*', 'category', array('parent_id' => $sid, 'flag' => 2, 'is_deleted' => 0));
      if(count($all_data) != '0'){
          $data['norecord'] = 'norecord';
          echo json_encode($data);
          exit;
      }else{
        $update_id = $this->general_model->delete_category($data, 'category', array('category_id' => $sid));
        if (isset($update_id)) {
           $data['success'] = 'success';
           $data['id'] = $sid;
           echo json_encode($data);
           exit;
        }
        else{
          $data['unsuccess'] = 'unsuccess';
          echo json_encode($data);
          exit;
        }
      }
    }
  }

  public function Delete_child_category() {
    $data = array();
    if ($_POST['id'] != '') {
      $sid = $_POST['id'];
      $data = array(
        'is_deleted' => 1
      );
      $update_id = $this->general_model->delete_category($data, 'category', array('category_id' => $sid));
      if (isset($update_id)) {
         $data['success'] = 'success';
         $data['id'] = $sid;
         echo json_encode($data);
         exit;
      }
      else{
        $data['unsuccess'] = 'unsuccess';
        echo json_encode($data);
        exit;
      }
    }
  }

  public function private_category() {
    $data = array();
    if ($_POST['id'] != '') {
      $sid = $_POST['id'];
      $flag = $_POST['flag'];
      if($flag == 1){
        $data = array(
          'permission' => 1
        );
      }else if($flag == 2){
        $data = array(
          'permission' => 2
        );
      }

        $update_id = $this->general_model->delete_category($data, 'category', array('category_id' => $sid));

        if (isset($update_id)) {
           $data['success'] = 'success';
           $data['id'] = $sid;
           echo json_encode($data);
           exit;
        }
        else{
          $data['unsuccess'] = 'unsuccess';
          echo json_encode($data);
          exit;
        }
  }
}
}
