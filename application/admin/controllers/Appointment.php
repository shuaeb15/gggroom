<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Appointment extends Admin_Controller {
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
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 6, 'is_deleted' => 0), 'result_array');
          }
          $this->data['user_access_data'] = $user_access_data;

          $appointment_list = $this->general_model->get_appointment_data('*','appointment');
          // echo '<pre>';print_r($appointment_list);exit;
          foreach ($appointment_list as $key => $appointment) {
            $var =  $this->url_encrypt($appointment->id);
            $appointment_list[$key]->encrypt_id = $var;
          }
          // echo '<pre>';print_r($appointment_list);exit;
          foreach ($appointment_list as $key => $value) {
            if($value->user_id != 0){
                $user_list = $this->general_model->get_user_by_appointment('firstname, lastname', 'user', array('id' => $value->user_id));
                $appointment_list[$key]->user = $user_list;
              }
              if($value->worker_id != 0){
                  $worker_list = $this->general_model->get_user_by_appointment('name', 'workers', array('id' => $value->worker_id));
                  $appointment_list[$key]->worker = $worker_list;
              }
              if($value->shop_id != 0){
                $shop_list = $this->general_model->get_user_by_appointment('shop_name', 'shop', array('id' => $value->shop_id));
                $appointment_list[$key]->shop = $shop_list;
              }
              if($value->service_id != 0){
                $appointment_price = $this->general_model->get_user_by_appointment('price', 'services', array('id' => $value->service_id));
                $appointment_list[$key]->price = $appointment_price;
              }

            }
            // echo '<pre>';print_r($appointment_list);exit;
            $this->data['appointment_list'] = $appointment_list;
            if($user_promotion != 3){
                  $this->render('appointment_view');
            }else{
                redirect('dashboard', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function appointment_info($id1) {

      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;
        $role_id =  $admin_data[0]['id'];
        $user_promotion =  $admin_data[0]['user_promotion'];

        $id1 = $this->url_decrypt($id1);
          if ($id1 != '') {
              $appointment_list = $this->general_model->get_appointment_data_id('*', 'appointment', array('id' => $id1));

                if($appointment_list->user_id != 0){
                    $user_list = $this->general_model->get_user_by_appointment('firstname, lastname', 'user', array('id' => $appointment_list->user_id));
                    $appointment_list->user = $user_list;
                  }
                  if($appointment_list->worker_id != 0){
                      $worker_list = $this->general_model->get_user_by_appointment('name', 'workers', array('id' => $appointment_list->worker_id));
                      $appointment_list->worker = $worker_list;
                  }
                  if($appointment_list->shop_id != 0){
                    $shop_list = $this->general_model->get_user_by_appointment('shop_name', 'shop', array('id' => $appointment_list->shop_id));
                    $appointment_list->shop = $shop_list;
                  }
                  if($appointment_list->service_id != 0){
                    $service_list = $this->general_model->get_user_by_appointment('image as service_image', 'services', array('id' => $appointment_list->service_id));
                    $appointment_list->service = $service_list;
                  }
                  if($appointment_list->order_id != 0){
                    $order_list = $this->general_model->get_user_by_appointment('transaction_id', 'orders', array('order_id' => $appointment_list->order_id));
                    // echo $this->db->last_query();exit;
                    $appointment_list->order = $order_list;
                  }
                  if($appointment_list->service_id != 0){
                    $appointment_price = $this->general_model->get_user_by_appointment('price', 'services', array('id' => $appointment_list->service_id));
                    $appointment_list->price = $appointment_price;
                  }
                // }
              $this->data['appointment_list'] = $appointment_list;

              if($user_promotion != 3){
                    $this->render('appointment_info_view');
              }else{
                  redirect('dashboard', 'refresh');
              }
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('appointment', 'refresh');
          }
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function edit_appointment($id1) {

      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;
        $role_id =  $admin_data[0]['id'];
        $user_promotion =  $admin_data[0]['user_promotion'];

        $id1 = $this->url_decrypt($id1);
          if ($id1 != '') {
              $appointment_list = $this->general_model->get_appointment_data_id('*', 'appointment', array('id' => $id1));
              $var =  $this->url_encrypt($appointment_list->id);
              $appointment_list->encrypt_id = $appointment_list->id;

              if($appointment_list->user_id != 0){
                  $user_list = $this->general_model->get_user_by_appointment('firstname, lastname', 'user', array('id' => $appointment_list->user_id));
                  $appointment_list->user = $user_list;
                }
                if($appointment_list->worker_id != 0){
                    $worker_list = $this->general_model->get_user_by_appointment('name', 'workers', array('id' => $appointment_list->worker_id));
                    $appointment_list->worker = $worker_list;
                }
                if($appointment_list->shop_id != 0){
                  $shop_list = $this->general_model->get_user_by_appointment('shop_name', 'shop', array('id' => $appointment_list->shop_id));
                  $appointment_list->shop = $shop_list;
                }
                if($appointment_list->service_id != 0){
                  $service_list = $this->general_model->get_user_by_appointment('image as service_image', 'services', array('id' => $appointment_list->service_id));
                  $appointment_list->service = $service_list;
                }
                if($appointment_list->order_id != 0){
                  $order_list = $this->general_model->get_user_by_appointment('transaction_id', 'orders', array('order_id' => $appointment_list->order_id));
                  // echo $this->db->last_query();exit;
                  $appointment_list->order = $order_list;
                }
                if($appointment_list->service_id != 0){
                  $appointment_price = $this->general_model->get_user_by_appointment('price', 'services', array('id' => $appointment_list->service_id));
                  $appointment_list->price = $appointment_price;
                }
                // echo '<pre>';print_r($appointment_list);exit;
                $this->data['js_file'] = array(
                  "../front/js/bootstrap-datetimepicker.min.js",
                  "../front/js/jquery.timepicker.js",
                  "../front/js/datepair.js",
                  "../admin/assets/build/js/appointment.js"

                );
                $this->data['css_file'] = array(
                  "../front/css/bootstrap-datetimepicker.min.css",
                  "../front/css/jquery.timepicker.css"
                );
                $this->data['appointment_list'] = $appointment_list;

              if($user_promotion != 3){
                  $this->render('edit_appointment_view');
              }else{
                  redirect('dashboard', 'refresh');
              }
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('appointment', 'refresh');
          }
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function update_appointment() {
      if (!$this->session->userdata('admin_id')) {
        $this->session->set_flashdata('error_message', "Something wents wrong!");
        redirect('appointment', 'refresh');
      }
      else{
            if ($this->input->post()) {
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ap_date', 'Appointment date', 'required');
                $this->form_validation->set_rules('start_time', 'Time', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('appointment/edit_appointment/'.$id, 'refresh');
                } else {
                  $appointment_id = $this->input->post('appointment_id');
                  $get_main_data = $this->general_model->get_appointment_time('*', 'appointment', array('id' => $appointment_id));
                  $service_time = $this->general_model->get_appointment_time('time', 'services', array('id' => $get_main_data->service_id));
                  $service_time = $service_time->time;

                  $cu_date = $this->input->post('ap_date');
                  $ap_date = date("Y-m-d", strtotime($cu_date));
                  $cu_time = $this->input->post('start_time');
                  $f_start = date("H:i", strtotime($cu_time));
                  $minutes = '+'.$service_time.' minutes';
                  $end_time = date('H:i',strtotime($minutes,strtotime($f_start)));
                  $data = array(
                      'ap_date' => $ap_date,
                      'from_time' => $f_start,
                      'to_time' => $end_time,
                      'updated_at' => date('Y-m-d H:i:s'),
                      // 'booking_status' => 1,
                      'is_deleted' => 0,
                  );
                  $email_data = $this->general_model->get_appointment_time('from_time', 'appointment', array('id' => $appointment_id));

                  $updated_id = $this->general_model->update_ap_data($data, 'appointment', array('id' => $appointment_id));

                  $get_data = $this->general_model->get_appointment_time('*', 'appointment', array('id' => $appointment_id));
                  $worker_name = $this->general_model->get_appointment_time('name', 'workers', array('id' => $get_data->worker_id));
                  $user_id = $this->general_model->get_appointment_time('email', 'user', array('id' => $get_data->user_id));
                  $email_data1 = array(
                      'ap_date' => $ap_date,
                      'from_time' => $f_start,
                      'to_time' => $end_time,
                      'service_name' => $get_data->service_name,
                      'worker_name' => $worker_name->name,
                      'user_email' => $user_id->email,
                  );
                  $ap_time = date("H:i", strtotime($email_data->from_time));
                  if($f_start == $ap_time){
                  }else{
                    $emailsend = $this->general_model->send_appointment_change_mail($email_data1);
                  }
                  $this->session->set_flashdata('success_message', "Appointment updated successfully");
                  redirect('appointment', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('appointment', 'refresh');
            }
        }
    }

    public function active_appointment() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

        $data = array(
          // 'is_active' => 1,
          'is_deleted' => 0,
          'booking_status' => 1
        );
        $update_id = $this->general_model->active_appointment($data, 'appointment', array('id' => $sid));
        $appointment_list = $this->general_model->get_appointment_data_id('order_id', 'appointment', array('id' => $sid));

        $data1 = array(
          'status' => 1,
          'is_deleted' => 0
        );

        $order_id = $this->general_model->active_appointment($data1, 'orders', array('order_id' => $appointment_list->order_id));

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

    public function inactive_appointment() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            // 'is_active' => 0,
            'is_deleted' => 1,
            'booking_status' => 3
          );
          $update_id = $this->general_model->inactive_appointment($data, 'appointment', array('id' => $sid));
          $appointment_list = $this->general_model->get_appointment_data_id('order_id', 'appointment', array('id' => $sid));

          $data1 = array(
            'status' => 0,
            'is_deleted' => 1
          );

          $order_id = $this->general_model->inactive_appointment($data1, 'orders', array('order_id' => $appointment_list->order_id));
          // echo '<pre>';print_r($appointment_list->order_id);exit;

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

    public function confirm_appointment() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

        $data2 = array(
          'is_deleted' => 0,
          'booking_status' => 1
        );
        $update_id = $this->general_model->active_appointment($data2, 'appointment', array('id' => $sid));
        $appointment_list = $this->general_model->get_appointment_data_id('order_id', 'appointment', array('id' => $sid));

        $data1 = array(
          'status' => 1,
          'is_deleted' => 0
        );
        $order_id = $this->general_model->active_appointment($data1, 'orders', array('order_id' => $appointment_list->order_id));
        $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('order_id' => trim($appointment_list->order_id), 'is_deleted' => 0));

        $emailsend = $this->general_model->appointment_book_sendConfirmationEmail($email_data);

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

    public function get_worker_time_check(){
      $worker_id = $this->input->post('worker_id');
      $time = $this->input->post('from_time');
      $f_start = date("H:i", strtotime($time));
      $shop_id = $this->input->post('shop_id');

      $worker_date = $this->input->post('worker_date');
      $parts = explode('-', $worker_date);
      $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
      $day = date('l', strtotime($f_worker_date));

      $worker_list = $this->general_model->check_worker_time('worker_available_time', array('worker_id' => $worker_id, 'shop_id' => $shop_id, 'from_time' => $f_start, 'to_time' => $f_start, 'worker_day' => $day, 'is_deleted' => 0));

      $worker_list_available_time = $this->general_model->get_worker_time('*', 'worker_available_time', array('worker_id' => $worker_id, 'shop_id' => $shop_id, 'is_deleted' => 0));

      // echo '<pre>';print_r($worker_list);exit;
      if(!empty($worker_list))
      {
        echo 1;exit;
      }
      else
      {
        echo json_encode($worker_list_available_time);
      }
    }

    public function check_worker_appointment_time(){
      // echo "in";exit;
      $worker_id = $this->input->post('worker_id');
      $shop_id = $this->input->post('shop_id');
      $service_id = $this->input->post('service_id');
      $from_time = $this->input->post('from_time');
      $f_start = date("H:i", strtotime($from_time));
      $worker_date = $this->input->post('worker_date');
      $parts = explode('-', $worker_date);
      $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
      // echo $f_worker_date;exit;
      $app_date = date("Y-m-d", strtotime($f_worker_date));

      // SELECT * FROM `appointment` WHERE shop_id = "2" AND worker_id = "1" AND service_id = "9" AND ap_date = "2018-06-18" AND from_time = "09:00"
      $worker_list = $this->general_model->check_exist_data('*','appointment',array('worker_id' => $worker_id, 'shop_id' => $shop_id, 'service_id' => $service_id, 'from_time' => $f_start, 'ap_date' => $app_date, 'is_deleted' => 0, 'booking_status' => 1));

      if(!empty($worker_list))
      {
        echo 1;exit;
      }
      else
      {
        echo 0;exit;
      }
    }
  }
