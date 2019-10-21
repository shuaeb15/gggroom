<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Home extends MY_Controller {
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
      $map_api = $this->config->item('map_api');
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        if(!empty($_SESSION['fav_shopid']) && !empty($_SESSION['fav_serviceid']))
        {
          $Fav_data = array(
            'user_id' => $id,
            'service_id' => $_SESSION['fav_serviceid'],
            'shop_id' => $_SESSION['fav_shopid']
          );
          $FavData = $this->general_model->check_exist_data('id','favourite',$Fav_data);
          if(empty($FavData))
          {
            $this->general_model->create_general_data($Fav_data,'favourite');
          }
          $_SESSION['fav_shopid']      = "";
          $_SESSION['fav_serviceid']   = "";
        }

        $main_filter_shop_list = $this->general_model->get_services_data( 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), 4, 0);
        $service_list = [];
        foreach ($main_filter_shop_list as $key => $value) {
          $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

          if(!empty($main_services)){
              $service_list[] = $main_services;
          }
        }

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
        }
        $this->data['servicelist'] = $service_list;

        $top_rated_services = $this->general_model->get_top_rated_services( 'rating_review', array('rating_review.is_deleted' => 0, 'services.is_deleted' => 0, 'user.u_category' => 2));

        $top_rated_service_list_nonUnique = [];
        foreach ($top_rated_services as $key => $value) {
          $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->service_id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

          if(!empty($main_services)){
              $top_rated_service_list_nonUnique[] = $main_services;
          }
        }
         $top_rated_service_list = $this->unique_multidim_array($top_rated_service_list_nonUnique,'service_id','shop_id');

        foreach ($top_rated_service_list as $key => $value) {
          $var =  $this->url_encrypt($value->id);
          $top_rated_service_list[$key]->encrypt_id = $var;

          if($value->parent_id != 0){
            $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
            $top_rated_service_list[$key]->sub_category = $cat_list1;
            if($cat_list1->cat_parent_id != 0){
              $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
              $top_rated_service_list[$key]->und_sub_category = $cat_list2;
            }
          }
          $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));
          $all_review = count($all_review_list);
          $top_rated_service_list[$key]->review_list = $all_review;
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
          $top_rated_service_list[$key]->ratingRound = $roundEvg;
          $data = array(
            'user_id' => $id,
            'service_id' => $value->id,
            'shop_id' => $value->shop_id
          );
          $FavData = $this->general_model->check_exist_data('id','favourite',$data);
          $fav = !empty($FavData) ? "1" : "0";
          $top_rated_service_list[$key]->fav = $fav;
        }
        // echo '<pre>';print_r($top_rated_service_list);exit;
        $this->data['top_rated_service_list'] = $top_rated_service_list;

        $filter_service_list = $this->general_model->get_filter_service_data( 'services', array('is_deleted' => 0));
        $this->data['filter_service_list'] = $filter_service_list;

        $filter_shop_list = $this->general_model->get_filter_shop_data( 'shop', array('is_deleted' => 0));
        $this->data['filter_shop_list'] = $filter_shop_list;

        $this->data['title'] = 'Home | GGG Rooms';

        $this->data['full_js_file'] = array(
            'https://maps.googleapis.com/maps/api/js?key='.$map_api.'&callback=initMap'
         );
        $this->data['js_file'] = array(
            "front/js/favourite.js",
            "front/js/bootstrap-datetimepicker.min.js",
            "front/js/home.js"
        );
        $this->data['css_file'] = array(
            "front/css/bootstrap-datetimepicker.min.css"
        );
        $this->data['UserId'] = $id;

        $userid = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $userid, 'is_deleted' => 0));

        $this->render('home_view');
        $this->check_apoointment_date();
    }

    //send reminder email
    public function check_apoointment_time(){
      $ap_data = $this->general_model->get_all_appointment_data('id,ap_date,from_time', 'appointment', array('booking_status' => 1,'is_deleted' => 0));

      $current_date = date("Y-m-d");
      $c_time = date("H:i");

      foreach ($ap_data as $key => $date) {
        $ap_id = $date->id;
        $date_to_compare = date($date->ap_date);
        $current_time = date("H:i", strtotime($date->from_time));
        $timestamp = strtotime($current_time) - 60*120;
        $time = date('H:i', $timestamp);

        if (strtotime($date_to_compare) == strtotime($current_date)) {
          if($c_time == $time){
            $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('id' => $ap_id));
            $emailsend = $this->general_model->send_reminder_email_appointment($email_data);
          }
        }
      }
    }

    public function check_apoointment_date(){
      $ap_data = $this->general_model->get_all_appointment_data('id,ap_date', 'appointment', array('booking_status' => 1));
      $current_date = date("Y-m-d");

      foreach ($ap_data as $key => $date) {
        $ap_id = $date->id;
        $date_to_compare = date($date->ap_date);
        if (strtotime($date_to_compare) < strtotime($current_date)) {
          $data = array(
              'booking_status' => 2
          );
          $updated_id = $this->general_model->update_appointment_status($data, 'appointment', array('id' => $ap_id));
        }
      }
    }

    public function filter_services(){

      $total_all_services =  $this->input->post('total_all_services');
      $start = $total_all_services;
      $filter_location_name =  $this->input->post('filter_location');
      if($filter_location_name != ''){
        $city_name = $this->general_model->get_page_data_id('id', 'city', array('name' => $filter_location_name, 'is_deleted' => 0));
        $filter_location = $city_name->id;
      }else{
        $filter_location = '';
      }
      $filter_services =  $this->input->post('filter_services');
      $filter_shops =  $this->input->post('filter_shops');
      $filter_sorting =  $this->input->post('filter_sorting');
      $filter_date =  $this->input->post('filter_date');
      $filter_min_price =  $this->input->post('filter_min_price');
      $filter_max_price =  $this->input->post('filter_max_price');

      if($filter_date == ''){
          $main_date = '';
      }
      else{
        $parts = explode('-', $filter_date);
        $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
        $main_date = date("Y-m-d", strtotime($f_worker_date));
      }

      if($filter_shops != '' && $filter_services == '' && $filter_sorting == '' && $main_date == '' && $filter_min_price == '' && $filter_max_price == '' && $filter_location == ''){
        $all_main_filter_shop_list = $this->general_model->get_filter_data_shop_list( 'shop', array('id'=>$filter_shops, 'is_deleted' => 0));
      }else{
        $all_main_filter_shop_list = $this->general_model->get_filter_data_all_list( 'services', array('services.is_deleted' => 0), $filter_services,$filter_shops, $filter_sorting, $main_date, $filter_min_price, $filter_max_price, $filter_location);
      }

      $check_worker_service = $start;
      $start_rec = $start;

      $filter_data1 = $this->general_model->get_filter_data_list_main('services', array('services.is_deleted' => 0, 'user.u_category' => 2), $filter_services,$filter_shops, $filter_sorting, $main_date, $filter_min_price, $filter_max_price, $filter_location);
      $limit = count($filter_data1);
      $all_total_services = count($filter_data1);

      $main_filter_shop_list = $this->general_model->get_filter_data_list('services', array('services.is_deleted' => 0, 'user.u_category' => 2), $filter_services,$filter_shops, $filter_sorting, $main_date, $filter_min_price, $filter_max_price, $filter_location, $limit, $start_rec);

      $filter_shop_list = [];
      $total_worker_service = 0;
      foreach ($main_filter_shop_list as $key => $value) {
        $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

        if(count($filter_shop_list) <= 3){
            $check_worker_service++;
        }
        if(!empty($main_services)){
          $total_worker_service++;
          if(count($filter_shop_list) <= 3){
              $filter_shop_list[] = $main_services;
          }
        }
      }
      foreach ($filter_shop_list as $key => $services) {
        $var =  $this->url_encrypt($services->id);
        $filter_shop_list[$key]->encrypt_id = $var;
        $var2 =  $this->url_encrypt($services->shop_id);
        $filter_shop_list[$key]->encrypt_shop_id = $var2;

        $img =  $services->image;
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

        $filter_shop_list[$key]->main_image = $main_image;
      }

      // echo '<pre>';print_r($filter_shop_list);exit;
      $id = $this->session->userdata('uid');

      foreach ($filter_shop_list as $key => $value) {
        if($value->parent_id != 0){
          $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
          $filter_shop_list[$key]->sub_category = $cat_list1;
          if($cat_list1->cat_parent_id != 0){
            $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
            $filter_shop_list[$key]->und_sub_category = $cat_list2;
          }
        }

        $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));

        $all_review = count($all_review_list);
        $filter_shop_list[$key]->review_list = $all_review;
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
        // echo $sum;exit;
        $filter_shop_list[$key]->ratingRound = $roundEvg;

        $data = array(
          'user_id' => $id,
          'service_id' => $value->id,
          'shop_id' => $value->shop_id
        );
        $FavData = $this->general_model->check_exist_data('id','favourite',$data);
        $fav = !empty($FavData) ? "1" : "0";
        $filter_shop_list[$key]->fav = $fav;
        $filter_shop_list[$key]->UserId = $id;
      }
      // echo '<pre>';print_r($filter_shop_list);exit;
      if(!empty($filter_location))
      {
        $where_like = 'city LIKE "%'.$filter_location.'%" AND is_active = "1" AND is_deleted = "0"';
        $shopData = $this->general_model->check_exist_data('shop.*','shop',$where_like);
      }
      else
      {
        $shopData = "";
      }
      // $location['latitude'] = (isset($shopData->latitude) && !empty($shopData->latitude) ? $shopData->latitude : "" );
      // $location['longitude'] = (isset($shopData->longitude) && !empty($shopData->longitude) ? $shopData->longitude : "" );

      //shop_list
      $shop_New_Arr = [];
      foreach ($all_main_filter_shop_list as $key => $value) {
        $whereArray = array('shop.is_active'=>1,'shop.is_deleted'=>0,'shop.latitude !=' => "",'shop.longitude !=' => "", 'shop.id'=>$value->shop_id);
        $ShopData = $this->general_model->get_shop_list_data('shop',$whereArray);

        $main_shop_id =  $this->url_encrypt($ShopData[0]->id);
        $main_url = site_url().'shop/services/'.$main_shop_id;
        $address = '<a href="'.$main_url.'" style="font-size: 18px;font-weight:500;cursor:pointer;">'.$ShopData[0]->shop_name.'</a><br/><label style="font-weight:bolder;text-transform:capitalize;">'.$ShopData[0]->addline1.', '.$ShopData[0]->city_name.', '.$ShopData[0]->state_name.', '.$ShopData[0]->zipcode.'</label>';

        $shop_New_Arr[] = array('lat'=>$ShopData[0]->latitude,'lng'=>$ShopData[0]->longitude,'description'=>$address);
      }
     echo json_encode(array('services_list' => $filter_shop_list,'shop_list' => $shop_New_Arr,'total_services' => $check_worker_service, 'all_total_services' => $all_total_services, 'total_worker_service' => $total_worker_service));
      // echo json_encode($filter_shop_list).'||'.json_encode($location);
    }

    public function filter_reset(){
      $id = $this->session->userdata('uid');

      $latitudeFrom = $this->input->post('lattitude');
      $longitudeFrom =  $this->input->post('longitude');

      $shop_list = $this->general_model->get_all_shop_data( 'shop', array('is_deleted' => 0));

      $New_Arr = [];
      foreach ($shop_list as $key => $value) {
        $latitudeTo = $value->latitude;
        $longitudeTo = $value->longitude;

        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $distance = ($miles * 1.609344);
        if($distance <= 100)
        {
            $New_Arr[]=$value->id;
        }
      }
      if(empty($New_Arr)){
        $New_Arr = '';
      }
      // $main_filter_shop_list = $this->general_model->get_service_by_shop_id($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), 4, 0);

      $filter_data1 = $this->general_model->get_service_by_shop_id_all($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2));
      $limit = count($filter_data1);
      $all_total_services = count($filter_data1);

      $main_filter_shop_list = $this->general_model->get_service_by_shop_id($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), $limit, 0);

      $check_worker_service = 0;
      $total_worker_service = 0;
      $filter_shop_list = [];
      foreach ($main_filter_shop_list as $key => $value) {
        $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

        if(count($filter_shop_list) <= 3){
            $check_worker_service++;
        }
        if(!empty($main_services)){
          $total_worker_service++;
          if(count($filter_shop_list) <= 3){
              $filter_shop_list[] = $main_services;
          }
        }
      }

      foreach ($filter_shop_list as $key => $services) {
        $var =  $this->url_encrypt($services->id);
        $filter_shop_list[$key]->encrypt_id = $var;
        $var2 =  $this->url_encrypt($services->shop_id);
        $filter_shop_list[$key]->encrypt_shop_id = $var2;

        $img =  $services->image;
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

        $filter_shop_list[$key]->main_image = $main_image;
      }

      foreach ($filter_shop_list as $key => $value) {
        if($value->parent_id != 0){
          $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
          $filter_shop_list[$key]->sub_category = $cat_list1;
          if($cat_list1->cat_parent_id != 0){
            $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
            $filter_shop_list[$key]->und_sub_category = $cat_list2;
          }
        }

        $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));
        // $all_review = count($all_review_list);
        // $filter_shop_list[$key]->review_list = $all_review;

        $all_review = count($all_review_list);
        $filter_shop_list[$key]->review_list = $all_review;
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
        $filter_shop_list[$key]->ratingRound = $roundEvg;

        $data = array(
          'user_id' => $id,
          'service_id' => $value->id,
          'shop_id' => $value->shop_id
        );
        $FavData = $this->general_model->check_exist_data('id','favourite',$data);
        $fav = !empty($FavData) ? "1" : "0";
        $filter_shop_list[$key]->fav = $fav;
        $filter_shop_list[$key]->UserId = $id;
      }

      //shop_list
      $whereArray = array('shop.is_active'=>1,'shop.is_deleted'=>0,'shop.latitude !=' => "",'shop.longitude !=' => "");
      $ShopData = $this->general_model->get_shop_list_data('shop',$whereArray);

      $shop_New_Arr = [];
      foreach ($ShopData as $key => $value) {
        $latitudeTo = $value->latitude;
        $longitudeTo = $value->longitude;

        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $distance = ($miles * 1.609344);
        if($distance <= 100)
        {
          $main_shop_id =  $this->url_encrypt($value->id);
          $main_url = site_url().'shop/services/'.$main_shop_id;
          $address = '<a href="'.$main_url.'" style="font-size: 18px;font-weight:500;cursor:pointer;">'.$value->shop_name.'</a><br/><label style="font-weight:bolder;text-transform:capitalize;">'.$value->addline1.', '.$value->city_name.', '.$value->state_name.', '.$value->zipcode.'</label>';

          $shop_New_Arr[] = array('lat'=>$value->latitude,'lng'=>$value->longitude,'description'=>$address);
        }
      }
     echo json_encode(array('services_list' => $filter_shop_list,'shop_list' => $shop_New_Arr,'total_services' => $check_worker_service, 'all_total_services' => $all_total_services, 'total_worker_service' => $total_worker_service));
    }

    public function GetSearchData()
    {
      if($this->input->post())
      {
        $term = $this->input->post('term');
        // $array = "services.is_deleted = 0 AND (services.service_name LIKE '%".$term."%' OR shop.shop_name LIKE '%".$term."%')";
        // $service_list = $this->general_model->get_services_data( 'services', $array, 4, 0);
        // category
        /*$cat_where = "is_deleted = 0 AND cat_name LIKE '%".$term."%'";
        $cat_list = $this->general_model->get_all_general_data('category_id as id,cat_name as searchName','category',$cat_where,'result_array','','','cat_name');*/
        // services
        $service_where = "is_deleted = 0 AND is_active = 1 AND service_name LIKE '%".$term."%'";
        $service_list = $this->general_model->get_all_general_data('id,service_name as searchName','services',$service_where,'result_array','','','service_name');
        // shops
        $shop_where = "is_deleted = 0 AND is_active = 1 AND shop_name LIKE '%".$term."%'";
        $shop_list = $this->general_model->get_all_general_data('id,shop_name as searchName','shop',$shop_where,'result_array','','','shop_name');

        $searchData = array_merge($shop_list,$service_list);
        foreach ($searchData as $value) {
          $data[] = array('value' => $value['searchName'] , 'id' => $value['id']);
        }

        echo json_encode($data);
        // echo $this->db->last_query();exit;
      }
    }

    function unique_multidim_array($array, $key, $key2) {

      $temp_array = array();
      $i = 0;
      $key_array = array();
      // echo "<pre>";print_r($array);exit;
      foreach($array as $val) {
          if (!in_array($val->$key, $key_array) && !in_array($val->$key2, $key_array)) {
              $key_array[$i] = $val->$key;
              $key_array[$i] = $val->$key2;
              $temp_array[$i] = $val;
          }
          $i++;
      }
      // echo "<pre>";print_r($temp_array);exit;
      return $temp_array;
    }

    // public function GetAllcityname()
    // {
    //   $term = $this->input->post('term');
    //   $array = "shop.is_deleted = 0 AND (shop.city LIKE '%".$term."%')";
    //   $ShopData = $this->general_model->get_all_city_name('city,id','shop', $array);
    //   foreach ($ShopData as $value) {
    //     $data[] = array('value' => $value->city, 'id' => $value->id);
    //   }
    //   echo json_encode($data);
    // }

    public function searchresults(){
      $id = $this->session->userdata('uid');
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
      $this->data['userlist'] = $user_list;

      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      $search = $this->input->get('search');
      $search = addslashes($search);
      // if(!empty($search))
      // {
        $shop_array = "shop.is_deleted = 0 AND (shop.shop_name LIKE '%".$search."%')";
        $shop_list = $this->general_model->search_shop_get_data( 'shop', $shop_array, 4, 0);
        foreach ($shop_list as $key => $shop) {
          $var =  $this->url_encrypt($shop->id);
          $shop_list[$key]->shop_id = $var;

          $img =  $shop->image;
          $temp_file = base_url()."front/images/banner.jpg";
          $main_file = "assets/uploads/shop/".$img;
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

          $shop_list[$key]->main_image = $main_image;
        }
        $shop_list1 = $this->general_model->search_shop_get_data1( 'shop', $shop_array);
        // echo $this->db->last_query();exit;
        $count_shop = count($shop_list1);
        $this->data['count_shop'] = $count_shop;
        $this->data['shop_list'] = $shop_list;

        $service_array = "services.is_deleted = 0 AND user.u_category = 2 AND (services.service_name LIKE '%".$search."%')";
        $filter_data1 = $this->general_model->search_service_get_data1( 'services', $service_array);
        $limit = count($filter_data1);

        $main_filter_shop_list = $this->general_model->search_service_get_data( 'services', $service_array, $limit, 0);
        // echo '<pre>';print_r($main_filter_shop_list);exit;
        $service_list = [];
        $check_worker_service = 0;
        foreach ($main_filter_shop_list as $key => $value) {
          $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));
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

        $main_filter_shop_list1 = $this->general_model->search_service_get_data1( 'services', $service_array);
        $service_list1 = [];
        foreach ($main_filter_shop_list1 as $key => $value) {
          $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

          if(!empty($main_services)){
              $service_list1[] = $main_services;
          }
        }

        $count_service = count($service_list1);
        $this->data['count_service'] = $count_service;
        $this->data['check_worker_service'] = $check_worker_service;
        $this->data['servicelist'] = $service_list;

      // }
      $this->data['js_file'] = array(
          "front/js/favourite.js",
      );
      // echo '<pre>';print_r($service_list);exit;
      $this->data['search_result'] = $search;
      $this->data['title'] = 'Search Result | GGG Rooms';
      $this->render('search_details');
      // }

    }

    public function search_shop_data(){

        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        $search = $this->input->post('search_result');
        $start =  $this->input->post('data_limit');
        $search = addslashes($search);
        $count_data = $start;

        $shop_array = "shop.is_deleted = 0 AND (shop.shop_name LIKE '%".$search."%')";
        $shop_result = $this->general_model->search_shop_get_data_all( 'shop', $shop_array);
        $total_shop_result = count($shop_result);

        $shop_list = $this->general_model->search_shop_get_data( 'shop', $shop_array, 4, $start);
        foreach ($shop_list as $key => $shop) {
          $count_data++;
          $var =  $this->url_encrypt($shop->id);
          $shop_list[$key]->shop_id = $var;

          $img =  $shop->image;
          $temp_file = base_url()."front/images/banner.jpg";
          $main_file = "assets/uploads/shop/".$img;
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

          $shop_list[$key]->main_image = $main_image;
          $shop_list[$key]->total_shop_result = $total_shop_result;
        }
        $shop_list[0]->count_data = $count_data;
        echo json_encode($shop_list);
      }

      public function search_services_data(){

          $id = $this->session->userdata('uid');
          $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
          $this->data['userlist'] = $user_list;

          $search = $this->input->post('search_result');
          $start =  $this->input->post('data_limit');
          $search = addslashes($search);

          $service_array = "services.is_deleted = 0 AND user.u_category = 2 AND (services.service_name LIKE '%".$search."%')";
          $main_filter_shop_list1 = $this->general_model->search_service_get_data1( 'services', $service_array);
          $limit = count($main_filter_shop_list1);
          $$total_service_result = count($main_filter_shop_list1);

          $main_filter_shop_list = $this->general_model->search_service_get_data( 'services', $service_array, $limit, $start);

          $service_list = [];
          $check_worker_service = $start;
          foreach ($main_filter_shop_list as $key => $value) {
            $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));
            if(count($service_list) <= 3){
                $check_worker_service++;
            }
            if(!empty($main_services)){
              if(count($service_list) <= 3){
                  $service_list[] = $main_services;
              }
            }
          }

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
            $service_list[$key]->check_worker_service = $check_worker_service;
            $service_list[$key]->total_service_result = $$total_service_result;
            $service_list[$key]->count_result = $check_worker_service;
          }
          echo json_encode($service_list);
        }

        public function get_user_nearest_services(){
            $start = $this->input->post('total_all_services');
            $latitudeFrom = $this->input->post('lattitude');
            $longitudeFrom =  $this->input->post('longitude');

            $id = $this->session->userdata('uid');
            $shop_list = $this->general_model->get_all_shop_data( 'shop', array('is_deleted' => 0));
            $New_Arr = [];
            foreach ($shop_list as $key => $value) {

              $latitudeTo = $value->latitude;
              $longitudeTo = $value->longitude;

              $theta = $longitudeFrom - $longitudeTo;
              $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
              $dist = acos($dist);
              $dist = rad2deg($dist);
              $miles = $dist * 60 * 1.1515;

              $distance = ($miles * 1.609344);
              if($distance <= 100)
              {
                  $New_Arr[]=$value->id;
              }
            }
            if(empty($New_Arr)){
              $New_Arr = '';
            }
            // $main_filter_shop_list = $this->general_model->get_service_by_shop_id($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), 4, 0);

            $filter_data1 = $this->general_model->get_service_by_shop_id_all($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2));
            $limit = count($filter_data1);
            $all_total_services = count($filter_data1);

            $main_filter_shop_list = $this->general_model->get_service_by_shop_id($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), $limit, $start);

            $service_list = [];
            $total_worker_service = 0;
            $check_worker_service = $start;
            foreach ($main_filter_shop_list as $key => $value) {
              $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

              if(count($service_list) <= 3){
                  $check_worker_service++;
              }
              if(!empty($main_services)){
                $total_worker_service++;
                if(count($service_list) <= 3){
                    $service_list[] = $main_services;
                }
              }
            }

            foreach ($service_list as $key => $services) {
              $var =  $this->url_encrypt($services->id);
              $service_list[$key]->encrypt_id = $var;
              $var2 =  $this->url_encrypt($services->shop_id);
              $service_list[$key]->encrypt_shop_id = $var2;

              $img =  $services->image;
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
               }

               //shop_list
               $whereArray = array('shop.is_active'=>1,'shop.is_deleted'=>0,'shop.latitude !=' => "",'shop.longitude !=' => "");
               $ShopData = $this->general_model->get_shop_list_data('shop',$whereArray);

               $shop_New_Arr = [];
               foreach ($ShopData as $key => $value) {
                 $latitudeTo = $value->latitude;
                 $longitudeTo = $value->longitude;

                 $theta = $longitudeFrom - $longitudeTo;
                 $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
                 $dist = acos($dist);
                 $dist = rad2deg($dist);
                 $miles = $dist * 60 * 1.1515;

                 $distance = ($miles * 1.609344);
                 if($distance <= 100)
                 {
                   $main_shop_id =  $this->url_encrypt($value->id);
                   $main_url = site_url().'shop/services/'.$main_shop_id;
                   $address = '<a href="'.$main_url.'" style="font-size: 18px;font-weight:500;cursor:pointer;">'.$value->shop_name.'</a><br/><label style="font-weight:bolder;text-transform:capitalize;">'.$value->addline1.', '.$value->city_name.', '.$value->state_name.', '.$value->zipcode.'</label>';

                   $shop_New_Arr[] = array('lat'=>$value->latitude,'lng'=>$value->longitude,'description'=>$address);
                 }
               }

            echo json_encode(array('services_list' => $service_list,'shop_list' => $shop_New_Arr,'total_services' => $check_worker_service, 'all_total_services' => $all_total_services, 'total_worker_service' => $total_worker_service));

          }

          public function filter_services1(){
            $total_all_services =  $this->input->post('total_all_services');
            $start = $total_all_services;
            $filter_location =  $this->input->post('filter_location');
            $filter_services =  $this->input->post('filter_services');
            $filter_shops =  $this->input->post('filter_shops');
            $filter_sorting =  $this->input->post('filter_sorting');
            $filter_date =  $this->input->post('filter_date');
            $filter_min_price =  $this->input->post('filter_min_price');
            $filter_max_price =  $this->input->post('filter_max_price');
            $id = $this->session->userdata('uid');

            if($filter_date == ''){
                $main_date = '';
            }
            else{
              $parts = explode('-', $filter_date);
              $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
              $main_date = date("Y-m-d", strtotime($f_worker_date));
            }

            $latitudeFrom = $this->input->post('lattitude');
            $longitudeFrom =  $this->input->post('longitude');
            $shop_list = $this->general_model->get_all_shop_data( 'shop', array('is_deleted' => 0));

            $New_Arr = [];
            foreach ($shop_list as $key => $value) {
              $latitudeTo = $value->latitude;
              $longitudeTo = $value->longitude;

              $theta = $longitudeFrom - $longitudeTo;
              $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
              $dist = acos($dist);
              $dist = rad2deg($dist);
              $miles = $dist * 60 * 1.1515;
              $distance = ($miles * 1.609344);
              if($distance <= 100)
              {
                  $New_Arr[]=$value->id;
              }
            }
            if(empty($New_Arr)){
              $New_Arr = '';
            }

            $main_filter_shop_list1 = $this->general_model->get_filter_data_list_all($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), $filter_services,$filter_shops, $filter_sorting, $main_date, $filter_min_price, $filter_max_price, $filter_location);
            $limit = count($main_filter_shop_list1);
            $all_total_services = count($main_filter_shop_list1);

            $main_filter_shop_list = $this->general_model->get_filter_data_list1($New_Arr, 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), $filter_services,$filter_shops, $filter_sorting, $main_date, $filter_min_price, $filter_max_price, $filter_location, $limit, $start);

            $check_worker_service = $start;
            $total_worker_service = 0;
            $filter_shop_list = [];
            foreach ($main_filter_shop_list as $key => $value) {
              $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

              if(count($filter_shop_list) <= 3){
                  $check_worker_service++;
              }
              if(!empty($main_services)){
                $total_worker_service++;
                if(count($filter_shop_list) <= 3){
                    $filter_shop_list[] = $main_services;
                }
              }
            }

            foreach ($filter_shop_list as $key => $services) {
              $var =  $this->url_encrypt($services->id);
              $filter_shop_list[$key]->encrypt_id = $var;

              $img =  $services->image;
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
              $filter_shop_list[$key]->main_image = $main_image;
            }

            foreach ($filter_shop_list as $key => $value) {
              if($value->parent_id != 0){
                $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
                $filter_shop_list[$key]->sub_category = $cat_list1;
                if($cat_list1->cat_parent_id != 0){
                  $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
                  $filter_shop_list[$key]->und_sub_category = $cat_list2;
                }
              }

              $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));

              $all_review = count($all_review_list);
              $filter_shop_list[$key]->review_list = $all_review;
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
              $filter_shop_list[$key]->ratingRound = $roundEvg;

              $data = array(
                'user_id' => $id,
                'service_id' => $value->id,
                'shop_id' => $value->shop_id
              );
              $FavData = $this->general_model->check_exist_data('id','favourite',$data);
              $fav = !empty($FavData) ? "1" : "0";
              $filter_shop_list[$key]->fav = $fav;
              $filter_shop_list[$key]->UserId = $id;
            }

            //shop_list
            $whereArray = array('shop.is_active'=>1,'shop.is_deleted'=>0,'shop.latitude !=' => "",'shop.longitude !=' => "");
            $ShopData = $this->general_model->get_shop_list_data('shop',$whereArray);

            $shop_New_Arr = [];
            foreach ($ShopData as $key => $value) {
              $latitudeTo = $value->latitude;
              $longitudeTo = $value->longitude;

              $theta = $longitudeFrom - $longitudeTo;
              $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
              $dist = acos($dist);
              $dist = rad2deg($dist);
              $miles = $dist * 60 * 1.1515;

              $distance = ($miles * 1.609344);
              if($distance <= 100)
              {
                $main_shop_id =  $this->url_encrypt($value->id);
                $main_url = site_url().'shop/services/'.$main_shop_id;
                $address = '<a href="'.$main_url.'" style="font-size: 18px;font-weight:500;cursor:pointer;">'.$value->shop_name.'</a><br/><label style="font-weight:bolder;text-transform:capitalize;">'.$value->addline1.', '.$value->city_name.', '.$value->state_name.', '.$value->zipcode.'</label>';

                $shop_New_Arr[] = array('lat'=>$value->latitude,'lng'=>$value->longitude,'description'=>$address);
              }
            }
            echo json_encode(array('services_list' => $filter_shop_list,'shop_list' => $shop_New_Arr,'total_services' => $check_worker_service, 'all_total_services' => $all_total_services, 'total_worker_service' => $total_worker_service));
            // echo json_encode($filter_shop_list);
            // echo json_encode($filter_shop_list).'||'.json_encode($location);
          }

          public function page($page_url){
              $id = $this->session->userdata('uid');
              $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
              $this->data['userlist'] = $user_list;

              $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
              $this->data['footer_pages1'] = $footer_pages1;

              $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
              $this->data['footer_pages2'] = $footer_pages2;

              $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
              $this->data['footer_pages3'] = $footer_pages3;

              $page_data = $this->general_model->get_page_data_id('*', 'page', array('page_url' => $page_url));
              $this->data['page_data'] = $page_data;
              $this->data['title'] = ucfirst($page_data->title).' | GGG Rooms';
              $this->render('page_view');

          }

}
