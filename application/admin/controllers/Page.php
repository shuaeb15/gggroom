<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Page extends Admin_Controller {
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

          $page_data = $this->general_model->get_page_data('*', 'page', array());
          foreach ($page_data as $key => $page) {
            $var =  $this->url_encrypt($page->id);
            $page_data[$key]->encrypt_id = $var;
          }

          $this->data['page_list'] = $page_data;
          $this->render('page_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function add_page() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $this->render('add_page');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function insert_page() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('page_url', 'Page url', 'required');
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
                $this->form_validation->set_rules('footer_page', 'Page', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('page/add_page', 'refresh');
                } else {
                      $name = $this->input->post('name');
                      $page_url = $this->input->post('page_url');
                      $title = $this->input->post('title');
                      $page_type = $this->input->post('footer_page');
                      $description = $this->input->post('description');

                      $data = array(
                          'name' => $name,
                          'page_url' => $page_url,
                          'title' => $title,
                          'description' => $description,
                          'flag' => $page_type,
                          'created_at' => date('Y-m-d H:i:s'),
                          'updated_at' => date('Y-m-d H:i:s'),
                          'is_active' => 1,
                          'is_deleted' => 0,
                      );

                      $inserted_id = $this->general_model->insert_page($data, 'page');

                      if ($inserted_id) {
                        $this->session->set_flashdata('success_message', "Page added successfully");
                        redirect('page', 'refresh');
                      }
                      else{
                        $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                        redirect('page', 'refresh');
                      }
                }
            } else {
                $this->render('page/add_page');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_page($id1) {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $id1 = $this->url_decrypt($id1);
          $page_data = $this->general_model->get_page_data_id('*', 'page', array('id' => $id1));
          $var =  $this->url_encrypt($page_data->id);
          $page_data->encrypt_id = $var;
          $this->data['page_list'] = $page_data;

          $this->render('edit_page');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function update_page() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');

                if ($this->form_validation->run() == false) {

                    $this->session->set_flashdata('error_message', "Please fill required fields.");

                    $this->session->set_userdata('PAGE_DETAIL', $_POST);

                    redirect('page', 'refresh');

                } else {
                      $name = $this->input->post('name');
                      $page_url = $this->input->post('page_url');
                      $title = $this->input->post('title');
                      $description = $this->input->post('description');
                      $page_id = $this->input->post('page_id');
                      $page_type = $this->input->post('footer_page');

                      $data = array(
                          'name' => $name,
                          'page_url' => $page_url,
                          'title' => $title,
                          'description' => $description,
                          'flag' => $page_type,
                          'updated_at' => date('Y-m-d H:i:s'),
                          'is_active' => 1,
                          'is_deleted' => 0,
                      );

                      $updated_id = $this->general_model->update_page_data($data, 'page', array('id' => $page_id));

                      if ($updated_id) {
                        $this->session->set_flashdata('success_message', "Page updated successfully");
                        redirect('page', 'refresh');
                      }
                      else{
                        $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                        redirect('page', 'refresh');
                      }
                }
            } else {
                $this->render('page/add_page');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function active_page_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 1,
            'is_deleted' => 0
          );

          $update_id = $this->general_model->active_inactive_page($data, 'page', array('id' => $sid));

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

    public function inactive_page_id() {
      $data = array();
      if ($_POST['id'] != '') {
        $sid = $_POST['id'];

          $data = array(
            'is_active' => 0,
            'is_deleted' => 1
          );
          $update_id = $this->general_model->active_inactive_page($data, 'page', array('id' => $sid));

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

    public function checkUnique_id($table, $columnName)
   {
     $page_url = $_POST['page_url'];
     $page_id = $_POST['id'];
     if(!empty($page_url)) {

          $this->db->select($columnName);
          $this->db->from($table);
          $this->db->where('id !=',$page_id);
          $this->db->where('page_url',$page_url);
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

public function checkUnique($table, $columnName)
{
 $page_url = $_POST['page_url'];
    if(!empty($page_url)) {

         $this->db->select($columnName);
         $this->db->from($table);
         $this->db->where('page_url',$page_url);
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

}
