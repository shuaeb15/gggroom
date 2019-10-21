<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Worker extends Admin_Controller {
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
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 4, 'is_deleted' => 0), 'result_array');
          }
          $this->data['user_access_data'] = $user_access_data;

          $worker_list = $this->general_model->get_shops_data('*','workers', array('is_removed' => 0));
          foreach ($worker_list as $key => $worker) {
            $var =  $this->url_encrypt($worker->id);
            $worker_list[$key]->encrypt_id = $var;
          }
          // echo '<pre>';print_r($shop_list);exit;
          foreach ($worker_list as $key => $value) {
            if($value->user_id != 0){
                $user_list = $this->general_model->get_user_by_shop( 'user', array('id' => $value->user_id));
                $worker_list[$key]->user = $user_list;
              }
            }
            $this->data['worker_list'] = $worker_list;
            if($user_promotion != 3){
                $this->render('worker_view');
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
          $update_id = $this->general_model->active_inactive_worker($data, 'workers', array('id' => $sid));
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
          $update_id = $this->general_model->active_inactive_worker($data, 'workers', array('id' => $sid));
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

    public function remove_worker() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];
          $data = array(
            'is_active' => 0,
            'is_deleted' => 1,
            'is_removed' => 1
          );
          $update_id = $this->general_model->active_inactive_worker($data, 'workers', array('id' => $sid));
          if (isset($update_id)) {
              $data['success'] = 'success';
              $data['id'] = $sid;
              echo json_encode($data);
              exit;
          }
      }else{
          $data['unsuccess'] = 'unsuccess';
          echo json_encode($data);
          exit;
      }
    }

    public function worker_info($id1) {
      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;
        $role_id =  $admin_data[0]['id'];
        $user_promotion =  $admin_data[0]['user_promotion'];

        $id1 = $this->url_decrypt($id1);
        if ($id1 != '') {
            $worker_data = $this->general_model->get_worker_data_id('workers', array('workers.id' => $id1));
            // echo '<pre>';print_r($worker_data);exit;
            $this->data['worker_data'] = $worker_data;

            $business_hours = $this->general_model->get_business_hours_data('*', 'worker_available_time', array('worker_id' => $id1, 'is_deleted' => 0));
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

            $breaks = $this->general_model->get_business_hours_data('*', 'breaks', array('shop_id' => $id1, 'is_deleted' => 0));
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

            $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 2));
            $this->data['vacation_module_data'] = $vacation_module_data;

            if($user_promotion != 3){
                $this->render('worker_info_view');
            }else{
                redirect('dashboard', 'refresh');
            }
        }else{
            $this->session->set_flashdata('error_message', "Something wents wrong!");
            redirect('worker', 'refresh');
        }
      } else {
          redirect('Login', 'refresh');
      }
  }
  public function edit_worker($id1) {
    if ($this->session->userdata('admin_id')) {
      $admin_id = $this->session->userdata('admin_id');
      $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
      $this->data['admin_data'] = $admin_data;
      $role_id =  $admin_data[0]['id'];
      $user_promotion =  $admin_data[0]['user_promotion'];

        $id1 = $this->url_decrypt($id1);
        if ($id1 != '') {
            $worker_data = $this->general_model->get_worker_data_id('workers', array('workers.id' => $id1));
            $var =  $this->url_encrypt($worker_data->id);
            $worker_data->encrypt_id = $var;
            $this->data['worker_data'] = $worker_data;

            $user_id = $worker_data->user_id;
            $shop_list = $this->general_model->get_shop_data_by_service('*', 'shop', array('user_id' => $user_id, 'is_deleted' => 0));
            $this->data['shoplist'] = $shop_list;

            $business_hours = $this->general_model->get_business_hours_data('*', 'worker_available_time', array('worker_id' => $id1, 'is_deleted' => 0));
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

            $breaks = $this->general_model->get_business_hours_data('*', 'breaks', array('shop_id' => $id1, 'is_deleted' => 0));
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

            $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 2));
            $this->data['vacation_module_data'] = $vacation_module_data;

            $this->data['js_file'] = array(
                "../front/js/bootstrap-datetimepicker.min.js",
                "../front/js/jquery.timepicker.js",
                "../front/js/datepair.js",
                "../front/js/jquery.datepair.js",
                "assets/build/js/admin_worker.js"
            );
            $this->data['css_file'] = array(
                "../front/css/bootstrap-datetimepicker.min.css",
                "../front/css/jquery.timepicker.css"
            );

            if($user_promotion != 3){
                $this->render('edit_worker_view');
            }else{
                redirect('dashboard', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', "Something wents wrong!");
            redirect('worker', 'refresh');
        }
    } else {
        redirect('Login', 'refresh');
    }
  }
  public function update_worker($id) {
    $id = $this->url_decrypt($id);
    if (!$this->session->userdata('admin_id')) {
      $this->session->set_flashdata('error_message', "Something wents wrong!");
      redirect('worker', 'refresh');
    }
    else{
          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('worker_name', 'Worker Name', 'required');
              $this->form_validation->set_rules('worker_mobile', 'Worker mobile', 'required');
              $this->form_validation->set_rules('worker_email', 'Worker Email', 'required|valid_email');

              if ($this->form_validation->run() == false) {
                  $this->session->set_flashdata('error_message', "Please fill required fields.");
                  $this->session->set_userdata('USER_DETAIL', $_POST);
                  redirect('worker/edit_worker/'.$id, 'refresh');
              } else {
                $map_api = $this->config->item('map_api');
                $worker_id = $this->input->post('worker_id');
                $worker_name = $this->input->post('worker_name');
                $worker_email = $this->input->post('worker_email');
                $mobile_no = $this->input->post('worker_mobile');
                $percentage = $this->input->post('percentage');
                $selected_shop = $this->input->post('radiog_list_detail');
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

                $image = $this->upload_shop_Image($_FILES['imgupload1']['name'], 'imgupload1', 'worker_image', $worker_id);
                // echo '<pre>';print_r($image);exit;
                $data = array(
                    'name' => $worker_name,
                    'email' => $worker_email,
                    'mobile' => $mobile_no,
                    'percentage' => $percentage,
                    'image' => $image,
                    'shop_id' => $selected_shop,
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
                  $insert_user_id = $this->general_model->insert_user($user_data, 'user');
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

                $worker_id = $this->input->post('worker_id');
                $shop_id = $this->input->post('shop_id');
                  if($worker_id){
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
      }
  }
  public function upload_shop_Image($path, $imagename, $upload_path, $worker_id){
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
      $this->db->from('workers');
      $this->db->where('id',$worker_id);
      $count = $this->db->get()->row();
      $img = $count->image;
      $path = '../assets/uploads/'.$upload_path.'/'.$img;
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

   public function CheckShopTime(){
     if($this->input->post())
     {
       $shopId = $this->input->post('shopid');
       $shopHours = $this->general_model->get_all_general_data123('*','business_hours',array('shop_id'=>$shopId, 'is_active' => 1, 'is_deleted' => 0));
       if(!empty($shopHours)){
         $startTime = date("g:ia", strtotime($shopHours[0]['from_time']));
         $endTime = date("g:ia", strtotime($shopHours[0]['to_time']));
       }
       else{
         $startTime = '01:00';
         $endTime = '01:00';
       }
       $dayArr = array();
       foreach ($shopHours as $value)
       {
         $dayArr[] = $value['hours_day'];
       }
       // echo '<pre>';print_r($dayArr);exit;
       echo json_encode($dayArr).'||'.$startTime.'||'.$endTime;exit;
     }

   }
   public function check_shop_hours_for_worker() {
     $shop_id = $this->input->post('shopid');
     $business_hours = $this->general_model->get_business_hours_data('*', 'business_hours', array('shop_id' => $shop_id, 'is_deleted' => 0));
     if(empty($business_hours)){
        $business_hours = '0';
     }
     echo json_encode($business_hours);
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
        if($count > 0){
          echo 'false';
        }else{
          echo 'true';
        }
      }
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
}
