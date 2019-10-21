
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Booking extends MY_Controller {
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
        $start = 0;
        // echo "<pre>"; print_r($this->session->userdata('uid'));exit;
        // $past_booking_data = $this->general_model->get_order_booking_data('*', 'appointment', array('user_id'=>$this->session->userdata('uid'), 'booking_status' => 2, 'is_deleted' => 0));

       $usertype = $this->session->userdata('usertype'); 
       // print_r($this->session->userdata('email')); 

       $query = $this->db->get_where('workers', array('email' =>$this->session->userdata('email')));
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

        $this->data['title'] = 'Booking | GGG Rooms';
        $this->data['js_file'] = array(
            "front/js/favourite.js",
            "front/js/rating.js",
      );
        $this->render('booking_view');
      }
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
                $html .= '<div class="button_link col-md-3"><a href="'.site_url().'appointment/appointment_step1/'.$encrypt_shop_id.'/'.$encrypt_id.'">BOOK AGAIN</a></div><div class="button_link col-md-3"><a href="void:javascript(0)" class="btn_call_us" data-shop-mobile="'.$appointment->shop_mobile.'">CALL US</a></div>';
              }
              if($appointment->booking_status == 1 || $appointment->booking_status == 0 && $appointment->ap_date >= $todaysdate){
                $html .= '<div class="col-md-3 button_link cancel_ap col-md-3'.$appointment->id.'"><a href="void:javascript(0)" class="btn_cancel" data-appointment-id="'.$appointment->id.'">CANCEL</a></div>';
              }
               if($appointment->booking_status == 0 && $appointment->ap_date >= $todaysdate){
                $html .= '<div class="col-md-3 button_link confirm_ap col-md-3'.$appointment->id.'"><a href="void:javascript(0)" class="btn_confirm" data-appointment-id="'.$appointment->id.'">Confirm</a></div>';
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
}
