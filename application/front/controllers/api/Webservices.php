<?php
   
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Webservices extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
        $this->load->library('form_validation');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)

	{
        if(!empty($id)){
            $data = $this->db->get_where("user", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("user")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}


     public function login_post(){

              $this->form_validation->set_rules('uname', 'Username', 'required');
              $this->form_validation->set_rules('pwd', 'Password', 'required');

              
                  if ($this->form_validation->run() == false) {
                    
                       $this->response([
                                'status' => FALSE,
                                'message' => 'Username and Password is require'
                            ], REST_Controller::HTTP_NOT_FOUND);
                  } else {
    
                   $email = $this->input->post('uname');
                   $pwd2 = $this->input->post('pwd');
                   $password = md5($this->input->post('pwd'));
                   
                    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
                      $uresult = $this->general_model->check_data( 'user', array('username' => $email, 'password' => $password));
                    }
                    else{
                      $uresult = $this->general_model->check_data( 'user', array('email' => $email, 'password' => $password));
                    }
                   
                    if (count($uresult) > 0)
                    {
                      if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
                        $verification = $this->general_model->check_verification('user', array('username' => $email, 'is_active' => 1));
                        $check_verify = count($verification);
                      }
                      else{
                        $verification = $this->general_model->check_verification('user', array('email' => $email, 'is_active' => 1));
                        $check_verify = count($verification);
                      }
                      
                      $check_verify = count($verification);

                      $set = '1234567890';
                      $code = substr(str_shuffle($set), 0, 4);

                      $u_data = array(
                          'email' => $uresult[0]->email,
                          'password' => $pwd2,
                          'code' => $code,
                      );

                      $data = array(
                          'code' => $code,
                      );

                      if($check_verify == 1){
                        $sess_data = array('login' => TRUE, 'email' => $uresult[0]->email, 'username' => $uresult[0]->username, 'uid' => $uresult[0]->id, 'firstname' => $uresult[0]->firstname, 'usertype' => $uresult[0]->u_category);
                       
                         $this->response($sess_data, REST_Controller::HTTP_OK);
                      }else{
                        $update_id = $this->general_model->update_verification_code($data, 'user', array('email' => $uresult[0]->email));
                        // echo '<pre>';print_r($update_id);exit;
                        if ($update_id) {
                          $emailsend = $this->general_model->sendConfirmationEmail($u_data);

                          if($emailsend){
                            $msg = 'Activation code sent to email, Please first verify your account.';
                            
                            $this->data['user_data'] = $uresult[0]->email;
                          
                          
                            $this->response([
                         'status' => TRUE, 
                         'email' => $uresult[0]->email,
                          'message' => 'Activation code sent to email, Please first verify your account.'
                             ], REST_Controller::HTTP_OK);

                          }else{

                              $this->response([
                                    'status' => FALSE,
                                    'message' => 'Sorry, User can not login as he is Inactive or deleted.'
                                ], REST_Controller::HTTP_NOT_FOUND);

                            }
                        }
                      }
                    }
                    else {
                       
                         $this->response([
                                'status' => FALSE,
                                'message' => 'Please enter correct username and password.'
                            ], REST_Controller::HTTP_NOT_FOUND);

                    }
                  }
    }

    public function change_password_post(){


          $this->form_validation->set_rules('current_pwd', 'Password', 'required');
          $this->form_validation->set_rules('pwd', 'Password', 'required');
          $this->form_validation->set_rules('c_pwd', 'Confirm Password', 'required|matches[pwd]');

          if ($this->form_validation->run() == false) {
             

              $this->response([
                                'status' => FALSE,
                                'message' => 'Please fill all the fields'
                            ], REST_Controller::HTTP_NOT_FOUND);
          } else {

            $uid = $this->input->post('uid');
            $pwd = $this->input->post('pwd');
            $c_pwd = $this->input->post('c_pwd');
            $current_pwd = $this->input->post('current_pwd');

              $data = array(
                'password' => md5($pwd),
              );

            $change_pwd = $this->general_model->change_password($data, 'user', array('id' => $uid));

              // if($change_pwd == 1){
              $this->db->select('email,firstname');
              $this->db->from('user');
              $this->db->where('id',$uid);
              $count = $this->db->get()->row();
                  $email = $count->email;
                  $firstname = $count->firstname;
                  $emailsend = $this->general_model->change_pwd_Email($email, $firstname);
                  if($emailsend){
                    $data = array('login' => '', 'email' => '', 'username' => '', 'firstname' => '', 'uid' => '');
                   
                     $this->response([
                         'status' => TRUE, 
                          'message' => 'Your password has been updated, Try to Login with the new Password.'
                             ], REST_Controller::HTTP_OK);

                  }
                  else{

                      $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong. please try again'
                            ], REST_Controller::HTTP_NOT_FOUND);

                  }
                }
           
         
        }


     public function register_user_post() {
    
           
                $this->load->library('form_validation');
                $this->form_validation->set_rules('fname', 'Firstname', 'required');
                $this->form_validation->set_rules('lname', 'Lastname', 'required');
                $this->form_validation->set_rules('uname', 'Username', 'required|is_unique[user.username]');
                $this->form_validation->set_rules('gender', 'Gender', 'required');
                $this->form_validation->set_rules('mobile', 'Mobile No', 'required');
                $this->form_validation->set_rules('user_type', 'user_type', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

                if ($this->form_validation->run() == false) {
                    $err = validation_errors();
                   
                    $this->response([
                                'status' => FALSE,
                                'message' => $err
                            ], REST_Controller::HTTP_NOT_FOUND);

                } else {

                    $u_email = $this->input->post('u_email');
                    // echo '<pre>';print_r($this->input->post());exit;
                    if ($this->general_model->check_exist_data('id', 'user', array('email' => $u_email, 'is_deleted' => 0))) {


                        $this->response([
                                'status' => FALSE,
                                'message' => 'User already exist.'
                            ], REST_Controller::HTTP_NOT_FOUND);

                    } else {
                      $fname = $this->input->post('fname');
                      $lname = $this->input->post('lname');
                      $uname = $this->input->post('uname');
                      $mobile = $this->input->post('mobile');
                      $u_email = $this->input->post('email');
                      $gender = $this->input->post('gender');
                      $pwd = $this->input->post('password');
                      $u_chk = $this->input->post('user_type');
                      $code = rand(1111,9999);
                      $u_data = array(
                          'firstname' => $fname,
                          'lastname' => $lname,
                          'username' => $uname,
                          'mobile' => $mobile,
                          'email' => $u_email,
                          'gender' => $gender,
                          'password' => $pwd,
                          'u_category' => $u_chk,
                          'code' => $code,
                      );

                      $data = array(
                          'firstname' => $fname,
                          'lastname' => $lname,
                          'username' => $uname,
                          'mobile' => $mobile,
                          'email' => $u_email,
                          'gender' => $gender,
                          'password' => md5($pwd),
                          'u_category' => $u_chk,
                          'code' => $code,
                          'date' => date('Y-m-d H:i:s'),
                          'is_active' => 0,
                          'is_deleted' => 0,
                      );
                     

                        $emailsend = $this->general_model->sendConfirmationEmail($u_data);
                        if($emailsend){
                          $inserted_id = $this->general_model->insert_user($data, 'user');
                          

                          $this->response([
                         'status' => TRUE, 
                         'user_data' => $u_email, 
                          'message' => 'Activation code sent to email.'
                             ], REST_Controller::HTTP_OK);

                        }else{

                           $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong. please try again'
                            ], REST_Controller::HTTP_NOT_FOUND);

                           
                         }
                          
                      
                    }
                }

    }

    public function activate_email_post(){
    

      $u_email = $this->input->post('user_email');
      $code = $this->input->post('code');
      $user = $this->general_model->getUser($u_email);

    if($user['code'] == $code){
      $data['is_active'] = 1;
      $query = $this->general_model->activate($data, $u_email);
      if($query){
        $sess_data = array('login' => TRUE, 'email' => $user['email'], 'username' => $user['username'], 'uid' => $user['id'], 'firstname' => $user['firstname']);
        $this->session->set_userdata($sess_data);

      

         $this->response([
                         'status' => TRUE, 
                          'message' => 'User activated successfully.'
                             ], REST_Controller::HTTP_OK);

        // $this->session->set_flashdata('success_message', 'User activated successfully');
        // redirect('login', 'refresh');
      }
      else{
       
         $this->response([
                                'status' => FALSE,
                                'message' => 'Something went wrong in activating account'
                            ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
    else{
     

       $this->response([
                                'status' => FALSE,
                                'email' => $u_email,
                                'message' => 'Cannot activate account. Code did not match'
                            ], REST_Controller::HTTP_NOT_FOUND);

    }
  }

  public function service_list_get()
  {
      $filter_service_list = $this->general_model->get_filter_service_data( 'services', array('is_deleted' => 0));
      
         $this->response($filter_service_list, REST_Controller::HTTP_OK);
  }
 
 public function shop_list_get()
 {
    $filter_shop_list = $this->general_model->get_filter_shop_data( 'shop', array('is_deleted' => 0));
        $this->response($filter_shop_list, REST_Controller::HTTP_OK);
 }




  public function booking_count_post() {

   
        $id = $this->session->userdata('uid');
        $email = $this->session->userdata('email');
        $usertype = $this->session->userdata('usertype');

        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;
        $start = 0;
        

       $query = $this->db->get_where('workers', array('email' =>$email));
       $worker = $query->result();
       $worker_id = $worker[0]->id;
       if($usertype=='3'){
        $past_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', ("worker_id= '".$worker_id."' AND (booking_status = 2 OR booking_status = 3) AND ap_date < CURRENT_DATE() AND is_deleted = 0"));
        }
        else
        {
            $past_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', ("user_id= '".$this->session->userdata('uid')."'  AND (booking_status = 2 OR booking_status = 3) AND ap_date < CURRENT_DATE() AND is_deleted = 0"));
        }
        // echo "<pre>"; print_r($past_booking_data);exit;
        $all_past_booking_data = count($past_booking_data);
        

        // $present_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', array('booking_status' => 0, 'is_deleted' => 0));

        if($usertype=='3'){

        $present_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', (" worker_id= '".$worker_id."' AND (booking_status = 0 OR booking_status = 1) AND ap_date >= CURRENT_DATE() AND is_deleted = 0"));
         }
        else
        {
          $present_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', ("user_id= '".$this->session->userdata('uid')."'  AND (booking_status = 0 OR booking_status = 1) AND ap_date >= CURRENT_DATE() AND is_deleted = 0"));
        }
        // echo "<pre>"; print_r($present_booking_data);exit;
        $all_present_booking_data = count($present_booking_data);

        if($usertype=='3'){

        $finished_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', (" worker_id= '".$worker_id."' AND ( booking_status = 2)  AND is_deleted = 0"));
         }
        else
        {
          $finished_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', ("user_id= '".$this->session->userdata('uid')."'  AND ( booking_status = 2) AND is_deleted = 0"));
        }
        // echo "<pre>"; print_r($present_booking_data);exit;
        $all_finished_booking_data = count($finished_booking_data);



        $this->data['past_booking_data'] = $all_past_booking_data;
        $this->data['present_booking_data'] = $all_present_booking_data;
        $this->data['finished_booking_data'] = $all_finished_booking_data;

        $this->response([
           'status' => TRUE, 
           'past_booking_data' => $all_past_booking_data,
           'present_booking_data' => $all_present_booking_data,
           'finished_booking_data' => $all_finished_booking_data
               ], REST_Controller::HTTP_OK);

      
    }



     public function AddReview()
    {
      $userId = $this->session->userdata('uid');
      if($this->input->post())
      {
        $shopid = $this->input->post('shopid');
        $serviceid = $this->input->post('serviceid');
        $workerid = $this->input->post('workerid');
        $appointment = $this->input->post('appointment');
        $star = $this->input->post('star');

        $worker_star = $this->input->post('worker_star');
        $service_quality = $this->input->post('service_quality');
        $friendliness = $this->input->post('friendliness');
        $cleanliness = $this->input->post('cleanliness');
        $value_for_mony = $this->input->post('value_for_mony');

        $review = $this->input->post('review');
        $checkData = array(
          'shop_id' => $shopid,
          'service_id' => $serviceid,
          'worker_id' => $workerid,
          'appointment_id' => $appointment,
          'user_id' => $userId,
          'is_deleted' => 0
        );
        $ReviewData = $this->general_model->check_exist_data('*','rating_review',$checkData);
        // echo $this->db->last_query();exit;
        if(!empty($ReviewData))
        {
          $data = array(
            'star' => $star,
            'worker_star' => $worker_star,
            'service_quality' => $service_quality,
            'friendliness' => $friendliness,
            'cleanliness' => $cleanliness,
            'value_for_mony' => $value_for_mony,
            'review' => $review,
            'updated_date' => date('Y-m-d H:i:s')
          );
          $this->general_model->update_general_data($data,'rating_review',$checkData);
          echo '1';
        }
        else
        {
          $data = array(
            'shop_id' => $shopid,
            'service_id' => $serviceid,
            'worker_id' => $workerid,
            'appointment_id' => $appointment,
            'user_id' => $userId,
            'star' => $star,
            'worker_star' => $worker_star,
            'service_quality' => $service_quality,
            'friendliness' => $friendliness,
            'cleanliness' => $cleanliness,
            'value_for_mony' => $value_for_mony,
            'review' => $review,
            'is_deleted' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s')
          );

          $insert = $this->general_model->create_general_data($data,'rating_review');
          echo '0';
        }

      }
    }

    public function CheckReview()
    {
      $userId = $this->session->userdata('uid');
      if($this->input->post())
      {
        $shopid = $this->input->post('shopid');
        $serviceid = $this->input->post('serviceid');
        $workerid = $this->input->post('workerid');
        $appointment = $this->input->post('appointment');
        $star = $this->input->post('star');
        $review = $this->input->post('review');
        $checkData = array(
          'shop_id' => $shopid,
          'service_id' => $serviceid,
          'worker_id' => $workerid,
          'appointment_id' => $appointment,
          'user_id' => $userId,
          'is_deleted' => 0
        );
        $ReviewData = $this->general_model->check_exist_data('*','rating_review',$checkData);
        // echo $this->db->last_query();exit;
        if(!empty($ReviewData))
        {
          echo json_encode($ReviewData);exit;
        }
        else
        {
          echo "1";exit;
        }
      }
    }

    public function cancel_appointment()
    {
      $id = $this->session->userdata('uid');
      $appointment_id = $this->input->post('appointment_id');

      $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('id' => $appointment_id));

      $data = array(
        'is_active' => 0,
        'is_deleted' => 1,
        'booking_status' => 3
      );
      $update = $this->general_model->update_general_data($data,'appointment',array('id' => $appointment_id));

      $emailsend = $this->general_model->cancel_appointment_sendemail_client($email_data);
      $emailsend_worker = $this->general_model->cancel_appointment_sendemail_worker($email_data);
      $emailsend_shop = $this->general_model->cancel_appointment_sendemail_shop($email_data);

    }

    public function refund_appointment()
    {
      $id = $this->session->userdata('uid');
      $appointment_id = $this->input->post('appointment_id');

      $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('id' => $appointment_id));

      $request_date = date();
      $data = array(
        'is_active' => 0,
        'refund_request' => 'yes',
        'refund_request_date' => $request_date,
      
      );
      $update = $this->general_model->update_general_data($data,'appointment',array('id' => $appointment_id));

     

    }


    public function confirm_appointment()
    {
      $id = $this->session->userdata('uid');
      $appointment_id = $this->input->post('appointment_id');

      $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('id' => $appointment_id));

      $data = array(
        'is_active' => 0,
        'booking_status' => 1
      );
      $update = $this->general_model->update_general_data($data,'appointment',array('id' => $appointment_id));

     

    }

    public function booking_data()
    {
      $id = $this->session->userdata('uid');
      $usertype = $this->session->userdata('usertype'); 
      // print_r($this->session->userdata('email')); 

      $query = $this->db->get_where('workers', array('email' =>$this->session->userdata('email')));
      $worker = $query->result();
      $worker_id = $worker[0]->id;

      $past_appointments = $this->input->post('past_appointments');
      $current_appointments = $this->input->post('current_appointments');
      $finished_appointments = $this->input->post('finished_appointments');
      $limit = $this->input->post('limit');
      $start = $this->input->post('start');
      // echo '<pre>'; print_r($_POST);exit;
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id));

      if(isset($start, $limit))
      {
        if($past_appointments && $past_appointments == 1){
          // echo 'past';exit;
          if($usertype=='3'){
             $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ("appointment.worker_id= '".$worker_id."' AND (appointment.booking_status = 2 OR appointment.booking_status = 3) AND appointment.ap_date < CURRENT_DATE() AND appointment.is_deleted = 0"),$limit,$start);
          }
          else{
          $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ("appointment.user_id= '".$this->session->userdata('uid')."' AND (appointment.booking_status = 2 OR appointment.booking_status = 3) AND appointment.ap_date < CURRENT_DATE() AND appointment.is_deleted = 0"),$limit,$start);
          }
        }
        else if($current_appointments && $current_appointments == 1){
          // echo 'current';exit;
          if($usertype=='3'){
             $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ("appointment.worker_id= '".$worker_id."' AND (appointment.booking_status = 0 OR appointment.booking_status = 1) AND appointment.ap_date >= CURRENT_DATE() AND appointment.is_deleted = 0"),$limit,$start);
             }
          else{
          $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ("appointment.user_id= '".$this->session->userdata('uid')."' AND (appointment.booking_status = 0 OR appointment.booking_status = 1) AND appointment.ap_date >= CURRENT_DATE() AND appointment.is_deleted = 0"),$limit,$start);
            }
        }

        else if($finished_appointments && $finished_appointments == 1){
          // echo 'current';exit;
          if($usertype=='3'){
             $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ("appointment.worker_id= '".$worker_id."' AND (appointment.booking_status = 2)  AND appointment.is_deleted = 0"),$limit,$start);
             }
          else{
          $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ("appointment.user_id= '".$this->session->userdata('uid')."' AND (appointment.booking_status = 2)  AND appointment.is_deleted = 0"),$limit,$start);
            }
        }




        else{
          // echo 'none';exit;
          if($usertype=='3'){
            $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ('appointment.worker_id = "'.$worker_id.'" AND appointment.is_deleted = 0'),$limit,$start);
            }
          else{
          $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', ('appointment.user_id = "'.$id.'" AND appointment.is_deleted = 0'),$limit,$start);
           }
          // $appointment_list = $this->general_model->get_appointment_all_data( 'appointment', array('appointment.user_id' => $id, 'appointment.is_deleted' => 0),$limit,$start);
        }
        $user_category = $user_list->u_category;
        // echo "<pre>"; print_r($appointment_list);exit;
        if(count($appointment_list) > 0){
          foreach ($appointment_list as $key => $appointment) {
            $shop_list = $this->general_model->get_shop_list_data('shop', array('shop.id' => $appointment->shop_id));
            // echo '<pre>'; print_r($shop_list); exit;
            $service_image = $appointment->service_image;
            $temp_file = base_url()."front/images/banner.jpg";
            $main_file = "assets/uploads/service_image/".$service_image;
            $filename = FCPATH.$main_file;
            if (file_exists($filename)) {
              if($service_image != ''){
                  $main_image =  base_url().$main_file;
              }else{
                  $main_image =  $temp_file;
              }
            }else{
              $main_image =  $temp_file;
            }

            $shop_image = $appointment->shop_image;
            $temp_file1 = base_url()."front/images/banner.jpg";
            $main_file1 = "assets/uploads/shop_image/".$shop_image;
            $filename1 = FCPATH.$main_file1;
            if (file_exists($filename1)) {
              if($worker_image != ''){
                  $main_image1 =  base_url().$main_file1;
              }else{
                  $main_image1 =  $temp_file1;
              }
            }else{
              $main_image1 =  $temp_file1;
            }

            $data = array(
              'user_id' => $id,
              'service_id' => $appointment->service_id,
              'shop_id' => $appointment->shop_id
            );
            $FavData = $this->general_model->check_exist_data('id','favourite',$data);
            $fav = !empty($FavData) ? "1" : "0";
            $appointment_list[$key]->fav = $fav;
            $heart = ($fav == "1")  ? 'fa-heart' : 'fa-heart-o';

            $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $appointment->shop_id,'is_deleted' => 0));
            $all_review = count($all_review_list);
            $review_list = $all_review;
            if(!empty($all_review))
            {
              $sum = 0;
              foreach($all_review_list as $item) {
                $sum += $item->star;
              }
              $ratingEverage = $sum / $all_review;
              $roundEvg = round($ratingEverage);
            }
            else
            {
              $roundEvg = 0;
            }
            $ratingRound = $roundEvg;

            $ap_date = strtotime($appointment->ap_date);
            $main_ap_date = date('j M ', $ap_date);
            $from_time = date('h:i A', strtotime($appointment->from_time));
            $todaysdate=date("Y-m-d");

            if($appointment->booking_status == 0 && $appointment->ap_date >= $todaysdate){
                $booking_status = 'Pending';
            }
            if($appointment->booking_status == 1){
                $booking_status = 'Confirmed';
            }
            if($appointment->booking_status == 2){
                $booking_status = 'Finished';
            }
            if($appointment->booking_status == 3){
                $booking_status = 'Cancelled';
            }
            if($appointment->ap_date < $todaysdate){
                $booking_status = 'Expired';
            }
            // echo $booking_status; exit;
            // echo '<pre>'; print_r($appointment); exit;

            if($appointment->addline2 != ''){
              $add2 = ', '.$appointment->addline2;
            }else{
              $add2 = '';
            }
            $var1 =  $this->url_encrypt($appointment->main_service_id);
            $encrypt_id = $var1;
            $var2 =  $this->url_encrypt($appointment->shop_id);
            $encrypt_shop_id = $var2;
            if($appointment->booking_status == 2){
              $review_section = '<h4 style="color: white; text-align: right;"><a href="#" class="addReview" name="appointMentData" id="appointMentData" data-shop="'.$appointment->shop_id.'" data-service="'.$appointment->service_id.'" data-appointment="'.$appointment->id.'" data-worker-id="'.$appointment->worker_id.'" data-worker-name="'.$appointment->worker_name.'" data-star="" style="color: #fff;">ADD REVIEW</a></h4>';
            }else{
              $review_section = '';
            }

            $html = '';
            $twitter = base_url()."front/images2/twitter.png";
            $fb = base_url()."front/images2/facebook-icon.png";
            $insta = base_url()."front/images2/insta-icon.png";
            $location = base_url()."front/images2/location.png";

            $html .= '<div class="row p-detail-list"><div class="col-md-5 center"><a href="#"><img src="'.$main_image.'" width="100%" height="350px" class="cls_s_img" style="object-fit:cover;"></a><div class="bottom_social_link" style="margin-top: 10px"><div class="social-area" style="display: flex;"><li style="list-style: none;text-decoration: none; padding-right: 10px"><a href="https://twitter.com/GgGroom" target="_blank"><img src="'.$twitter.'"></a></li><li style="list-style: none;text-decoration: none; padding-right: 10px"><a href="https://www.facebook.com/gggroom/" target="_blank"><img src="'.$fb.'"></a></li><li style="list-style: none;text-decoration: none;padding-right: 10px;"><a href="https://www.instagram.com/gggroomapp/" target="_blank"><img src="'.$insta.'"></a></li>'.$review_section.'</div></div><p style="font-weight: normal; text-align: justify;">'.$shop_list[0]->description.'
            </p></div><div class="col-md-7"><div class="product_details"><div class="like_dislike"><span class="fav">FAVORITE</span><i class="fa '.$heart.' heart_like_dislike" data-shopid="'.$appointment->shop_id.'" data-serviceid="'.$appointment->service_id.'" aria-hidden="true" id="like_dislike"></i><img src="'.$main_image1.'" class="img-responsive img-circle" style="object-fit:cover;"><h2>'.$appointment->shop_name.'</h2><hr></div><div class="cmpny_details"><p>'.$appointment->service_name.' - with '.$appointment->worker_name.'  -  $'.$appointment->price.'</p><div class="star-container">';
            for ($i=0; $i < 5; $i++) {
              if($i < $ratingRound){
                $html .= '<i class="fa fa-star fa-2x star-checked" id="star-'.$i.'"></i>';
              }else{
                $html .= '<i class="fa fa-star fa-2x" id="star-'.$i.'"></i>';
              }
            }
            $html .= '<span>('.$review_list.')<a href="'.base_url('booking/review/'.$appointment->shop_id).'" style="color:#000;"> Show All</a></span><hr></div><div class="locate"><ul><li><img src="'.$location.'"></li><li style="font-weight: bold;">'.$appointment->addline1.$add2.', <br> '.$shop_list[0]->city_name.', '.$shop_list[0]->state_name.', '.$appointment->zipcode.'</li><li style="font-weight: bold;">'.$main_ap_date.'<br> '.$from_time.'</li><li style="color: red; font-weight: bold;">'.$booking_status.'</li></ul></div><div class="bottom_btn_product">';
            if($appointment->mainuser != $id){
              $html .= '<div class="bottom_btn_product">';
              if($user_category != 2){
                $html .= '<div class="button_link col-md-3"><a href="'.base_url('chat?id='.$appointment->mainuser).'">MESSAGE US</a></div>';
              }
              if($appointment->booking_status == 2 || $appointment->booking_status == 3){
                $html .= '<div class="button_link col-md-3"><a href="'.site_url().'appointment/appointment_step1/'.$appointment->shop_id.'/'.$encrypt_id.'">BOOK AGAIN</a></div><div class="button_link col-md-3"><a href="void:javascript(0)" class="btn_call_us" data-shop-mobile="'.$appointment->shop_mobile.'">CALL US</a></div><div class="col-md-2 button_link refund_ap col-md-3'.$appointment->id.'"><a href="void:javascript(0)" class="btn_refund" data-appointment-id="'.$appointment->id.'">REFUND</a></div>';
              }
              if($appointment->booking_status == 1 || $appointment->booking_status == 0 && $appointment->ap_date >= $todaysdate){
                $html .= '<div class="col-md-2 button_link cancel_ap col-md-3'.$appointment->id.'"><a href="void:javascript(0)" class="btn_cancel" data-appointment-id="'.$appointment->id.'">CANCEL</a></div><div class="col-md-2 button_link refund_ap col-md-3'.$appointment->id.'"><a href="void:javascript(0)" class="btn_refund" data-appointment-id="'.$appointment->id.'">REFUND</a></div>';
              }
               if($appointment->booking_status == 0 && $appointment->ap_date >= $todaysdate){
                $html .= '<div class="col-md-2 button_link confirm_ap col-md-3'.$appointment->id.'"><a href="void:javascript(0)" class="btn_confirm" data-appointment-id="'.$appointment->id.'">CONFIRM</a></div>';
              }
              $html .= '</div>';
            }
            $html .= '</div></div></div></div></div>';
            echo $html;
          }
        }else{
          echo '';
          // echo "<div class='row' style='clear:both;'><h2 style='text-align:center;'>You dont have any favorites so far.</h2></div>";
        }
      }
    }
    public function review($shop_id){
      $all_review_list = $this->general_model->count_rating_review_with_user( 'rating_review', array('rating_review.shop_id' => $shop_id,'rating_review.is_deleted' => 0));
      $this->data['all_review_list'] = $all_review_list;
      $this->data['title'] = 'All Review | GGG Rooms';
      $this->render('review_view');
    }



 public function reset_password_post(){
         
         $this->form_validation->set_rules('recovery_email', 'Email', 'required');

          if ($this->form_validation->run() == false) {
              $this->response([
                                'status' => FALSE,
                                'message' => 'Email is require'
                            ], REST_Controller::HTTP_NOT_FOUND);
          } else {

            $email = $this->input->post('recovery_email');
            $this->load->helper('string', 6);
            $token= random_string('alnum', 12);

              $data = array(
                  'token' => $token
              );

              $qry = $this->db->where('email', $email)
                              ->update('user', $data);

              $emailsend = $this->general_model->forgot_pwd_Email($email, $token);
              if($emailsend){

                $this->response([
                         'status' => TRUE, 
                          'message' => 'Your password has been updated, Try to Login with the new Password.'
                             ], REST_Controller::HTTP_OK);

              }
              else{
               
                $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry, something went wrong. please try again'
                            ], REST_Controller::HTTP_NOT_FOUND);
              }
          }
        
      }

}
