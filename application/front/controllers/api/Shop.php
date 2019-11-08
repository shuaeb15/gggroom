<?php

   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Shop extends REST_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
        

    }

    /**
     * index function.
     *
     * @access public
     * @return void
     */
    public function user_shop_list_post() {
    
       
        $id = $this->input->post('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;


        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if($user_list->u_category == 3){
            $p_id = $user_list->p_id;
          }else{
            $p_id = $id;
          }
          $all_u_id = array($p_id, 0);
          $user_data = $this->general_model->get_shop_data('*', 'user', array('p_id' => $p_id, 'u_category' => 3, 'is_deleted' => 0));
          foreach ($user_data as $key => $value) {
            array_push($all_u_id,$value->id);
          }
          $shop_list = $this->general_model->get_worker_shop_data('*', 'shop', array('is_deleted' => 0), $all_u_id);

          foreach ($shop_list as $key => $shop) {
           
            //$var =  $this->url_encrypt($shop->id);
            $shop_list[$key]->encrypt_id = $shop->id;
          }
         
          $this->data['shoplist'] = $shop_list;
          
          $this->response([
                         'status' => TRUE, 
                          'data' => $shop_list
                             ], REST_Controller::HTTP_OK);
          
        }else{

          $this->response([
                                'status' => FALSE,
                                'message' => 'Not Authorize'
                            ], REST_Controller::HTTP_NOT_FOUND);
       
        }
     
    }
  public function city_list_get()
  {
     $city = $this->general_model->get_all_state_data('id,name', 'city', array('is_deleted' => 0));
       
         $this->response([
                         'status' => TRUE, 
                          'data' => $city
                             ], REST_Controller::HTTP_OK);
  }
  public function state_list_get()
  {  
        $state = $this->general_model->get_all_state_data('id,name', 'state', array('is_deleted' => 0));
        $this->response([
                         'status' => TRUE, 
                          'data' => $state
                             ], REST_Controller::HTTP_OK);
  }
 
  public function category_list_shop_add_post() {
   

      $id = $this->input->post('uid');
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
      $this->data['userlist'] = $user_list;


      $city = $this->general_model->get_all_state_data('*', 'city', array('is_deleted' => 0));
      $this->data['city'] = $city;

      $state = $this->general_model->get_all_state_data('*', 'state', array('is_deleted' => 0));
      $this->data['state'] = $state;

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

        $shop_list = $this->general_model->get_shop_list_data_by_user('shop', array('shop.is_deleted' => 0), $all_u_id);
        $this->data['shoplist'] = $shop_list;

        $worker_list = $this->general_model->get_worker_data('*', 'workers', array('user_id' => $id, 'is_deleted' => 0));
        $this->data['workerlist'] = $worker_list;
        

        $main_category_list = $this->general_model->get_main_category('*', 'category', array( 'flag' => 0, 'is_deleted' => 0));

        $all_category = [];
        foreach ($main_category_list as $key => $value) {
            $main_category_list1 = $this->general_model->get_all_category('*', 'category', array( 'category_id' => $value->category_id, 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0), $value->permission, $id);

            if(!empty($main_category_list1)){
              $all_category[] = $main_category_list1;
            }
        }
        $this->data['main_category'] = $all_category;

             $this->response([
                         'status' => TRUE, 
                         'data' => $all_category
                         
                             ], REST_Controller::HTTP_OK);
            


      }else{
         $this->response([
                                    'status' => FALSE,
                                    'message' => 'Sorry, User can not login as he is Inactive or deleted.'
                                ], REST_Controller::HTTP_NOT_FOUND);
      }
    
  }

      public function insert_shop_post(){
     
        $map_api = $this->config->item('map_api');
        $uid = $this->input->post('uid');
        // echo "<pre>"; print_r($_POST);exit;
        if(isset($_POST['city'])){
          $city_chk = implode(',', $_POST['city']);
        }else{
          $city_chk = "";
        }
        $state_name = $this->general_model->get_all_state_data('name', 'state', array('id' => $state));
        $state_name = $state_name[0]->name;
        $Address = $this->input->post('address_1').$this->input->post('address_2').'+'.$this->input->post('city').'+'.$this->input->post('state').'+'.$this->input->post('zipcode');
        $formattedAddr = str_replace(' ','+',$Address);
        $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key='.$map_api);
        $json = json_decode($json);

        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        $latitude = !empty($lat) ? $lat : "";
        $longitude = !empty($long) ? $long : "";
        // echo "<pre>"; print_r(json_decode($_POST['categories'][0]));exit;
        $categories = json_decode($_POST['categories'][0]);

        // echo "<pre>"; print_r($categories_final); exit;
        // echo "<pre>"; print_r($_POST['radiog_list_worker_time']); exit;
        foreach($categories as $key=>$value){
          // $implode[] = implode(', ', $value->id);
          $implode[] = $value->id;
        }
        $categories_final = implode(",",$implode);
        // echo $categories_final;exit;
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

        $start_time = implode(",",$time_start);
        $end_time = implode(",",$time_end);
        $new_service_type = implode(",",$_POST['service_type']);
        
        // echo $end_time; exit;

        $workers = implode (",", $_POST['radiog_list_worker_time']);
        // echo $workers;exit;
        $image = $this->uploadImage($_FILES['imgupload1']['name'], 'imgupload1', 'shop_image');
        // $file_element_name = 'imgupload1';
        $json_files = $this->input->post('json_files');
        // echo "<pre>"; print_r($json_files);exit;
        if($json_files != ''){
          $json_files2 = explode(",",$json_files);
        }
        else {
          $json_files2 = [];
        }
        // echo "<pre>"; print_r($json_files2);exit;
        $data = array(
            'user_id' => $uid,
            'shop_name' => $_POST['shop_name'],
            'service_type' => $new_service_type,
            'service_id' => $categories_final,
            'worker_id' => $workers,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'shop_email' => $_POST['shop_email'],
            'mobile' => $_POST['mobile_no'],
            'addline1' => $_POST['address_1'],
            'addline2' => $_POST['address_2'],
            'city' => $city_chk,
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'description' => $_POST['discription'],
            'cancel_policy' => $_POST['radiog_dark'],
            'image' => $image,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'is_deleted' => 0
        );
        // echo "<pre>"; print_r($data);exit;
        $insert_id = $this->general_model->insert_shop_data($data, 'shop');
        // $shop_id = $insert_id;
        $image1 = $this->upload_muliple_image($insert_id,$json_files2);
        if($insert_id){
          
           $this->response([
                         'status' => TRUE, 
                          'message' => 'Shop added successfully.'
                             ], REST_Controller::HTTP_OK);

         

        }else{

               $this->response([
                                 'status' => FALSE,
                                   'message' => 'Sorry, something went wrong. please try again.'
                                ], REST_Controller::HTTP_NOT_FOUND);

        }
       
    }

  public function edit_shop($id1) {
   

    if (!$this->session->userdata('uid')) {
      redirect(site_url());
    }
    else{
      $id1 = $this->url_decrypt($id1);

      $id = $this->session->userdata('uid');
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
      $this->data['userlist'] = $user_list;

      $city = $this->general_model->get_all_state_data('*', 'city', array('is_deleted' => 0));
      $this->data['city'] = $city;

      $state = $this->general_model->get_all_state_data('*', 'state', array('is_deleted' => 0));
      $this->data['state'] = $state;
      // echo '<pre>'; print_r($state); exit;

      if($user_list->u_category == 2 || $user_list->u_category == 3){
        $cat_data = $this->general_model->get_edit_shop_data('shop', array('shop.id' => $id1, 'shop.is_active' => 1));
        $get_sub_category_data_exist = $this->general_model->get_sub_category_data_exist('services', $cat_data->service_id);
        // echo '<pre>';  print_r(json_encode($get_sub_category_data_exist)); exit;
        $this->data['get_sub_category_data_exist'] = json_encode($get_sub_category_data_exist);

        $var =  $this->url_encrypt($cat_data->id);
        $cat_data->encrypt_id = $var;
        // echo '<pre>';  print_r(explode(',',$cat_data->service_id)); exit;
        $this->data['shoplist'] = $cat_data;

        $worker_list = $this->general_model->get_worker_data('*', 'workers', array('user_id' => $id, 'is_deleted' => 0));
        $this->data['workerlist'] = $worker_list;

        $business_hours = $this->general_model->get_business_hours_data('*', 'business_hours', array('shop_id' => $id1, 'is_active' => 1));
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

        $breaks = $this->general_model->get_business_hours_data('*', 'breaks', array('shop_id' => $id1, 'is_active' => 1));
        $this->data['breaks'] = $breaks;

        $get_images = $this->general_model->get_allshop_images('*', 'shop_images', array('shop_id' => $id1,'is_active' => 1, 'flag' => 1));
        $this->data['shop_image_list'] = $get_images;

        $vacation_module_data = $this->general_model->get_allshop_images('*', 'vacation_module', array('shop_id' => $id1, 'is_deleted' => 0, 'flag' => 1));

        $this->data['vacation_module_data'] = $vacation_module_data;

        $main_category_list = $this->general_model->get_main_category('*', 'category', array( 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0));
        $all_category = [];
        foreach ($main_category_list as $key => $value) {
            $main_category_list1 = $this->general_model->get_all_category('*', 'category', array( 'category_id' => $value->category_id, 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0), $value->permission, $id);

            if(!empty($main_category_list1)){
              $all_category[] = $main_category_list1;
            }
        }
        $this->data['main_category'] = $all_category;
        // echo "<pre>"; print_r($this->data['shoplist']);exit;
        $this->data['title'] = 'Shop | GGG Rooms';

          $this->data['js_file'] = array(
              "front/js/services.js",
              "front/js/jquery-confirm.min.js",
              "front/js/bootstrap-datetimepicker.min.js",
              "front/js/jquery.timepicker.js",
              "front/js/datepair.js",
              "front/js/jquery.datepair.js",
              "front/js/shop.js"
          );
          $this->data['css_file'] = array(
              "front/css2/jquery-confirm.min.css",
              "front/css/bootstrap-datetimepicker.min.css",
              "front/css/jquery.timepicker.css"
          );

        $this->render('edit_service_view');
        // $this->render('edit_shop');
      }else{
        redirect('profile', 'refresh');
      }
    }
    $this->check_vacation_module_time_available();
  }

   


    public function upload_muliple_image($shop_id, $json_files2)
   {
    if($_FILES["files"]["name"] != '')
    {
     $output = '';
     $config["upload_path"] = FCPATH.'assets/uploads/shop_image/';
     $config["allowed_types"] = 'gif|jpg|png|jpeg';
     $this->load->library('upload', $config);
     $this->upload->initialize($config);
     $insert_data = [];

     for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
     {
       if(!empty($json_files2)){
         if (in_array($_FILES["files"]["name"][$count],$json_files2)) {
           $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
           $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
           $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
           $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
           $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
           if($this->upload->do_upload('file'))
           {
            $data = $this->upload->data();

            $data = array(
                'shop_id' => $shop_id,
                'flag' => '1',
                'image' => $data["file_name"],
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'is_deleted' => 0,
            );
            $inserted_id = $this->general_model->insert_shop_images($data, 'shop_images');
           }
         }
       }
       else{
         $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
         $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
         $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
         $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
         $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
         if($this->upload->do_upload('file'))
         {
          $data = $this->upload->data();

          $data = array(
              'shop_id' => $shop_id,
              'flag' => '1',
              'image' => $data["file_name"],
              'created_at' => date('Y-m-d H:i:s'),
              'is_active' => 1,
              'is_deleted' => 0,
          );
          $inserted_id = $this->general_model->insert_shop_images($data, 'shop_images');
         }
       }
     }
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

    public function check_vacation_module_time_available(){
      $current_date = date("Y-m-d");
      $check_vacation_module = $this->general_model->get_all_state_data('*', 'vacation_module', array('flag' => 1, 'is_deleted' => 0));
      foreach ($check_vacation_module as $key => $date) {
        $date_to_compare = date($date->end_date);
        if (strtotime($date_to_compare) < strtotime($current_date)) {
          $check_vacation_module1 = $this->general_model->check_vacation_module_time_available('*', 'vacation_module', array('flag' => 1, 'is_deleted' => 0), $date_to_compare);
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

  
    ///////////////// Update Shop New Functionality Start ///////////////////////
    public function update_shop($id1){
      $shop_id = $this->url_decrypt($id1);
      // echo $id1;exit;
      if ($this->input->post() && $this->input->post() != '') {
        $map_api = $this->config->item('map_api');
        $uid = $this->session->userdata('uid');
        // echo "<pre>"; print_r($_POST);exit;
        if(isset($_POST['city'])){
          $city_chk = implode(',', $_POST['city']);
        }else{
          $city_chk = "";
        }
        $state_name = $this->general_model->get_all_state_data('name', 'state', array('id' => $state));
        $state_name = $state_name[0]->name;
        $Address = $this->input->post('address_1').$this->input->post('address_2').'+'.$this->input->post('city').'+'.$this->input->post('state').'+'.$this->input->post('zipcode');
        $formattedAddr = str_replace(' ','+',$Address);
        $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key='.$map_api);
        $json = json_decode($json);

        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        $latitude = !empty($lat) ? $lat : "";
        $longitude = !empty($long) ? $long : "";
        // echo "<pre>"; print_r(json_decode($_POST['categories'][0]));exit;
        $categories = json_decode($_POST['categories'][0]);

        // echo "<pre>"; print_r($categories_final); exit;
        // echo "<pre>"; print_r($_POST['radiog_list_worker_time']); exit;
        foreach($categories as $key=>$value){
          // $implode[] = implode(', ', $value->id);
          $implode[] = $value->id;
        }
        $categories_final = implode(",",$implode);
       // echo $categories_final;exit;
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

        $start_time = implode(",",$time_start);
        $end_time = implode(",",$time_end);
        $new_service_type = implode(",",$_POST['service_type']);

        // echo $end_time; exit;

        $workers = implode (", ", $_POST['radiog_list_worker_time']);
        // echo $workers;exit;
        $image = ($_POST['shop_image'] && $_POST['shop_image'] != '') ? $_POST['shop_image'] : $this->uploadImage($_FILES['imgupload1']['name'], 'imgupload1', 'shop_image');
        // $file_element_name = 'imgupload1';
        $json_files = $this->input->post('json_files');
        // echo "<pre>"; print_r($json_files);exit;
        if($json_files != ''){
          $json_files2 = explode(",",$json_files);
        }
        else {
          $json_files2 = [];
        }
        // echo "<pre>"; print_r($json_files2);exit;
        $data = array(
            'user_id' => $uid,
            'shop_name' => $_POST['shop_name'],
            'service_type' => $new_service_type,
            'service_id' => $categories_final,
            'worker_id' => $workers,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'shop_email' => $_POST['shop_email'],
            'mobile' => $_POST['mobile_no'],
            'addline1' => $_POST['address_1'],
            'addline2' => $_POST['address_2'],
            'city' => $city_chk,
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'description' => $_POST['discription'],
            'cancel_policy' => $_POST['radiog_dark'],
            'image' => $image,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'is_deleted' => 0
        );
        // echo "<pre>"; print_r($data);exit;
        $insert_id = $this->general_model->update_shop_data($data, 'shop', array('id' => $shop_id));
        // echo $insert_id;exit;
        $image1 = $this->upload_muliple_image($insert_id,$json_files2);
        if($insert_id){
          $this->session->set_flashdata('success_message', "Shop updated successfully");
          redirect('shop', 'refresh');
        }else{
           $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
           redirect('shop/edit_shop/'.$id1, 'refresh');
        }
        // echo "<pre>"; print_r($categories); exit;
      }else {
        $this->session->set_flashdata('error_message', "Something went wrong!");
        redirect('shop', 'refresh');
      }
    }
    ///////////////// Update Shop New Functionality End ///////////////////////

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
      $config['upload_path']          = FCPATH.'assets/uploads/'.$upload_path.'/';
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
        $path = 'assets/uploads/'.$upload_path.'/'.$img;
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

  public function upload($shop_id)
 {
  if($_FILES["files"]["name"] != '')
  {
   $output = '';
   $config["upload_path"] = FCPATH.'assets/uploads/shop_image/';
   $config["allowed_types"] = 'gif|jpg|png|jpeg';
   $this->load->library('upload', $config);
   $this->upload->initialize($config);
   $insert_data = [];

   for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
   {
    $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
    $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
    $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
    $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
    $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
    if($this->upload->do_upload('file'))
    {
     $data = $this->upload->data();

     $data = array(
         'shop_id' => $shop_id,
         'flag' => '1',
         'image' => $data["file_name"],
         'created_at' => date('Y-m-d H:i:s'),
         'is_active' => 1,
         'is_deleted' => 0,
     );
     $inserted_id = $this->general_model->insert_shop_images($data, 'shop_images');
     $insert_data[$count] = $inserted_id;
    }
   }
    echo json_encode($insert_data);
  }
 }
 public function delete_image() {
   $id = $this->input->post('img_id');

   $this->db->select('image');
   $this->db->from('shop_images');
   $this->db->where('id',$id);
   $count = $this->db->get()->row();
   $img = $count->image;
   $path = 'assets/uploads/shop_image/'.$img;
   unlink($path);

   $this->db->where('id', $id);
   $this->db->delete('shop_images');

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

   public function delete_breaks_time() {
     $id = $this->input->post('id');
     $this->db->where('id', $id);
     $this->db->delete('breaks');

    }

    public function delete_shop($id1) {

      if($id1){

        $data = array(
          'is_active' => 0,
            'is_deleted' => 1
        );
        $update_id = $this->general_model->delete_shop($data, 'shop', array('id' => $id1));

        $this->db->where('shop_id', $id1);
        $this->db->delete('business_hours');

        // $this->db->where('shop_id', $id1);
        // $this->db->delete('breaks');

        $this->db->select('image');
        $this->db->from('shop_images');
        $this->db->where('shop_id',$id1);
        $this->db->where('flag', '1');
        $count = $this->db->get()->result();
        $img = $count->image;
        $path = 'assets/uploads/shop_image/'.$img;
        unlink($path);

        $this->db->where('shop_id', $id1);
        $this->db->where('flag', '1');
        $this->db->delete('shop_images');

        if($update_id){
          $this->session->set_flashdata('success_message', "Shop deleted successfully");
          redirect('profile', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('shop', 'refresh');
        }

      }

    }

    public function GetAllShops()
    {
      $whereArray = array('shop.is_active'=>1,'shop.is_deleted'=>0,'shop.latitude !=' => "",'shop.longitude !=' => "");
      $ShopData = $this->general_model->get_shop_list_data('shop',$whereArray);

      $newArray = [];
      foreach ($ShopData as $value) {
        $main_shop_id =  $this->url_encrypt($value->id);
        $main_url = site_url().'shop/services/'.$main_shop_id;
        $address = '<a href="'.$main_url.'" style="font-size: 18px;font-weight:500;cursor:pointer;">'.$value->shop_name.'</a><br/><label style="font-weight:bolder;text-transform:capitalize;">'.$value->addline1.', '.$value->city_name.', '.$value->state_name.', '.$value->zipcode.'</label>';
        $newArray[] = array('lat'=>$value->latitude,'lng'=>$value->longitude,'description'=>$address);
      }
      // echo "<pre>"; print_r($newArray);exit;
      echo json_encode($newArray);exit;
    }

    public function services($shop_id)
    {
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      $shop_id = $this->url_decrypt($shop_id);

      $id = $this->session->userdata('uid');
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
      $this->data['userlist'] = $user_list;


      $query = $this->db->get_where('shop', array('id' => $shop_id));
      $row = $query->result();
      $string=$row[0]->service_id;
      $array1=array_map('intval', explode(',', $string));
      $array = implode("','",$array1);
      $total_service_list1 = $array;
      $total_service_list2 = array($string);
     

      $filter_data1 = $this->general_model->search_service_get_data1( 'services', array('services.is_deleted' => 0, 'services.shop_id' => $shop_id, 'user.u_category' => 2));
      $limit1 = count($filter_data1);
      $limit = count($array1);

     

      // $main_filter_shop_list2 = $this->general_model->search_service_get_data( 'services', array('services.is_deleted' => 0, 'services.shop_id' => $shop_id, 'user.u_category' => 2), $limit, 0);

      $main_filter_shop_list = $this->general_model->search_service_get_data_new( 'services', $array1, $limit, 0,$shop_id);
    //print_r($main_filter_shop_list);
     //print_r($main_filter_shop_list);

     //echo '<pre>',print_r($main_filter_shop_list),'</pre>';
      // echo '<pre>';print_r($main_filter_shop_list);exit;
      $service_list = [];
      $check_worker_service = 0;
      foreach ($main_filter_shop_list as $key => $value) {
        // $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

         $main_services = $this->general_model->get_service_data_by_worker_shopid_new( 'services', array('services.id' => $value->id, 'services.is_deleted' => 0),$shop_id);

         //print_r($main_services);
         //echo '<pre>', print_r($main_services),'</pre>';

        if(count($service_list) <= 3){
            $check_worker_service++;
        }
        if(!empty($main_services)){
          if(count($service_list) <= 3){
              $service_list[] = $main_services;
          }
        }
      }
      // echo '<pre>';print_r($service_list);exit;
      foreach ($service_list as $key => $value) {
        $var =  $this->url_encrypt($value->id);
        $service_list[$key]->encrypt_id = $var;

        if($value->parent_id != 0){
          $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
          $service_list[$key]->sub_category = $cat_list1;
          if($cat_list1->cat_parent_id != 0){
            $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
            $service_list[$key]->und_sub_category = $cat_list2;
          }
        }
        $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));
        $all_review = count($all_review_list);
        $service_list[$key]->review_list = $all_review;
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
        $service_list[$key]->ratingRound = $roundEvg;
        $data = array(
          'user_id' => $id,
          'service_id' => $value->id,
          'shop_id' => $value->shop_id
        );
        $FavData = $this->general_model->check_exist_data('id','favourite',$data);
        $fav = !empty($FavData) ? "1" : "0";
        $service_list[$key]->fav = $fav;

        $img =  $value->image;
        $temp_file = base_url()."front/images/banner.jpg";
        $main_file = "assets/uploads/service_image/".$img;
        $filename = FCPATH.$main_file;
        if (file_exists($filename)) {
          if($img != ''){
              $main_image =  base_url().$main_file;
          }else{
              $main_image =  $temp_file;
          }
        }else{
          $main_image =  $temp_file;
        }

        $service_list[$key]->main_image = $main_image;
      }
      
      //Total Count 
      $main_filter_shop_list1 = $this->general_model->search_service_get_data1( 'services', array('services.is_deleted' => 0, 'services.shop_id' => $shop_id, 'user.u_category' => 2));
      $service_list1 = [];
      foreach ($main_filter_shop_list1 as $key => $value) {
        $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));
          
        if(!empty($main_services)){


            $service_list1[] = $main_services;
        }
      }

        $this->data['js_file'] = array(
            "front/js/favourite.js",
        );

        //$count_service = count($service_list1);
        $count_service = count($array1);
        $this->data['shop_id'] =  $shop_id;
        $this->data['shop_id_encrypt'] =  $this->url_encrypt($shop_id);
        $this->data['count_service'] = $count_service;
        $this->data['check_worker_service'] = $check_worker_service;
        $this->data['servicelist'] = $service_list;
        $this->data['main_shop_id'] = $shop_id;
        $this->data['title'] = 'Services | GGG Rooms';
        $this->render('shop_details');

    }

    public function search_services_data(){

        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        $shop_id = $this->input->post('shop_id');
        $start =  $this->input->post('data_limit') -1;



      $query = $this->db->get_where('shop', array('id' => $shop_id));
      $row = $query->result();
      $string=$row[0]->service_id;
      $array1=array_map('intval', explode(',', $string));
      $array = implode("','",$array1);
      $total_service_list1 = $array;
      $total_service_list2 = array($string);
     

     

      $service_list = $this->general_model->search_service_get_data_new( 'services', $array1, 3 , $start,$shop_id);


        //$service_list = $this->general_model->search_service_get_data_new( 'services', array('services.is_deleted' => 0), 4, $);

      $query = $this->db->get_where('shop', array('id' => $shop_id));
      $row = $query->result();
      $string=$row[0]->service_id;
      $array1=array_map('intval', explode(',', $string));
      
      //    $service_list = $this->general_model->search_service_get_data_new( 'services', $array1), 4, $start);

        foreach ($service_list as $key => $services) {
          $var =  $this->url_encrypt($services->id);
          $service_list[$key]->encrypt_id = $var;
        }

        foreach ($service_list as $key => $value) {
          if($value->parent_id != 0){
            $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
            $service_list[$key]->sub_category = $cat_list1;
            if($cat_list1->cat_parent_id != 0){
              $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
              $service_list[$key]->und_sub_category = $cat_list2;
            }
          }
          $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));
          $all_review = count($all_review_list);
          $service_list[$key]->review_list = $all_review;
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
          $service_list[$key]->ratingRound = $roundEvg;
          $data = array(
            'user_id' => $id,
            'service_id' => $value->id,
            'shop_id' => $value->shop_id
          );
          $FavData = $this->general_model->check_exist_data('id','favourite',$data);
          $fav = !empty($FavData) ? "1" : "0";
          $service_list[$key]->fav = $fav;

          $img =  $value->image;
          $temp_file = base_url()."front/images/banner.jpg";
          $main_file = "assets/uploads/service_image/".$img;
          $filename = FCPATH.$main_file;
          if (file_exists($filename)) {
            if($img != ''){
                $main_image =  base_url().$main_file;
            }else{
                $main_image =  $temp_file;
            }
          }else{
            $main_image =  $temp_file;
          }

          $service_list[$key]->main_image = $main_image;
        }
        // echo '<pre>';print_r($service_list);exit;
        // $this->data['servicelist'] = $service_list;

        echo json_encode($service_list);
      }

      public function uncheck_hours_day_checkbox() {
        $shop_id = $this->input->post('shop_id');
        $hours_data = $this->general_model->uncheck_hours_day_checkbox('hours_day','business_hours',array('is_deleted' => 0, 'shop_id' => $shop_id));
        echo json_encode($hours_data);
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

          public function checkUniqueadd_email_post()
          {
            $email = $_POST['shop_email'];
            $id = $this->input->post('uid');

              if(!empty($email)) {
                   $this->db->select('id');
                   $this->db->from('shop');
                   $this->db->where('shop_email',$email);
                   $this->db->where('user_id',$id);
                   $count = $this->db->get()->row();
                   $count = count($count);
                   $count = (int)$count;
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
          public function edit_checkUniqueadd_email($table, $columnName)
          {
            $email = $_POST['shop_email'];
            $shop_id = $_POST['id'];
            $id = $this->session->userdata('uid');

              if(!empty($email)) {
                   $this->db->select($columnName);
                   $this->db->from($table);
                   $this->db->where('shop_email',$email);
                   $this->db->where('id !=',$shop_id);
                   $this->db->where('user_id',$id);
                   $count = $this->db->get()->row();
                   $count = count($count);
                   $count = (int)$count;
                   if($count > 0){
                      echo 'false';
                   }else{
                     echo 'true';
                   }
                 }
          }

          public function confirm_varification(){
            if ($this->input->post()){
                $this->load->helper('form','url');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('recovery_email', 'Email', 'required');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Email is require");
                    redirect('shop', 'refresh');
                } else {
                  $email = $this->input->post('recovery_email');
                  $shop_id = $this->input->post('shop_id');
                  $this->load->helper('string', 6);
                  $token= random_string('alnum', 12);
                    $data = array(
                        'token' => $token
                    );
                    $qry = $this->db->where('id', $shop_id)
                                    ->update('shop', $data);
                    $emailsend = $this->general_model->shop_varification_email($email, $token, $shop_id);
                    if($emailsend){
                      $this->session->set_flashdata('success_message', "Please check email for verification.");
                      redirect('shop','refresh');
                    }
                    else{
                      $this->session->set_flashdata('error_message', 'Sorry, something went wrong. please try again');
                      redirect('home', 'refresh');
                    }
                }
              }
            }

            public function verification($token, $shop_id){
              $this->db->select("*");
              $this->db->from("shop");
              $this->db->where('id',$shop_id);
              $this->db->where('token',$token);
              $query = $this->db->get();
              $res = $query->result();
              if ($query->num_rows() == 0)
              {
                $this->session->set_flashdata('error_message', "Sorry!!! Already your verification is done!");
                redirect('shop', 'refresh');
              }
              else
              {
                $data = array(
                  'varification' => 0,
                  'token' => ''
                );

                $where=$this->db->where('id',$shop_id);
                       $this->db->update('shop',$data);
                  if($where){
                    $this->session->set_flashdata('success_message', "Verification successfully!");
                    redirect('shop', 'refresh');
                  }
                  else{
                    $this->session->set_flashdata('error_message', 'Sorry, something went wrong. please try again');
                    redirect('home', 'refresh');
                  }
              }
            }
}
