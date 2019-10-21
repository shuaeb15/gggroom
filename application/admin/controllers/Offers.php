<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Calendar class.
 *
 * @extends CI_Controller
 */
class Offers extends Admin_Controller {
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

        if ($this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 1, 'is_deleted' => 0), 'result_array')) {
          $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 1, 'is_deleted' => 0), 'result_array');
        }else{
          $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 7, 'is_deleted' => 0), 'result_array');
        }
        $this->data['user_access_data'] = $user_access_data;

        $offers_list = $this->general_model->get_offres_data('offers', array());
        foreach ($offers_list as $key => $value) {
          $var =  $this->url_encrypt($value->id);
          $offers_list[$key]->encrypt_id = $var;

          $shop_list = $this->general_model->get_services('services', array('services.id' => $value->service_id));
          if(!empty($shop_list)){
            $offers_list[$key]->shop_name = $shop_list[0]->shop_name;
          }else{
              $offers_list[$key]->shop_name = '';
          }
        }
        $this->data['offers_list'] = $offers_list;

    		$this->data['title'] = 'Promotions and offers | GGG Rooms';
		    $this->render('offers_view');
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function add_offers() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $services_list = $this->general_model->get_services('services', array('services.is_deleted' => 0));
          $this->data['services_list'] = $services_list;

          $this->data['js_file'] = array(
              "../front/js/jquery-editable-select.min.js",
          );
          $this->data['css_file'] = array(
              "../front/css/jquery-editable-select.min.css"
          );

          $this->data['title'] = 'Promotions and offers | GGG Rooms';
          $this->render('add_offers_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function insert_offer() {

        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('offer_code', 'Code', 'required');
                $this->form_validation->set_rules('price', 'Price', 'required');
                // $this->form_validation->set_rules('service_name', 'Services', 'required');
                $this->form_validation->set_rules('discount_type', 'Discount type', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('offers/add_offers', 'refresh');
                } else {

                  $user_id = $this->session->userdata('admin_id');
                  $offer_code = $this->input->post('offer_code');
                  $price = $this->input->post('price');
                  $service_id = $this->input->post('service_id');
                  $discount_type = $this->input->post('discount_type');
                  $offer_type = $this->input->post('offer_radio_type');

                  $data = array(
                      'user_id' => $user_id,
                      'code' => $offer_code,
                      'price' => $price,
                      'service_id' => $service_id,
                      'discount_type' => $discount_type,
                      'offer_type' => $offer_type,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0,
                      'flag' => 1,
                  );
                  $inserted_id = $this->general_model->insert_state($data, 'offers');
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "Offers added successfully");
                    redirect('offers', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('offers', 'refresh');
                  }
                }
            } else {
                redirect('offers', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_offers($id1) {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $id1 = $this->url_decrypt($id1);
          $offer_data = $this->general_model->get_page_data_id('*', 'offers', array('id' => $id1));
          $var =  $this->url_encrypt($offer_data->id);
          $offer_data->encrypt_id = $var;
          $this->data['offer_data'] = $offer_data;

          $services_list = $this->general_model->get_services('services', array('services.is_deleted' => 0));
          $this->data['services_list'] = $services_list;

          $this->data['js_file'] = array(
              "../front/js/jquery-editable-select.min.js",
          );
          $this->data['css_file'] = array(
              "../front/css/jquery-editable-select.min.css"
          );

          $this->data['title'] = 'Promotions and offers | GGG Rooms';
          $this->render('edit_offers_view');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function update_offer() {

        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('offer_code', 'Code', 'required');
                $this->form_validation->set_rules('price', 'Price', 'required');
                // $this->form_validation->set_rules('service_name', 'Services', 'required');
                $this->form_validation->set_rules('discount_type', 'Discount type', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('offers/add_offers', 'refresh');
                } else {

                  $user_id = $this->session->userdata('admin_id');
                  $offer_id = $this->input->post('offer_id');
                  $offer_code = $this->input->post('offer_code');
                  $price = $this->input->post('price');
                  $service_id = $this->input->post('service_id');
                  $discount_type = $this->input->post('discount_type');
                  $offer_type = $this->input->post('offer_radio_type');
                  if($offer_type == '1'){
                    $service_id = 0;
                  }
                  $data = array(
                      'user_id' => $user_id,
                      'code' => $offer_code,
                      'price' => $price,
                      'service_id' => $service_id,
                      'discount_type' => $discount_type,
                      'offer_type' => $offer_type,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0,
                      'flag' => 1,
                  );
                  $updated_id = $this->general_model->update_shop_data($data, 'offers', array('id' => $offer_id));

                  $this->session->set_flashdata('success_message', "Offers updated successfully");
                  redirect('offers', 'refresh');
                }
            } else {
                redirect('offers', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function active_offers_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 1,
            'is_deleted' => 0
          );

          $update_id = $this->general_model->active_inactive_page($data, 'offers', array('id' => $sid));

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

    public function inactive_offers_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 0,
            'is_deleted' => 1
          );
          $update_id = $this->general_model->active_inactive_page($data, 'offers', array('id' => $sid));

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
    // public function Get_services_Data()
    // {
    //   if($this->input->post())
    //   {
    //     $services = $this->input->post('term');
    //     $services_where = "services.is_deleted = 0 AND services.service_name LIKE '%".$services."%'";
    //     $service_list = $this->general_model->get_auto_services_data('services',$services_where,'result_array','','','services.service_name');
    //     $searchData = $service_list;
    //     foreach ($searchData as $value) {
    //       $service_name = $value['service_name'].' - '.$value['shop_name'];
    //       $data[] = array('value' => $service_name , 'id' => $value['id']);
    //     }
    //     echo json_encode($data);
    //   }
    // }
}
