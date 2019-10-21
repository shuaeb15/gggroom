
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Contact_info extends Admin_Controller {

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
            if($this->input->post()){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('Freecall', 'Freecall', 'trim|required');
                $this->form_validation->set_rules('Telephone', 'Telephone', 'trim|required');
                $this->form_validation->set_rules('Fax', 'Fax', 'trim|required');
                $this->form_validation->set_rules('Email', 'Email', 'trim|required');
                $this->form_validation->set_rules('Address', 'Address', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('Contact_info', 'refresh');
                } else {
                      $Freecall = $this->input->post('Freecall');
                      $Telephone = $this->input->post('Telephone');
                      $Fax = $this->input->post('Fax');
                      $Email = $this->input->post('Email');
                      $Address = $this->input->post('Address');
                      if ($this->general_model->check_exist_data('id', 'CI_contact_admin', array('id' => 1, 'is_deleted' => 0))) {
                        $data = array(
                            'Freecall' => $Freecall,
                            'Telephone' => $Telephone,
                            'Fax' => $Fax,
                            'Email' => $Email,
                            'Address' => $Address,
                            'is_deleted' => 0,
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        $update_id = $this->general_model->update_general_data($data, 'CI_contact_admin', array('id' => 1));
                        if ($update_id) {
                           $this->session->set_flashdata('success_message', "Contact Info added successfully");
                            redirect('Contact_info', 'refresh');
                        }
                    } else {
                        $data = array(
                            'Freecall' => $Freecall,
                            'Telephone' => $Telephone,
                            'Fax' => $Fax,
                            'Email' => $Email,
                            'Address' => $Address,
                            'is_deleted' => 0,
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        $inserted_id = $this->general_model->create_general_data($data, 'CI_contact_admin');
                        if ($inserted_id) {
                            $this->session->set_flashdata('success_message', "Contact Info added successfully");
                            redirect('Contact_info', 'refresh');
                        }
                    }
                }
            }
            else{
                $contact = $this->general_model->get_all_general_data("*", "CI_contact_admin", array('is_deleted' => 0), 'result_array');
            $this->data['contact'] = $contact;
            $this->render('Contact/Contact_view');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }
}
