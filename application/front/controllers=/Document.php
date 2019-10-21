<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Document extends MY_Controller {
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
          $document_list = $this->general_model->get_shop_data('*', 'document', array('user_id' => $id, 'is_deleted' => 0));
          foreach ($document_list as $key => $doc) {
            $var =  $this->url_encrypt($doc->id);
            $document_list[$key]->encrypt_id = $var;
          }
          $this->data['document_list'] = $document_list;

          $this->data['title'] = 'Documents | GGG Rooms';
          $this->render('document_view');
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function add_document() {
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

        $document_type = $this->general_model->get_all_state_data('*', 'document_type', array('is_deleted' => 0));
        $this->data['document_type'] = $document_type;

        if($user_list->u_category == 2 || $user_list->u_category == 3){

        $this->data['title'] = 'Dcument | GGG Rooms';
        $this->render('add_document_view');
      }else{
        redirect('profile', 'refresh');
      }
    }
  }

    public function insert_document() {

        if ($this->session->userdata('uid')) {
            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('doc_caption', 'Document Caption', 'required');
                $this->form_validation->set_rules('doc_type', 'Document Type', 'required');

                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('PAGE_DETAIL', $_POST);
                    redirect('document', 'refresh');
                } else {
                  $user_id = $this->session->userdata('uid');
                  $caption = $this->input->post('doc_caption');
                  $type = $this->input->post('doc_type');
                  $image = $this->uploadImage($_FILES['imgupload']['name'], 'imgupload', 'document');

                  $data = array(
                      'user_id' => $user_id,
                      'caption' => $caption,
                      'types' => $type,
                      'name' => $image,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0,
                  );
                  $inserted_id = $this->general_model->insert_category($data, 'document');
                  if ($inserted_id) {
                    $this->session->set_flashdata('success_message', "Document added successfully");
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

    public function uploadImage($path, $imagename, $upload_path){
      $this->load->library('upload');
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);

      if($ext !='')
      {
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $temp_name = $randomString.'.'.$ext;
      }
      else {
          $temp_name = '';
      }
      $config = array();
      $config['upload_path']          = FCPATH.'assets/uploads/'.$upload_path.'/';
      $config['file_name'] 						= $temp_name;
      $config['allowed_types']        = 'pdf|jpg|jpeg|png|tiff|tif';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        return $temp_name;
      }else{
        return $temp_name;
      }
    }

    public function delete_document() {
      $id = $this->input->post('img_id');

      $data = array(
          'is_deleted' => 1
      );
      $update_id = $this->general_model->delete_service($data, 'document', array('id' => $id));
     }
}
