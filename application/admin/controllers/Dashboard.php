<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Dashboard extends Admin_Controller {

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
    }

    public function index() {

        if ($this->session->userdata('admin_id')) {
            $this->data['admin'] = '';

            $admin_id = $this->session->userdata('admin_id');
            $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
            $this->data['admin_data'] = $admin_data;

            $user_val = $this->general_model->get_all_general_data("*", "user", array('is_deleted' => 0), 'result_array');
            $this->data['user_val'] = count($user_val);

            $category_list = $this->general_model->get_all_general_data("*", "category", array('is_deleted' => 0), 'result_array');
            $this->data['category_list'] = count($category_list);

            $shop_list = $this->general_model->get_all_general_data("*", "shop", array('is_deleted' => 0), 'result_array');
            $this->data['shop_list'] = count($shop_list);

            $appointment_list = $this->general_model->get_all_general_data("*", "appointment", array('is_deleted' => 0), 'result_array');
            $this->data['appointment_list'] = count($appointment_list);

            $service_list = $this->general_model->get_all_general_data("*", "services", array('is_deleted' => 0), 'result_array');
            $this->data['service_list'] = count($service_list);

            $collection_list = $this->general_model->get_collection_data( "appointment", array('appointment.is_deleted' => 0, 'appointment.booking_status' => 1), 'result_array');
            // echo '<pre>';print_r($collection_list);exit;
            $total_price = 0;
            foreach ($collection_list as $key => $val_price) {
                $total_price += $val_price['price'];
            }
            $this->data['collection_list'] = $total_price;

            $count_shop = $this->general_model->get_count_shop_data("*", "shop", array('is_deleted' => 0));
            $total_shop = count($count_shop);
            $count_service_list = $this->general_model->get_service_limit_data("*", "category", array('flag'=> 2,'is_deleted' => 0));

            foreach ($count_service_list as $key => $value) {
                $count_service_list1 = $this->general_model->get_count_shop_data1("shop_id", "services", array('is_deleted' => 0, 'cat_id' => $value->category_id));
                $total_service = count($count_service_list1);
                $per = ($total_service * 100) / $total_shop;
                $count_service_list[$key]->percent = round($per);
            }
            // echo '<pre>';print_r($count_service_list);exit;
            $this->data['count_service_list'] = $count_service_list;

            $this->data['full_css_file'] = array(
                "https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"
            );

            $this->data['js_file'] = array(
                "assets/build/js/dashboard.js",
                "assets/build/js/jquery.easypiechart.min.js",
                "assets/build/js/bootstrap-progressbar.min.js"
            );

            $this->data['full_js_file'] = array(
                "https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js",
            );

            $this->render('Home/Dashboard_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        redirect('Login', 'refresh');
    }

    public function change_password(){
        $this->load->helper('form');
            $this->load->library('form_validation');
         if ($this->session->userdata('admin_id')) {
           $admin_id = $this->session->userdata('admin_id');
           $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
           $this->data['admin_data'] = $admin_data;

             if($this->input->post()){
                 $this->form_validation->set_rules('n_password', 'New Password', 'trim|required');
                 $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required');
                   if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect("Dashboard/change_password", 'refresh');
                } else {
                     $new_pass = $this->input->post('n_password');
                    $confirm_pass = $this->input->post('c_password');
                        if ($new_pass == $confirm_pass) {
                        $NewPassword = $this->url_encrypt($new_pass);
                        $data = array(
                            'password' => $NewPassword,
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        // echo "<pre>"; print_r($data);exit;
                        if ($this->general_model->update_general_data($data, 'admin', array('id' => $_SESSION['admin_id'], 'is_deleted' => 0))) {
                            $this->session->set_flashdata('success_message', "Password changed successfully.");
                            redirect('Dashboard/change_password', 'refresh');
                        } else {
                            $this->session->set_flashdata('error_message', "There is some problem in change password.");
                            redirect('Dashboard/change_password', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', "Password and confirm password do not match");
                        redirect('Dashboard/change_password', 'refresh');
                    }
                }
             }else{
                 $this->render('Home/Change_password_view');
             }
         }else {
            redirect('Login', 'refresh');
        }
    }
     public function Forgotpassword() {
       $admin_id = $this->session->userdata('admin_id');
       $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
       $this->data['admin_data'] = $admin_data;

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error_message', "Emailid is require");
                redirect('Dashboard/Forgotpassword', 'refresh');
            } else {
                if ($this->general_model->check_exist_data('email', 'admin', array('email' => $this->input->post('email'), 'is_deleted' => 0))) {
                    $email_id = $this->input->post('email');
                    $token = $this->url_encrypt($email_id);
                    $ChangePassUrl = site_url("Dashboard/changepassword/" . $token);
//                    echo $ChangePassUrl;exit;
                    $emailBody = 'Please change your password : ' . $ChangePassUrl;
                    // set email data

                    // $config = Array(
                    //     'protocol' => 'smtp',
                    //     'smtp_host' => 'ssl://smtp.googlemail.com',
                    //     'smtp_port' => 465,
                    //     'smtp_user' => 'rahulitp',
                    //     'smtp_pass' => 'rahul123#',
                    //     'mailtype' => 'html',
                    //     'charset' => 'iso-8859-1'
                    // );
                    $this->load->library('email');
                    $this->email->initialize(array(
                    'protocol' => 'mail',
                    'smtp_host' => 'smtp.sendgrid.net',
                    'smtp_user' => 'pratikvekariya',
                    'smtp_pass' => 'pratik123#',
                    'smtp_port' => 587,
                    'crlf' => "\r\n",
                    'newline' => "\r\n"
                    ));
                    $this->email->set_newline("\r\n");


                    $this->email->set_mailtype("html");
                    $this->email->from('admin@gggroom.com', 'GGG Rooms');
                    $this->email->to($this->input->post('email'));
                    $this->email->subject('GGGRoom :: Change password');
                    $this->email->message($emailBody);
                    $data = array(
                        'token' => $token,
                        'updated_date' => date('Y-m-d H:i:s')
                    );
                  // $this->email->send();
                    if ($this->general_model->update_general_data($data, 'admin', array('email' => $email_id, 'is_deleted' => 0))) {
                        if ($this->email->send()) {
                            $this->session->set_flashdata('success_message', "Email has been sent to your registered email, Please follow link to reset password.");
                            redirect('Dashboard/Forgotpassword', 'refresh');
                        } else {
                            $this->session->set_flashdata('success_message', "Email could not send, please contact administrator to verify email.");
                            redirect('Dashboard/Forgotpassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', "Forgot Password request failed.");
                        redirect('Dashboard/Forgotpassword', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', "Email id is not exists");
                    redirect('Dashboard/Forgotpassword', 'refresh');
                }
            }
        } else {
            $this->data['admin'] = '';
            $this->render('Home/Forgotpassword_view');
        }
    }

    public function changepassword($token = '') {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;

        if (!$this->session->userdata('admin_id')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required');
            if ($this->input->post()) {
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('message', "Password is require");
                    redirect('Dashboard/changepassword', 'refresh');
                } else {
                    // print_r($_POST);exit;
                    $new_pass = $this->input->post('password');
                    $token = $this->input->post('token');
                    $confirm_pass = $this->input->post('c_password');
                    if ($new_pass == $confirm_pass) {
                        // $NewPassword = $this->url_encrypt($new_pass);
                        $NewPassword =md5($new_pass);
                        $data = array(
                            'password' => $NewPassword,
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        // echo "<pre>"; print_r($data);exit;
                        if ($this->general_model->update_general_data($data, 'admin', array('token' => $token, 'is_deleted' => 0))) {
                            $this->session->set_flashdata('success_message', "Password changed successfully.");
                            unset($_SESSION['admin_id']);
                            redirect('Login', 'refresh');
                        } else {
                            $this->session->set_flashdata('error_message', "There is some problem in change password.");
                            redirect('Dashboard/changepassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', "Password and confirm password do not match");
                        redirect('Dashboard/changepassword', 'refresh');
                    }
                }
            } else {
                $this->data['token'] = $token;
                $this->render('Home/changepassword_view');
            }
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required');
            if ($this->input->post()) {
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('message', "Password is require");
                    redirect('Dashboard/changepassword', 'refresh');
                } else {
                    // print_r($_POST);exit;
                    $new_pass = $this->input->post('password');
                    $confirm_pass = $this->input->post('c_password');
                    if ($new_pass == $confirm_pass) {
                        $NewPassword = $this->url_encrypt($new_pass);
                        $data = array(
                            'password' => $NewPassword,
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        // echo "<pre>"; print_r($data);exit;
                        if ($this->general_model->update_general_data($data, 'admin', array('id' => $_SESSION['admin_id'], 'is_deleted' => 0))) {
                            $this->session->set_flashdata('success_message', "Password changed successfully.");
                            redirect('Dashboard/changepassword', 'refresh');
                        } else {
                            $this->session->set_flashdata('error_message', "There is some problem in change password.");
                            redirect('Dashboard/changepassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', "Password and confirm password do not match");
                        redirect('Dashboard/changepassword', 'refresh');
                    }
                }
            } else {
                $this->data['admin'] = '';
                $this->render('Home/changepassword_view_login');
            }
        }
    }

    public function settings() {
      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;

        if($this->input->post()){

          if (isset($_FILES['p_logo']) && $_FILES['p_logo']['name'] != "") {
                        $chkext = $this->getExtention($_FILES['p_logo']['name']);
                        $ext = strtolower($chkext);
                        $validextensions = array("jpg","jpeg","png","gif");
                        if (in_array($ext, $validextensions))
                        {
                        $p_logo = $this->getFileName($_FILES['p_logo']['name']) . "_" . time() . "." . $ext;
                        $original = str_replace('\\', '/', FCPATH . "assets/images/" . $p_logo);
                        $profile_logo = str_replace('\\', '/', FCPATH . "assets/images/thumb/" . $p_logo);
                        $source = $_FILES['p_logo']['tmp_name'];
                        /* create thumbnail image */
                        // $filename = @stripslashes($_FILES['p_logo']['name']);

                        if ($ext == "jpg" || $ext == "jpeg") {
                            $uploadedfile = $_FILES['p_logo']['tmp_name'];
                            $src = @imagecreatefromjpeg($uploadedfile);
                        } else if ($ext == "png") {
                            $uploadedfile = $_FILES['p_logo']['tmp_name'];
                            $src = @imagecreatefrompng($uploadedfile);
                        } else {
                              $uploadedfile = $_FILES['p_logo']['tmp_name'];
                            $src = @imagecreatefromgif($uploadedfile);
                        }

                        @list($width, $height) = @getimagesize($uploadedfile);
                        $newwidth = 150;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = @imagecreatetruecolor($newwidth, $newheight);
                        @imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        @imagejpeg($tmp, $profile_logo, 100);
                        move_uploaded_file($source, $original);
                        $profile_picture = $p_logo;
                        $adminimg = $this->general_model->check_exist_data('id,profile_img', 'admin', array('id' => $this->session->userdata('admin_id'), 'is_deleted' => 0));
                        if ($adminimg->profile_img != '') {
//                           echo $_SERVER['DOCUMENT_ROOT'];exit;
                            $file = str_replace('\\', '/', FCPATH . "assets/images/" . $adminimg->profile_img);
                            unlink($file);
                            $thumb = str_replace('\\', '/', FCPATH . "assets/images/thumb/" . $adminimg->profile_img);
                            unlink($thumb);
                        }
                        }
                        else{
                            $this->session->set_flashdata('error_message', 'Only image Allowed');
                            redirect('Dashboard/settings', 'refresh');exit;
                        }
                    } else {
                        $profile_picture = $this->input->post('old_image');
                    }
                    $data = array(
                        'firstname' => $this->input->post('firstname'),
                        'lastname' => $this->input->post('lastname'),
                        'username' => $this->input->post('username'),
                        'email' => $this->input->post('email'),
                        'profile_img' => $profile_picture,
                        'updated_date' => date('Y-m-d H:i:s')
                    );
          $update_id = $this->general_model->update_general_data($data, 'admin', array('id' => $this->session->userdata('admin_id')));
          if ($update_id) {
                $_SESSION['name'] = $this->input->post('username');
                $_SESSION['email'] = $this->input->post('email');
                $_SESSION['profile_picture'] = $profile_picture;
              $this->session->set_flashdata('success_message', "Profile changed successfully");
              redirect('Dashboard/settings', 'refresh');
          }else{
            $this->session->set_flashdata('error_message', "There is a problem uploading profile, please try again later");
            redirect('Dashboard/settings', 'refresh');
          }
        }else{
          $getAdminData = $this->general_model->get_all_general_data("*", "admin", array('id'=>$_SESSION['admin_id'], 'is_deleted' => 0), 'row_array');
          // echo '<pre>'; print_r($getAdminData);exit;
          $this->data['admin'] = $getAdminData;
          $this->render('Home/settings_view');
        }
      }
      else{
           redirect('Login', 'refresh');
      }
    }

    public function GetAppointment()
    {
        $appointment_list = $this->general_model->GetAppointmentData(array());

        $arr1 = [];
        foreach ($appointment_list as $key => $appointment)
        {
            $arr1[] = array('Date'=>date("Y-m", strtotime($appointment['ap_date'])),'amount'=>$appointment['price']);
        }
        // echo '<pre>';print_r($arr1);exit;
        $Arr_new = [];

        $last = date('Y-m');
        $first =  date('Y-m', strtotime('-1 year'));
        $step = '+1 month';
        $format = 'Y-m';
        $current = strtotime($first);
        $last = strtotime($last);
        while( $current <= $last ) {
          $Arr_new[] = array('Date'=>date($format, $current), 'amount'=>'0');
          $current = strtotime($step, $current);
        }

      //count prize by month wise
      $aggregateArray = array();
      foreach($arr1 as $row) {
        if(!array_key_exists($row['Date'], $aggregateArray)){
          $aggregateArray[$row['Date']] = 0;
        }
        $aggregateArray[$row['Date']] += $row['amount'];
      }
      $temp_array = [];
      foreach ($aggregateArray as $key => $value) {
        $temp_array[]  =  array('Date'=> $key, 'amount'=> $value);
      }
        for($i = 0; $i < count($Arr_new); $i++){
          for($j = 0; $j < count($temp_array); $j++){
            if($temp_array[$j]['Date'] == $Arr_new[$i]['Date']){
              if($temp_array[$j]['amount'] != '0'){
                  $Arr_new[$i]['amount'] = $temp_array[$j]['amount'];
              }
            }
          }
        }
        echo json_encode($Arr_new);
    }

    public function get_country_data()
    {
      $state_list = $this->general_model->get_state_data('shop.state, state.name as state_name', 'shop',array('shop.is_deleted' => 0));
         $New_Arr = [];
         foreach ($state_list as $key => $value) {
           $all_state_list = $this->general_model->get_state_all_data('*', 'shop',array('state' => $value->state, 'is_deleted' => 0));
           $all_state = count($all_state_list);
           if(!empty($state_list[$key]->state_name)){
           $New_Arr[] = array('State'=> $state_list[$key]->state_name,'shop'=> $all_state);
         }
         }
         // echo '<pre>';print_r($New_Arr);exit;
        echo json_encode($New_Arr);
    }
    public function get_location_payment_data()
    {
      $state_list = $this->general_model->get_state_data('shop.state, state.name as state_name', 'shop',array('shop.is_deleted' => 0));
      $cash = 0;
      $stripe = 0;
      $squareup = 0;
         $New_Arr = [];
         foreach ($state_list as $key => $value) {
           $all_state_list = $this->general_model->get_state_all_data('*', 'shop',array('state' => $value->state, 'is_deleted' => 0));
           if(!empty($all_state_list)){
             foreach ($all_state_list as $key1 => $value) {
                $all_price_list = $this->general_model->get_appointment_payment_data('appointment',array('appointment.shop_id' => $value->id, 'appointment.is_deleted' => 0, 'appointment.booking_status' => 2));

                if(!empty($all_price_list)){
                  foreach ($all_price_list as $key1 => $value) {
                    $price = $value->price;
                    if($value->payment_type == 1){
                      $stripe += $price;
                    }elseif ($value->payment_type == 2) {
                      $squareup += $price;
                    }elseif ($value->payment_type == 3) {
                      $cash += $price;
                    }
                  }
                }
             }
           }
           if(!empty($state_list[$key]->state_name)){
              $New_Arr[] = array('State'=> $state_list[$key]->state_name,'a'=> $stripe,'b'=> $squareup,'c'=> $cash);
           }
         }
         // echo '<pre>';print_r($New_Arr);exit;
        echo json_encode($New_Arr);
    }

    public function get_payment_data()
    {
      $payment_list = $this->general_model->get_payment_data('*', 'orders',array('is_deleted' => 0, 'status' => 1));
        $cash = 0;
        $online = 0;
         $New_Arr = [];
         foreach ($payment_list as $key => $value) {
           $price = $value->price;
           if($value->payment_type == 1 || $value->payment_type == 2){
             $online += $price;
           }elseif ($value->payment_type == 3) {
             $cash += $price;
           }
         }
         $New_Arr[0] = array('label'=> 'Cash($)','y'=> $cash);
         $New_Arr[1] = array('label'=> 'Online($)','y'=> $online);
        echo json_encode($New_Arr);
    }

    // public function get_country_data()
    // {
    //     $state_list = $this->general_model->get_state_data('shop.state, state.name as state_name', 'shop',array('shop.is_deleted' => 0));
    //     $New_Arr = [];
    //     foreach ($state_list as $key => $value) {
    //       $all_state_list = $this->general_model->get_state_all_data('*', 'shop',array('state' => $value->state, 'is_deleted' => 0));
    //       $all_state = count($all_state_list);
    //       if($all_state == 1 || $all_state == 0){
    //         $shop = $all_state.' shop';
    //       }else{
    //         $shop = $all_state.' shops';
    //       }
    //
    //       $New_Arr[] = array('label'=>$state_list[$key]->state_name,'value'=>$shop);
    //     }
    //
    //     echo json_encode($New_Arr);
    // }
}
