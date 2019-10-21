<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Document extends Admin_Controller {
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

          $document_data = $this->general_model->get_page_data('*', 'document_type', array());
          foreach ($document_data as $key => $page) {
            $var =  $this->url_encrypt($page->id);
            $document_data[$key]->encrypt_id = $var;
          }

          $this->data['document_list'] = $document_data;
          $this->render('document_type_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function add_document_type() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          $this->render('add_document_type');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function insert_document_type() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('d_name', 'Name', 'required');
                if($this->form_validation->run() == false){
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('document/add_document_type', 'refresh');
                }else{
                  $name = $this->input->post('d_name');
                  $data = array(
                      'name' => $name,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );
                  $inserted_id = $this->general_model->insert_page($data, 'document_type');
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "Document type added successfully");
                    redirect('document', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('document', 'refresh');
                  }
                }
            }else{
                $this->render('document/add_document_type');
            }
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function edit_document_type($id1) {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

          $id1 = $this->url_decrypt($id1);
          $document_data = $this->general_model->get_page_data_id('*', 'document_type', array('id' => $id1));
          $var =  $this->url_encrypt($document_data->id);
          $document_data->encrypt_id = $var;
          $this->data['document_list'] = $document_data;

          $this->render('edit_document_type');
        }else{
            redirect('Login', 'refresh');
        }
    }

    public function update_document_type() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('d_name', 'Name', 'required');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('document', 'refresh');
                }else{
                  $doc_id = $this->input->post('document_id');
                  $name = $this->input->post('d_name');
                  $data = array(
                      'name' => $name,
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );

                      $updated_id = $this->general_model->update_page_data($data, 'document_type', array('id' => $doc_id));

                      if ($updated_id) {
                        $this->session->set_flashdata('success_message', "Document type updated successfully");
                        redirect('document', 'refresh');
                      }
                      else{
                        $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                        redirect('document', 'refresh');
                      }
                }
            } else {
                redirect('document', 'refresh');
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
            'is_deleted' => 0
          );

          $update_id = $this->general_model->active_inactive_page($data, 'document_type', array('id' => $sid));

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
            'is_deleted' => 1
          );
          $update_id = $this->general_model->active_inactive_page($data, 'document_type', array('id' => $sid));

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

public function checkUnique_name($table, $columnName)
{
    $d_name = $_POST['d_name'];
    if(!empty($d_name)) {
      $this->db->select($columnName);
      $this->db->from($table);
      $this->db->where('name',$d_name);
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

 public function edit_frm_checkUnique_name($table, $columnName)
 {
     $d_name = $_POST['d_name'];
     $id = $_POST['document_id'];
     if(!empty($d_name)) {
       $this->db->select($columnName);
       $this->db->from($table);
       $this->db->where('name',$d_name);
       $this->db->where('id !=',$id);
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
