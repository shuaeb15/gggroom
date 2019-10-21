
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Favourite extends MY_Controller {
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

      $userId = $this->session->userdata('uid');
      // echo $userId;exit;
      if(!empty($userId))
      {
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $userId, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;

        $this->data['js_file'] = array(
            "front/js/favourite.js"
        );
        $this->data['title'] = 'Favourite | GGG Rooms';
        $this->data['UserId'] = $id;
        $this->render('favourite_view');
      }
      else
      {
        redirect(site_url());
      }
    }

    public function AddToFav()
    {
      $userId = $this->session->userdata('uid');
      // echo "<pre>"; print_r($_POST);exit;
      if($this->input->post())
      {
        $shopid = $this->input->post('shopid');
        $serviceid = $this->input->post('serviceid');
        if(!empty($userId))
        {
          $data = array(
            'user_id' => $userId,
            'service_id' => $serviceid,
            'shop_id' => $shopid
          );
          $FavData = $this->general_model->check_exist_data('id','favourite',$data);
          if(empty($FavData))
          {
            if($this->general_model->create_general_data($data,'favourite'))
            {
              echo "1";exit;
            }
            else
            {
              echo "0";exit;
            }
          }
          else
          {
            if($this->general_model->delete_physical_data(array('id'=>$FavData->id),'favourite'))
            {
              echo "1";exit;
            }
            else
            {
              echo "0";exit;
            }
          }
        }
        else
        {
          $this->session->set_flashdata('success_message', 'Please login and continue');
          $_SESSION['fav_shopid']      = $shopid;
          $_SESSION['fav_serviceid']   = $serviceid;
          echo "2";exit;
        }
      }
    }

    public function favourite_data(){

     $userId = $this->session->userdata('uid');
     $start =  $this->input->post('start');

     $count_data = $this->general_model->GetUserFavouriteData1(array('services.is_deleted' => 0,'fv.user_id'=>$userId));
     $limit = count($count_data);

     $main_filter_shop_list = $this->general_model->GetUserFavouriteData(array('services.is_deleted' => 0,'fv.user_id'=>$userId), $limit, $start);

     $check_worker_service = $start;
     $total_worker_service = 0;
     $service_list = [];
     foreach ($main_filter_shop_list as $key => $value) {
       $main_services = $this->general_model->get_service_data_by_worker_shopid( 'services', array('services.id' => $value->id, 'services.shop_id' => $value->shop_id,'workers.shop_id' => $value->shop_id, 'services.is_deleted' => 0, 'workers.is_deleted' => 0, 'shop.is_deleted' => 0));

       if(count($service_list) <= 2){
           $check_worker_service++;
       }
       if(!empty($main_services)){
         $total_worker_service++;
         if(count($service_list) <= 2){
             $service_list[] = $main_services;
         }
       }
     }
     foreach ($service_list as $key => $value) {
       $var =  $this->url_encrypt($value->id);
       $service_list[$key]->encrypt_id = $var;

       $var2 =  $this->url_encrypt($value->shop_id);
       $service_list[$key]->encrypt_shop_id = $var2;

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
     }
     // echo json_encode($service_list);
     echo json_encode(array('service_list' => $service_list, 'all_service' => $total_worker_service));
     }
}
