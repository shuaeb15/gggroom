<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Admin extends Admin_Controller {
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
          $user_promotion =  $admin_data[0]['user_promotion'];

          $admin_list = $this->general_model->get_admin_user_data('*','admin', array('admin.is_deleted' => 0));
            foreach ($admin_list as $key => $admin) {
              $var =  $this->url_encrypt($admin->id);
              $admin_list[$key]->encrypt_id = $var;

              $role_permission = $this->general_model->get_module_admin_data('*','user_access', array('user_access.role_id' => $admin->id, 'user_access.is_deleted' => 0));
              $admin_list[$key]->permission = $role_permission;
            }
            // echo '<pre>';print_r($admin_list);exit;
            $total_admin = count($admin_list);
            $this->data['admin_list'] = $admin_list;
            $this->data['total_admin'] = $total_admin;
            if($user_promotion == 1){
                $this->render('admin_list');
            }else{
                redirect('dashboard', 'refresh');
            }

        } else {
            redirect('Login', 'refresh');
        }
    }
    public function add_user() {
      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;
        $user_promotion =  $admin_data[0]['user_promotion'];

        $role_list = $this->general_model->get_user_data_asc('*','role', array('is_deleted' => 0));
        $this->data['role_list'] = $role_list;

        $module_list = $this->general_model->get_user_data_asc('*','module', array('is_deleted' => 0));
        $this->data['module_list'] = $module_list;

        if($user_promotion == 1){
            $this->render('add_admin_user');
        }else{
            redirect('dashboard', 'refresh');
        }
      } else {
          redirect('Login', 'refresh');
      }
    }
    public function insert_user() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          $role_id =  $admin_data[0]['id'];
          $user_promotion =  $admin_data[0]['user_promotion'];

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('fname', 'Firstname', 'required');
                $this->form_validation->set_rules('lname', 'Lastname', 'required');
                $this->form_validation->set_rules('user_role', 'Role', 'required');
                // $this->form_validation->set_rules('u_email', 'Password', 'required|valid_email');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('admin/add_user', 'refresh');
                } else {
                    $u_email = $this->input->post('u_email');
                    if ($this->general_model->check_exist_data('id', 'admin', array('email' => $u_email, 'is_deleted' => 0))) {
                        $this->session->set_flashdata('error_message', "User already exist.");
                        redirect('admin/add_user', 'refresh');
                    }else {
                      $fname = $this->input->post('fname');
                      $lname = $this->input->post('lname');
                      $u_email = $this->input->post('u_email');
                      $user_role = $this->input->post('user_role');
                      $user_all = $this->input->post('u_1');

                      $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
                      $password = substr(str_shuffle($password_string), 0, 12);

                      $data = array(
                          'firstname' => $fname,
                          'lastname' => $lname,
                          'email' => $u_email,
                          'password' => $this->url_encrypt($password),
                          'user_promotion' => $user_role,
                          'created_date' => date('Y-m-d H:i:s'),
                          'updated_date' => date('Y-m-d H:i:s'),
                          'is_deleted' => 0,
                      );

                      $inserted_id = $this->general_model->insert_user($data, 'admin');
                      $uname = 'user'.$inserted_id;
                      $username = array(
                          'username' => $uname,
                      );
                      $update_id = $this->general_model->update_user_data($username, 'admin', array('id' => $inserted_id));

                      $role_data = $this->general_model->get_user_data_asc('role_name','role', array('id' => $user_role,'is_deleted' => 0));
                      $email_data = array(
                          'firstname' => $fname,
                          'lastname' => $lname,
                          'email' => $u_email,
                          'password' => $password,
                          'username' => $uname,
                          'user_promotion' => $role_data[0]->role_name,
                      );

                      $emailsend = $this->general_model->sendregister_admin_user($email_data);

                      if ($inserted_id) {
                        if($user_all != ''){
                          $role_id = $inserted_id;
                          $module_id = '1';
                          $user_1_1 = '1';
                          $user_1_2 = '1';
                          $user_1_3 = '1';

                          $data1 = array(
                              'role_id' => $role_id,
                              'module_id' => $module_id,
                              'u_add' => $user_1_1,
                              'u_edit' => $user_1_2,
                              'u_delete' => $user_1_3,
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s'),
                              'is_deleted' => 0,
                          );
                          $inserted_role_id = $this->general_model->insert_user($data1, 'user_access');
                        }else{
                          $count = 0;
                          $module_list = $this->general_model->get_user_data_asc('*','module', array('is_deleted' => 0));
                          $this->data['module_list'] = $module_list;
                          foreach ($module_list as $key => $value) {
                            if($count == 0){
                              $count++;
                            }else{
                              $role_id = $inserted_id;
                              $module_id = $value->id;
                              $user_1_add = $this->input->post('u_'.$module_id);
                              if($user_1_add != ''){
                                $u_1_1 = $this->input->post('u_'.$module_id.'_1');
                                $u_1_2 = $this->input->post('u_'.$module_id.'_2');
                                $u_1_3 = $this->input->post('u_'.$module_id.'_3');
                                if($u_1_1 != ''){
                                    $main_u_1_1 = '1';
                                }else{
                                    $main_u_1_1 = '0';
                                }
                                if($u_1_2 != ''){
                                    $main_u_1_2 = '1';
                                }else{
                                    $main_u_1_2 = '0';
                                }
                                if($u_1_3 != ''){
                                    $main_u_1_3 = '1';
                                }else{
                                    $main_u_1_3 = '0';
                                }

                                $data1 = array(
                                    'role_id' => $role_id,
                                    'module_id' => $module_id,
                                    'u_add' => $main_u_1_1,
                                    'u_edit' => $main_u_1_2,
                                    'u_delete' => $main_u_1_3,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'is_deleted' => 0,
                                );
                                $inserted_role_id = $this->general_model->insert_user($data1, 'user_access');
                              }
                            }
                          }
                        }
                        $this->session->set_flashdata('success_message', "User added successfully");
                        redirect('admin', 'refresh');
                      }
                    }
                }
            } else {
              if($user_promotion == 1){
                  $this->render('admin/add_user');
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

          $id = $this->url_decrypt($id);
            if ($id != '') {
                $admin_list = $this->general_model->check_exist_data('*', 'admin', array('id' => $id));
                $this->data['admin_list'] = $admin_list;
                $role_list = $this->general_model->get_user_data_asc('*','role', array('is_deleted' => 0));
                $this->data['role_list'] = $role_list;

                $module_list = $this->general_model->get_user_data_asc('*','module', array('is_deleted' => 0));
                $this->data['module_list'] = $module_list;

                $user_module_list = $this->general_model->get_user_data_asc('*','user_access', array('role_id' => $admin_list->id, 'is_deleted' => 0));
                $this->data['user_module_list'] = $user_module_list;

                if($user_promotion == 1){
                    $this->render('edit_admin_user');
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
                  $role_id = $this->input->post('user_id');
                  $user_all = $this->input->post('u_1');
                  $fname = $this->input->post('fname');
                  $lname = $this->input->post('lname');
                  $u_email = $this->input->post('u_email');
                  $user_role = $this->input->post('user_role');
                  if($user_role == 1){
                      $user_all = '1';
                  }
                  $admin_data = array(
                      'firstname' => $fname,
                      'lastname' => $lname,
                      'email' => $u_email,
                      'user_promotion' => $user_role,
                      'created_date' => date('Y-m-d H:i:s'),
                      'updated_date' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );
                  $update_id = $this->general_model->update_user_data($admin_data, 'admin', array('id' => $role_id));

                  if($user_all != ''){
                    $module_id = '1';
                    $user_1_1 = '1';
                    $user_1_2 = '1';
                    $user_1_3 = '1';

                    if ($this->general_model->check_exist_data('id', 'user_access', array('role_id' => $role_id, 'module_id' => $module_id))) {
                      $data1 = array(
                          'u_add' => $user_1_1,
                          'u_edit' => $user_1_2,
                          'u_delete' => $user_1_3,
                          'updated_at' => date('Y-m-d H:i:s'),
                          'is_deleted' => 0,
                      );
                      $update_id = $this->general_model->update_user_data($data1, 'user_access', array('role_id' => $role_id, 'module_id' => $module_id));
                    }else{
                      $data1 = array(
                          'role_id' => $role_id,
                          'module_id' => $module_id,
                          'u_add' => $user_1_1,
                          'u_edit' => $user_1_2,
                          'u_delete' => $user_1_3,
                          'created_at' => date('Y-m-d H:i:s'),
                          'updated_at' => date('Y-m-d H:i:s'),
                          'is_deleted' => 0,
                      );
                      $inserted_role_id = $this->general_model->insert_user($data1, 'user_access');
                    }
                    $delete_data = $this->general_model->delete_user_module('user_access', array('role_id' => $role_id, 'module_id !=' => $module_id));
                  }else{
                    $delete_data = $this->general_model->delete_user_module('user_access', array('role_id' => $role_id, 'module_id' => '1'));

                    $count = 0;
                    $module_list = $this->general_model->get_user_data_asc('*','module', array('is_deleted' => 0));
                    $this->data['module_list'] = $module_list;
                    foreach ($module_list as $key => $value) {
                      if($count == 0){
                        $count++;
                      }else{
                        $module_id = $value->id;
                        $user_1_add = $this->input->post('u_'.$module_id);
                        if($user_1_add != ''){
                        if ($this->general_model->check_exist_data('id', 'user_access', array('role_id' => $role_id, 'module_id' => $module_id))) {

                          $u_1_1 = $this->input->post('u_'.$module_id.'_1');
                          $u_1_2 = $this->input->post('u_'.$module_id.'_2');
                          $u_1_3 = $this->input->post('u_'.$module_id.'_3');
                          if($u_1_1 != ''){
                              $main_u_1_1 = '1';
                          }else{
                              $main_u_1_1 = '0';
                          }
                          if($u_1_2 != ''){
                              $main_u_1_2 = '1';
                          }else{
                              $main_u_1_2 = '0';
                          }
                          if($u_1_3 != ''){
                              $main_u_1_3 = '1';
                          }else{
                              $main_u_1_3 = '0';
                          }
                          $user_access_data = array(
                              'u_add' => $main_u_1_1,
                              'u_edit' => $main_u_1_2,
                              'u_delete' => $main_u_1_3,
                              'updated_at' => date('Y-m-d H:i:s'),
                              'is_deleted' => 0,
                          );
                          $update_id = $this->general_model->update_user_data($user_access_data, 'user_access', array('role_id' => $role_id, 'module_id' => $module_id));
                          // echo $this->db->last_query();exit;
                          }else {
                            $u_1_1 = $this->input->post('u_'.$module_id.'_1');
                            $u_1_2 = $this->input->post('u_'.$module_id.'_2');
                            $u_1_3 = $this->input->post('u_'.$module_id.'_3');
                            if($u_1_1 != ''){
                                $main_u_1_1 = '1';
                            }else{
                                $main_u_1_1 = '0';
                            }
                            if($u_1_2 != ''){
                                $main_u_1_2 = '1';
                            }else{
                                $main_u_1_2 = '0';
                            }
                            if($u_1_3 != ''){
                                $main_u_1_3 = '1';
                            }else{
                                $main_u_1_3 = '0';
                            }

                            $data1 = array(
                                'role_id' => $role_id,
                                'module_id' => $module_id,
                                'u_add' => $main_u_1_1,
                                'u_edit' => $main_u_1_2,
                                'u_delete' => $main_u_1_3,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'is_deleted' => 0,
                            );
                            $inserted_role_id = $this->general_model->insert_user($data1, 'user_access');
                        }
                      }else{
                          $delete_data = $this->general_model->delete_user_module('user_access', array('role_id' => $role_id, 'module_id' => $module_id));
                      }
                    }
                  }
                }
                $this->session->set_flashdata('success_message', "User updated successfully");
                redirect('admin', 'refresh');
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('admin', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function remove_user() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];
        $admin_id = $this->session->userdata('admin_id');
          $data = array(
            'is_deleted' => 1,
          );

          $update_id = $this->general_model->active_user($data, 'admin', array('id' => $sid));

          if (isset($update_id)) {
            if($sid == $admin_id){
              $this->session->unset_userdata('admin_id');
              $this->session->unset_userdata('is_logged_in');
              $this->session->unset_userdata('name');
              $this->session->unset_userdata('email');
            }
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

public function get_module_data(){
  $module_list = $this->general_model->get_user_data_asc('*','module', array('id' => 1, 'is_deleted' => 0));
  echo json_encode($module_list);exit;
  }
}
