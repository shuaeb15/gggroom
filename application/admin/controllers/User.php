<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class User extends Admin_Controller {
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
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 2, 'is_deleted' => 0), 'result_array');
          }
          $this->data['user_access_data'] = $user_access_data;
          $user_list = $this->general_model->get_user_data('*','user', array('is_removed' => 0));
          foreach ($user_list as $key => $page) {
            $var =  $this->url_encrypt($page->id);
            $user_list[$key]->encrypt_id = $var;
          }
          $this->data['user_list'] = $user_list;
          if($user_promotion != 3){
              $this->render('User/user_list');
          }else{
              redirect('dashboard', 'refresh');
          }
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function add_user() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          $role_id =  $admin_data[0]['id'];
          $user_promotion =  $admin_data[0]['user_promotion'];

          $this->data['js_file'] = array(
              "../front/js/jquery-editable-select.min.js",

          );
          $this->data['css_file'] = array(
              "../front/css/jquery-editable-select.min.css"
          );

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('fname', 'Firstname', 'required');
                $this->form_validation->set_rules('lname', 'Lastname', 'required');
                // $this->form_validation->set_rules('uname', 'Username', 'required');
                $this->form_validation->set_rules('radio_gender', 'Gender', 'required');
                $this->form_validation->set_rules('u_chk', 'Checkbox', 'required');
                $this->form_validation->set_rules('pwd', 'Password', 'required');
                $this->form_validation->set_rules('u_email', 'Password', 'required|valid_email');
                //echo $this->form_validation->run();
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('User/add_user', 'refresh');
                } else {
                    $u_email = $this->input->post('u_email');
                  //  echo $u_email;exit;
                    if ($this->general_model->check_exist_data('id', 'user', array('email' => $u_email, 'is_deleted' => 0))) {
                        $this->session->set_flashdata('error_message', "User already exist.");
                        redirect('User/add_user', 'refresh');
                    }else {
                      $fname = $this->input->post('fname');
                      $lname = $this->input->post('lname');
                      // $uname = $this->input->post('uname');
                      $u_email = $this->input->post('u_email');
                      $gender = $this->input->post('radio_gender');
                      $pwd = $this->input->post('pwd');
                      $u_chk = $this->input->post('u_chk');

                      $u_data = array(
                          'firstname' => $fname,
                          'lastname' => $lname,
                          // 'username' => $uname,
                          'email' => $u_email,
                          'gender' => $gender,
                          'password' => $pwd,
                          'u_category' => $u_chk,
                      );

                      $data = array(
                          'firstname' => $fname,
                          'lastname' => $lname,
                          // 'username' => $uname,
                          'email' => $u_email,
                          'gender' => $gender,
                          'password' => md5($pwd),
                          'u_category' => $u_chk,
                          'date' => date('Y-m-d H:i:s'),
                          'is_active' => 1,
                          'is_deleted' => 0,
                      );

                      $inserted_id = $this->general_model->insert_user($data, 'user');
                      if ($inserted_id) {
                        $emailsend = $this->general_model->sendConfirmationEmail($u_data);
                        if($emailsend){
                          $this->session->set_flashdata('success_message', "User added successfully");
                          redirect('User', 'refresh');
  				              }else{
  					               $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                           redirect('User', 'refresh');
  				                }
                      }
                    }
                }
            } else {
              if($user_promotion != 3){
                  $this->render('User/add_user');
              }else{
                  redirect('dashboard', 'refresh');
              }
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_user($id) {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          $role_id =  $admin_data[0]['id'];
          $user_promotion =  $admin_data[0]['user_promotion'];

          $this->data['js_file'] = array(
              "../front/js/jquery-editable-select.min.js",

          );
          $this->data['css_file'] = array(
              "../front/css/jquery-editable-select.min.css"
          );

          $id = $this->url_decrypt($id);
            if ($id != '') {
                $cat_data = $this->general_model->check_exist_data('*', 'user', array('id' => $id));
                $this->data['userlist'] = $cat_data;
                if($user_promotion != 3){
                    $this->render('User/edit_user');
                }else{
                    redirect('dashboard', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('User', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function update_user() {
        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {

                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('fname', 'Firstname', 'required');
                $this->form_validation->set_rules('lname', 'Lastname', 'required');
                // $this->form_validation->set_rules('uname', 'Username', 'required');
                $this->form_validation->set_rules('radio_gender', 'Gender', 'required');
                // $this->form_validation->set_rules('u_chk', 'Checkbox', 'required');
               // $this->form_validation->set_rules('u_email', 'Password', 'required|valid_email');

                if ($this->form_validation->run() == false) {
                  $user_id = $this->input->post('user_id');

                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('User/edit_user/'.$user_id, 'refresh');
                }else{
                  $fname = $this->input->post('fname');
                  $lname = $this->input->post('lname');
                  // $uname = $this->input->post('uname');
                  $u_email = $this->input->post('u_email');
                  $u_chk = $this->input->post('u_chk');
                  $gender = $this->input->post('radio_gender');
                  $user_id = $this->input->post('user_id');

                  if($u_chk == 2){
                    $data = array(
                      'is_active' => 1,
                      'is_deleted' => 0
                    );
                    $update_id1 = $this->general_model->active_user($data, 'shop', array('user_id' => $user_id));
                    $worker_update_id = $this->general_model->active_user($data, 'workers', array('user_id' => $user_id));
                    $service_update_id = $this->general_model->active_user($data, 'services', array('user_id' => $user_id));
                  }else{
                    $data = array(
                      'is_active' => 0,
                      'is_deleted' => 1
                    );

                    $update_id1 = $this->general_model->active_user($data, 'shop', array('user_id' => $user_id));
                    $worker_update_id = $this->general_model->active_user($data, 'workers', array('user_id' => $user_id));
                    $service_update_id = $this->general_model->active_user($data, 'services', array('user_id' => $user_id));
                  }

                  $data = array(
                      'firstname' => $fname,
                      'lastname' => $lname,
                      // 'username' => $uname,
                      'email' => $u_email,
                      'gender' => $gender,
                      'u_category' => $u_chk,
                      'updated_date' => date('Y-m-d H:i:s'),
                  );
                    $update_id = $this->general_model->update_user_data($data, 'user', array('id' => $user_id));
                    // if ($update_id) {
                        $this->session->set_flashdata('success_message', "User updated successfully");
                        redirect('User', 'refresh');
                    // }
                }
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('User', 'refresh');
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

          $update_id = $this->general_model->active_user($data, 'user', array('id' => $sid));
          $update_id1 = $this->general_model->active_user($data, 'shop', array('user_id' => $sid));
          $worker_update_id = $this->general_model->active_user($data, 'workers', array('user_id' => $sid));
          $service_update_id = $this->general_model->active_user($data, 'services', array('user_id' => $sid));

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
          $update_id = $this->general_model->active_user($data, 'user', array('id' => $sid));
          $update_id1 = $this->general_model->active_user($data, 'shop', array('user_id' => $sid));
          $worker_update_id = $this->general_model->active_user($data, 'workers', array('user_id' => $sid));
          $service_update_id = $this->general_model->active_user($data, 'services', array('user_id' => $sid));

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

    public function remove_user() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 0,
            'is_deleted' => 1,
            'is_removed' => 1
          );

          $data1 = array(
            'is_active' => 0,
            'is_deleted' => 1,
          );

          $update_id = $this->general_model->active_user($data, 'user', array('id' => $sid));
          $update_id1 = $this->general_model->active_user($data1, 'shop', array('user_id' => $sid));
          $worker_update_id = $this->general_model->active_user($data1, 'workers', array('user_id' => $sid));
          $service_update_id = $this->general_model->active_user($data1, 'services', array('user_id' => $sid));

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

    public function checkUnique($table, $columnName)
    {
       $email = $_POST['u_email'];
       if(!empty($email)) {

       $this->db->select($columnName);
       $this->db->from($table);
       $this->db->where('email',$email);
       $this->db->where('is_active',1);
       $this->db->where('is_deleted',0);
       $count = $this->db->get()->result();
       $count = count($count);
       $count = (int)$count;
       if($count > 0){
          echo 'false';
       }else{
          echo 'true';
       }
    }
}

public function checkUniqueusername($table, $columnName)
{
   $username = $_POST['username'];
   if(!empty($username)) {
      $this->db->select($columnName);
      $this->db->from($table);
      $this->db->where('username',$username);
      $this->db->where('is_active',1);
      $this->db->where('is_deleted',0);
      $count = $this->db->get()->result();
      $count = count($count);
      $count = (int)$count;
      if($count > 0){
        echo 'false';
      }else{
        echo 'true';
      }
   }
}

public function checkUniqueemail($table, $columnName)
{
 $email = $_POST['u_email'];
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
}
