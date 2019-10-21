<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Shop extends Admin_Controller {
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
          $role_id =  $admin_data[0]['id'];

          if ($this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 1, 'is_deleted' => 0), 'result_array')) {
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 1, 'is_deleted' => 0), 'result_array');
          }else{
            $user_access_data = $this->general_model->get_all_general_data("*", "user_access", array('role_id' => $role_id, 'module_id' => 3, 'is_deleted' => 0), 'result_array');
          }
          $this->data['user_access_data'] = $user_access_data;

          $shop_list = $this->general_model->get_shops_data('*','shop', array());
          foreach ($shop_list as $key => $shop) {
            $var =  $this->url_encrypt($shop->id);
            $shop_list[$key]->encrypt_id = $var;
          }
          // echo '<pre>';print_r($shop_list);exit;
          foreach ($shop_list as $key => $value) {
            if($value->user_id != 0){
                $user_list = $this->general_model->get_user_by_shop( 'user', array('id' => $value->user_id));
                $shop_list[$key]->user = $user_list;
              }
            }
            $this->data['shop_list'] = $shop_list;
            $this->render('shop_view');
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function add_shop() {
      $admin_id = $this->session->userdata('admin_id');
      $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
      $this->data['admin_data'] = $admin_data;

      $city = $this->general_model->get_all_state_data('*', 'city', array('is_deleted' => 0));
      $this->data['city'] = $city;

      $state = $this->general_model->get_all_state_data('*', 'state', array('is_deleted' => 0));
      $this->data['state'] = $state;

      $this->render('add_shop_view');
    }

    public function insert_shop() {

        if ($this->session->userdata('admin_id')) {
          $admin_id = $this->session->userdata('admin_id');
          $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
          $this->data['admin_data'] = $admin_data;
          $role_id =  $admin_data[0]['id'];
          $user_promotion =  $admin_data[0]['user_promotion'];

            if ($this->input->post()) {
                $this->load->helper('form','url');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('shop_name', 'Shop name', 'required');
                $this->form_validation->set_rules('mobile_no', 'Mobile', 'required');
                $this->form_validation->set_rules('shop_email', 'Email', 'required');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('shop/add_shop', 'refresh');
                } else {
                      $name = $this->input->post('shop_name');
                      $mobile = $this->input->post('mobile_no');
                      $email = $this->input->post('shop_email');
                      $address_1 = $this->input->post('address_1');
                      $address_2 = $this->input->post('address_2');
                      $city = $this->input->post('city');
                      if(isset($city)){
                        $city_chk = implode(',', $city);
                      }else{
                        $city_chk = "";
                      }
                      $state = $this->input->post('state');
                      $zipcode = $this->input->post('zipcode');
                      $discription = $this->input->post('discription');

                      $data = array(
                          'shop_name' => $name,
                          'mobile' => $mobile,
                          'shop_email' => $email,
                          'addline1' => $address_1,
                          'addline2' => $address_2,
                          'city' => $city_chk,
                          'state' => $state,
                          'zipcode' => $zipcode,
                          'description' => $discription,
                          'varification' => 1,
                          'created_at' => date('Y-m-d H:i:s'),
                          'updated_at' => date('Y-m-d H:i:s'),
                          'is_active' => 1,
                          'is_deleted' => 0,
                      );

                      $inserted_id = $this->general_model->insert_user($data, 'shop');
                      if ($inserted_id) {
                        $emailsend = $this->general_model->sendConfirmationEmail_add_shop($data);
                        if($emailsend){
                          $this->session->set_flashdata('success_message', "Shop added successfully");
                          redirect('shop', 'refresh');
  				              }else{
  					               $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                           redirect('shop', 'refresh');
  				                }
                      }
                }
            } else {
              $this->render('User/add_user');
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
            'is_active' => 1,
            'is_deleted' => 0
          );
          $update_id = $this->general_model->active_shop($data, 'shop', array('id' => $sid));
          $worker_update_id = $this->general_model->active_shop($data, 'workers', array('shop_id' => $sid));
          $service_update_id = $this->general_model->active_shop($data, 'services', array('shop_id' => $sid));

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
            'is_active' => 0,
            'is_deleted' => 1
          );
          $update_id = $this->general_model->inactive_shop($data, 'shop', array('id' => $sid));
          $worker_update_id = $this->general_model->inactive_shop($data, 'workers', array('shop_id' => $sid));
          $service_update_id = $this->general_model->inactive_shop($data, 'services', array('shop_id' => $sid));

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

    public function shop_info($id1) {
      if ($this->session->userdata('admin_id')) {
        $admin_id = $this->session->userdata('admin_id');
        $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
        $this->data['admin_data'] = $admin_data;

        $id1 = $this->url_decrypt($id1);
        if ($id1 != '') {
              $shop_data = $this->general_model->get_edit_shop_data('shop', array('shop.id' => $id1));
              
              $city_data = explode(',', $shop_data->city);
              $city_arr = [];
              foreach ($city_data as $key => $city) {
                $all_city_data = $this->general_model->get_allshop_images('name', 'city', array('id' => $city));
                $city_arr[$key] = $all_city_data[0]->name;
              }
              $city_name = implode(',', $city_arr);
              $shop_data->all_city_name = $city_name;

              $this->data['shop_data'] = $shop_data;
              // echo '<pre>';print_r($shop_data);exit;
              $business_hours = $this->general_model->get_business_hours_data('*', 'business_hours', array('shop_id' => $id1, 'is_deleted' => 0));
              $days = array();
              $main_hours = [];
              for ($i = 0; $i < 7; $i++) {
                $days[$i] = jddayofweek($i,1);
                foreach ($business_hours as $key => $value) {
                  if($days[$i] == $value->hours_day){
                      $main_hours[] = $value;
                  }
                }
              }
              $this->data['business_hours'] = $main_hours;
              $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 1));
              $this->data['vacation_module_data'] = $vacation_module_data;

              // echo '<pre>';print_r($business_hours);exit;
              $this->data['full_css_file'] = array(
                  "https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"
              );

              $this->data['full_js_file'] = array(
                  "https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js",
                  "https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"
              );

            $this->render('shop_info_view');
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('shop', 'refresh');
          }
      } else {
          redirect('Login', 'refresh');
      }
  }
  public function edit_shop($id1) {
    if ($this->session->userdata('admin_id')) {
      $admin_id = $this->session->userdata('admin_id');
      $admin_data = $this->general_model->get_all_general_data("*", "admin", array('is_deleted' => 0, 'id' => $admin_id), 'result_array');
      $this->data['admin_data'] = $admin_data;

      $id1 = $this->url_decrypt($id1);
        if ($id1 != '') {
            $shop_data = $this->general_model->get_edit_shop_data('shop', array('shop.id' => $id1));
            $var =  $this->url_encrypt($shop_data->id);
            $shop_data->encrypt_id = $var;
            $this->data['shop_data'] = $shop_data;

            $city = $this->general_model->get_all_state_data('*', 'city', array('is_deleted' => 0));
            $this->data['city'] = $city;

            $state = $this->general_model->get_all_state_data('*', 'state', array('is_deleted' => 0));
            $this->data['state'] = $state;

            $business_hours = $this->general_model->get_business_hours_data('*', 'business_hours', array('shop_id' => $id1, 'is_deleted' => 0));
            $days = array();
            $main_hours = [];
            for ($i = 0; $i < 7; $i++) {
              $days[$i] = jddayofweek($i,1);
              foreach ($business_hours as $key => $value) {
                if($days[$i] == $value->hours_day){
                    $main_hours[] = $value;
                }
              }
            }
            $this->data['business_hours'] = $main_hours;

            $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 1));
            $this->data['vacation_module_data'] = $vacation_module_data;

            $this->data['js_file'] = array(
                "../front/js/bootstrap-datetimepicker.min.js",
                "../front/js/jquery.timepicker.js",
                "../front/js/datepair.js",
                "../front/js/jquery.datepair.js",
                "../admin/assets/build/js/admin_shop.js"
            );
            $this->data['css_file'] = array(
                "../front/css/bootstrap-datetimepicker.min.css",
                "../front/css/jquery.timepicker.css"
            );

            $this->render('edit_shop_view');
        } else {
            $this->session->set_flashdata('error_message', "Something wents wrong!");
            redirect('shop', 'refresh');
        }
    } else {
        redirect('Login', 'refresh');
    }
  }
  public function update_shop($id) {
    $id = $this->url_decrypt($id);

    if (!$this->session->userdata('admin_id')) {
      $this->session->set_flashdata('error_message', "Something wents wrong!");
      redirect('shop', 'refresh');
    }
    else{
          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('shop_name', 'Shop Name', 'required');
              $this->form_validation->set_rules('shop_email', 'Shop Email', 'required|valid_email');
              if ($this->form_validation->run() == false) {
                  $this->session->set_flashdata('error_message', "Please fill required fields.");
                  $this->session->set_userdata('USER_DETAIL', $_POST);
                  redirect('shop/edit_shop/'.$id, 'refresh');
              } else {
                $map_api = $this->config->item('map_api');
                $shop_id = $this->input->post('shop_id');
                $shop_name = $this->input->post('shop_name');
                $shop_email = $this->input->post('shop_email');
                $mobile_no = $this->input->post('mobile_no');
                $address_1 = $this->input->post('address_1');
                $address_2 = $this->input->post('address_2');
                $city = $this->input->post('city');
                if(isset($city)){
                  $city_chk = implode(',', $city);
                }else{
                  $city_chk = "";
                }
                $state = $this->input->post('state');
                $zipcode = $this->input->post('zipcode');
                $discription = $this->input->post('discription');
                $cancel_policy = $this->input->post('radiog_dark');
                $all_day = $this->input->post('all_day');
                $start_time = $this->input->post('start_time');
                $end_time = $this->input->post('end_time');
                $chk_vacation_module = $this->input->post('chk_vacation_module');

                if($chk_vacation_module != ''){
                  if($start_time == '' && $end_time == ''){
                    $b_f_start = '00:00:00';
                    $b_t_start = '23:59:00';
                  }else{
                    $b_f_start = date("H:i:s", strtotime($start_time));
                    $b_t_start = date("H:i:s", strtotime($end_time));
                  }
                  if($all_day != ''){
                    $main_all_day = '1';
                  }else{
                    $main_all_day = '0';
                  }


                  $v_md_start_date = $this->input->post('start_date_v_module');
                  $v_md_end_date = $this->input->post('end_date_v_module');
                  $parts1 = explode('-', $v_md_start_date);
                  $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
                  $vacation_md_start_date = date("Y-m-d", strtotime($s_date));
                  $parts2 = explode('-', $v_md_end_date);
                  $e_date = $parts2[1] . '-' . $parts2[0] . '-' . $parts2[2];
                  $vacation_md_end_date = date("Y-m-d", strtotime($e_date));

                  $main_start_date = $vacation_md_start_date.' '.$b_f_start;
                  $main_end_date = $vacation_md_end_date.' '.$b_t_start;

                  $data_vacation_module = array(
                      'shop_id' => $shop_id,
                      'start_date' => $main_start_date,
                      'end_date' => $main_end_date,
                      'all_day' => $main_all_day,
                      'flag' => 1,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_deleted' => 0
                  );
                  $vacation_id = $this->general_model->insert_user($data_vacation_module, 'vacation_module');
                }

                $image = $this->upload_shop_Image($_FILES['imgupload1']['name'], 'imgupload1', 'shop', $shop_id);

                $state_name = $this->general_model->get_all_state_data('name', 'state', array('id' => $state));
                $state_name = $state_name[0]->name;

                $Address = $address_1.$address_2.'+'.$city.'+'.$state_name.'+'.$zipcode;
                $formattedAddr = str_replace(' ','+',$Address);
                // echo $formattedAddr;exit;
                $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key='.$map_api);

                $json = json_decode($json);
                // echo "<pre>"; print_r($json);exit;

                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                // echo $lat.','.$long;exit;
                $latitude = !empty($lat) ? $lat : "";
                $longitude = !empty($long) ? $long : "";
                // $latitude = '';
                // $longitude = '';
                // $check_city = $this->general_model->check_exist_data('*', 'city', array('name' => $city, 'is_deleted' => 0));
                //
                // $data_city = array(
                //     'name' => $city,
                //     'created_at' => date('Y-m-d H:i:s'),
                //     'updated_at' => date('Y-m-d H:i:s'),
                //     'is_active' => 1,
                //     'is_deleted' => 0
                // );
                // if(empty($check_city)){
                //     $inserted_city_id = $this->general_model->insert_user($data_city, 'city');
                //     $city_id = $inserted_city_id;
                // }else{
                //     $city_id = $check_city->id;
                // }

                $data = array(
                    'shop_name' => $shop_name,
                    // 'user_id' => $uid,
                    'shop_email' => $shop_email,
                    'mobile' => $mobile_no,
                    // 'title' => $shop_title,
                    'addline1' => $address_1,
                    'addline2' => $address_2,
                    'city' => $city_chk,
                    'state' => $state,
                    'zipcode' => $zipcode,
                    'description' => $discription,
                    'image' => $image,
                    'cancel_policy' => $cancel_policy,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );
                // echo '<pre>';print_r($data);exit;
                $updated_id = $this->general_model->update_shop_data($data, 'shop', array('id' => $shop_id));

                // echo '<pre>';print_r($updated_id);exit;
                $shop_id = $this->input->post('shop_id');
                  if($shop_id){
                    $service_time = $this->input->post('service_time[]');
                    foreach ($service_time as $key => $value) {
                      $business_hours_day = $value;
                      $business_hours_from_time = $this->input->post('Monday1');
                      $business_hours_to_time = $this->input->post('Monday2');

                      $f_start = date("H:i", strtotime($business_hours_from_time));
                      $t_start = date("H:i", strtotime($business_hours_to_time));

                        $data1 = array(
                            'shop_id' => $shop_id,
                            'hours_day' => $business_hours_day,
                            'from_time' => $f_start,
                            'to_time' => $t_start,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'is_active' => 1,
                            'is_deleted' => 0,
                        );
                        if($business_hours_from_time != '' && $business_hours_to_time != ''){
                            $inserted_time = $this->general_model->update_shop_business_hours_availability_time($data1, 'business_hours');
                        }
                    }
                    $this->session->set_flashdata('success_message', "Shop updated successfully");
                    redirect('shop', 'refresh');
                  }else{
                     $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                     redirect('shop', 'refresh');
                    }
              }
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('shop', 'refresh');
          }
      }
  }
  public function upload_shop_Image($path, $imagename, $upload_path, $shop_id){
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
    $config['upload_path']          = FCPATH.'../assets/uploads/'.$upload_path.'/';
    $config['file_name'] 						= $temp_name;
    $config['allowed_types']        = 'gif|jpg|jpeg|png';
    // $config['max_size']             = 2000;
    $this->upload->initialize($config);

    if($this->upload->do_upload($imagename))
    {
      $this->db->select('image');
      $this->db->from('shop');
      $this->db->where('id',$shop_id);
      $count = $this->db->get()->row();
      $img = $count->image;
      $path = '../assets/uploads/'.$upload_path.'/'.$img;
      unlink($path);
      return $temp_name;
    }else{
      $this->db->select('image');
      $this->db->from('shop');
      $this->db->where('id',$shop_id);
      $count = $this->db->get()->row();
      return $count->image;
    }
  }

   public function delete_business_hours_time() {
     $id = $this->input->post('id');
     $shop_id = $this->input->post('shop_id');
     $hour_day = $this->input->post('hour_day');

     $this->db->where('id', $id);
     $hours_id = $this->db->delete('business_hours');

     $exists1 = $this->general_model->check_breaks_time_exists('worker_available_time', array('worker_day' => $hour_day, 'shop_id' => $shop_id));
     $main_data = $exists1->worker_id;

     if(!empty($exists1)){
        $this->db->where('id', $exists1->id);
        $data = $this->db->delete('worker_available_time');
     }
     if(!empty($main_data)){
       $exists = $this->general_model->check_breaks_time_exists('breaks', array('day' => $hour_day, 'shop_id' => $main_data));

       if(!empty($exists)){
          $this->db->where('id', $exists->id);
          $data1 = $this->db->delete('breaks');
      }
     }
    }

    public function uncheck_hours_day_checkbox() {
      $shop_id = $this->input->post('shop_id');
      $hours_data = $this->general_model->uncheck_hours_day_checkbox('hours_day','business_hours',array('is_deleted' => 0, 'shop_id' => $shop_id));
      echo json_encode($hours_data);
     }

     public function Getshop_matrix($shop_id)
     {
         $appointment_list = $this->general_model->GetAppointmentData(array('app.shop_id' => $shop_id));
         $arr1 = [];
         foreach ($appointment_list as $key => $appointment)
         {
             $arr1[] = array('Date'=>date("Y-m", strtotime($appointment['ap_date'])),'amount'=>$appointment['price']);
         }
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

     public function Get_city_Data()
     {
       if($this->input->post())
       {
         $city = $this->input->post('term');
         $city_where = "is_deleted = 0 AND is_active = 1 AND name LIKE '%".$city."%'";
         $city_list = $this->general_model->get_all_general_data1('id,name','city',$city_where,'result_array','','','name');
         $searchData = $city_list;
         foreach ($searchData as $value) {
           $data[] = array('value' => $value['name'] , 'id' => $value['id']);
         }
         echo json_encode($data);
       }
     }

     public function delete_vacation_module_time() {
       $id = $this->input->post('id');
       $shop_id = $this->input->post('shop_id');
       $this->db->where('id', $id);
       $this->db->where('shop_id', $shop_id);
       $this->db->where('flag', 1);
       $hours_id = $this->db->delete('vacation_module');
      }

      public function check_vacation_module_start_time() {
        $start_date = $this->input->post('start_date');
        $shop_id = $this->input->post('shop_id');

        $parts1 = explode('-', $start_date);
        $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
        $vacation_md_start_date = date("Y-m-d", strtotime($s_date));
        $check_vacation_module = $this->general_model->check_vacation_module_start_time('*', 'vacation_module', array('shop_id' => $shop_id, 'flag' => 1, 'is_deleted' => 0), $vacation_md_start_date);

        echo json_encode($check_vacation_module);
        // echo '<pre>';print_r($check_vacation_module);exit;
       }

       public function check_vacation_module_end_time() {
         $start_date = $this->input->post('start_date');
         $end_date = $this->input->post('end_date');
         $shop_id = $this->input->post('shop_id');

         $parts2 = explode('-', $end_date);
         $e_date = $parts2[1] . '-' . $parts2[0] . '-' . $parts2[2];
         $vacation_md_end_date = date("Y-m-d", strtotime($e_date));

         $check_vacation_module = $this->general_model->check_vacation_module_end_time('*', 'vacation_module', array('shop_id' => $shop_id, 'flag' => 1, 'is_deleted' => 0), $vacation_md_end_date);

         echo json_encode($check_vacation_module);
         // echo '<pre>';print_r($check_vacation_module);exit;
        }

        public function get_state_time(){
          if($this->input->post())
          {
            $state_id = $this->input->post('state_id');
            $shopHours = $this->general_model->get_all_general_data('*','state',array('id'=>$state_id, 'is_deleted' => 0));

            if($shopHours[0]['start_time'] != '00:00:00'){
                  $startTime = date("g:ia", strtotime($shopHours[0]['start_time']));
            }else{
                $startTime = '12:00am';
            }

            if($shopHours[0]['end_time'] != '00:00:00'){
                  $endTime = date("g:ia", strtotime($shopHours[0]['end_time']));
            }else{
                $endTime = '11:30pm';
            }

            $dayArr = array();
            foreach ($shopHours as $value)
            {
              $dayArr[] = $value['hours_day'];
            }

            echo json_encode($dayArr).'||'.$startTime.'||'.$endTime;exit;
          }
        }

        public function checkUnique_email($table, $columnName)
        {
           $email = $_POST['shop_email'];
           if(!empty($email)) {

           $this->db->select($columnName);
           $this->db->from($table);
           $this->db->where('shop_email',$email);
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
