<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Calendar class.
 *
 * @extends CI_Controller
 */
class Location extends Admin_Controller {
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

        $state_list = $this->general_model->get_location_state_data('*', 'state', array());
        foreach ($state_list as $key => $state) {
          $var =  $this->url_encrypt($state->id);
          $state_list[$key]->encrypt_id = $var;
        }
        $this->data['state_list'] = $state_list;
    		$this->data['title'] = 'Location | GGG Rooms';

		    $this->render('state_view');
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function add_state() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $this->data['js_file'] = array(
              "../front/js/jquery.timepicker.js",
              "../front/js/datepair.js",
              "../front/js/jquery.datepair.js",
          );
          $this->data['css_file'] = array(
              "../front/css/jquery.timepicker.css"
          );

          $this->data['title'] = 'Location | GGG Rooms';
          $this->render('add_state_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function insert_state() {

        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('state_name', 'Name', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('location/add_state', 'refresh');
                } else {
                  $name = $this->input->post('state_name');
                  $chk_state_hours = $this->input->post('add_state_hours');
                  $break_start_time = $this->input->post('break_hours_start_time');
                  $break_end_time = $this->input->post('break_hours_end_time');
                  $break_s_time = date("H:i", strtotime($break_start_time));
                  $break_e_time = date("H:i", strtotime($break_end_time));

                  if($chk_state_hours != ''){
                    $start_time = $this->input->post('hours_start_time');
                    $end_time = $this->input->post('hours_end_time');
                    $s_time = date("H:i", strtotime($start_time));
                    $e_time = date("H:i", strtotime($end_time));
                  }else{
                    $s_time = '';
                    $e_time = '';
                  }

                  $data = array(
                      'name' => $name,
                      'start_time' => $s_time,
                      'end_time' => $e_time,
                      'break_start_time' => $break_s_time,
                      'break_end_time' => $break_e_time,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0,
                  );
                  $inserted_id = $this->general_model->insert_state($data, 'state');
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "State added successfully");
                    redirect('location', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('location', 'refresh');
                  }
                }
            } else {
                redirect('location', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_state($state_id) {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $state_id = $this->url_decrypt($state_id);
          $state_list = $this->general_model->get_location_state_data_by_id('*', 'state', array('id' => $state_id));
          $var =  $this->url_encrypt($state_list->id);
          $state_list->encrypt_id = $var;

          if($state_list->start_time == "00:00:00"){
              $state_list->start_time = '';
          }
          if($state_list->end_time == "00:00:00"){
              $state_list->end_time = '';
          }
          if($state_list->break_start_time == "00:00:00"){
              $state_list->break_start_time = '';
          }
          if($state_list->break_end_time == "00:00:00"){
              $state_list->break_end_time = '';
          }
          $this->data['state_list'] = $state_list;

          $this->data['js_file'] = array(
              "../front/js/jquery.timepicker.js",
              "../front/js/datepair.js",
              "../front/js/jquery.datepair.js",
          );
          $this->data['css_file'] = array(
              "../front/css/jquery.timepicker.css"
          );

          $this->data['title'] = 'Location | GGG Rooms';
          $this->render('edit_state_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function update_state() {
        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('state_name', 'Name', 'required');

                $state_id = $this->input->post('state_id');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('location/edit_state/'.$state_id, 'refresh');
                } else {
                  $name = $this->input->post('state_name');
                  $chk_state_hours = $this->input->post('add_state_hours');
                  $break_start_time = $this->input->post('break_hours_start_time');
                  $break_end_time = $this->input->post('break_hours_end_time');
                  $break_s_time = date("H:i", strtotime($break_start_time));
                  $break_e_time = date("H:i", strtotime($break_end_time));

                  if($chk_state_hours != ''){
                    $start_time = $this->input->post('hours_start_time');
                    $end_time = $this->input->post('hours_end_time');
                    $s_time = date("H:i", strtotime($start_time));
                    $e_time = date("H:i", strtotime($end_time));
                  }else{
                    $s_time = '';
                    $e_time = '';
                  }

                  $data = array(
                      'name' => $name,
                      'start_time' => $s_time,
                      'end_time' => $e_time,
                      'break_start_time' => $break_s_time,
                      'break_end_time' => $break_e_time,
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0,
                  );
                  $inserted_id = $this->general_model->update_state_data($data, 'state', array('id' => $state_id));
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "State update successfully");
                    redirect('location', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('location', 'refresh');
                  }
                }
            } else {
                redirect('location', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function active_state_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 1,
            'is_deleted' => 0
          );

          $update_id = $this->general_model->active_inactive_page($data, 'state', array('id' => $sid));

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

    public function inactive_state_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 0,
            'is_deleted' => 1
          );
          $update_id = $this->general_model->active_inactive_page($data, 'state', array('id' => $sid));

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

}
