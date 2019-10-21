<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once '/home/dekhli007/public_html/webform/assets/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Front extends MY_Controller {

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
        $this->data['front'] = 'front';
        $this->render('Front/Front_view', 'front');
    }

    public function Dashboard() {

        if ($this->session->userdata('username')) {
            $userid = $_SESSION['user_id'];
            $customer_id = $_SESSION['customer_id'];
            $this->data['admin'] = '';
            $formdata = $this->general_model->get_all_general_data("*", "link_user_form", array('is_deleted' => 0, 'user_id' => $userid), 'result_array', '', '', '');
//      print_r($User_val);exit;
            $this->data['formdata'] = count($formdata);
            $last_formdata = $this->general_model->get_all_general_data("*", "link_user_form", array('is_deleted' => 0, 'user_id' => $userid), 'result_array', '`id` DESC', 10, '');
//      print_r($User_val);exit;
            $this->data['last_formdata'] = count($last_formdata);
            $this->data['front'] = 'front';
            $this->render('Front/Dashboard_view', 'front');
        } else {
            redirect('Front');
        }
    }

    public function Login() {
        $this->data['front'] = 'front';
        $this->render('Front/login_view', 'front');
    }

    public function Logout() {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('customer_id');
        $this->session->unset_userdata('profile_picture');
        $this->session->unset_userdata('logged_in');
        redirect('Front', 'refresh');
    }

    public function Signin() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Emailid', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        if ($this->input->post()) {
//                print_r($_POST);exit;
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error_message', "Please fill required fields.");
                $this->session->set_userdata('USER_DETAIL', $_POST);
                redirect('Front', 'refresh');
            } else {
                $Password = $this->input->post('password');
                $NewPassword = $this->url_encrypt($Password);
                $get_data = $this->general_model->check_exist_data('*', 'user', array('email' => $this->input->post('email'), 'password' => $NewPassword, 'is_deleted' => 0));
//                  print_r($get_data);exit;
                if ($get_data) {
                    $newdata = array(
                        'username' => $get_data->name . ' ' . $get_data->surname,
                        'email' => $get_data->email,
                        'user_id' => $get_data->id,
                        'customer_id' => $get_data->customer_id,
                        'profile_picture' => $get_data->profile_picture,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($newdata);
                    redirect('Front/Dashboard', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', "username and password incorrect!");
                    redirect('Front', 'refresh');
                }
            }
        }
    }

    public function Form() {
        $userid = $_SESSION['user_id'];
        if ($this->session->userdata('username')) {
            $formdata = $this->general_model->get_all_general_data("*", "link_user_form", array('is_deleted' => 0, 'user_id' => $userid), 'result_array', '', '', '');
//      print_r($User_val);exit;
            $this->data['formdata'] = $formdata;
            $this->render('Front/Formlist_view', 'front');
        } else {
            redirect('Front');
        }
    }

    public function Fillform() {
        $userid = $_SESSION['user_id'];
        if ($this->session->userdata('username')) {
            $formdata = $this->general_model->get_all_general_data("*", "user_fill_form", array('is_deleted' => 0, 'user_id' => $userid), 'result_array', '`id` DESC', '', 'from_id,form_list_id');
//      print_r($User_val);exit;
            $this->data['formdata'] = $formdata;
            $this->render('Front/fillFormlist_view', 'front');
        } else {
            redirect('Front');
        }
    }

    public function FillViewFormDetail($id = '', $formnum = 1) {
        if ($this->session->userdata('username')) {
            if ($id != '') {
                $userid = $_SESSION['user_id'];
                $customer_id = $_SESSION['customer_id'];
//            echo $sid;exit;
//                $Formdata = $this->general_model->get_all_general_data("*", "user_fill_form", array('from_id' => $id, 'page_num' => $page, 'is_deleted' => 0), "result_array");
//                // print_r($Vehicle);exit;
//                $this->data['Formdata'] = $Formdata;
                $Formdata = $this->general_model->edit_fill_form("*", "form_view", array('uff.user_id' => $userid, 'uff.customer_id' => $customer_id, 'uff.form_list_id' => $formnum, 'uff.from_id' => $id, 'uff.is_deleted' => 0), "result_array");
//                    echo '<pre>';
//                 print_r($Formdata);exit;
                $this->data['Formdata'] = $Formdata;
                $lastpage = $this->general_model->get_all_general_data("page_num", "user_fill_form", array('is_deleted' => 0, 'from_id' => $id), 'result_array', '`id` DESC', '', '');

                $this->data['lastpage'] = $lastpage[0]['page_num'];
//                print_r($lastpage[0]['page_num']); exit;
                $this->data['form_id'] = $id;
                $this->render('Front/fillformDetail_view', 'front');
            } else {
                $this->session->set_flashdata('error_message', "Something went wrong");
                redirect('Front/Fillform', 'refresh');
            }
        } else {
            redirect('Front');
        }
    }

    public function EditFormDetail($id = '', $formnum = 1) {
//        echo $formnum;exit;
        if ($this->session->userdata('username')) {
            if ($id != '') {
                $userid = $_SESSION['user_id'];
                $customer_id = $_SESSION['customer_id'];
                if ($this->input->post()) {
                    $curent_page = 1;
                    foreach ($_FILES as $f_key => $f_value) {
                        
                    }
                    foreach ($_POST as $key => $value) {
//                        echo '<pre>';
//                        print_r($_POST);exit;
                        if ($key == 'form_name') {
                            $form_name = $value;
                        } elseif ($key == 'submit') {
                            $this->session->set_flashdata('success_message', "Form updated sucessfully");
                            redirect('Front/Fillform');
                        } elseif (strpos($key, 'file') !== FALSE) {
                            $f_key = $key;
                            if (isset($_FILES[$f_key]) && $_FILES[$f_key]['name'] != "") {
                                $chkext = $this->getExtention($_FILES[$f_key]['name']);
                                $ext = strtolower($chkext);
                                $profile_picture = $this->getFileName($_FILES[$f_key]['name']) . "_" . time() . "." . $ext;
                                $original = str_replace('\\', '/', FCPATH . "/assets/uploads/form_image/" . $profile_picture);
                                $profile_logo = str_replace('\\', '/', FCPATH . "/assets/uploads/form_image/thumb/" . $profile_picture);
                                $source = $_FILES[$f_key]['tmp_name'];
                                /* create thumbnail image */
                                // $filename = @stripslashes($_FILES['profile_picture']['name']);

                                if ($ext == "jpg" || $ext == "jpeg") {
                                    $uploadedfile = $_FILES[$f_key]['tmp_name'];
                                    $src = @imagecreatefromjpeg($uploadedfile);
                                } else if ($ext == "png") {
                                    $uploadedfile = $_FILES[$f_key]['tmp_name'];
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
                                $formId = $this->general_model->check_exist_data('id,meta_value', 'user_fill_form', array('user_id' => $userid, 'meta_label' => $f_key, 'customer_id' => $customer_id, 'from_id' => $id, 'is_deleted' => 0, 'form_list_id' => $formnum));
                                $file = $_SERVER['DOCUMENT_ROOT'] . '/webform/assets/uploads/form_image/' . $formId->meta_value;
                                unlink($file);
                                if ($formId) {
                                    $data = array(
                                        'customer_id' => $customer_id,
                                        'user_id' => $userid,
                                        'from_id' => $id,
                                        'form_name' => $_POST['form_name'],
                                        'meta_label' => $f_key,
                                        'meta_value' => $profile_picture,
                                        'form_list_id' => $formnum,
                                        'is_deleted' => 0,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'updated_date' => date('Y-m-d H:i:s')
                                    );

                                    $response = $this->general_model->update_general_data($data, "user_fill_form", array('id' => $formId->id, 'form_list_id' => $formnum));
                                } else {
                                    $data = array(
                                        'customer_id' => $customer_id,
                                        'user_id' => $userid,
                                        'from_id' => $id,
                                        'form_name' => $_POST['form_name'],
                                        'meta_label' => $f_key,
                                        'meta_value' => $profile_picture,
                                        'page_num' => $curent_page,
                                        'form_list_id' => 1,
                                        'is_deleted' => 0,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'updated_date' => date('Y-m-d H:i:s')
                                    );

                                    $response = $this->general_model->create_general_data($data, "user_fill_form");
                                }
                            }
                        } else {
                            if (strpos($key, 'signature') !== false || $key != '') {
                                if (strpos($value, 'base64') !== false) {
                                    $img = str_replace('data:image/png;base64,', '', $value);
                                    $img = str_replace(' ', '+', $img);
                                    $data_image = base64_decode($img);
                                    $value = 'SIGN_' . $key . '_' . time() . '.png';
                                    file_put_contents("assets/uploads/signature/" . $value, $data_image);
                                } else {
                                    $value = $value;
                                }
                            }
                            $data = array(
                                'customer_id' => $customer_id,
                                'user_id' => $userid,
                                'from_id' => $id,
                                'form_name' => $form_name,
                                'meta_label' => $key,
                                'meta_value' => $value,
//                                'page_num' => $curent_page,
                                'form_list_id' => $formnum,
                                'is_deleted' => 0,
                                'created_date' => date('Y-m-d H:i:s'),
                                'updated_date' => date('Y-m-d H:i:s')
                            );
                            if ($key == 'breaktag') {
                                $curent_page = $value;
                            }
                            $formId = $this->general_model->check_exist_data('id', 'user_fill_form', array('user_id' => $userid, 'meta_label' => $key, 'customer_id' => $customer_id, 'from_id' => $id, 'is_deleted' => 0, 'form_list_id' => $formnum));
                            if ($formId->id) {
                                $response = $this->general_model->update_general_data($data, "user_fill_form", array('id' => $formId->id, 'form_list_id' => $formnum));
                            } else {
                                $response = $this->general_model->create_general_data($data, 'user_fill_form');
                            }
                        }
                    }
                } else {
//            echo $sid;exit;
                    $Formdata = $this->general_model->edit_fill_form("*", "form_view", array('uff.user_id' => $userid, 'uff.customer_id' => $customer_id, 'uff.form_list_id' => $formnum, 'uff.from_id' => $id, 'uff.is_deleted' => 0), "result_array");
//                    echo '<pre>';
//                 print_r($Formdata);exit;
                    $this->data['Formdata'] = $Formdata;
                    $lastpage = $this->general_model->get_all_general_data("page_num", "form_view", array('is_delete' => 0, 'from_id' => $id), 'result_array', '`id` DESC', '', '');

                    $this->data['lastpage'] = $lastpage[0]['page_num'];
//                print_r($lastpage[0]['page_num']); exit;
                    $this->data['form_id'] = $id;
                    $this->render('Front/Edit_formDetail_view', 'front');
                }
            } else {
                $this->session->set_flashdata('error_message', "Something went wrong");
                redirect('Front/Fillform', 'refresh');
            }
        } else {
            redirect('Front');
        }
    }

    public function ViewFormDetail($id = '', $page = '') {
        if ($this->session->userdata('username')) {
            if ($id != '') {
                $userid = $_SESSION['user_id'];
                $customer_id = $_SESSION['customer_id'];
                if ($this->input->post()) {


//                    print_r($_FILES);
                    print_r($_POST);
                    $curent_page = 1;
                    foreach ($_POST as $key => $value) {
                        if ($key == 'form_name') {
                            $form_name = $value;
                        } elseif ($key == 'submit1') {
                            $this->session->set_flashdata('success_message', "Form submited sucessfully");
                            $pdfname = $_POST['pdffile'];
                            $_SESSION['pdffilename'] = $pdfname;
//                            redirect('Front/Fillform');
                            redirect('Front/google_drive');
                        } 
                        elseif (strpos($key, 'file') !== FALSE) {
                            $f_key = $key;
                            if (isset($_FILES[$f_key]) && $_FILES[$f_key]['name'] != "") {
                                $chkext = $this->getExtention($_FILES[$f_key]['name']);
                                $ext = strtolower($chkext);
                                $profile_picture = $this->getFileName($_FILES[$f_key]['name']) . "_" . time() . "." . $ext;
                                $original = str_replace('\\', '/', FCPATH . "/assets/uploads/form_image/" . $profile_picture);
                                $profile_logo = str_replace('\\', '/', FCPATH . "/assets/uploads/form_image/thumb/" . $profile_picture);
                                $source = $_FILES[$f_key]['tmp_name'];
                                /* create thumbnail image */
                                // $filename = @stripslashes($_FILES['profile_picture']['name']);

                                if ($ext == "jpg" || $ext == "jpeg") {
                                    $uploadedfile = $_FILES[$f_key]['tmp_name'];
                                    $src = @imagecreatefromjpeg($uploadedfile);
                                } else if ($ext == "png") {
                                    $uploadedfile = $_FILES[$f_key]['tmp_name'];
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
                                $formId = $this->general_model->get_all_general_data('id,form_list_id', 'user_fill_form', array('user_id' => $userid, 'meta_label' => $f_key, 'customer_id' => $customer_id, 'from_id' => $id, 'is_deleted' => 0), 'result_array', '`id` DESC', '', '');
//                            print_r($formId);exit;
                                if ($formId) {
                                    $formliseid = $formId[0]['form_list_id'];
                                    $data = array(
                                        'customer_id' => $customer_id,
                                        'user_id' => $userid,
                                        'from_id' => $id,
                                        'form_name' => $_POST['form_name'],
                                        'meta_label' => $f_key,
                                        'meta_value' => $profile_picture,
                                        'page_num' => $curent_page,
                                        'form_list_id' => $formliseid + 1,
                                        'is_deleted' => 0,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'updated_date' => date('Y-m-d H:i:s')
                                    );

                                    $response = $this->general_model->create_general_data($data, "user_fill_form");
                                } else {
                                    $data = array(
                                        'customer_id' => $customer_id,
                                        'user_id' => $userid,
                                        'from_id' => $id,
                                        'form_name' => $_POST['form_name'],
                                        'meta_label' => $f_key,
                                        'meta_value' => $profile_picture,
                                        'page_num' => $curent_page,
                                        'form_list_id' => 1,
                                        'is_deleted' => 0,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'updated_date' => date('Y-m-d H:i:s')
                                    );

                                    $response = $this->general_model->create_general_data($data, "user_fill_form");
                                }
                            } else {
                                $formId = $this->general_model->get_all_general_data('id,form_list_id', 'user_fill_form', array('user_id' => $userid, 'meta_label' => $f_key, 'customer_id' => $customer_id, 'from_id' => $id, 'is_deleted' => 0), 'result_array', '`id` DESC', '', '');
//                            print_r($formId);exit;
                                if ($formId) {
                                    $formliseid = $formId[0]['form_list_id'];
                                    $data = array(
                                        'customer_id' => $customer_id,
                                        'user_id' => $userid,
                                        'from_id' => $id,
                                        'form_name' => $_POST['form_name'],
                                        'meta_label' => $f_key,
                                        'meta_value' => '',
                                        'page_num' => $curent_page,
                                        'form_list_id' => $formliseid + 1,
                                        'is_deleted' => 0,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'updated_date' => date('Y-m-d H:i:s')
                                    );

                                    $response = $this->general_model->create_general_data($data, "user_fill_form");
                                } else {
                                    $data = array(
                                        'customer_id' => $customer_id,
                                        'user_id' => $userid,
                                        'from_id' => $id,
                                        'form_name' => $_POST['form_name'],
                                        'meta_label' => $f_key,
                                        'meta_value' => '',
                                        'page_num' => $curent_page,
                                        'form_list_id' => 1,
                                        'is_deleted' => 0,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'updated_date' => date('Y-m-d H:i:s')
                                    );

                                    $response = $this->general_model->create_general_data($data, "user_fill_form");
                                }
                            }
                        } else {

                            if (strpos($key, 'signature') !== false && $value != '') {
                                $img = str_replace('data:image/png;base64,', '', $value);
                                $img = str_replace(' ', '+', $img);
                                $data_image = base64_decode($img);
                                $value = 'SIGN_' . $key . '_' . time() . '.png';
                                file_put_contents("assets/uploads/signature/" . $value, $data_image);
                            }
                            if (strpos($key, 'checkbox-group') !== FALSE) {
//                                print_r($_SESSION);
//                                echo 'frgfd';exit;
                               $key_explode = explode("##",$key);
                               $key = $key_explode[0];
                               if(strpos($key_explode[1], 'Email') !== FALSE && $value ==1 ){
                                $emailBody = 'from pdf :';
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

                                $file_path = str_replace('\\', '/', FCPATH . 'Formpdf/' . $_POST['pdffile']);
                                $this->email->set_mailtype("html");
                                $this->email->from('johan.o@bonlifenam.com', 'Web Form');
                                $this->email->to($_SESSION['email']);
                                $this->email->subject('Web Form :: Change password');
                                $this->email->attach($file_path);
                                $this->email->message($emailBody);
                                $this->email->send();   
                               }
                           }

                            $formId = $this->general_model->get_all_general_data('id,form_list_id', 'user_fill_form', array('user_id' => $userid, 'meta_label' => $key, 'customer_id' => $customer_id, 'from_id' => $id, 'is_deleted' => 0), 'result_array', '`id` DESC', '', '');
//                            print_r($formId);

                            if ($formId) {
                                $formliseid = $formId[0]['form_list_id'];
                                $data = array(
                                    'customer_id' => $customer_id,
                                    'user_id' => $userid,
                                    'from_id' => $id,
                                    'form_name' => $form_name,
                                    'meta_label' => $key,
                                    'meta_value' => $value,
                                    'page_num' => $curent_page,
                                    'form_list_id' => $formliseid + 1,
                                    'is_deleted' => 0,
                                    'created_date' => date('Y-m-d H:i:s'),
                                    'updated_date' => date('Y-m-d H:i:s')
                                );

                                $response = $this->general_model->create_general_data($data, "user_fill_form");
                            } else {
                                $data = array(
                                    'customer_id' => $customer_id,
                                    'user_id' => $userid,
                                    'from_id' => $id,
                                    'form_name' => $form_name,
                                    'meta_label' => $key,
                                    'meta_value' => $value,
                                    'page_num' => $curent_page,
                                    'form_list_id' => 1,
                                    'is_deleted' => 0,
                                    'created_date' => date('Y-m-d H:i:s'),
                                    'updated_date' => date('Y-m-d H:i:s')
                                );

                                $response = $this->general_model->create_general_data($data, 'user_fill_form');
                            }
                            if (strpos($key, 'breaktag') !== false) {
                                $curent_page = $value;
                            }
                        }
                    }
                } else {
                    $Formdata = $this->general_model->get_all_general_data("*", "form_view", array('from_id' => $id, 'is_delete' => 0), "result_array");
                    $this->data['Formdata'] = $Formdata;
                    $lastpage = $this->general_model->get_all_general_data("page_num", "form_view", array('is_delete' => 0, 'from_id' => $id), 'result_array', '`id` DESC', '', '');

                    $this->data['lastpage'] = $lastpage[0]['page_num'];
                    $this->data['page'] = $page;
                    $this->data['form_id'] = $id;
                    $this->render('Front/formDetail_view', 'front');
                }
            } else {
                $this->session->set_flashdata('error_message', "Something went wrong");
                redirect('Front/Form', 'refresh');
            }
        } else {
            redirect('Front');
        }
    }

    public function store_pdf() {
//        print_r($_POST);
        $html = '<img src="' . $_POST["imgData"] . '">';
        $pdffilename = 'form_' . time() . '.pdf';
        $pdfFilePath = str_replace('\\', '/', FCPATH . 'Formpdf/' . $pdffilename);
        //load mPDF library
//        echo $html;exit;
        $this->load->library('m_pdf');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, 'F');
        $data = array();
        $data['pdf_name'] = $pdffilename;
        echo json_encode($data);
        exit;
    }

    public function google_drive() {
        $url_array = explode('?', 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $url = $url_array[0];

        require_once 'google-api-php-client/src/Google_Client.php';
        require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
        $client = new Google_Client();
        $client->setClientId('485972277198-5s3eq2hb9oaujgtpgph4k0o3hne99fr2.apps.googleusercontent.com');
        $client->setClientSecret('Z_ZeTVgAFBvJVHIWyToUeJya');
        $client->setRedirectUri($url);
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        print_r($_SESSION);
        if (isset($_GET['code'])) {
            echo 'code';
            $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
            header('location:' . $url);
            exit;
        } elseif (!isset($_SESSION['accessToken'])) {
            $client->authenticate();
        }
        else{
//if (!empty($_POST)) {
        $client->setAccessToken($_SESSION['accessToken']);
        $service = new Google_DriveService($client);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file = new Google_DriveFile();
        echo '$file : ' . $file;
        $file_name = $_SESSION['pdffilename'];
        $file_path = str_replace('\\', '/', FCPATH . 'Formpdf/' . $file_name);
        $mime_type = finfo_file($finfo, $file_path);
        echo '$mime_type : ' . $mime_type;
        $file->setTitle($file_name);
        $file->setDescription('This is a ' . $mime_type . ' document');
        $file->setMimeType($mime_type);
        $service->files->insert(
                $file, array(
            'data' => file_get_contents($file_path),
            'mimeType' => $mime_type
                )
        );
        finfo_close($finfo);
        redirect('Front/Fillform');
        }
//    header('location:'.$url);exit;
}
//    }

}
