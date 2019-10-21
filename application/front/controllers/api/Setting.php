<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Setting extends MY_Controller {
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
      

      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        // if($user_list->u_category == 2 || $user_list->u_category == 3){
          $encrypt_u_id = $this->url_encrypt($id);
          $this->data['encrypt_u_id'] = $encrypt_u_id;

          $this->data['js_file'] = array(
              "front/js/bootstrap-datetimepicker.min.js",
              "front/js/jquery.maskedinput.min.js",
              "front/js/setting.js"

          );
          $this->data['css_file'] = array(
              "front/css/bootstrap-datetimepicker.min.css"
          );

          $this->data['title'] = 'Setting | GGG Rooms';
          $this->render('setting_view');
        // }else{
        //   redirect('profile', 'refresh');
        // }
      }
    }

    public function delete_profile() {
      $id1 = $this->input->post('id');
      if($id1){
        $data = array(
          'is_active' => 0,
          'is_deleted' => 1
        );
        $update_id = $this->general_model->delete_profile($data, 'user', array('id' => $id1));
        $update_shop = $this->general_model->delete_profile($data, 'shop', array('user_id' => $id1));
        $update_worker = $this->general_model->delete_profile($data, 'workers', array('user_id' => $id1));
        $update_service = $this->general_model->delete_profile($data, 'services', array('user_id' => $id1));

        if($update_id){
          $data = array('login' => '', 'email' => '', 'username' => '', 'firstname' => '', 'uid' => '');
      		$this->session->unset_userdata($data);
          $this->session->set_flashdata('success_message', "Profile Delete successfully");
          redirect('setting', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('setting', 'refresh');
        }
      }
    }

    public function update_message_alert() {
      $id1 = $this->input->post('id');
      $add_alert = $this->input->post('add_alert');
      if($id1){
        if($add_alert == '0'){
          $data = array(
            'message_alert' => '0'
          );
        }
        if($add_alert == '1'){
          $data = array(
            'message_alert' => '1'
          );
        }
        $update_id = $this->general_model->update_notification($data, 'user', array('id' => $id1));
        if($update_id){
          redirect('setting', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('setting', 'refresh');
        }
      }
    }

    public function update_reminder_alert() {
      $id1 = $this->input->post('id');
      $add_alert = $this->input->post('add_alert');
      if($id1){
        if($add_alert == '0'){
          $data = array(
            'reminder_alert' => '0'
          );
        }
        if($add_alert == '1'){
          $data = array(
            'reminder_alert' => '1'
          );
        }
        $update_id = $this->general_model->update_notification($data, 'user', array('id' => $id1));
        if($update_id){
          redirect('setting', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('setting', 'refresh');
        }
      }
    }

    public function update_tips_alert() {
      $id1 = $this->input->post('id');
      $add_alert = $this->input->post('add_alert');
      if($id1){
        if($add_alert == '0'){
          $data = array(
            'tips_alert' => '0'
          );
        }
        if($add_alert == '1'){
          $data = array(
            'tips_alert' => '1'
          );
        }
        $update_id = $this->general_model->update_notification($data, 'user', array('id' => $id1));
        if($update_id){
          redirect('setting', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('setting', 'refresh');
        }
      }
    }

    public function insert_card_detail(){
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('card_number', 'Card Number', 'required');
      $this->form_validation->set_rules('card_name', 'Card Name', 'required');
      $this->form_validation->set_rules('exp_date', 'Expiry Date', 'required');
      $this->form_validation->set_rules('card_cvv', 'CVV Number', 'required');

      if ($this->form_validation->run() == false) {
          $this->session->set_flashdata('error_message', "Please fill required fields.");
          $this->session->set_userdata('USER_DETAIL', $_POST);
          redirect('setting', 'refresh');
      } else {
        $uid = $this->session->userdata('uid');
        $card_number = $this->input->post('card_number');
        $card_name = $this->input->post('card_name');
        $exp_date = $this->input->post('exp_date');
        $card_cvv = $this->input->post('card_cvv');

        $data = array(
            'card_no' => $card_number,
            'card_name' => $card_name,
            'exp_date' => $exp_date,
            'cvv_no' => $card_cvv,
        );

        $updated_id = $this->general_model->update_card_details($data, 'user', array('id' => $uid));
          if($updated_id == '1' || $updated_id == '0'){
            $this->session->set_flashdata('success_message', "Card detail update successfully");
            redirect('setting', 'refresh');
          }else{
             $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
             redirect('setting', 'refresh');
          }
        }
      }

}
