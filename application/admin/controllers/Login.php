<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Login extends Admin_Controller {
    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
        // $this->load->library('session');
    }

    public function index() {

         if (!$this->session->userdata('admin_id')) {
        $this->data['admin'] = '';
        $this->render('Home/login_view');
         }
         else{
             $this->data['Admin'] = '';
            redirect('dashboard');
         }
    }

     public function login() {
      // echo $this->session->userdata('admin_id');exit;
        if (!$this->session->userdata('admin_id')) {
            $this->load->helper('form');
            $this->load->library('form_validation');
            // set validation rules
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->input->post()) {

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('message', "Username and Password is require");
                    redirect('Login', 'refresh');
                } else {
                    // $data = $this->url_decrypt('ellPYkZ5Q3BWL0hSUEFpdzg4NzlOdz09');
                    // echo $data;exit;
                    $email = $this->input->post('email');
                    $password = md5($this->input->post('password'));
                    // echo $this->url_encrypt("123!@#memento");exit;
                     $admin_id = $this->general_model->check_exist_data('*', 'admin', array('email' => $email, 'password' => $password, 'is_deleted' => 0));
                    if (@$admin_id->id) {
                        // echo "hi";exit;

                        // $this->session->set_userdata('special_data',"hello");
                        $_SESSION['admin_id'] = (int) $admin_id->id;
                        $_SESSION['is_logged_in'] = (bool) true;
                        $_SESSION['name'] = $admin_id->username;
                        $_SESSION['email'] = $admin_id->email;
                        // $_SESSION['profile_picture'] = $admin_id->profile_img;
                        redirect('dashboard', 'refresh');
                    } else {
                        $this->session->set_flashdata('error_message', "Please enter correct Username and Password");
                        redirect('Login', 'refresh');
                    }
                }
            }
            $this->render('Home/login_view');
        } else {
            $this->data['Admin'] = '';
            redirect('dashboard');
        }
    }
}
