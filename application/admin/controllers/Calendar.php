<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Calendar class.
 *
 * @extends CI_Controller
 */
class Calendar extends Admin_Controller {
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
      // echo $userId;exit;
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

        $WorkersData = $this->general_model->get_worker_data('*', 'workers', array('is_deleted' => 0));
        $ShopData = $this->general_model->all_get_all_general_data("*",'shop',array('is_deleted'=>0));
        // echo "<pre>";print_r($WorkersData);exit;
        $this->data['WorkersData'] = $WorkersData;
        $this->data['ShopData'] = $ShopData;
    		$this->data['title'] = 'Appointment | GGG Rooms';
        $this->data['js_file'] = array(
          "assets/build/js/moment.min.js",
          "assets/build/js/fullcalendar.min.js",
          "../front/js/bootstrap-datetimepicker.min.js",
          "../front/js/jquery.timepicker.js",
          "../front/js/datepair.js",
          "assets/build/js/calendar.js"
        );

        $this->data['css_file'] = array(
            "assets/build/css/fullcalendar.min.css",
            "assets/build/css/fullcalendar.css",
            "../front/css/bootstrap-datetimepicker.min.css",
            "../front/css/jquery.timepicker.css"
            // "../front/css/calendar.css",
        );

        if($user_promotion != 3){
            $this->render('appointment_calendar_view');
        }else{
            redirect('dashboard', 'refresh');
        }
      } else {
          redirect('Login', 'refresh');
      }
    }
    public function GetWorkerAppointmentsData()
    {
      if($this->input->post())
      {
        $workerId = $this->input->post('workerid');
        $shop_id = $this->input->post('shop_id');
        if(!empty($shopid))
        {
            $WorkerAppointmentData = $this->general_model->GetWorkerAppointments(array('appointment.worker_id'=>$workerId, 'appointment.shop_id'=>$shop_id, 'appointment.booking_status'=>1, 'appointment.is_deleted'=>0, 'workers.is_deleted'=>0));
        }else{
            $WorkerAppointmentData = $this->general_model->GetWorkerAppointments(array('appointment.worker_id'=>$workerId, 'appointment.booking_status'=>1, 'appointment.is_deleted'=>0, 'workers.is_deleted'=>0));
        }


        $arr = [];
        foreach ($WorkerAppointmentData as $key => $value)
        {
          $ap_id = $value->id;
          $main_date = date("d-m-Y", strtotime($value->ap_date));

          $fromtime = substr($value->from_time,0,8);
          $totime = substr($value->to_time,0,8);
          $f_start = date('g:i A',strtotime($fromtime));
          $t_start = date('g:i A',strtotime($totime));
          // print_r($fromtime);exit;
          $startDate = $value->ap_date.'T'.$fromtime;
          $endDate = $value->ap_date.'T'.$totime;
          // $value->firstname.' '.$f_start.' - '.$t_start
          $arr[] = array('title'=>$f_start.' - '.$t_start,'start'=>$startDate,'end'=>$endDate, 'email'=>$value->user_email, 'mobile'=>$value->user_mobile, 'service'=>$value->service_name, 'user'=>$value->firstname.' '.$value->lastname,'ap_id'=>$ap_id,'ap_date'=>$main_date,'ap_start'=>$f_start);
        }
        echo json_encode($arr);exit;
        // echo $this->db->last_query();exit;
      }
    }

    public function GetShopWorkerData()
    {
      if($this->input->post())
      {
        $shopid = $this->input->post('shopid');
        if(!empty($shopid))
        {
          $WorkersData = $this->general_model->all_get_all_general_data('*', 'workers', array('shop_id' => $shopid,'is_deleted' => 0));

          $WorkerAppointmentData = $this->general_model->GetWorkerAppointments(array('appointment.shop_id'=>$shopid, 'appointment.is_deleted'=>0, 'appointment.booking_status'=>1, 'workers.is_deleted'=>0));
          $arr = [];
        }
        else
        {
          $WorkersData = $this->general_model->all_get_all_general_data('*', 'workers', array('is_deleted' => 0));

          $WorkerAppointmentData = $this->general_model->GetWorkerAppointments(array('appointment.is_deleted'=>0, 'appointment.booking_status'=>1, 'workers.is_deleted'=>0));
          $arr = [];
        }
        // echo $this->db->last_query();exit;
        $workerHtml = '';
        foreach ($WorkersData as $key => $value) {
          $workerHtml .= '<button type="button" class="btn WorkerData full-width-btn" data-id="'.$value['id'].'" data-shop-id="'.$shopid.'">'.$value['name'].'</button>';
        }

        // appointment time

        // echo '<pre>';print_r($WorkerAppointmentData);exit;
        foreach ($WorkerAppointmentData as $key => $value)
        {
          $ap_id = $value->id;
          $main_date = date("d-m-Y", strtotime($value->ap_date));

          $fromtime = substr($value->from_time,0,8);
          $totime = substr($value->to_time,0,8);
          $f_start = date('g:i A',strtotime($fromtime));
          $t_start = date('g:i A',strtotime($totime));
          // print_r($fromtime);exit;
          $startDate = $value->ap_date.'T'.$fromtime;
          $endDate = $value->ap_date.'T'.$totime;
          // $value->firstname.' '.$f_start.' - '.$t_start
          $arr[] = array('title'=>$f_start.' - '.$t_start,'start'=>$startDate,'end'=>$endDate, 'email'=>$value->user_email, 'mobile'=>$value->user_mobile, 'service'=>$value->service_name, 'user'=>$value->firstname.' '.$value->lastname,'ap_id'=>$ap_id,'ap_date'=>$main_date,'ap_start'=>$f_start);
        }
        $arr[0] = $arr;
        $arr[1] = $workerHtml;

        echo json_encode($arr);
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
                    redirect('calendar', 'refresh');
                } else {

                  $appointment_id = $this->input->post('appointment_id');
                  $cu_date = $this->input->post('ap_date');
                  $ap_date = date("Y-m-d", strtotime($cu_date));
                  $cu_time = $this->input->post('start_time');

                  $appointment_data = $this->general_model->get_appointment_data_main('appointment', array('appointment.id' => $appointment_id));

                  $service_time = $appointment_data->time;
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
                  redirect('calendar', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('calendar', 'refresh');
            }
        }
    }

    public function get_worker_time_check(){
      $ap_id = $this->input->post('ap_id');
      $ap_date = $this->input->post('ap_date');
      $from_time = $this->input->post('from_time');
      $f_start = date("H:i", strtotime($from_time));

      $appointment_data = $this->general_model->get_appointment_data_main('appointment', array('appointment.id' => $ap_id, 'appointment.is_deleted' => 0));

      $parts = explode('-', $ap_date);
      $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
      $day = date('l', strtotime($f_worker_date));

      $worker_list = $this->general_model->check_worker_time('worker_available_time', array('worker_id' => $appointment_data->worker_id, 'shop_id' => $appointment_data->shop_id, 'from_time' => $f_start, 'to_time' => $f_start, 'worker_day' => $day, 'is_deleted' => 0));

      $worker_list_available_time = $this->general_model->get_worker_time('*', 'worker_available_time', array('worker_id' => $appointment_data->worker_id, 'shop_id' => $appointment_data->shop_id, 'is_deleted' => 0));

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
      $ap_id = $this->input->post('ap_id');
      $ap_date = $this->input->post('ap_date');
      $from_time = $this->input->post('from_time');
      $f_start = date("H:i", strtotime($from_time));
      $parts = explode('-', $ap_date);
      $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
      $app_date = date("Y-m-d", strtotime($f_worker_date));

      $appointment_data = $this->general_model->get_appointment_data_main('appointment', array('appointment.id' => $ap_id, 'appointment.is_deleted' => 0));

      $worker_list = $this->general_model->check_exist_data('*','appointment',array('worker_id' => $appointment_data->worker_id, 'shop_id' => $appointment_data->shop_id, 'service_id' => $appointment_data->service_id, 'from_time' => $f_start, 'ap_date' => $app_date, 'is_deleted' => 0, 'booking_status' => 1));

      // echo '<pre>';print_r($worker_list);exit;
      if(!empty($worker_list))
      {
        echo 1;exit;
      }
      else
      {
        echo 0;exit;
      }
    }

    public function delete_appointment() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
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

          if (isset($update_id)) {

              $data['success_message'] = 'Appointment updated successfully';
              $data['id'] = $sid;
              echo json_encode($data);
              exit;
          }
      } else {
          $data['error_message'] = 'Something wents wrong!';
          echo json_encode($data);
          exit;
      }
    }

}
