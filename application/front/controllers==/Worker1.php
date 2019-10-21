<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Worker extends MY_Controller {
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
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));
          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }
          $worker_list = $this->general_model->get_worker_shop_data('*', 'workers', array('is_deleted' => 0), $all_u_id);
          foreach ($worker_list as $key => $worker) {
            $var =  $this->url_encrypt($worker->id);
            $worker_list[$key]->encrypt_id = $var;
          }
          $this->data['workerlist'] = $worker_list;
          $this->data['title'] = 'Worker | GGG Rooms';
          if(count($worker_list) > 0){
            $this->render('worker');
          }
          else{
              $this->render('blank_worker');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function add_worker() {
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id,0);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));

          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }

          $shop_list = $this->general_model->get_shop_list_data_by_user('shop', array('shop.is_deleted' => 0), $all_u_id);
          $this->data['shoplist'] = $shop_list;
          $this->data['title'] = 'Worker | GGG Rooms';

          $this->data['js_file'] = array(
              "front/js/jquery.timepicker.js",
              "front/js/datepair.js",
              "front/js/jquery.datepair.js",
              "front/js/worker.js"
          );
          $this->data['css_file'] = array(
              "front/css/jquery.timepicker.css"
          );

          $this->render('add_worker');
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function insert_worker() {
      if (!$this->session->userdata('uid')) {
          redirect(site_url());
      }
      else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){

          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('worker_name', 'Worker Name', 'required');
              $this->form_validation->set_rules('worker_mobile', 'Worker Title', 'required');
              $this->form_validation->set_rules('worker_email', 'Worker Email', 'required|valid_email');
              if ($this->form_validation->run() == false) {
                  $this->session->set_flashdata('error_message', "Please fill required fields.");
                  $this->session->set_userdata('USER_DETAIL', $_POST);
                  redirect('worker/add_worker/', 'refresh');
              }else{
                $uid = $this->session->userdata('uid');
                $worker_name = $this->input->post('worker_name');
                $worker_email = $this->input->post('worker_email');
                $mobile_no = $this->input->post('worker_mobile');
                $percentage = $this->input->post('worker_percentage');
                $shop_id = $this->input->post('radiog_list');
                $worker_permission = $this->input->post('worker_permission');

                $image = $this->uploadImage($_FILES['imgupload']['name'], 'imgupload', 'worker_image');

                $data = array(
                    'name' => $worker_name,
                    'email' => $worker_email,
                    'mobile' => $mobile_no,
                    'percentage' => $percentage,
                    'shop_id' => $shop_id,
                    'user_id' => $uid,
                    'shop_permission' => 0,
                    'image' => $image,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );

                $insert_id = $this->general_model->insert_worker_data($data, 'workers');
                if($worker_permission != ''){
                  $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
                  $password = substr(str_shuffle($password_string), 0, 12);

                  $user_data = array(
                      'p_id' => $uid,
                      'firstname' => $worker_name,
                      'email' => $worker_email,
                      'password' => md5($password),
                      'mobile' => $mobile_no,
                      'u_category' => 1,
                      'date' => date('Y-m-d H:i:s'),
                      'updated_date' => date('Y-m-d H:i:s'),
                      'is_active' => 0,
                      'is_deleted' => 0,
                  );
                  $insert_user_id = $this->general_model->insert_worker_data($user_data, 'user');
                  $user_id =  $this->url_encrypt($insert_user_id);
                  $worker_id =  $this->url_encrypt($insert_id);

                  $u_data = array(
                      'firstname' => $worker_name,
                      'email' => $worker_email,
                      'password' => $password,
                      'user_id' => $user_id,
                      'worker_id' => $worker_id,
                  );
                  $emailsend = $this->general_model->send_worker_permission_email($u_data);
                }

                  if($insert_id){
                    $service_time = $this->input->post('service_time[]');
                    foreach ($service_time as $key => $value) {
                      $business_hours_day = $value;
                      $business_hours_from_time = $this->input->post('Monday1');
                      $business_hours_to_time = $this->input->post('Monday2');

                      $f_start = date("H:i", strtotime($business_hours_from_time));
                      $t_start = date("H:i", strtotime($business_hours_to_time));

                        $data1 = array(
                            'worker_id' => $insert_id,
                            'shop_id' => $shop_id,
                            'worker_day' => $business_hours_day,
                            'from_time' => $f_start,
                            'to_time' => $t_start,
                            'created_at' => date('Y-m-d H:i:s'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                        );
                        if($business_hours_from_time != '' && $business_hours_to_time != ''){
                            $inserted_time = $this->general_model->update_worker_business_hours_availability_time($data1, 'worker_available_time');
                        }
                    }

                    $break_time = $this->input->post('service_time[]');
                    foreach ($break_time as $key => $breaks) {
                      $breaks_day = $breaks;
                      $breaks_from_time = $this->input->post('break_Monday1');
                      $breaks_to_time = $this->input->post('break_Monday2');

                      $b_f_start = date("H:i", strtotime($breaks_from_time));
                      $b_t_start = date("H:i", strtotime($breaks_to_time));

                        $data2 = array(
                            'shop_id' => $insert_id,
                            'day' => $breaks_day,
                            'from_time' => $b_f_start,
                            'to_time' => $b_t_start,
                            'created_at' => date('Y-m-d H:i:s'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                        );
                        if($breaks_from_time != '' && $breaks_to_time != ''){
                            $inserted_time = $this->general_model->update_breaks_availability_time($data2, 'breaks');
                        }
                    }

                    $this->session->set_flashdata('success_message', "Worker added successfully");
                    redirect('worker', 'refresh');
                  }else{
                     $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                     redirect('worker', 'refresh');
                  }
              }
          }else {
            $this->session->set_flashdata('error_message', "Something wents wrong!");
            redirect('worker', 'refresh');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function uploadImage($path, $imagename, $upload_path){
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
      $config['upload_path']          = FCPATH.'assets/uploads/'.$upload_path.'/';
      $config['file_name'] 						= $temp_name;
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        return $temp_name;
      }else{
        return $temp_name;
      }
    }

    public function edit_worker($id1) {
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
        $id1 = $this->url_decrypt($id1);

        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        $breaks = $this->general_model->get_business_hours_data('*', 'breaks', array('shop_id' => $id1, 'is_active' => 1));
        $days1 = array();
        $main_hours1 = [];
        for ($i = 0; $i < 7; $i++) {
          $days1[$i] = jddayofweek($i,1);
          foreach ($breaks as $key => $value) {
            if($days1[$i] == $value->day){
                $main_hours1[] = $value;
            }
          }
        }
        $this->data['breaks'] = $main_hours1;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id,0);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));

          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }

          $shop_list = $this->general_model->get_shop_list_data_by_user('shop', array('shop.is_deleted' => 0), $all_u_id);
          $this->data['shoplist'] = $shop_list;

          $business_hours = $this->general_model->get_worker_business_hours_data('*', 'worker_available_time', array('worker_id' => $id1, 'is_deleted' => 0));
          $days = array();
          $main_hours = [];
          for ($i = 0; $i < 7; $i++) {
            $days[$i] = jddayofweek($i,1);
            foreach ($business_hours as $key => $value) {
              if($days[$i] == $value->worker_day){
                  $main_hours[] = $value;
              }
            }
          }
          $this->data['business_hours'] = $main_hours;

          $worker_list = $this->general_model->get_shop_data_id('*', 'workers', array('id' => $id1, 'is_deleted' => 0));
          $var =  $this->url_encrypt($worker_list->id);
          $worker_list->encrypt_id = $var;
          $this->data['workerlist'] = $worker_list;

          $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 2));
          $this->data['vacation_module_data'] = $vacation_module_data;

          $this->data['title'] = 'Worker | GGG Rooms';

          $this->data['js_file'] = array(
              "front/js/bootstrap-datetimepicker.min.js",
              "front/js/jquery.timepicker.js",
              "front/js/datepair.js",
              "front/js/jquery.datepair.js",
              "front/js/worker.js"
          );
          $this->data['css_file'] = array(
              "front/css/bootstrap-datetimepicker.min.css",
              "front/css/jquery.timepicker.css"
          );

          $this->render('edit_worker');
        }else{
          redirect('profile', 'refresh');
        }
      }
      $this->check_vacation_module_time_available();
    }

    public function check_vacation_module_time_available(){
      $current_date = date("Y-m-d");
      $check_vacation_module = $this->general_model->get_all_state_data('*', 'vacation_module', array('flag' => 2, 'is_deleted' => 0));
      foreach ($check_vacation_module as $key => $date) {
        $date_to_compare = date($date->end_date);
        if (strtotime($date_to_compare) < strtotime($current_date)) {
          $check_vacation_module1 = $this->general_model->check_vacation_module_time_available('*', 'vacation_module', array('flag' => 2, 'is_deleted' => 0), $date_to_compare);
          if(!empty($check_vacation_module1)){
            foreach ($check_vacation_module1 as $key => $value) {
              $val_id = $value->id;
              $this->db->where('id', $val_id);
              $data1 = $this->db->delete('vacation_module');
            }
          }
        }
      }
    }

    public function update_worker($id1) {
      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          $id1 = $this->url_decrypt($id1);
          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('worker_name', 'Worker Name', 'required');
              $this->form_validation->set_rules('worker_mobile', 'Worker Title', 'required');
              $this->form_validation->set_rules('worker_email', 'Worker Email', 'required|valid_email');
              if ($this->form_validation->run() == false) {
                  $this->session->set_flashdata('error_message', "Please fill required fields.");
                  $this->session->set_userdata('USER_DETAIL', $_POST);
                  redirect('worker/edit_worker/'.$id1, 'refresh');
              } else {
                $worker_id = $this->input->post('worker_id');
                $worker_name = $this->input->post('worker_name');
                $worker_email = $this->input->post('worker_email');
                $mobile_no = $this->input->post('worker_mobile');
                $percentage = $this->input->post('worker_percentage');
                $shop_id = $this->input->post('radiog_list');
                $all_day = $this->input->post('all_day');
                $start_time = $this->input->post('start_time');
                $end_time = $this->input->post('end_time');

                $chk_vacation_module = $this->input->post('chk_vacation_module');
                $worker_permission = $this->input->post('worker_permission');

                if($chk_vacation_module != ''){
                  if($start_time == '' && $end_time == ''){
                    $b_f_start = '00:00:00';
                    $b_t_start = '23:59:00';
                  }else{
                    $b_f_start = date("H:i:s", strtotime($start_time));
                    $b_t_start = date("H:i:s", strtotime($end_time));
                  }
                  if($all_day != ''){
                    $main_all_day = '1';
                  }else{
                    $main_all_day = '0';
                  }

                  $v_md_start_date = $this->input->post('start_date_v_module');
                  $v_md_end_date = $this->input->post('end_date_v_module');
                  $parts1 = explode('-', $v_md_start_date);
                  $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
                  $vacation_md_start_date = date("Y-m-d", strtotime($s_date));
                  $parts2 = explode('-', $v_md_end_date);
                  $e_date = $parts2[1] . '-' . $parts2[0] . '-' . $parts2[2];
                  $vacation_md_end_date = date("Y-m-d", strtotime($e_date));

                  $main_start_date = $vacation_md_start_date.' '.$b_f_start;
                  $main_end_date = $vacation_md_end_date.' '.$b_t_start;

                  $data_vacation_module = array(
                      'shop_id' => $worker_id,
                      'start_date' => $main_start_date,
                      'end_date' => $main_end_date,
                      'all_day' => $main_all_day,
                      'flag' => 2,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0
                  );
                  $vacation_id = $this->general_model->insert_user($data_vacation_module, 'vacation_module');
                }

                $image = $this->upload_worker_Image($_FILES['imgupload']['name'], 'imgupload', 'worker_image', $worker_id);
                $data = array(
                    'name' => $worker_name,
                    'email' => $worker_email,
                    'mobile' => $mobile_no,
                    'percentage' => $percentage,
                    'shop_id' => $shop_id,
                    'image' => $image,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );
                $updated_id = $this->general_model->update_worker_data($data, 'workers', array('id' => $worker_id));

                if($worker_permission != ''){
                  $worker_data = array(
                      'shop_permission' => 0,
                  );
                  $updated_id = $this->general_model->update_worker_data($worker_data, 'workers', array('id' => $worker_id));

                  $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
                  $password = substr(str_shuffle($password_string), 0, 12);

                  $user_data = array(
                      'p_id' => $id,
                      'firstname' => $worker_name,
                      'email' => $worker_email,
                      'password' => md5($password),
                      'mobile' => $mobile_no,
                      'u_category' => 1,
                      'date' => date('Y-m-d H:i:s'),
                      'updated_date' => date('Y-m-d H:i:s'),
                      'is_active' => 0,
                      'is_deleted' => 0,
                  );
                  $insert_user_id = $this->general_model->insert_worker_data($user_data, 'user');
                  $user_id =  $this->url_encrypt($insert_user_id);
                  $worker_id =  $this->url_encrypt($worker_id);

                  $u_data = array(
                      'firstname' => $worker_name,
                      'email' => $worker_email,
                      'password' => $password,
                      'user_id' => $user_id,
                      'worker_id' => $worker_id,
                  );
                  $emailsend = $this->general_model->send_worker_permission_email($u_data);
                }

                  if($shop_id){
                    $service_time = $this->input->post('service_time[]');
                    // $business_hours_from_time = $this->input->post('Monday1');
                    // $business_hours_to_time = $this->input->post('Monday2');
                    //
                    // if($business_hours_from_time != '' && $business_hours_to_time != ''){
                    //   $inserted_time = $this->general_model->delete_worker_hours_time('worker_available_time', array('worker_id' => $worker_id));
                    // }

                    foreach ($service_time as $key => $value) {
                      $business_hours_day = $value;
                      $business_hours_from_time = $this->input->post('Monday1');
                      $business_hours_to_time = $this->input->post('Monday2');

                      $f_start = date("H:i", strtotime($business_hours_from_time));
                      $t_start = date("H:i", strtotime($business_hours_to_time));

                        $data1 = array(
                            'worker_id' => $worker_id,
                            'shop_id' => $shop_id,
                            'worker_day' => $business_hours_day,
                            'from_time' => $f_start,
                            'to_time' => $t_start,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                        );
                        if($business_hours_from_time != '' && $business_hours_to_time != ''){
                            $inserted_time = $this->general_model->update_worker_business_hours_availability_time($data1, 'worker_available_time');
                        }
                    }

                    $break_time = $this->input->post('service_time[]');
                    foreach ($break_time as $key => $breaks) {
                      $breaks_day = $breaks;
                      $breaks_from_time = $this->input->post('break_Monday1');
                      $breaks_to_time = $this->input->post('break_Monday2');

                      $b_f_start = date("H:i", strtotime($breaks_from_time));
                      $b_t_start = date("H:i", strtotime($breaks_to_time));

                        $data2 = array(
                            'shop_id' => $worker_id,
                            'day' => $breaks_day,
                            'from_time' => $b_f_start,
                            'to_time' => $b_t_start,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                        );
                        if($breaks_from_time != '' && $breaks_to_time != ''){
                            $inserted_time = $this->general_model->update_breaks_availability_time($data2, 'breaks');
                        }
                    }

                    $this->session->set_flashdata('success_message', "Worker updated successfully");
                    redirect('worker', 'refresh');
                  }else{
                     $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                     redirect('worker', 'refresh');
                  }
              }
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('worker', 'refresh');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function upload_worker_Image($path, $imagename, $upload_path, $worker_id){
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
      $config['upload_path']          = FCPATH.'assets/uploads/'.$upload_path.'/';
      $config['file_name'] 						= $temp_name;
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        $this->db->select('image');
        $this->db->from('workers');
        $this->db->where('id',$worker_id);
        $count = $this->db->get()->row();
        $img = $count->image;
        $path = 'assets/uploads/'.$upload_path.'/'.$img;
        unlink($path);
        return $temp_name;
      }else{
        $this->db->select('image');
        $this->db->from('workers');
        $this->db->where('id',$worker_id);
        $count = $this->db->get()->row();
        return $count->image;
      }
    }

    public function checkUniqueadd_email($table, $columnName)
    {
      $email = $_POST['worker_email'];
      if(!empty($email)) {
        $this->db->select($columnName);
        $this->db->from($table);
        $this->db->where('email',$email);
        $count = $this->db->get()->row();
        $count = count($count);
        $count = (int)$count;
        if($count == 0){
          $this->db->select($columnName);
          $this->db->from('user');
          $this->db->where('email',$email);
          $count1 = $this->db->get()->row();
          $count1 = count($count1);
          $count1 = (int)$count1;

          if($count1 > 0){
            echo 'false';
          }else{
            echo 'true';
         }
        }else{
          if($count > 0){
            echo 'false';
          }else{
            echo 'true';
         }
        }
     }
    }

    public function checkUniqueemail($table, $columnName)
    {
      $email = $_POST['worker_email'];
      $id = $_POST['id'];
      if(!empty($email)) {
        $this->db->select($columnName);
        $this->db->from($table);
        $this->db->where('id !=',$id);
        $this->db->where('email',$email);
        $count = $this->db->get()->row();
        $count = count($count);
        $count = (int)$count;
        if($count == 0){
          $this->db->select($columnName);
          $this->db->from('user');
          $this->db->where('email',$email);
          $this->db->where('u_category != ',3);
          $count1 = $this->db->get()->row();
          $count1 = count($count1);
          $count1 = (int)$count1;

          if($count1 > 0){
            echo 'false';
          }else{
            echo 'true';
         }
        }else{
          if($count > 0){
            echo 'false';
          }else{
            echo 'true';
         }
       }
     }
    }

    public function delete_business_hours_time() {
      $id = $this->input->post('id');

      $worker_id = $this->input->post('worker_id');
      $hour_day = $this->input->post('hour_day');

      $this->db->where('id', $id);
      $hours_id = $this->db->delete('worker_available_time');

      $exists = $this->general_model->check_breaks_time_exists('breaks', array('day' => $hour_day, 'shop_id' => $worker_id));
      if(!empty($exists)){
         $this->db->where('id', $exists->id);
         $this->db->delete('breaks');
         echo $exists->id;
      }
     }

     public function delete_breaks_time() {
       $id = $this->input->post('id');
       $this->db->where('id', $id);
       $this->db->delete('breaks');

      }

    public function delete_worker($id1) {
      if($id1){
        $data = array(
          'is_active' => 0,
          'is_deleted' => 1
        );
        $update_id = $this->general_model->delete_shop($data, 'workers', array('id' => $id1));

        $this->db->where('worker_id', $id1);
        $this->db->delete('worker_available_time');

        $this->db->where('shop_id', $id1);
        $this->db->delete('breaks');

        $this->db->select('image');
        $this->db->from('workers');
        $this->db->where('id',$id1);
        // $this->db->where('flag', '1');
        $count = $this->db->get()->result();
        $img = $count->image;
        $path = 'assets/uploads/worker_image/'.$img;
        unlink($path);

        if($update_id){
          $this->session->set_flashdata('success_message', "Worker deleted successfully");
          redirect('worker', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('worker', 'refresh');
        }
      }
    }

    public function CheckShopTime(){
      if($this->input->post())
      {
        $shopId = $this->input->post('shopid');
        $shopHours = $this->general_model->get_all_general_data('*','business_hours',array('shop_id'=>$shopId, 'is_active' => 1, 'is_deleted' => 0));
        $startTime = date("g:ia", strtotime($shopHours[0]['from_time']));
        $endTime = date("g:ia", strtotime($shopHours[0]['to_time']));
        $dayArr = array();
        foreach ($shopHours as $value)
        {
          $dayArr[] = $value['hours_day'];
        }
        echo json_encode($dayArr).'||'.$startTime.'||'.$endTime;exit;
      }
    }

    public function check_shop_hours_for_worker() {
      $shop_id = $this->input->post('shopid');
      $business_hours = $this->general_model->get_business_hours_data('*', 'business_hours', array('shop_id' => $shop_id, 'is_deleted' => 0));
      echo json_encode($business_hours);
     }

     public function delete_vacation_module_time() {
       $id = $this->input->post('id');
       $worker_id = $this->input->post('worker_id');
       $this->db->where('id', $id);
       $this->db->where('shop_id', $worker_id);
       $this->db->where('flag', 2);
       $hours_id = $this->db->delete('vacation_module');
      }

      public function check_vacation_module_start_time() {
        $start_date = $this->input->post('start_date');
        $worker_id = $this->input->post('worker_id');

        $parts1 = explode('-', $start_date);
        $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
        $vacation_md_start_date = date("Y-m-d", strtotime($s_date));
        $check_vacation_module = $this->general_model->check_vacation_module_start_time('*', 'vacation_module', array('shop_id' => $worker_id, 'flag' => 2, 'is_deleted' => 0), $vacation_md_start_date);

        echo json_encode($check_vacation_module);
        // echo '<pre>';print_r($check_vacation_module);exit;
       }

       public function check_vacation_module_end_time() {
         $start_date = $this->input->post('start_date');
         $end_date = $this->input->post('end_date');
         $worker_id = $this->input->post('worker_id');

         $parts2 = explode('-', $end_date);
         $e_date = $parts2[1] . '-' . $parts2[0] . '-' . $parts2[2];
         $vacation_md_end_date = date("Y-m-d", strtotime($e_date));

         $check_vacation_module = $this->general_model->check_vacation_module_end_time('*', 'vacation_module', array('shop_id' => $worker_id, 'flag' => 2, 'is_deleted' => 0), $vacation_md_end_date);

         echo json_encode($check_vacation_module);
         // echo '<pre>';print_r($check_vacation_module);exit;
        }

        public function permission($u_id, $w_id) {
          $user_id = $this->url_decrypt($u_id);
          $worker_id = $this->url_decrypt($w_id);

          $worker_data = array(
              'shop_permission' => 1,
          );
          $user_data = array(
              'u_category' => 3,
              'is_active' => 1,
          );

          $updated_id = $this->general_model->update_worker_data($worker_data, 'workers', array('id' => $worker_id));
          $updated_id1 = $this->general_model->update_worker_data($user_data, 'user', array('id' => $user_id));

          $this->session->set_flashdata('success_message', "Congratulation!, Your permission is active.");
          redirect('home', 'refresh');
        }
}
