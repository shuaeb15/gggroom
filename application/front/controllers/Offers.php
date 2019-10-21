<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Offers extends MY_Controller {
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
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          $encrypt_u_id = $this->url_encrypt($id);
          $this->data['encrypt_u_id'] = $encrypt_u_id;

          $services_list = $this->general_model->get_services('services', array('services.user_id' => $id, 'services.is_deleted' => 0));
          $this->data['services_list'] = $services_list;

          $this->data['js_file'] = array(
              "front/js/jquery-editable-select.min.js",

          );
          $this->data['css_file'] = array(
              "front/css/jquery-editable-select.min.css"
          );

          $this->data['title'] = 'Promotions & Offers | GGG Rooms';
          $this->render('add_offers_view');
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function insert_offer() {

        if ($this->session->userdata('uid')) {
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
                    redirect('offers', 'refresh');
                } else {
                  $user_id = $this->session->userdata('uid');
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
                      'flag' => 2,
                  );
                  $inserted_id = $this->general_model->insert_category($data, 'offers');
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
}
