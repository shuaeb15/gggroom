<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Poll extends Admin_Controller {
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

        $poll_data = $this->general_model->get_all_general_data("*", "poll_qst", array(), 'result_array');
        // echo '<pre>'; print_r($poll_data); exit;

        $this->data['poll_data'] = $poll_data;
        $this->data['num_of_data'] = count($poll_data);
        // echo count($poll_data);exit;
        $this->render('poll_view');
      } else {
          redirect('Login', 'refresh');
      }
    }

    public function add_poll() {
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
          $this->render('poll_add_view');
        } else {
            redirect('Login', 'refresh');
        }
        // if ($this->session->userdata('admin_id')) {
        //   $admin_id = $this->session->userdata('admin_id');
        //   $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        //   $this->data['admin_data'] = $admin_data;
        //
        //   $this->render('add_page');
        // }else{
        //     redirect('Login', 'refresh');
        // }
    }

    public function insert_poll() {
        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
            // echo '<pre>'; print_r($_POST);
            $data = array();
            $sumArray = array();
            $i = 0;
            foreach($_POST as $k=>$v){
              $newarr = explode('-',$k);
              // echo '<pre>'; print_r($newarr[0]); exit;
              // $newarr = substr($k,0, -1);
              if($newarr[0] == 'question'){
                // echo $v.'<br>';
                $sumArray[$newarr[1]]['qst'] = $v;
              }
              if($newarr[0] == 'queOption'){
                // echo $v.'<br>';
                $sumArray[$newarr[1]]['textbox'] = $v;
              }
              if($newarr[0] == 'option'){
              // if(substr($newarr,0, -1) == 'option'){
                // echo $newarr[2].'<br>';
                $sumArray[$newarr[1]]['opt'.$newarr[2]] = $v;
              }
              $i++;
            }
            // echo count($sumArray['question']);exit;
            // echo '<pre>'; print_r($sumArray);exit;
            $this->db->truncate('poll_qst');
            $succ = array();
            $i=1;
            foreach($sumArray as $key=>$val){
              $num_of_rows = count($sumArray);
              // echo '<pre>'; print_r($val);
              $inserted_id = $this->general_model->insert_user($val, 'poll_qst');
              if ($inserted_id) {
                $succ[] = $inserted_id;
                if($i == $num_of_rows){
                  $tags = implode(', ', $succ);
                  $this->session->set_flashdata('success_message', "Poll upto ID $tags added successfully");
                  redirect('poll', 'refresh');
                }
                $i++;
                // redirect('poll', 'refresh');
              }
              else{
                $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                redirect('poll', 'refresh');
              }
            }
            exit;



            $qstCount = count($sumArray['question']);
            $this->db->truncate('poll_qst');
            for($j = 0; $j < $qstCount; $j++){
              $data['qst'] = $sumArray['question'][$j];
              $newj = $j+1;
              // if(isset($sumArray['option'.$newj])){
              //   echo $newj.'<br>';}
              // if(isset($sumArray['option'.$newj])){
              if(isset($sumArray['option'.$newj])){
                $countOpt = count($sumArray['option'.$newj]);
                for($k = 0; $k < $countOpt; $k++){
                  $newk = $k+1;
                  $data['opt'.$newk] = $sumArray['option'.$newj][$k];
                }
              }else{
                $data['opt'.$newj] = '';
              }
              $data['textbox'] = $sumArray['queOption'][$j];
              echo '<pre>'; print_r($data);
              // $inserted_id = $this->general_model->insert_user($data, 'poll_qst');
              // $inserted_id = 1;
              // if ($inserted_id) {
              //   $succ = array();
              //   $this->session->set_flashdata('success_message', "Poll upto ID $inserted_id added successfully");
              //   // redirect('poll', 'refresh');
              // }
              // else{
              //   $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
              //   // redirect('poll', 'refresh');
              // }
            }
            exit;

        } else {
            redirect('Login', 'refresh');
        }
    }
    public function get_poll_data(){
      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;

        $poll_data = $this->general_model->all_get_all_general_data("*", "poll_answer", array(), "result_array", "", "", "user_id");
        // echo '<pre>'; print_r($poll_data); exit;
        foreach($poll_data as $k=>$v){
          $get_poll_data_by_id = $this->general_model->get_poll_submissions("poll_answer", array('user_id' => $v['user_id']));
          $key = $v['user_id'];
          // echo '<pre>'; print_r($get_poll_data_by_id);exit;
          $data[$key] = $get_poll_data_by_id;
        }
        // echo '<pre>'; print_r($data);exit;
        $this->data['poll_data'] = $data;
        // $this->data['num_of_data'] = count($poll_data);
        // echo count($poll_data);exit;
        $this->render('poll_data_view');
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
