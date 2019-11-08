<?php

   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Worker extends REST_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
        $this->load->library('form_validation');
    }

    /**
     * index function.
     *
     * @access public
     * @return void
     */
    public function worker_list_post() {
    
        $id = $this->input->post('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;
        

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));
          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }
          $worker_list = $this->general_model->get_worker_shop_data('*', 'workers', array('is_deleted' => 0), $all_u_id);
          foreach ($worker_list as $key => $worker) {
            $var =  $worker->id;
            $worker_list[$key]->encrypt_id = $var;
          }
          $this->data['workerlist'] = $worker_list;
          
            $this->response([
                         'status' => TRUE, 
                         'data' => $worker_list
                             ], REST_Controller::HTTP_OK);
         
        }else{
          redirect('profile', 'refresh');
           $this->response([
                                'status' => FALSE,
                                'message' => 'Not authorized user.'
                            ], REST_Controller::HTTP_NOT_FOUND);
        }
      
    }

   

    public function shop_list_user_post() {

        $id = $this->input->post('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id,0);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));

          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }

          $shop_list = $this->general_model->get_shop_list_data_by_user_list('shop', array('shop.is_deleted' => 0), $id);
          $this->data['shoplist'] = $shop_list;

          
            $this->response([
                         'status' => TRUE,
                          'data' => $shop_list
                             ], REST_Controller::HTTP_OK);
        }else{
           $this->response([
                                    'status' => FALSE,
                                    'message' => 'Not authorized.'
                                ], REST_Controller::HTTP_NOT_FOUND);
        }
      
    }

    public function insert_worker_post() {
     
         //echo '<pre>'; print_r($_POST); exit;
        if($_POST['all_day']=='off' && $_POST['vacation_start_date']){
          $ds = str_replace('/', ',', $_POST['vacation_start_date']);
          $ts = str_replace(':', ',', $_POST['vacation_start_time']);
          $date_start = $ts.',0,'.$ds;
          $fulldate_start = explode(',',$date_start);

          $hs = $fulldate_start[0];
          $is = $fulldate_start[1];
          $ss = $fulldate_start[2];
          $ms = $fulldate_start[3];
          $ds = $fulldate_start[4];
          $ys = $fulldate_start[5];

          $vacation_start_date = date("y-m-d h:i:s",mktime($hs,$is,$ss,$ms,$ds,$ys));
          // echo $vacation_start_date;exit;
          $de = str_replace('/', ',', $_POST['vacation_end_date']);
          $te = str_replace(':', ',', $_POST['vacation_end_time']);
          $date_end = $te.',0,'.$de;
          $fulldate_end = explode(',',$date_end);

          $he = $fulldate_end[0];
          $ie = $fulldate_end[1];
          $se = $fulldate_end[2];
          $me = $fulldate_end[3];
          $de = $fulldate_end[4];
          $ye = $fulldate_end[5];

          $vacation_end_date = date("y-m-d h:i:s",mktime($he,$ie,$se,$me,$de,$ye));
          // echo $vacation_start_date.','.$vacation_end_date;exit;
        }else if($_POST['all_day']=='on' && $_POST['vacation_start_date']){
          $vacation_start_date = date("y-m-d h:i:s",mktime($_POST['vacation_start_date']));
          $vacation_end_date = date("y-m-d h:i:s",mktime($_POST['vacation_end_date']));
        }
        if(!$_POST['worker_vacation']){
          $_POST['vacation_start_date'] = '';
          $_POST['vacation_end_date'] = '';
        }
        $id = $this->input->post('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){

          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('worker_name', 'Worker Name', 'required');
              $this->form_validation->set_rules('worker_mobile', 'Worker Title', 'required');
              $this->form_validation->set_rules('worker_email', 'Worker Email', 'required');
              if ($this->form_validation->run() == false) {
                 

                  $this->response([
                                'status' => FALSE,
                                'message' => 'Please fill required fields.'
                            ], REST_Controller::HTTP_NOT_FOUND);

              }else{
                $uid = $this->input->post('uid');
                $worker_name = $this->input->post('worker_name');
                $worker_email = $this->input->post('worker_email');
                $mobile_no = $this->input->post('worker_mobile');
                $percentage = $this->input->post('worker_percentage');
                // $worker_permission = $this->input->post('worker_permission');
                $worker_permission = '3';

                $image = $this->uploadImage($_FILES['imgupload1']['name'], 'imgupload1', 'worker_image');

                $time_start[] = ($_POST['Monday1'] && $_POST['Monday1'] != '' ? $_POST['Monday1'] : '');
                $time_start[] = ($_POST['tuesday1'] && $_POST['tuesday1'] != '' ? $_POST['tuesday1'] : '');
                $time_start[] = ($_POST['wednesday1'] && $_POST['wednesday1'] != '' ? $_POST['wednesday1'] : '');
                $time_start[] = ($_POST['thursday1'] && $_POST['thursday1'] != '' ? $_POST['thursday1'] : '');
                $time_start[] = ($_POST['friday1'] && $_POST['friday1'] != '' ? $_POST['friday1'] : '');
                $time_start[] = ($_POST['saturday1'] && $_POST['saturday1'] != '' ? $_POST['saturday1'] : '');
                $time_start[] = ($_POST['sunday1'] && $_POST['sunday1'] != '' ? $_POST['sunday1'] : '');

                $time_end[] = ($_POST['Monday2'] && $_POST['Monday2'] != '' ? $_POST['Monday2'] : '');
                $time_end[] = ($_POST['tuesday2'] && $_POST['tuesday2'] != '' ? $_POST['tuesday2'] : '');
                $time_end[] = ($_POST['wednesday2'] && $_POST['wednesday2'] != '' ? $_POST['wednesday2'] : '');
                $time_end[] = ($_POST['thursday2'] && $_POST['thursday2'] != '' ? $_POST['thursday2'] : '');
                $time_end[] = ($_POST['friday2'] && $_POST['friday2'] != '' ? $_POST['friday2'] : '');
                $time_end[] = ($_POST['saturday2'] && $_POST['saturday2'] != '' ? $_POST['saturday2'] : '');
                $time_end[] = ($_POST['sunday2'] && $_POST['sunday2'] != '' ? $_POST['sunday2'] : '');

                $break_time_start[] = ($_POST['Monday_break1'] && $_POST['Monday_break1'] != '' ? $_POST['Monday_break1'] : '');
                $break_time_start[] = ($_POST['tuesday_break1'] && $_POST['tuesday_break1'] != '' ? $_POST['tuesday_break1'] : '');
                $break_time_start[] = ($_POST['wednesday_break1'] && $_POST['wednesday_break1'] != '' ? $_POST['wednesday_break1'] : '');
                $break_time_start[] = ($_POST['thursday_break1'] && $_POST['thursday_break1'] != '' ? $_POST['thursday_break1'] : '');
                $break_time_start[] = ($_POST['friday_break1'] && $_POST['friday_break1'] != '' ? $_POST['friday_break1'] : '');
                $break_time_start[] = ($_POST['saturday_break1'] && $_POST['saturday_break1'] != '' ? $_POST['saturday_break1'] : '');
                $break_time_start[] = ($_POST['sunday_break1'] && $_POST['sunday_break1'] != '' ? $_POST['sunday_break1'] : '');

                $break_time_end[] = ($_POST['Monday_break2'] && $_POST['Monday_break2'] != '' ? $_POST['Monday_break2'] : '');
                $break_time_end[] = ($_POST['tuesday_break2'] && $_POST['tuesday_break2'] != '' ? $_POST['tuesday_break2'] : '');
                $break_time_end[] = ($_POST['wednesday_break2'] && $_POST['wednesday_break2'] != '' ? $_POST['wednesday_break2'] : '');
                $break_time_end[] = ($_POST['thursday_break2'] && $_POST['thursday_break2'] != '' ? $_POST['thursday_break2'] : '');
                $break_time_end[] = ($_POST['friday_break2'] && $_POST['friday_break2'] != '' ? $_POST['friday_break2'] : '');
                $break_time_end[] = ($_POST['saturday_break2'] && $_POST['saturday_break2'] != '' ? $_POST['saturday_break2'] : '');
                $break_time_end[] = ($_POST['sunday_break2'] && $_POST['sunday_break2'] != '' ? $_POST['sunday_break2'] : '');

                $start_time = implode(",",$time_start);
                $end_time = implode(",",$time_end);

                $break_time_start = implode(",",$break_time_start);
                $break_time_end = implode(",",$break_time_end);

                $checkbox1=$_POST['shop_name'];  
                $chk="";  
                foreach($checkbox1 as $chk1)  
                {  
                $chk .= $chk1.",";  
                } 
                $checkbox11=$_POST['service_list_all'];  
               
                
                //print_r($_POST); 
               
                $chk2="";  
                foreach($checkbox11 as $chk11)  
                {  
                $chk2 .= $chk11.",";  
                } 
                //print_r($chk2);
                //exit();

                $data = array(
                    'name' => $worker_name,
                    'email' => $worker_email,
                    'mobile' => $mobile_no,
                    'percentage' => $percentage,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'break_start_time' => $break_time_start,
                    'break_end_time' => $break_time_end,
                    'shop_id' => $chk,
                    'service_id' => $chk2,
                    'user_id' => $uid,
                    'shop_permission' => 0,
                    'image' => $image,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );
                // echo '<pre>'; print_r($worker_data);exit;

                $insert_id = $this->general_model->insert_worker_data($data, 'workers');
                $worker_data = array(
                    'user_id' => $insert_id,
                    'shop_id' => $_POST['shop_id'],
                    'start_date' => $vacation_start_date,
                    'end_date' => $vacation_end_date,
                    'all_day' => ($_POST['all_day'] && $_POST['all_day'] != '') ? $_POST['all_day'] : '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_deleted' => 0,
                    'flag' => 2
                );
                if($worker_permission != ''){
                  $password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
                  $password = substr(str_shuffle($password_string), 0, 12);

                  $user_data = array(
                      'p_id' => $uid,
                      'firstname' => $worker_name,
                      'email' => $worker_email,
                      'password' => md5($password),
                      'mobile' => $mobile_no,
                      'u_category' => 3,
                      'date' => date('Y-m-d H:i:s'),
                      'updated_date' => date('Y-m-d H:i:s'),
                      'is_active' => 0,
                      'is_deleted' => 0,
                  );
                  $insert_user_id = $this->general_model->insert_worker_data($user_data, 'user');
                  
                  $user_id =  $insert_user_id;
                  $worker_id =  $insert_id;

                  $u_data = array(
                      'firstname' => $worker_name,
                      'email' => $worker_email,
                      'password' => $password,
                      'user_id' => $user_id,
                      'worker_id' => $worker_id,
                  );
                  $emailsend = $this->general_model->send_worker_permission_email($u_data);
                }

                  if($insert_id){
                    // $service_time = $this->input->post('service_time[]');
                    $insert_worker_vacation = $this->general_model->insert_worker_data($worker_data, 'vacation_module');
                  
                    if($insert_worker_vacation){
                    
                        $this->response([
                         'status' => TRUE, 
                         'message' => 'Worker added successfully'
                             ], REST_Controller::HTTP_OK);

                    }else{
                      
                       $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong.'
                            ], REST_Controller::HTTP_NOT_FOUND);
                    }
                  }else{

                     $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong.'
                            ], REST_Controller::HTTP_NOT_FOUND);

                     
                  }
              }
          }else {
            $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong.'
                            ], REST_Controller::HTTP_NOT_FOUND);
          }
        }else{
          $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong.'
                            ], REST_Controller::HTTP_NOT_FOUND);
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
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        return $temp_name;
      }else{
        return $temp_name;
      }
    }

    public function edit_worker($id1) {
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }else{
        $id1 = $this->url_decrypt($id1);

        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        $breaks = $this->general_model->get_business_hours_data('*', 'breaks', array('shop_id' => $id1, 'is_active' => 1));
        $days1 = array();
        $main_hours1 = [];
        for ($i = 0; $i < 7; $i++) {
          $days1[$i] = jddayofweek($i,1);
          foreach ($breaks as $key => $value) {
            if($days1[$i] == $value->day){
                $main_hours1[] = $value;
            }
          }
        }
        $this->data['breaks'] = $main_hours1;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id,0);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));

          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }

         // $shop_list = $this->general_model->get_shop_list_data_by_user('shop', array('shop.is_deleted' => 0), $all_u_id);

           $shop_list = $this->general_model->get_shop_list_data_by_user_list('shop', array('shop.is_deleted' => 0), $id);

          $this->data['shoplist'] = $shop_list;

          $business_hours = $this->general_model->get_worker_business_hours_data('*', 'worker_available_time', array('worker_id' => $id1, 'is_deleted' => 0));
          $days = array();
          $main_hours = [];
          for ($i = 0; $i < 7; $i++) {
            $days[$i] = jddayofweek($i,1);
            foreach ($business_hours as $key => $value) {
              if($days[$i] == $value->worker_day){
                  $main_hours[] = $value;
              }
            }
          }
          $this->data['business_hours'] = $main_hours;

          $worker_list = $this->general_model->get_worker_data_by_id('workers', array('workers.id' => $id1, 'workers.is_deleted' => 0));
          // echo '<pre>'; print_r($worker_list); exit;
          $var =  $this->url_encrypt($worker_list->id);
          // echo $worker_list->id;exit;
          $worker_list->encrypt_id = $var;
          $this->data['workerlist'] = $worker_list;
          // echo '<pre>'; print_r($worker_list); exit;
          // $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 2));
          // $this->data['vacation_module_data'] = $vacation_module_data;

          $this->data['title'] = 'Worker | GGG Rooms';

          $this->data['js_file'] = array(
              "front/js/bootstrap-datetimepicker.min.js",
              "front/js/jquery.timepicker.js",
              "front/js/datepair.js",
              "front/js/jquery.datepair.js",
              "front/js/worker.js",
              "front/js/jquery-confirm.min.js",
          );
          $this->data['css_file'] = array(
              "front/css/bootstrap-datetimepicker.min.css",
              "front/css/jquery.timepicker.css",
              "front/css2/jquery-confirm.min.css"
          );

          $this->render('edit_worker_view');
        }else{
          redirect('profile', 'refresh');
        }
      }
      $this->check_vacation_module_time_available();
    }

    public function check_vacation_module_time_available(){
      $current_date = date("Y-m-d");
      $check_vacation_module = $this->general_model->get_all_state_data('*', 'vacation_module', array('flag' => 2, 'is_deleted' => 0));
      foreach ($check_vacation_module as $key => $date) {
        $date_to_compare = date($date->end_date);
        if (strtotime($date_to_compare) < strtotime($current_date)) {
          $check_vacation_module1 = $this->general_model->check_vacation_module_time_available('*', 'vacation_module', array('flag' => 2, 'is_deleted' => 0), $date_to_compare);
          if(!empty($check_vacation_module1)){
            foreach ($check_vacation_module1 as $key => $value) {
              $val_id = $value->id;
              $this->db->where('id', $val_id);
              $data1 = $this->db->delete('vacation_module');
            }
          }
        }
      }
    }
    public function update_worker($id1){
      if (!$this->session->userdata('uid')) {
          redirect(site_url());
      }else{
        // echo '<pre>'; print_r($_POST); exit;

        if(!$_POST['all_day']){
          $ds = str_replace('/', ',', $_POST['vacation_start_date']);
          $ts = str_replace(':', ',', $_POST['vacation_start_time']);
          $date_start = $ts.',0,'.$ds;
          $fulldate_start = explode(',',$date_start);

          $hs = $fulldate_start[0];
          $is = $fulldate_start[1];
          $ss = $fulldate_start[2];
          $ms = $fulldate_start[3];
          $ds = $fulldate_start[4];
          $ys = $fulldate_start[5];

          $vacation_start_date = date("y-m-d h:i:s",mktime($hs,$is,$ss,$ms,$ds,$ys));

          $de = str_replace('/', ',', $_POST['vacation_end_date']);
          $te = str_replace(':', ',', $_POST['vacation_end_time']);
          $date_end = $te.',0,'.$de;
          $fulldate_end = explode(',',$date_end);

          $he = $fulldate_end[0];
          $ie = $fulldate_end[1];
          $se = $fulldate_end[2];
          $me = $fulldate_end[3];
          $de = $fulldate_end[4];
          $ye = $fulldate_end[5];

          $vacation_end_date = date("y-m-d h:i:s",mktime($he,$ie,$se,$me,$de,$ye));
          // echo $vacation_start_date.','.$vacation_end_date;exit;
        }else if($_POST['all_day'] && $_POST['vacation_start_date']){
          $vacation_start_date = date("y-m-d h:i:s",mktime($_POST['vacation_start_date']));
          $vacation_end_date = date("y-m-d h:i:s",mktime($_POST['vacation_end_date']));
        }
        if(!$_POST['worker_vacation']){
          $_POST['vacation_start_date'] = '';
          $_POST['vacation_end_date'] = '';
        }
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){

          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('worker_name', 'Worker Name', 'required');
              $this->form_validation->set_rules('worker_mobile', 'Worker Title', 'required');
              $this->form_validation->set_rules('worker_email', 'Worker Email', 'required|valid_email');
              if ($this->form_validation->run() == false) {
                  $this->session->set_flashdata('error_message', "Please fill required fields.");
                  $this->session->set_userdata('USER_DETAIL', $_POST);
                  redirect('worker/add_worker/', 'refresh');
              }else{
                $uid = $this->session->userdata('uid');
                $worker_name = $this->input->post('worker_name');
                $worker_email = $this->input->post('worker_email');
                $mobile_no = $this->input->post('worker_mobile');
                $percentage = $this->input->post('worker_percentage');
                $worker_permission = $this->input->post('worker_permission');
                $image = ($_FILES['imgupload1']['name'] && $_FILES['imgupload1']['name'] != '') ? $this->uploadImage($_FILES['imgupload1']['name'], 'imgupload1', 'worker_image') : $_POST['image_exists'];

                $time_start[] = ($_POST['Monday1'] && $_POST['Monday1'] != '' ? $_POST['Monday1'] : '');
                $time_start[] = ($_POST['tuesday1'] && $_POST['tuesday1'] != '' ? $_POST['tuesday1'] : '');
                $time_start[] = ($_POST['wednesday1'] && $_POST['wednesday1'] != '' ? $_POST['wednesday1'] : '');
                $time_start[] = ($_POST['thursday1'] && $_POST['thursday1'] != '' ? $_POST['thursday1'] : '');
                $time_start[] = ($_POST['friday1'] && $_POST['friday1'] != '' ? $_POST['friday1'] : '');
                $time_start[] = ($_POST['saturday1'] && $_POST['saturday1'] != '' ? $_POST['saturday1'] : '');
                $time_start[] = ($_POST['sunday1'] && $_POST['sunday1'] != '' ? $_POST['sunday1'] : '');

                $time_end[] = ($_POST['Monday2'] && $_POST['Monday2'] != '' ? $_POST['Monday2'] : '');
                $time_end[] = ($_POST['tuesday2'] && $_POST['tuesday2'] != '' ? $_POST['tuesday2'] : '');
                $time_end[] = ($_POST['wednesday2'] && $_POST['wednesday2'] != '' ? $_POST['wednesday2'] : '');
                $time_end[] = ($_POST['thursday2'] && $_POST['thursday2'] != '' ? $_POST['thursday2'] : '');
                $time_end[] = ($_POST['friday2'] && $_POST['friday2'] != '' ? $_POST['friday2'] : '');
                $time_end[] = ($_POST['saturday2'] && $_POST['saturday2'] != '' ? $_POST['saturday2'] : '');
                $time_end[] = ($_POST['sunday2'] && $_POST['sunday2'] != '' ? $_POST['sunday2'] : '');

                $break_time_start[] = ($_POST['Monday_break1'] && $_POST['Monday_break1'] != '' ? $_POST['Monday_break1'] : '');
                $break_time_start[] = ($_POST['tuesday_break1'] && $_POST['tuesday_break1'] != '' ? $_POST['tuesday_break1'] : '');
                $break_time_start[] = ($_POST['wednesday_break1'] && $_POST['wednesday_break1'] != '' ? $_POST['wednesday_break1'] : '');
                $break_time_start[] = ($_POST['thursday_break1'] && $_POST['thursday_break1'] != '' ? $_POST['thursday_break1'] : '');
                $break_time_start[] = ($_POST['friday_break1'] && $_POST['friday_break1'] != '' ? $_POST['friday_break1'] : '');
                $break_time_start[] = ($_POST['saturday_break1'] && $_POST['saturday_break1'] != '' ? $_POST['saturday_break1'] : '');
                $break_time_start[] = ($_POST['sunday_break1'] && $_POST['sunday_break1'] != '' ? $_POST['sunday_break1'] : '');

                $break_time_end[] = ($_POST['Monday_break2'] && $_POST['Monday_break2'] != '' ? $_POST['Monday_break2'] : '');
                $break_time_end[] = ($_POST['tuesday_break2'] && $_POST['tuesday_break2'] != '' ? $_POST['tuesday_break2'] : '');
                $break_time_end[] = ($_POST['wednesday_break2'] && $_POST['wednesday_break2'] != '' ? $_POST['wednesday_break2'] : '');
                $break_time_end[] = ($_POST['thursday_break2'] && $_POST['thursday_break2'] != '' ? $_POST['thursday_break2'] : '');
                $break_time_end[] = ($_POST['friday_break2'] && $_POST['friday_break2'] != '' ? $_POST['friday_break2'] : '');
                $break_time_end[] = ($_POST['saturday_break2'] && $_POST['saturday_break2'] != '' ? $_POST['saturday_break2'] : '');
                $break_time_end[] = ($_POST['sunday_break2'] && $_POST['sunday_break2'] != '' ? $_POST['sunday_break2'] : '');

                $start_time = implode(",",$time_start);
                $end_time = implode(",",$time_end);

                $break_time_start = implode(",",$break_time_start);
                $break_time_end = implode(",",$break_time_end);

                $checkbox1=$_POST['shop_name'];  
                $chk="";  
                foreach($checkbox1 as $chk1)  
                {  
                $chk .= $chk1.",";  
                } 

                $data = array(
                    'name' => $worker_name,
                    'email' => $worker_email,
                    'mobile' => $mobile_no,
                    'percentage' => $percentage,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'break_start_time' => $break_time_start,
                    'break_end_time' => $break_time_end,
                    'shop_id' => $chk,
                    'user_id' => $uid,
                    'shop_permission' => 0,
                    'image' => $image,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );
                // echo '<pre>'; print_r($data);exit;

                $insert_id = $this->general_model->update_worker_data($data, 'workers', array('id' => $_POST['worker_id']));
                $worker_data = array(
                    'user_id' => $this->url_decrypt($id1),
                    'shop_id' => $_POST['shop_id'],
                    'start_date' => $vacation_start_date,
                    'end_date' => $vacation_end_date,
                    'all_day' => ($_POST['all_day'] && $_POST['all_day'] != '') ? $_POST['all_day'] : '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_deleted' => 0,
                    'flag' => 2
                );
                  if($insert_id){
                    if($_POST['vacation_id'] == ''){
                      $insert_worker_vacation = $this->general_model->insert_worker_data($worker_data, 'vacation_module', array('id' => $_POST['vacation_id']));
                    }else{
                      $insert_worker_vacation = $this->general_model->update_worker_data($worker_data, 'vacation_module', array('id' => $_POST['vacation_id']));
                    }
                    if($insert_worker_vacation){
                      $this->session->set_flashdata('success_message', "Worker updated successfully");
                      redirect('worker', 'refresh');
                    }else{
                      $this->session->set_flashdata('error_message', "Sorry, Vacation can not be updated. Please try again");
                      redirect('worker', 'refresh');
                    }
                  }else{
                     $this->session->set_flashdata('error_message', "Sorry, Worker can not be updated. please try again...");
                     redirect('worker', 'refresh');
                  }
              }
          }else {
            $this->session->set_flashdata('error_message', "Something wents wrong!");
            redirect('worker', 'refresh');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }


    public function upload_worker_Image($path, $imagename, $upload_path, $worker_id){
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
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        $this->db->select('image');
        $this->db->from('workers');
        $this->db->where('id',$worker_id);
        $count = $this->db->get()->row();
        $img = $count->image;
        $path = 'assets/uploads/'.$upload_path.'/'.$img;
        unlink($path);
        return $temp_name;
      }else{
        $this->db->select('image');
        $this->db->from('workers');
        $this->db->where('id',$worker_id);
        $count = $this->db->get()->row();
        return $count->image;
      }
    }

    public function checkUniqueadd_email_post()
    {
      $email = $_POST['worker_email'];
      if(!empty($email)) {
        $this->db->select('id');
        $this->db->from('workers');
        $this->db->where('email',$email);
        $count = $this->db->get()->row();
        $count = count($count);
        $count = (int)$count;
        if($count == 0){
          $this->db->select($columnName);
          $this->db->from('user');
          $this->db->where('email',$email);
          $count1 = $this->db->get()->row();
          $count1 = count($count1);
          $count1 = (int)$count1;

          if($count1 > 0){
           $this->response([
                                    'status' => FALSE,
                                    'message' => 'Already exists.'
                                ], REST_Controller::HTTP_NOT_FOUND);
           }else{
             echo 'true';
              $this->response([
                         'status' => TRUE
                             ], REST_Controller::HTTP_OK);
         }
        }else{
          if($count > 0){
           $this->response([
                                    'status' => FALSE,
                                    'message' => 'Already exists.'
                                ], REST_Controller::HTTP_NOT_FOUND);
           }else{
             echo 'true';
              $this->response([
                         'status' => TRUE
                             ], REST_Controller::HTTP_OK);
         }
        }
     }
    }

    public function checkUniqueemail($table, $columnName)
    {
      $email = $_POST['worker_email'];
      $id = $_POST['id'];
      if(!empty($email)) {
        $this->db->select($columnName);
        $this->db->from($table);
        $this->db->where('id !=',$id);
        $this->db->where('email',$email);
        $count = $this->db->get()->row();
        $count = count($count);
        $count = (int)$count;

        if($count == 0){
          $this->db->select($columnName);
          $this->db->from('user');
          $this->db->where('email',$email);
          $this->db->where('u_category != ',3);
          $count1 = $this->db->get()->row();
          $count1 = count($count1);
          $count1 = (int)$count1;
          // echo $count1;exit;
          if($count1 > 0){
            echo 'false';
          }else{
            echo 'true';
         }
        }else{
          if($count > 0){
            echo 'false';
          }else{
            echo 'true';
         }
       }
     }
    }

    public function delete_business_hours_time() {
      $id = $this->input->post('id');

      $worker_id = $this->input->post('worker_id');
      $hour_day = $this->input->post('hour_day');

      $this->db->where('id', $id);
      $hours_id = $this->db->delete('worker_available_time');

      $exists = $this->general_model->check_breaks_time_exists('breaks', array('day' => $hour_day, 'shop_id' => $worker_id));
      if(!empty($exists)){
         $this->db->where('id', $exists->id);
         $this->db->delete('breaks');
         echo $exists->id;
      }
     }

     public function delete_breaks_time() {
       $id = $this->input->post('id');
       $this->db->where('id', $id);
       $this->db->delete('breaks');

      }

    public function delete_worker($id1) {
      if($id1){
        $data = array(
          'is_active' => 0,
          'is_deleted' => 1
        );
        $update_id = $this->general_model->delete_shop($data, 'workers', array('id' => $id1));

        $this->db->where('worker_id', $id1);
        $this->db->delete('worker_available_time');

        $this->db->where('shop_id', $id1);
        $this->db->delete('breaks');

        $this->db->select('image');
        $this->db->from('workers');
        $this->db->where('id',$id1);
        // $this->db->where('flag', '1');
        $count = $this->db->get()->result();
        $img = $count->image;
        $path = 'assets/uploads/worker_image/'.$img;
        unlink($path);

        if($update_id){
          $this->session->set_flashdata('success_message', "Worker deleted successfully");
          redirect('worker', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('worker', 'refresh');
        }
      }
    }

    public function CheckShopTime(){
      if($this->input->post())
      {
        $shopId = $this->input->post('shopid');
        $shopHours = $this->general_model->get_all_general_data('*','business_hours',array('shop_id'=>$shopId, 'is_active' => 1, 'is_deleted' => 0));
        $startTime = date("g:ia", strtotime($shopHours[0]['from_time']));
        $endTime = date("g:ia", strtotime($shopHours[0]['to_time']));
        $dayArr = array();
        foreach ($shopHours as $value)
        {
          $dayArr[] = $value['hours_day'];
        }
        echo json_encode($dayArr).'||'.$startTime.'||'.$endTime;exit;
      }
    }

    public function check_shop_hours_for_worker() {
      $shop_id = $this->input->post('shopid');
      $business_hours = $this->general_model->get_business_hours_data('*', 'business_hours', array('shop_id' => $shop_id, 'is_deleted' => 0));
      echo json_encode($business_hours);
     }

     public function delete_vacation_module_time() {
       $id = $this->input->post('id');
       $worker_id = $this->input->post('worker_id');
       $this->db->where('id', $id);
       $this->db->where('shop_id', $worker_id);
       $this->db->where('flag', 2);
       $hours_id = $this->db->delete('vacation_module');
      }

      public function get_worker_shop_services_post()
      {

       $all_shop_id = $this->input->post('shop_id');
       
       $arrlength = count($all_shop_id);
      
        $main_filter_shop_list_id = array();
       for($x = 0; $x < $arrlength; $x++) {

        $main_filter_shop_list = $this->db->select('shop.*')->from('shop')->where('shop.is_deleted','0')->where('shop.id',$all_shop_id[$x])->get()->result();
        
         $main_filter_shop_list_id[] = $main_filter_shop_list[0]->service_id;
        

        }
       // print_r($main_filter_shop_list);
          $aa = implode(",", $main_filter_shop_list_id);
         
          $bb = explode(",",$aa);
          $cc = array_unique($bb);
         
      foreach($cc as $new_service_myid){
           $main_filter_service_list[] = $this->db->select('services.*, category.parent_id,cat_name')->from('services')->where('services.is_deleted','0')->where('services.id',$new_service_myid)->join('category', 'services.cat_id=category.category_id', 'left')->get()->result_array();
         }
       

        $this->response([
                                'status' => TRUE,
                                'data' => $main_filter_service_list
                            ], REST_Controller::HTTP_OK);

      }

      public function get_worker_shop_services1()
      {

         $all_shop_id = $this->input->post('datastring');
        //print_r ($all_shop_id);

       //  $all_shop_id = array("1", "7", "8");
        $arrlength = count($all_shop_id);
       //  //$all_shop_id1 = $this->input->post('all_shop_id');
       //  //echo $all_shop_id;
        $main_filter_shop_list_id = array();
       for($x = 0; $x < $arrlength; $x++) {

        $main_filter_shop_list = $this->db->select('shop.*')->from('shop')->where('shop.is_deleted','0')->where('shop.id',$all_shop_id[$x])->get()->result();

       
$main_filter_shop_list_id[] = $main_filter_shop_list[0]->service_id;
//         $arr = array_merge($arr,$all_shop_id[$i]);
// array_merge($main_filter_shop_list[0]->service_id,$main_filter_shop_list_id);

         $main_filter_service_list[] = $this->db->select('services.*, category.parent_id,cat_name')->from('services')->where('services.is_deleted','0')->where('services.id',$main_filter_shop_list[0]->service_id)->join('category', 'services.cat_id=category.category_id', 'left')->get()->result();
 //print_r($main_filter_service_list);
       //  //echo $all_shop_id[$x];
        }
        print_r($main_filter_shop_list_id);
        echo $count = count($main_filter_shop_list_id);
        print_r (array_merge_recursive($main_filter_shop_list_id[0],$main_filter_shop_list_id[1])) ;

        for($i=1;$i<$count;$i++)
{   
  echo 'shuaeb';
        $option = array_merge($main_filter_shop_list_id[0],$main_filter_shop_list_id[$i]);
}
print_r($option);
        // print_r($arr);
        //echo json_encode($main_filter_service_list);

      }

      public function check_vacation_module_start_time() {
        $start_date = $this->input->post('start_date');
        $worker_id = $this->input->post('worker_id');

        $parts1 = explode('-', $start_date);
        $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
        $vacation_md_start_date = date("Y-m-d", strtotime($s_date));
        $check_vacation_module = $this->general_model->check_vacation_module_start_time('*', 'vacation_module', array('shop_id' => $worker_id, 'flag' => 2, 'is_deleted' => 0), $vacation_md_start_date);

        echo json_encode($check_vacation_module);
        // echo '<pre>';print_r($check_vacation_module);exit;
       }

       public function check_vacation_module_end_time() {
         $start_date = $this->input->post('start_date');
         $end_date = $this->input->post('end_date');
         $worker_id = $this->input->post('worker_id');

         $parts2 = explode('-', $end_date);
         $e_date = $parts2[1] . '-' . $parts2[0] . '-' . $parts2[2];
         $vacation_md_end_date = date("Y-m-d", strtotime($e_date));

         $check_vacation_module = $this->general_model->check_vacation_module_end_time('*', 'vacation_module', array('shop_id' => $worker_id, 'flag' => 2, 'is_deleted' => 0), $vacation_md_end_date);

         echo json_encode($check_vacation_module);
         // echo '<pre>';print_r($check_vacation_module);exit;
        }

        public function permission($u_id, $w_id) {
          $user_id = $this->url_decrypt($u_id);
          $worker_id = $this->url_decrypt($w_id);

          $worker_data = array(
              'shop_permission' => 1,
          );
          $user_data = array(
              'u_category' => 3,
              'is_active' => 1,
          );

          $updated_id = $this->general_model->update_worker_data($worker_data, 'workers', array('id' => $worker_id));
          $updated_id1 = $this->general_model->update_worker_data($user_data, 'user', array('id' => $user_id));

          $this->session->set_flashdata('success_message', "Congratulation!, Your permission is active.");
          redirect('home', 'refresh');
        }
}
