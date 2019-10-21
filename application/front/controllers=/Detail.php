<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Detail extends MY_Controller {
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
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        $main_filter_shop_list = $this->general_model->get_service_all_data( 'services', array('services.is_deleted' => 0, 'user.u_category' => 2));
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

        $this->data['servicelist'] = $service_list;

        $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $service_list->shop_id, 'service_id' => $service_list->id,'is_deleted' => 0));
        $all_review = count($all_review_list);
        $review_list = $all_review;
        $this->data['review_list'] = $review_list;

        $this->data['title'] = 'Detail | GGG Rooms';
        $this->render('shop_detail_view');
      }
    }

    public function shop_detail($service_id) {

      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      $service_id = $this->url_decrypt($service_id);

      $map_api = $this->config->item('map_api');
      $id = $this->session->userdata('uid');
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
      $this->data['userlist'] = $user_list;

      $service_list = $this->general_model->get_service_data_id_shop_name('services', array('services.id' => $service_id, 'services.is_deleted' => 0));
      $var1 =  $this->url_encrypt($service_list->id);
      $service_list->encrypt_id = $var1;
      $var2 =  $this->url_encrypt($service_list->shop_id);
      $service_list->encrypt_shop_id = $var2;
      $this->data['servicelist'] = $service_list;
      $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $service_list->shop_id,'is_deleted' => 0));

      $all_review = count($all_review_list);
      $this->data['review_list'] = $all_review;
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
      $this->data['roundEvg'] = $roundEvg;

      $get_images = $this->general_model->get_allshop_images('*', 'shop_images', array('shop_id' => $service_list->shop_id, 'flag' => '1', 'is_deleted' => 0));
      $this->data['service_image_list'] = $get_images;
      $this->data['full_js_file'] = array(
        'https://maps.googleapis.com/maps/api/js?key='.$map_api.'&callback=initMap'
      );
      $this->data['js_file'] = array(
        "front/js/favourite.js",
        "front/js/rating.js",
        "front/js/shopDetails.js",
        "front/js/jquery.viewbox.min.js"
      );
      $this->data['css_file'] = array(
          "front/css/viewbox.css"
      );

      $data = array(
        'user_id' => $id,
        'service_id' => $service_list->id,
        'shop_id' => $service_list->shop_id
      );
      $FavData = $this->general_model->check_exist_data('id','favourite',$data);
      $heart = (!empty($FavData))  ? 'fa-heart' : 'fa-heart-o';
      $this->data['heart'] = $heart;

      $top_rated_user_list = $this->general_model->get_top_rated_user( 'rating_review', array('rating_review.is_deleted' => 0,'rating_review.shop_id' => $service_list->shop_id,'rating_review.service_id' => $service_list->id ));

      $this->data['top_rated_service_list'] = $top_rated_user_list;

      $main_shop_business_hours_list = $this->general_model->get_shop_business_hours('*', 'business_hours', array('shop_id' => $service_list->shop_id, 'is_deleted' => 0));

      $days = array();
      if(!empty($main_shop_business_hours_list)){
        foreach ($main_shop_business_hours_list as $key => $day1) {
          for ($i = 0; $i < 7; $i++) {
          $day = jddayofweek($i,1);
          $shop_business_hours_list1 = $this->general_model->get_day_by_week('*', 'business_hours', array('shop_id' => $service_list->shop_id, 'hours_day' => $day, 'is_deleted' => 0));
          $days[$i] = $shop_business_hours_list1;
          }
        }
      }else{
        for ($i = 0; $i < 7; $i++) {
        $days[$i] = '';
        }
      }

      $shop_business_hours_list = $days;
      $this->data['shop_business_hours_list'] = $shop_business_hours_list;

      // Related Services
      $main_filter_shop_list = $this->general_model->get_related_services('services', array('services.id !=' => $service_id, 'services.cat_id' => $service_list->cat_id, 'services.is_deleted' => 0, 'user.u_category' => 2));

      $related_service_list = [];
      foreach ($main_filter_shop_list as $key => $value) {
        $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

        if(!empty($main_services)){
            $related_service_list[] = $main_services;
        }
      }

      foreach ($related_service_list as $key => $services) {
        $var =  $this->url_encrypt($services->id);
        $related_service_list[$key]->encrypt_id = $var;
      }
      foreach ($related_service_list as $key => $value) {
        if($value->parent_id != 0){
          $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
          $related_service_list[$key]->sub_category = $cat_list1;
          if($cat_list1->cat_parent_id != 0){
            $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
            $related_service_list[$key]->und_sub_category = $cat_list2;
          }
        }

        $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));
        $all_review = count($all_review_list);
        $related_service_list[$key]->review_list = $all_review;
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
        $related_service_list[$key]->ratingRound = $roundEvg;
      }
      $this->data['related_service_list'] = $related_service_list;

      // Other services
      $main_filter_shop_list1 = $this->general_model->get_other_services('services', array('services.id !=' => $service_id, 'services.shop_id' => $service_list->shop_id, 'services.is_deleted' => 0, 'user.u_category' => 2));
      $other_service_list = [];
      foreach ($main_filter_shop_list1 as $key => $value) {
        $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0, 'user.u_category' => 2));

        if(!empty($main_services)){
            $other_service_list[] = $main_services;
        }
      }

      foreach ($other_service_list as $key => $value) {
        $var =  $this->url_encrypt($value->id);
        $other_service_list[$key]->encrypt_id = $var;
        $var2 =  $this->url_encrypt($value->shop_id);
        $other_service_list[$key]->encrypt_shop_id = $var2;

        if($value->parent_id != 0){
          $cat_list1 = $this->general_model->get_service_category1( 'category', array('category_id' => $value->parent_id));
          $other_service_list[$key]->sub_category = $cat_list1;
          if($cat_list1->cat_parent_id != 0){
            $cat_list2 = $this->general_model->get_service_category1( 'category', array('category_id' => $cat_list1->cat_parent_id));
            $other_service_list[$key]->und_sub_category = $cat_list2;
          }
        }
        $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('shop_id' => $value->shop_id, 'service_id' => $value->id,'is_deleted' => 0));
        $all_review = count($all_review_list);
        $other_service_list[$key]->review_list = $all_review;

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
        $other_service_list[$key]->ratingRound = $roundEvg;
      }
      $this->data['other_service_list'] = $other_service_list;

      $this->data['title'] = 'Detail | GGG Rooms';
      $this->render('shop_detail_view');
    // }
  }

  public function GetShops_map()
  {
    $shop_id = $this->input->post('shop_id');
    $whereArray = array('shop.id'=>$shop_id, 'shop.is_active'=>1,'shop.is_deleted'=>0,'shop.latitude !=' => "",'shop.longitude !=' => "");
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
}
