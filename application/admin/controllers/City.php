<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Calendar class.
 *
 * @extends CI_Controller
 */
class City extends Admin_Controller {
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

        $city_list = $this->general_model->get_location_state_data('*', 'city', array());
        foreach ($city_list as $key => $city) {
          $var =  $this->url_encrypt($city->id);
          $city_list[$key]->encrypt_id = $var;
        }
        $this->data['city_list'] = $city_list;
    		$this->data['title'] = 'City | GGG Rooms';

		    $this->render('city_view');
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function add_city() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $this->data['title'] = 'City | GGG Rooms';
          $this->render('add_city_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function insert_city() {

        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('city_name', 'Name', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('city/add_city', 'refresh');
                } else {
                  $name = $this->input->post('city_name');

                  $data = array(
                      'name' => $name,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0,
                  );
                  $inserted_id = $this->general_model->insert_state($data, 'city');
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "City added successfully");
                    redirect('city', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('city', 'refresh');
                  }
                }
            } else {
                redirect('city', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_city($city_id) {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          
          $city_id = $this->url_decrypt($city_id);
          $city_list = $this->general_model->get_location_state_data_by_id('*', 'city', array('id' => $city_id));
          $var =  $this->url_encrypt($city_list->id);
          $city_list->encrypt_id = $var;

          $this->data['city_list'] = $city_list;
          $this->data['title'] = 'City | GGG Rooms';
          $this->render('edit_city_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function update_city() {
        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city_name', 'Name', 'required');

                $city_id = $this->input->post('city_id');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('city/edit_city/'.$city_id, 'refresh');
                } else {
                  $name = $this->input->post('city_name');

                  $data = array(
                      'name' => $name,
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0,
                  );
                  $inserted_id = $this->general_model->update_state_data($data, 'city', array('id' => $city_id));
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "City update successfully");
                    redirect('city', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('city', 'refresh');
                  }
                }
            } else {
                redirect('city', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function active_city_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 1,
            'is_deleted' => 0
          );

          $update_id = $this->general_model->active_inactive_page($data, 'city', array('id' => $sid));

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

    public function inactive_city_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 0,
            'is_deleted' => 1
          );
          $update_id = $this->general_model->active_inactive_page($data, 'city', array('id' => $sid));

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
