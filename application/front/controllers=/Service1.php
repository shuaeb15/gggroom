<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Service extends MY_Controller {
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
          $service_list = $this->general_model->get_worker_shop_data('*', 'services', array('is_deleted' => 0), $all_u_id);
          foreach ($service_list as $key => $service) {
            $var =  $this->url_encrypt($service->id);
            $service_list[$key]->encrypt_id = $var;
          }
          $this->data['servicelist'] = $service_list;
          // echo "<pre>"; print_r($service_list); exit;
          $this->data['title'] = 'Services | GGG Rooms';
          if(count($service_list) > 0){
            $this->render('service');
          }
          else{
              $this->render('blank_service');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function add_service() {
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

          $main_category_list = $this->general_model->get_main_category('*', 'category', array( 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0));

          $all_category = [];
          foreach ($main_category_list as $key => $value) {
              $main_category_list1 = $this->general_model->get_all_category('*', 'category', array( 'category_id' => $value->category_id, 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0), $value->permission, $id);

              if(!empty($main_category_list1)){
                $all_category[] = $main_category_list1;
              }
          }
          $this->data['main_category'] = $all_category;
          // echo "<pre>"; print_r($all_category); exit;

          $this->data['title'] = 'Services | GGG Rooms';

          $this->data['js_file'] = array(
              "front/js/services.js",
              "front/js/jquery-confirm.min.js",
              "front/js/jquery.timepicker.js",
              "front/js/datepair.js",
              "front/js/jquery.datepair.js",
              "front/js/shop.js"
              // "front/js/lightslider.js"
          );
          $this->data['css_file'] = array(
              "front/css2/jquery-confirm.min.css",
              "front/css/jquery.timepicker.css"
              // "front/js/lightslider.js"
          );
          if(!empty($shop_list)){
              //$this->render('add_service_view');
               $this->render('add_service');
          }
          else{
            $this->session->set_flashdata('success_message1', "No shop added, Please add the shop");
            $this->render('blank_service');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function edit_service($id1) {
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
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        // echo "<pre>"; print_r($user_list); exit;
        if($user_list->u_category == 2 || $user_list->u_category == 3){

          $id1 = $this->url_decrypt($id1);
          $service_list = $this->general_model->get_service_data_id('*', 'services', array('id' => $id1, 'is_deleted' => 0));

          $var =  $this->url_encrypt($service_list->id);
          $service_list->encrypt_id = $var;
          $this->data['servicelist'] = $service_list;

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

          // echo "<pre>"; print_r($shop_list); exit;

          $worker_list = $this->general_model->get_worker_data1('workers', 'workers.shop_id = "'.$service_list->shop_id.'" AND workers.user_id = "'.$id.'" AND workers.is_deleted = "0"');
          $this->data['workerlist'] = $worker_list;

          $main_category_list = $this->general_model->get_main_category('*', 'category', array('parent_id' => 0, 'flag' => 0, 'is_deleted' => 0));

            $all_category = [];
            foreach ($main_category_list as $key => $value) {
                $main_category_list1 = $this->general_model->get_all_category('*', 'category', array( 'category_id' => $value->category_id, 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0), $value->permission, $id);

                if(!empty($main_category_list1)){
                  $all_category[] = $main_category_list1;
                }
            }

            $this->data['main_category'] = $all_category;

          $get_images = $this->general_model->get_allshop_images('*', 'shop_images', array('shop_id' => $id1, 'flag' => '2', 'is_deleted' => 0));
          $this->data['shop_image_list'] = $get_images;

          $cate_id = $service_list->cat_id;
          if($cate_id != ''){
            $main_cat_id = $this->general_model->get_category_name('*','category', array('category_id' => $cate_id));
            if($main_cat_id->parent_id != 0){
                $main_cat_id_1 = $this->general_model->get_category_name('*','category', array('category_id' => $main_cat_id->parent_id));
                if($main_cat_id_1->parent_id != 0){
                    $main_cat_id_2 = $this->general_model->get_category_name('*','category', array('category_id' => $main_cat_id_1->parent_id));
                }
            }
          }
          if($main_cat_id->parent_id == 0){
            $category = $main_cat_id->category_id;
            $all_category_name = $main_cat_id->cat_name;
          }else if($main_cat_id_1->parent_id == 0){
            $category = $main_cat_id_1->category_id.','.$main_cat_id->category_id;
            $all_category_name = $main_cat_id_1->cat_name.','.$main_cat_id->cat_name;
          }else if($main_cat_id_2->parent_id == 0){
            $category = $main_cat_id_2->category_id.','.$main_cat_id_1->category_id.','.$main_cat_id->category_id;
            $all_category_name = $main_cat_id_2->cat_name.','.$main_cat_id_1->cat_name.','.$main_cat_id->cat_name;
          }

          $this->data['all_category'] = $category;
          $this->data['all_category_name'] = $all_category_name;
          // echo "<pre>"; print_r($category); exit;
          $this->data['title'] = 'Services | GGG Rooms';
          $this->data['js_file'] = array(
              "front/js/services.js",
              "front/js/jquery-confirm.min.js",
          );
          $this->data['css_file'] = array(
              "front/css2/jquery-confirm.min.css"
          );
          $this->render('edit_service_view');
        }else{
          redirect('profile', 'refresh');
        }
      }
    }

    public function get_sub_category($flag){
      $cat_id = $_POST['cat_id'];
      // echo $cat_id;exit;
      $main_category_list = $this->general_model->get_cat_subcat_data($cat_id);
      // echo "<pre>"; print_r($main_category_list);exit;
      $all_category = [];
      foreach ($main_category_list as $key => $value) {
        $main_category_list1 = $this->general_model->get_all_category('*', 'category', array( 'category_id' => $value->category_id, 'parent_id' => $cat_id, 'is_deleted' => 0), $value->permission, $id);

        if(!empty($main_category_list1)){
          $all_category[] = $main_category_list1;
        }
      }
      // echo "<pre>"; print_r($main_category_list[0]);exit;
      echo json_encode($main_category_list);exit;
      // echo "<pre>"; print_r($all_category);exit;
      // echo json_encode($all_category);exit;
    }

    public function search_services(){
      if($this->input->post())
      {
        $service = $this->input->post('term');
        // echo $service;exit;
        $service_where = "parent_id = 0 AND is_deleted = 0 AND cat_name LIKE '%".$service."%'";
        $service_list = $this->general_model->get_all_general_data('category_id, cat_name','category',$service_where,'result_array','','','cat_name');
        // echo "<pre>"; print_r($service_list); exit;
        foreach ($service_list as $value) {
          $data[] = array('value' => $value['cat_name'] , 'id' => $value['category_id']);
        }
        // echo '<pre>';print_r($data);exit;
        echo json_encode($data);
      }
    }

    public function get_search_service_data(){
      // echo "<pre>"; print_r($_POST['filter_services']); exit;

      $filter_services = $this->input->post('filter_services');

      $main_category_list = $this->general_model->get_main_category('*', 'category', array( 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0, 'cat_name' => $filter_services));

      $all_category = [];
      foreach ($main_category_list as $key => $value) {
          $main_category_list1 = $this->general_model->get_all_category('*', 'category', array( 'category_id' => $value->category_id, 'parent_id' => 0, 'flag' => 0, 'is_deleted' => 0), $value->permission, $id);

          if(!empty($main_category_list1)){
            $all_category[] = $main_category_list1;
          }
      }
      $this->data['main_category'] = $all_category;
      // echo "<pre>"; print_r($all_category); exit;
      if(!empty($all_category)){
        // $this->render('add_service_view_ajax');
        echo json_encode($all_category);
        // $html = $html.'<br><div class="list-timing"><ul id="content-slider" class="content-slider tabs">';
        // $k = 1;
        // foreach ($main_category as $cat) {
        //   echo "<pre>"; print_r($cat);exit;
        //   $categories = extract($main_category);
        //   $html = $htm.'<li><a href="#tb"'.$cat->category_id.'" data-btn-id="'.$cat->category_id.'"><div class="timing_date">'.$cat->cat_name.'</div></a></li>';
        // }
        // $html = $html.'</ul></div>';
        // foreach ($main_category as $cat) {
        //   $html .= '<div id="tb'.$cat->category_id.'" class="sub-cat-div">';
        // }
        // $html = $html.'</div>';
        //
        // echo $html;exit;
      }
      else{
        echo 'error';
        // $this->session->set_flashdata('success_message1', "No shop added, Please add the shop");
        // $this->render('blank_service');
      }
    }

    public function insert_service() {
      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $uid = $this->session->userdata('uid');
              $main_category = $this->input->post('main_category');
              $sub_category = $this->input->post('sub_category');
              $und_sub_category = $this->input->post('und_sub_category');
              $service_type = $this->input->post('radiog_dark_service_type');
              if(empty($service_type)){
                $service_type = '';
              }
              else{
                $service_type = $service_type;
              }
              $shop_type = $this->input->post('radiog_list_detail');
              $service_price = $this->input->post('range-price');
              $service_time = $this->input->post('range-time');
              $json_files = $this->input->post('json_files');
              if($json_files != ''){
                $json_files2 = explode(",",$json_files);
              }
              else {
                $json_files2 = [];
              }
              $worker = $this->input->post('radiog_list_worker_time[]');
              if(!empty($worker)){
                  $worker_id = implode(",",$worker);
              }else{
                $worker_id = '';
              }
              $cat = $main_category.','.$sub_category.','.$und_sub_category;
              if($und_sub_category == '' && $sub_category == ''){
                $cat_id = $main_category;
                $cat_name_get = $this->general_model->get_category_name('cat_name','category', array('category_id' => $main_category));
              }else{
                if($und_sub_category != ''){
                  $cat_id = $und_sub_category;
                  $cat_name_get = $this->general_model->get_category_name('cat_name','category', array('category_id' => $und_sub_category));
                }else{
                  $cat_id = $sub_category;
                  $cat_name_get = $this->general_model->get_category_name('cat_name','category', array('category_id' => $sub_category));
                }
              }
              $cat_name = $cat_name_get->cat_name;
              $image = $this->uploadImage($_FILES['imgupload1']['name'], 'imgupload1', 'service_image');
              $data = array(
                  'user_id' => $uid,
                  'worker_id' => $worker_id,
                  'service_name' => $cat_name,
                  'cat_id' => $cat_id,
                  'type' => $service_type,
                  'shop_id' => $shop_type,
                  'price' => $service_price,
                  'time' => $service_time,
                  'image' => $image,
                  'created_at' => date('Y-m-d H:i:s'),
                  'is_active' => 1,
                  'is_deleted' => 0,
              );

              $insert_id = $this->general_model->insert_all_services($data, 'services');
              $image1 = $this->upload_muliple_image($insert_id,$json_files2);

              if($insert_id){
                $this->session->set_flashdata('success_message', "Service added successfully");
                redirect('service', 'refresh');
              }else{
                $this->session->set_flashdata('error_message', "This services is already added.");
                redirect('service', 'refresh');
              }
          }else {
            $this->session->set_flashdata('error_message', "Something went wrong!");
            redirect('service', 'refresh');
          }
        }else{
          redirect('profile', 'refresh');
        }
      }
    }
    ///////////////// Add Services New Functionality Start ///////////////////////
    public function addServicesNew(){
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
        // echo $end_time; exit;

        $workers = implode (", ", $_POST['radiog_list_worker_time']);
        // echo $workers;exit;
        $image = $this->uploadImage($_FILES['imgupload1']['name'], 'imgupload1', 'service_image');
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
            'service_type' => $_POST['service_type'],
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
          $this->session->set_flashdata('success_message', "Shop added successfully");
          redirect('service', 'refresh');
        }else{
           $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
           redirect('service/add_service', 'refresh');
        }
        // echo "<pre>"; print_r($categories); exit;
      }else {
        $this->session->set_flashdata('error_message', "Something went wrong!");
        redirect('service', 'refresh');
      }
    }
    ///////////////// Add Services New Functionality End ///////////////////////

    public function upload_muliple_image($service_id, $json_files2)
   {
    if($_FILES["files"]["name"] != '')
    {
     $output = '';
     $config["upload_path"] = FCPATH.'assets/uploads/service_image/';
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
                'shop_id' => $service_id,
                'flag' => '2',
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
              'shop_id' => $service_id,
              'flag' => '2',
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

    public function update_service() {
      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }else{
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_active' => 1));
        $this->data['userlist'] = $user_list;

        if($user_list->u_category == 2 || $user_list->u_category == 3){
          if ($this->input->post()) {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $uid = $this->session->userdata('uid');
              $service_id = $this->input->post('service_id');
              $main_category = $this->input->post('main_category');
              $sub_category = $this->input->post('sub_category');
              $und_sub_category = $this->input->post('und_sub_category');
              $service_type = $this->input->post('radiog_dark_service_type');
              if(empty($service_type)){
                $service_type = '';
              }
              else{
                $service_type = $service_type;
              }
              $shop_type = $this->input->post('radiog_list_detail');
              $service_price = $this->input->post('range-price');
              $service_time = $this->input->post('range-time');

              $worker = $this->input->post('radiog_list_worker_time[]');
              $worker_id = implode(",",$worker);
              $cat = $main_category.','.$sub_category.','.$und_sub_category;

              if($und_sub_category == '' && $sub_category == ''){
                $cat_id = $main_category;
                $cat_name_get = $this->general_model->get_category_name('cat_name','category', array('category_id' => $main_category));
              }else{
                if($und_sub_category != ''){
                  $cat_id = $und_sub_category;
                  $cat_name_get = $this->general_model->get_category_name('cat_name','category', array('category_id' => $und_sub_category));
                }else{
                  $cat_id = $sub_category;
                  $cat_name_get = $this->general_model->get_category_name('cat_name','category', array('category_id' => $sub_category));
                }
              }

              $cat_name = $cat_name_get->cat_name;
              $image = $this->upload_shop_Image($_FILES['imgupload1']['name'], 'imgupload1', 'service_image', $service_id);
                $data = array(
                    'user_id' => $uid,
                    'worker_id' => $worker_id,
                    'service_name' => $cat_name,
                    'cat_id' => $cat_id,
                    'type' => $service_type,
                    'shop_id' => $shop_type,
                    'price' => $service_price,
                    'time' => $service_time,
                    'image' => $image,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_active' => 1,
                    'is_deleted' => 0,
                );

                $updated_id = $this->general_model->update_all_services($data, 'services', array('id' => $service_id));

                if($service_id){
                  $this->session->set_flashdata('success_message', "Service updated successfully");
                    redirect('service', 'refresh');
                }else{
                    $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
                    redirect('service', 'refresh');
                }
          } else {
              $this->session->set_flashdata('error_message', "Something wents wrong!");
              redirect('service', 'refresh');
          }
        }else{
          redirect('profile', 'refresh');
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
      $config['upload_path']          = FCPATH.'assets/uploads/'.$upload_path.'/';
      $config['file_name'] 						= $temp_name;
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        $this->db->select('image');
        $this->db->from('services');
        $this->db->where('id',$shop_id);
        $count = $this->db->get()->row();
        $img = $count->image;
        $path = 'assets/uploads/'.$upload_path.'/'.$img;
        unlink($path);
        return $temp_name;
      }else{
        $this->db->select('image');
        $this->db->from('services');
        $this->db->where('id',$shop_id);
        $count = $this->db->get()->row();
        return $count->image;
      }
    }

    public function upload($service_id)
   {
    if($_FILES["files"]["name"] != '')
    {
     $output = '';
     $config["upload_path"] = FCPATH.'assets/uploads/service_image/';
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
           'shop_id' => $service_id,
           'flag' => '2',
           'image' => $data["file_name"],
           'created_at' => date('Y-m-d H:i:s'),
           'is_active' => 1,
           'is_deleted' => 0,
       );
       $inserted_id = $this->general_model->insert_shop_images($data, 'shop_images');
       $insert_data[$count] = $inserted_id;
      }
     }
     // echo '<pre>';print_r($insert_data);exit;
      echo json_encode($insert_data);
    }
   }
   public function delete_image() {
     $id = $this->input->post('img_id');

     $this->db->select('image');
     $this->db->from('shop_images');
     $this->db->where('id',$id);
     $this->db->where('flag','2');
     $count = $this->db->get()->row();
     $img = $count->image;
     $path = 'assets/uploads/service_image/'.$img;
     unlink($path);

     $this->db->where('id', $id);
     $this->db->where('flag','2');
     $this->db->delete('shop_images');

    }

    public function delete_service($id1) {
      if($id1){
        $data = array(
          'is_active' => 0,
            'is_deleted' => 1
        );
        $update_id = $this->general_model->delete_service($data, 'services', array('id' => $id1));

        $this->db->select('image');
        $this->db->from('shop_images');
        $this->db->where('shop_id',$id1);
        $this->db->where('flag', '2');
        $count = $this->db->get()->result();
        $img = $count->image;
        $path = 'assets/uploads/service_image/'.$img;
        unlink($path);

        $this->db->where('shop_id', $id1);
        $this->db->where('flag', '2');
        $this->db->delete('shop_images');

        if($update_id){
          $this->session->set_flashdata('success_message', "Service deleted successfully");
          redirect('profile', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_message', "Sorry, something went wrong. please try again");
          redirect('shop', 'refresh');
        }
      }
    }


    public function GetShopWorkerData()
    {
      $userId = $this->session->userdata('uid');
      if($this->input->post())
      {
        $shopid = $this->input->post('shopid');
        if(!empty($shopid))
        {
          $WorkersData = $this->general_model->get_all_general_data('*', 'workers', array('user_id' => $userId, 'shop_id' => $shopid,'is_deleted' => 0));

          $j=100;
          foreach ($WorkersData as $key => $worker)
          {
            $workerHtml .= '<div class="radio_list_item css_worker_div worker" style="height:auto !important;"><label for="radio10" class="col-md-12 col-xs-12"><div class="col-md-6 col-xs-12 business_hrs_inner"><span>'.$worker['name'].'</span></div><div class="col-md-6 col-xs-12 business_hrs_inner"></div></label><input type="checkbox"  name="radiog_list_worker_time[]" id="radio'.$j.'" value="'.$worker['id'].'" class="css-checkbox" /><label for="radio'.$j.'" class="css-label css-label-check"></label></div>';
            $j++;
          }
          if(!empty($workerHtml))
          {
            echo $workerHtml;exit;
          }
          else
          {
            echo "No Worker for selected shop";exit;
          }
        }
      }
    }
}
