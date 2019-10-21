<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class User extends MY_Controller {

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
        $userid = $_SESSION['user_id'];
        if ($this->session->userdata('username')) {
            $User_val = $this->general_model->get_all_general_data("*", "user", array('is_deleted' => 0, 'customer_id' => $userid), 'result_array');
//      print_r($User_val);exit;
            $this->data['User'] = $User_val;
            $this->render('user/listuser_view');
        } else {
            redirect('Home');
        }
    }

    public function adduser() {
//        echo '<pre>'; print_r($_SESSION['user_id']);exit;
        $userid = $_SESSION['user_id'];
        if ($this->session->userdata('username')) {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('surname', 'Surname', 'trim|required');
            $this->form_validation->set_rules('email', 'Emailid', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('phone_number', 'Phone', 'trim|required');
            $this->form_validation->set_rules('identi_num', 'Identification number', 'trim|required');
//            $Password = $this->general_model->generate_random_password();
//            $NewPassword = $this->url_encrypt($Password);
            if ($this->input->post()) {
//                print_r($_POST);exit;
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('index.php/user/adduser', 'refresh');
                } else {
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');
                    $email = $this->input->post('email');
                    $Password = $this->input->post('password');
                    $NewPassword = $this->url_encrypt($Password);
                    $phone_number = $this->input->post('phone_number');
                    $role = $this->input->post('role');
                    $identi_num = $this->input->post('identi_num');
                    $isactive = $this->input->post('isactive');
                    if ($isactive != '') {
                        $isactive = $isactive;
                    } else {
                        $isactive = 'off';
                    }
                    $plan = $this->general_model->check_exist_data('plan', 'customer', array('id' => $userid, 'is_deleted' => 0));
                    $plan = explode('user',$plan->plan);
//                    print_r($plan);exit;
                    $User_val = $this->general_model->get_all_general_data("*", "user", array('is_deleted' => 0, 'customer_id' => $userid), 'result_array');
                   $count_user = count($User_val);

//                    print_r($User_val);exit;
                         if($count_user < $plan[0]){
                    if (!$this->general_model->check_exist_data('id', 'user', array('email' => $this->input->post('email'), 'is_deleted' => 0))) {

                        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != "") {
                            $chkext = $this->getExtention($_FILES['profile_picture']['name']);
                            $ext = strtolower($chkext);
                            $profile_picture = $this->getFileName($_FILES['profile_picture']['name']) . "_" . time() . "." . $ext;
                            $original = str_replace('\\', '/', FCPATH . "assets/uploads/users/profile/" . $profile_picture);
                            $profile_logo = str_replace('\\', '/', FCPATH . "assets/uploads/users/profile/thumb/" . $profile_picture);
                            $source = $_FILES['profile_picture']['tmp_name'];
                            /* create thumbnail image */
                            // $filename = @stripslashes($_FILES['profile_picture']['name']);

                            if ($ext == "jpg" || $ext == "jpeg") {
                                $uploadedfile = $_FILES['profile_picture']['tmp_name'];
                                $src = @imagecreatefromjpeg($uploadedfile);
                            } else if ($ext == "png") {
                                $uploadedfile = $_FILES['profile_picture']['tmp_name'];
                                $src = @imagecreatefrompng($uploadedfile);
                            } else {
                                $src = @imagecreatefromgif($uploadedfile);
                            }

                            @list($width, $height) = @getimagesize($uploadedfile);
                            $newwidth = 150;
                            $newheight = ($height / $width) * $newwidth;
                            $tmp = @imagecreatetruecolor($newwidth, $newheight);
                            @imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            // $filename = $uploaddir. $_FILES['profile_picture']['name'];
                            @imagejpeg($tmp, $profile_logo, 100);
                            move_uploaded_file($source, $original);
                            $profile_picture = $profile_picture;
                        } else {
                            $profile_picture = '';
                        }

                        if (isset($_FILES['identi_card_img']) && $_FILES['identi_card_img']['name'] != "") {
                            $chkext = $this->getExtention($_FILES['identi_card_img']['name']);
                            $ext = strtolower($chkext);
                            $identi_card_img = $this->getFileName($_FILES['identi_card_img']['name']) . "_" . time() . "." . $ext;
                            $original = str_replace('\\', '/', FCPATH . "assets/uploads/users/identification/" . $identi_card_img);
                            $identi_logo = str_replace('\\', '/', FCPATH . "assets/uploads/users/identification/thumb/" . $identi_card_img);
                            $source = $_FILES['identi_card_img']['tmp_name'];

                            if ($ext == "jpg" || $ext == "jpeg") {
                                $uploadedfile = $_FILES['identi_card_img']['tmp_name'];
                                $src = @imagecreatefromjpeg($uploadedfile);
                            } else if ($ext == "png") {
                                $uploadedfile = $_FILES['identi_card_img']['tmp_name'];
                                $src = @imagecreatefrompng($uploadedfile);
                            } else {
                                $src = @imagecreatefromgif($uploadedfile);
                            }

                            @list($width, $height) = @getimagesize($uploadedfile);
                            $newwidth = 150;
                            $newheight = ($height / $width) * $newwidth;
                            $tmp = @imagecreatetruecolor($newwidth, $newheight);
                            @imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            @imagejpeg($tmp, $identi_logo, 100);
                            move_uploaded_file($source, $original);
                            $identi_card_img = $identi_card_img;
                        } else {
                            $identi_card_img = '';
                        }

                        $data = array(
                            'customer_id' => $userid,
                            'name' => $name,
                            'surname' => $surname,
                            'password' => $NewPassword,
                            'email' => $email,
                            'phone_number' => $phone_number,
                            'profile_picture' => $profile_picture,
                            'identi_card_img' => $identi_card_img,
                            'role' => $role,
                            'identi_num' => $identi_num,
                            'isactive' => $isactive,
                            'is_deleted' => 0,
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_date' => date('Y-m-d H:i:s')
                        );

                        if ($this->general_model->create_general_data($data, 'user')) {

                             $emailBody = 'Hello ' . $name.'<br>';
                             $emailBody .= 'your username: ' . $email.'<br>';
                             $emailBody .= 'and password: ' . $Password.'<br>';
                    // set email data

                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'rahulitp',
                        'smtp_pass' => 'rahul123#',
                        'mailtype'  => 'html',
                        'charset'   => 'iso-8859-1'
                    );
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");


                    $this->email->set_mailtype("html");
                    $this->email->from('maheshwari.m.akbari@gmail.com', 'Web Form');
                    $this->email->to($email);
                    $this->email->subject('Web Form :: Change password');
                    $this->email->message($emailBody);
                    $data = array(
                        'token' => $token,
                        'updated_date' => date('Y-m-d H:i:s')
                    );
                     if ($this->email->send()) {
                                $this->session->set_flashdata('success_message', "Registration Successfull..!! and username and password sent user email successfully. ");
                                redirect('user', 'refresh');
                     }
                     else{
                            $this->session->set_flashdata('error_message', "Registration Successfull..!! But unsuccessfully email sent");
                                redirect('user', 'refresh');
                     }

                        } else {
                            $this->session->set_flashdata('error_message', "There is some problem in registration.");
                            redirect('index.php/user/adduser', 'refresh');
                        }
                    }
                    else {
                        $this->session->set_flashdata('error_message', "Email address already exist.");
                        redirect('index.php/user/adduser', 'refresh');
                    }
                }
                else{
                     $this->session->set_flashdata('error_message', "you can create only ".$plan[0]." user.");
                        redirect('index.php/user/adduser', 'refresh');
                }
                }
            } else {
                $this->data['session'] = '';
                $this->render('user/adduser_view');
            }
        } else {
            redirect('Home');
        }
    }

    public function DeleteUser($id = '') {
        if ($this->session->userdata('username')) {
            if ($id != '') {
                $sid = $this->url_decrypt($id);
                $formdata = $this->general_model->update_general_data(array('is_deleted' => 1), "user", array('id' => $sid));
                if($formdata){
                     $this->session->set_flashdata('success_message', "Deleted successfully!");
                redirect('user', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', "Something went wrong");
                redirect('user', 'refresh');
            }
        } else {
            redirect('Home');
        }
    }

    public function EditUser($id = '') {
        if ($this->session->userdata('username')) {
            if ($id != '') {
                $sid = $this->url_decrypt($id);
                $user = $this->general_model->check_exist_data("*", "user", array('id' => $sid, 'is_deleted' => 0), "row");
                // print_r($Vehicle);exit;
                $this->data['user'] = $user;
                $this->render('user/edituser_view');
            } else {
                $this->session->set_flashdata('error_message', "Something went wrong");
                redirect('index.php/user', 'refresh');
            }
        } else {
            redirect('Home');
        }
    }

    public function UpdateUser($id = '') {
        if ($this->session->userdata('username')) {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $sid = $this->url_decrypt($id);
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('surname', 'Surname', 'trim|required');
            $this->form_validation->set_rules('email', 'Emailid', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone_number', 'Phone', 'trim|required');
            $this->form_validation->set_rules('identi_num', 'Identification number', 'trim|required');
            if ($this->input->post()) {
//                print_r($_POST);exit;
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('index.php/user/EditUser' . $id, 'refresh');
                } else {
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');
                    $email = $this->input->post('email');
                    $phone_number = $this->input->post('phone_number');
                    $role = $this->input->post('role');
                    $identi_num = $this->input->post('identi_num');
                    $isactive = $this->input->post('isactive');
                    if ($isactive != '') {
                        $isactive = $isactive;
                    } else {
                        $isactive = 'off';
                    }

                    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != "") {
                        $chkext = $this->getExtention($_FILES['profile_picture']['name']);
                        $ext = strtolower($chkext);
                        $profile_picture = $this->getFileName($_FILES['profile_picture']['name']) . "_" . time() . "." . $ext;
                        $original = str_replace('\\', '/', FCPATH . "assets/uploads/users/profile/" . $profile_picture);
                        $profile_logo = str_replace('\\', '/', FCPATH . "assets/uploads/users/profile/thumb/" . $profile_picture);
                        $source = $_FILES['profile_picture']['tmp_name'];
                        /* create thumbnail image */
                        // $filename = @stripslashes($_FILES['profile_picture']['name']);

                        if ($ext == "jpg" || $ext == "jpeg") {
                            $uploadedfile = $_FILES['profile_picture']['tmp_name'];
                            $src = @imagecreatefromjpeg($uploadedfile);
                        } else if ($ext == "png") {
                            $uploadedfile = $_FILES['profile_picture']['tmp_name'];
                            $src = @imagecreatefrompng($uploadedfile);
                        } else {
                            $src = @imagecreatefromgif($uploadedfile);
                        }

                        @list($width, $height) = @getimagesize($uploadedfile);
                        $newwidth = 150;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = @imagecreatetruecolor($newwidth, $newheight);
                        @imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        // $filename = $uploaddir. $_FILES['profile_picture']['name'];
                        @imagejpeg($tmp, $profile_logo, 100);
                        move_uploaded_file($source, $original);
                        $profile_picture = $profile_picture;
                    } else {
                        $profile_picture = $this->input->post('old_image');
                    }

                    if (isset($_FILES['identi_card_img']) && $_FILES['identi_card_img']['name'] != "") {
                        $chkext = $this->getExtention($_FILES['identi_card_img']['name']);
                        $ext = strtolower($chkext);
                        $identi_card_img = $this->getFileName($_FILES['identi_card_img']['name']) . "_" . time() . "." . $ext;
                        $original = str_replace('\\', '/', FCPATH . "assets/uploads/users/identification/" . $identi_card_img);
                        $identi_logo = str_replace('\\', '/', FCPATH . "assets/uploads/users/identification/thumb/" . $identi_card_img);
                        $source = $_FILES['identi_card_img']['tmp_name'];

                        if ($ext == "jpg" || $ext == "jpeg") {
                            $uploadedfile = $_FILES['identi_card_img']['tmp_name'];
                            $src = @imagecreatefromjpeg($uploadedfile);
                        } else if ($ext == "png") {
                            $uploadedfile = $_FILES['identi_card_img']['tmp_name'];
                            $src = @imagecreatefrompng($uploadedfile);
                        } else {
                            $src = @imagecreatefromgif($uploadedfile);
                        }

                        @list($width, $height) = @getimagesize($uploadedfile);
                        $newwidth = 150;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = @imagecreatetruecolor($newwidth, $newheight);
                        @imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        @imagejpeg($tmp, $identi_logo, 100);
                        move_uploaded_file($source, $original);
                        $identi_card_img = $identi_card_img;
                    } else {
                        $identi_card_img = $this->input->post('I_image');
                    }

                    $data = array(
                        'name' => $name,
                        'surname' => $surname,
                        'email' => $email,
                        'phone_number' => $phone_number,
                        'profile_picture' => $profile_picture,
                        'identi_card_img' => $identi_card_img,
                        'role' => $role,
                        'identi_num' => $identi_num,
                        'isactive' => $isactive,
                        'is_deleted' => 0,
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_date' => date('Y-m-d H:i:s')
                    );
                    if ($this->general_model->update_general_data($data, "user", array('id' => $sid))) {
                        $this->session->set_flashdata('success_message', "Updated Successfully..!! ");
                        redirect('index.php/user', 'refresh');
                    } else {
                        $this->session->set_flashdata('error_message', "There is some problem in registration.");
                        redirect('index.php/user/adduser', 'refresh');
                    }
                }
            } else {
                $this->session->set_flashdata('error_message', "Something went wrong");
                redirect('index.php/user/EditUser' . $id, 'refresh');
            }
        } else {
            redirect('Home');
        }
    }
    public function Forgotpassword() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if ($this->input->post()) {
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error_message', "Emailid is require");
                redirect('Home/Forgotpassword_view', 'refresh');
            } else {
                if ($this->general_model->check_exist_data('email', 'user', array('email' => $this->input->post('email'), 'is_deleted' => 0))) {
                    $email_id = $this->input->post('email');
                    $token = $this->url_encrypt($email_id);
                    $ChangePassUrl = site_url("user/changepassword/" . $token);
//                    echo $ChangePassUrl;exit;
                    $emailBody = 'Please change your password : ' . $ChangePassUrl;
                    // set email data

                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'rahulitp',
                        'smtp_pass' => 'rahul123#',
                        'mailtype'  => 'html',
                        'charset'   => 'iso-8859-1'
                    );
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");


//                    $this->email->set_mailtype("html");
                    $this->email->from('johan.o@bonlifenam.com', 'Web Form');
                    $this->email->to($email_id);
                    $this->email->subject('Web Form :: Change password');
                    $this->email->message($emailBody);
                    $data = array(
                        'token' => $token,
                        'updated_date' => date('Y-m-d H:i:s')
                    );

//                   $this->email->send();exit;
                    if ($this->general_model->update_general_data($data, 'user', array('email' => $email_id, 'is_deleted' => 0))) {
                        if ($this->email->send()) {
                            $this->session->set_flashdata('success_message', "Email has been sent to your registered email, Please follow link to reset password.");
                            redirect('user/Forgotpassword', 'refresh');
                        } else {
                            $this->session->set_flashdata('success_message', "Email could not send, please contact administrator to verify email.");
                            redirect('user/Forgotpassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', "Forgot Password request failed.");
                        redirect('user/Forgotpassword', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', "Email id is not exists");
                    redirect('user/Forgotpassword', 'refresh');
                }
            }
        } else {
            $this->data['customer'] = '';
            $this->render('user/Forgotpassword_view');
        }
    }

    public function changepassword($token = '') {
//        echo $token;exit;
         $this->load->helper('form');
            $this->load->library('form_validation');
            // set validation rules
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required');
            if ($this->input->post()) {
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('message', "Password is require");
                    redirect('user/changepassword', 'refresh');
                } else {
                    // print_r($_POST);exit;
                    $new_pass = $this->input->post('password');
                    $token = $this->input->post('token');
                    $confirm_pass = $this->input->post('c_password');
                    if ($new_pass == $confirm_pass) {
                        $NewPassword = $this->url_encrypt($new_pass);
                        $data = array(
                            'password' => $NewPassword,
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        // echo "<pre>"; print_r($data);exit;
                        if ($this->general_model->update_general_data($data, 'user', array('token' => $token, 'is_deleted' => 0))) {
                            $this->session->set_flashdata('success_message', "Password changed successfully.");
                            unset($_SESSION['admin_id']);
                            redirect('Home', 'refresh');
                        } else {
                            $this->session->set_flashdata('error_message', "There is some problem in change password.");
                            redirect('user/changepassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', "Password and confirm password do not match");
                        redirect('user/changepassword', 'refresh');
                    }
                }
                //$this->data['page_title'] = 'Mr Parker - Login';
                //$this->render('admin/login_view','admin_main');
            }
            else{
                $this->data['token']= $token;
            $this->render('user/changepassword_view');
            }
    }

}
