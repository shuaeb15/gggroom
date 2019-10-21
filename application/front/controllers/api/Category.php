<?php

   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Category extends REST_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
        $this->load->library('form_validation');
    }



    /**
     * index function.
     *
     * @access public
     * @return void
     */
    public function index() {

      
      
        $id = $this->input->post('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
            $parent_category = $this->general_model->get_category( 'category', array('is_deleted' => 0, 'parent_id' => 0, 'flag' => 0));
            $this->data['parent_category'] = $parent_category;

           
        }else{
          redirect('profile', 'refresh');
       }
    
  }
    public function add_services_post() {
     
        $id = $this->input->post('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;
        

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if ($this->input->post()) {

              $uid = $this->input->post('uid');
              $parent_category = $this->input->post('parent_category');
              $add_parent_category = $this->input->post('add_parent_category');
              $sub_category = $this->input->post('sub_category');
              $add_sub_category = $this->input->post('add_sub_category');
              $child_category = $this->input->post('child_category');
              $add_child_category = $this->input->post('service_name');
              $permission = '2';

              if($parent_category != '' && $sub_category != '' && $child_category != ''){
                $all_cat = '';
              }else if($parent_category != '' && $sub_category != '' && $add_parent_category == '' && $add_sub_category == '' && $child_category == '' && $add_child_category == ''){
                $check_sub_cat = $this->general_model->get_category_name('*','category', array('category_id' => $sub_category, 'parent_id' => $parent_category, 'flag' => 1, 'is_deleted' => 0));
                if(!empty($check_sub_cat)){
                    $all_cat = '';
                }else{
                    $all_cat = 'sub_cat';
                }
              }else if($parent_category != '' && $add_parent_category == '' && $sub_category == '' && $add_sub_category == '' && $child_category == '' && $add_child_category == ''){
                $check_parent_cat = $this->general_model->get_category_name('*','category', array('category_id' => $parent_category, 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0));
                if(!empty($check_parent_cat)){
                    $all_cat = '';
                }else{
                    $all_cat = 'parent_cat';
                }
              }else{
                  $all_cat = 'parent_cat';
              }

              if($all_cat != ''){

                if($add_parent_category != '' && $parent_category == '' && $sub_category == '' && $add_sub_category == '' && $child_category == '' && $add_child_category == ''){

                    $data = array(
                        'cat_name' => $add_parent_category,
                        'parent_id' => 0,
                        'flag' => 0,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );

                }else if($add_sub_category != '' && $sub_category == '' &&  $child_category == '' && $add_child_category == ''){

                  if($parent_category != '' && $add_parent_category == ''){
                    $data = array(
                        'cat_name' => $add_sub_category,
                        'parent_id' => $parent_category,
                        'flag' => 1,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );
                  }else if($parent_category == '' && $add_parent_category != ''){
                    $data_cat = array(
                        'cat_name' => $add_parent_category,
                        'parent_id' => 0,
                        'flag' => 0,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );
                    $insert_parent_id = $this->general_model->insert_category($data_cat, 'category');
                    $data = array(
                        'cat_name' => $add_sub_category,
                        'parent_id' => $insert_parent_id,
                        'flag' => 1,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );

                  }
                }else if($add_child_category != '' && $child_category == ''){

                  if($parent_category != '' && $add_parent_category == '' && $sub_category != '' && $add_sub_category == ''){
                    $data = array(
                        'cat_name' => $add_child_category,
                        'parent_id' => $sub_category,
                        'flag' => 2,
                        'user_id' => $uid,
                        //'permission' => $permission,
                        'permission' => 1,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );

                    $data_service = array(
                        'service_name' => $add_child_category,
                        'cat_id' => $sub_category,
                        'type' => $this->input->post('service_type'),
                        'price' => $this->input->post('range-price'),
                        'time' => $this->input->post('range-time'),
                        'created_at' => date('Y-m-d H:i:s'),
                        //'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                        'is_active' => 1,
                    );

                $insert_parent_id_service = $this->general_model->insert_category($data_service, 'services');
                  }
                  else if($parent_category == '' && $add_parent_category != '' && $sub_category != '' && $add_sub_category == ''){
                    $data = array(
                        'cat_name' => $add_child_category,
                        'parent_id' => $sub_category,
                        'flag' => 2,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );
                  }else if($parent_category != '' && $add_parent_category == '' && $sub_category == '' && $add_sub_category != ''){
                    $data_cat1 = array(
                        'cat_name' => $add_sub_category,
                        'parent_id' => $parent_category,
                        'flag' => 1,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );
                    $insert_parent_id1 = $this->general_model->insert_category($data_cat1, 'category');
                    $data = array(
                        'cat_name' => $add_child_category,
                        'parent_id' => $insert_parent_id1,
                        'flag' => 2,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );

                   


                  }else if($parent_category == '' && $add_parent_category != '' && $sub_category == '' && $add_sub_category != ''){
                    $data_cat1 = array(
                        'cat_name' => $add_parent_category,
                        'parent_id' => 0,
                        'flag' => 0,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );
                    $insert_parent_id1 = $this->general_model->insert_category($data_cat1, 'category');
                    $data_cat2 = array(
                        'cat_name' => $add_sub_category,
                        'parent_id' => $insert_parent_id1,
                        'flag' => 1,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );
                    $insert_parent_id2 = $this->general_model->insert_category($data_cat2, 'category');
                    $data = array(
                        'cat_name' => $add_child_category,
                        'parent_id' => $insert_parent_id2,
                        'flag' => 2,
                        'user_id' => $uid,
                        'permission' => $permission,
                        'flag_user_admin' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                    );

                     $data_service = array(
                        'service_name' => $add_child_category,
                        'cat_id' => $sub_category,
                        'type' => $this->input->post('service_type'),
                        'price' => $this->input->post('range-price'),
                        'time' => $this->input->post('range-time'),
                        'created_at' => date('Y-m-d H:i:s'),
                        //'updated_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0,
                        'is_active' => 1,
                    );

                $insert_parent_id_service = $this->general_model->insert_category($data_service, 'services');

                  }
                }


                $insert_id = $this->general_model->insert_category($data, 'category');
                if($insert_id){
                 
                   $this->response([
                                    'status' => TRUE,
                                     'message' => 'Service category added successfully.'
                                ], REST_Controller::HTTP_OK);
                }else{
               
                 $this->response([
                                    'status' => FALSE,
                                    'message' => 'Something wents wrong!'
                                ], REST_Controller::HTTP_NOT_FOUND);
                }
              }else{
               
                $this->response([
                                    'status' => FALSE,
                                    'message' => 'This service category is already added.'
                                ], REST_Controller::HTTP_NOT_FOUND);
              }
          }else {
           
            $this->response([
                                    'status' => FALSE,
                                    'message' => 'Something wents wrong!.'
                                ], REST_Controller::HTTP_NOT_FOUND);
          }
        }else{
          $this->response([
                                    'status' => FALSE,
                                    'message' => 'Something wents wrong!.'
                                ], REST_Controller::HTTP_NOT_FOUND);
        }
      
    }

    public function get_child_category_post(){
        $cat_id = $this->input->post('cat_id');
        //$flag = $this->input->post('flag');
        $flag = 2;
        $parent_category = $this->general_model->get_category( 'category', array('is_deleted' => 0, 'parent_id' => $cat_id, 'flag' => $flag));

         $this->response([
                         'status' => TRUE, 
                          'data' => $parent_category
                             ], REST_Controller::HTTP_OK);
    }

    public function check_cat_name($table, $columnName)
    {
      $cat_name = $_POST['cat_name'];

      if(!empty($cat_name)) {
        $this->db->select($columnName);
        $this->db->from($table);
        $this->db->where('cat_name',$cat_name);
        $count = $this->db->get()->row();
        $count = count($count);
        $count = (int)$count;
        if($count > 0){
          echo 'false';
        }else{
          echo 'true';
       }
     }
    }
}
