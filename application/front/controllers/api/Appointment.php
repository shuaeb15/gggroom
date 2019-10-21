<?php

   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Appointment extends REST_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
        $this->load->library('form_validation');
    }

    /**
     * index function.
     *
     * @access public
     * @return void
     */
 

    public function appointment_post() {

      $shop_id = $this->input->post('shop_id');
      $service_id = $this->input->post('service_id');
      $id = $this->input->post('uid');
      $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
      $this->data['userlist'] = $user_list;
      $my_shop = $this->db->select('service_id')->from('shop')->where('id', $shop_id)->get()->result_array();
      $my_shop_id = $my_shop[0]['service_id'];
      $main_filter_shop_list = $this->db->select('services.*, category.parent_id')->from('services')->where('services.is_deleted','0')->where("FIND_IN_SET(services.id,'$my_shop_id') !=", 0)->join('category', 'services.cat_id=category.category_id', 'left')->get()->result();

      //echo '<pre>', print_r($main_filter_shop_list), '<pre>';
      //echo '<pre>',print_r($main_services),'</pre>';

      $service_list = [];
      foreach ($main_filter_shop_list as $key => $value) {

        $main_services = $this->general_model->get_service_data_by_worker_shopid_new( 'services', array('services.id' => $value->id,'services.is_deleted' => 0),$shop_id);

        if(!empty($main_services)){
            $service_list[] = $main_services;
        }
      }

      foreach ($service_list as $key => $services) {
        $var =  $services->id;
        $service_list[$key]->encrypt_id = $var;
      }
      //echo '<pre>';print_r($service_list);exit;

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
        }

      $this->data['servicelist'] = $service_list;
      $this->data['shop_id'] = $shop_id;
      $this->data['select_service_id'] = $service_id;
      
    $this->response([
                                    'status' => TRUE,
                                    'service_list' => $service_list,
                                    'shop_id' => $shop_id,
                                    'select_service_id' => $service_id
                                ], REST_Controller::HTTP_OK);
    }

     public function insert_appointment_post(){
    

        $u_id = $this->input->post('uid');
        $all_services = $this->input->post('all_services');
        $array_services = json_decode($all_services,true);
        // echo '<pre>';print_r($array_services);exit;
        $cu_date = $this->input->post('cu_date');
        $cu_time = $this->input->post('cu_time');
        $f_start = date("H:i", strtotime($cu_time));
        $leave_note = $this->input->post('leave_note');
        $shop_id = $this->input->post('shop_id');

        $parts = explode('-', $cu_date);
        $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];

        $cu_date1 = date("Y-m-d", strtotime($f_worker_date));
        $newArr = [];
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
        $OrderId = $today . $rand;
        foreach ($array_services as $key => $value) {
          // echo $value['timeid'];exit;
          $minutes = '+'.$value['timeid'].' minutes';
          $end_time = date('H:i',strtotime($minutes,strtotime($f_start)));
          $start_time =  $f_start;
          $data = array(
              'user_id' => $u_id,
              'order_id' => $OrderId,
              'worker_id' => $value['workerid'],
              'service_id' => $value['serviceid'],
              'cat_id' => $value['categoryid'],
              'service_name' => $value['services_name'],
              'ap_date' => $cu_date1,
              'from_time' => $start_time,
              'to_time' => $end_time,
              'shop_id' => $shop_id,
              'note' => $leave_note,
              'price' => $value['service_price'],
              'created_at' => date('Y-m-d H:i:s'),
              'is_deleted' => 0,
              // 'status' => 'Confirm',
              'booking_status' => 0
          );

          print_r($data); exit();
          $worker_list = $this->general_model->insert_appointment($data, 'appointment');
          $f_start = $end_time;
        }
        
         $this->response([
                         'status' => TRUE, 
                         'orderid' => $OrderId,
                         'message' => 'Appointment added successfully.'
                             ], REST_Controller::HTTP_OK);

   
  }


    public function get_worker_data_post(){
     $service_id = $_POST['cat_id'];
     $shop_id = $this->input->post('shop_id');
     $worker_list = $this->general_model->get_worker_data_id_appointment('services', array('services.is_deleted' => 0),$service_id);
  
      // $worker_data = [];
      $i = 0;
      $result=[];
      foreach ($worker_list as $key => $value) {
        //$w_id = explode(",", $value->worker_id);

         $w_id1 = $this->db->select('id')->from('workers')->where('is_deleted','0')->where("FIND_IN_SET('$shop_id',shop_id) !=", 0)->get()->result_array();
          $w_id = [];
           foreach($w_id1 as $valuee)
           {
            
           $w_id[] = $valuee['id']; 
           }

        if(!empty($w_id)){
          $j = 0;
          foreach ($w_id as $key1 => $worker) {

            

               $cat_list1  = $this->db->select('workers.id as worker_id, workers.name as worker_name')->from('workers')->where('id',$worker)->where('is_deleted','0')->where("FIND_IN_SET('$shop_id',shop_id) !=", 0)->get()->result();

              if(!empty($cat_list1)){

                $worker_data[$i][$j] = array('worker_id'=>$cat_list1[0]->worker_id,'worker_name'=>$cat_list1[0]->worker_name);

                $all_review_list = $this->general_model->count_rating_review( 'rating_review', array('worker_id' => $cat_list1[0]->worker_id, 'shop_id' => $shop_id, 'service_id' => $service_id[$key], 'is_deleted' => 0));

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
              }
              $j++;
          }
        }

        $worker_list[$key]->review_list = $all_review;
        $worker_list[$key]->ratingRound = $roundEvg;
        $worker_list[$key]->worker_data = array_values($worker_data[$i]);
        $i++;
      }
       //echo '<pre>';print_r($worker_list);exit;
     // echo json_encode($worker_list);

       $this->response([
                         'status' => TRUE, 
                         'data' => $worker_list
                             ], REST_Controller::HTTP_OK);
    }




    public function get_worker_time_check_post(){
      $worker_id = $this->input->post('worker_id');
      $time = $this->input->post('from_time');
      $f_start = date("H:i", strtotime($time));
      $shop_id = $this->input->post('shop_id');

      $worker_date = $this->input->post('worker_date');
      $parts = explode('-', $worker_date);
      $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
      $day = date('l', strtotime($f_worker_date));

      $worker_list = $this->general_model->check_worker_time('worker_available_time', array('worker_id' => $worker_id, 'shop_id' => $shop_id, 'from_time' => $f_start, 'to_time' => $f_start, 'worker_day' => $day, 'is_deleted' => 0));

      $worker_list_available_time = $this->general_model->get_worker_time('*', 'worker_available_time', array('worker_id' => $worker_id, 'shop_id' => $shop_id, 'is_deleted' => 0));

      // echo '<pre>';print_r($worker_list);exit;
      if(!empty($worker_list))
      {
        echo 1;exit;
      }
      else
      {
        echo json_encode($worker_list_available_time);
      }
    }

    public function check_worker_appointment_time_post(){
      // echo "in";exit;
      $worker_id = $this->input->post('worker_id');
      $shop_id = $this->input->post('shop_id');
      $service_id = $this->input->post('service_id');
      $from_time = $this->input->post('from_time');
      $f_start = date("H:i", strtotime($from_time));
      $worker_date = $this->input->post('worker_date');
      $parts = explode('-', $worker_date);
      $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
      // echo $f_worker_date;exit;
      $app_date = date("Y-m-d", strtotime($f_worker_date));

      // SELECT * FROM `appointment` WHERE shop_id = "2" AND worker_id = "1" AND service_id = "9" AND ap_date = "2018-06-18" AND from_time = "09:00"
      $worker_list = $this->general_model->check_exist_data('*','appointment',array('worker_id' => $worker_id, 'shop_id' => $shop_id, 'service_id' => $service_id, 'from_time' => $f_start, 'ap_date' => $app_date, 'is_deleted' => 0, 'booking_status' => 1));

      // echo $this->db->last_query();exit;
      // echo '<pre>';print_r($worker_list);exit;
      if(!empty($worker_list))
      {
        echo 1;exit;
      }
      else
      {
        echo 0;exit;
      }
    }

   

  public function payment_post()
  {
    $this->load->library('stripepayment');
    if($this->input->post())
    {
      // echo "<pre>";print_r($_POST);
      $userId = $this->session->userdata('uid');
      $email = $this->session->userdata('email');
      $name = $this->session->userdata('firstname');

      $stripeToken = $this->input->post('token');
      $orderid = $this->input->post('orderid');
      $payment_type = $this->input->post('payment_type');
      $totalprice = $this->input->post('totalprice');
      //$fullprice = $totalprice * 100;
      $fullprice = $totalprice;
      $charge_data = array(
        "amount" => $fullprice,
        "currency" => "usd",
        // "description" => $Sponsorship_Type->sponsor_type,
        'metadata' => array(
            'userId' => $userId,
            'order_id' => $orderid,
            "email"=>$email,
            "customer name"=>$name
        ),
        "source" => $stripeToken,
      );
      // echo "<pre>";print_r($charge_data);
      $charge = $this->stripepayment->create_charge($charge_data);
      // echo "<pre>";print_r($charge);
      $chargeJson = $charge->jsonSerialize();
      if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
      {
        $amount = $chargeJson['amount'];
        $balance_transaction = $chargeJson['balance_transaction'];
        $chargeId = $chargeJson['id'];
        $currency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        if($status == 'succeeded')
        {
          $statusId = 1;
        }
        else
        {
         $statusId = 0;
        }

        $data = array(
          'order_id' => trim($orderid),
          'user_id' => $userId,
          'price' => $totalprice,
          'transaction_id' => $balance_transaction,
          'charge_id' => $chargeId,
          'payment_type' => $payment_type,
          'status' => $statusId,
          'invoice_id' => '',
          'is_deleted' => 0,
          'created_at' => date('Y-m-d H:i:s')
        );
        $this->general_model->create_general_data($data,'orders');

        if($orderid && $status == 'succeeded'){

          $appointmentUpdate = array(
            'updated_at' => date('Y-m-d H:i:s'),
            'booking_status' => 0
          );
          $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('order_id' => trim($orderid),'is_deleted' => 0));

          // echo $orderid;exit;
          $statusMsg = '<p style="text-align: center;">Your booking is submitted. Thank you for choose our services. We will send you confirmation email. Reservation number: #'.$orderid.'</p>';

          $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('order_id' => trim($orderid), 'is_deleted' => 0));

          $user_data = $this->general_model->get_order_booking_data('reminder_alert', 'user', array('id' => $userId));

          if($user_data[0]->reminder_alert == 1){
              $emailsend_worker = $this->general_model->appointment_book_sendConfirmationEmail_worker($email_data);
              $emailsend_shop = $this->general_model->appointment_book_sendConfirmationEmail_shop($email_data);
          }

          $emailsend = $this->general_model->appointment_book_sendConfirmationEmail($email_data);
        }else{
            $statusMsg = "<h4>Transaction has been failed</h4>";
        }
      }
      else
      {
        $statusMsg = "<h4>Transaction has been failed</h4>";
      }
      echo $statusMsg;exit;
    }
  }

  public function paymentUsingSqureup_post()
  {
    if($this->input->post())
    {
      $userId = $this->session->userdata('uid');
      $email = $this->session->userdata('email');
      $name = $this->session->userdata('firstname');
      $token = $this->input->post('token');
      $orderid = $this->input->post('orderid');
      $totalprice = $this->input->post('totalprice');
      $payment_type = $this->input->post('payment_type');

      $postFields = [
        "idempotency_key" => uniqid(),
        "amount_money" => [
          "amount"=> (int)$totalprice,
          "currency"=> "USD"
        ],
        "card_nonce"=> $token,
      ];
      // echo "<pre>"; print_r(json_encode($postFields));exit;
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://connect.squareup.com/v2/locations/CBASELhxC7jDvbPyWveYkfNjnK4gAQ/transactions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postFields),
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer sandbox-sq0atb-6quxBbrtrpl830or_nGG8g",
          "Content-Type: application/json",
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      $result = json_decode($response);
      // echo "<pre>"; print_r($result->transaction);
      // echo "<pre>"; print_r($result->transaction->id);
      curl_close($curl);
      if(isset($result->transaction->id) && !empty($result->transaction->id))
      {
        $amount = (int)$totalprice;
        $balance_transaction = $result->transaction->id;
        $chargeId = "";
        $currency = "USD";
        $statusId = 1;
        $data = array(
          'order_id' => trim($orderid),
          'user_id' => $userId,
          'price' => $amount,
          'transaction_id' => $balance_transaction,
          'charge_id' => $chargeId,
          'payment_type' => $payment_type,
          'status' => $statusId,
          'invoice_id' => '',
          'is_deleted' => 0,
          'created_at' => date('Y-m-d H:i:s')
        );
        $this->general_model->create_general_data($data,'orders');

        if(!empty($orderid) && !empty($result->transaction->id)){

          $appointmentUpdate = array(
            'updated_at' => date('Y-m-d H:i:s'),
            'booking_status' => 0
          );
          $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('order_id' => trim($orderid),'is_deleted' => 0));

          // echo $orderid;exit;
          $statusMsg = '<p style="text-align: center;">Your booking is submitted. Thank you for choose our services. We will send you confirmation email. Reservation number: #'.$orderid.'</p>';

          $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('order_id' => trim($orderid), 'is_deleted' => 0));

          $user_data = $this->general_model->get_order_booking_data('reminder_alert', 'user', array('id' => $userId));

          if($user_data[0]->reminder_alert == 1){
              $emailsend_worker = $this->general_model->appointment_book_sendConfirmationEmail_worker($email_data);
              $emailsend_shop = $this->general_model->appointment_book_sendConfirmationEmail_shop($email_data);
          }

          $emailsend = $this->general_model->appointment_book_sendConfirmationEmail($email_data);
        }
        else
        {
            $statusMsg = "<h4>Transaction has been failed</h4>";
        }
      }
      else
      {
        $statusMsg = "<h4>Transaction has been failed</h4>";
      }
      echo $statusMsg;exit;
    }
  }

  public function UsingSqureup_post()
  {

      // $token = 'cnon:CBASEDEhJ8EmNJTU0czlgHLc7U4gAQ';
      // $token = 'cnon:CBASEA42FRAeBB_6CcTrOcuyXDE';
      $token = "cnon:CBASELjXRv1bRoy91T5G7vSYoJMgAQ";
      $totalprice = '10';
      $postFields = [
        "idempotency_key" => uniqid(),
        "amount_money" => [
          "amount"=> (int)$totalprice,
          "currency"=> "USD"
        ],
        "card_nonce"=> $token,
      ];
      // echo "<pre>"; print_r(json_encode($postFields));exit;
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://connect.squareup.com/v2/locations/CBASELhxC7jDvbPyWveYkfNjnK4gAQ/transactions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postFields),
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer sandbox-sq0atb-6quxBbrtrpl830or_nGG8g",
          "Content-Type: application/json",
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      $result = json_decode($response);
      echo "<pre>"; print_r($result);
      // echo "<pre>"; print_r($result->transaction->id);
      curl_close($curl);

  }

  public function paymentCash()
  {
      if($this->input->post())
      {
        // echo "<pre>";print_r($_POST);
        $userId = $this->session->userdata('uid');
        $email = $this->session->userdata('email');
        $name = $this->session->userdata('firstname');

        $orderid = $this->input->post('orderid');
        $totalprice = $this->input->post('totalprice');
        $fullprice = $totalprice * 100;
        $payment_type = $this->input->post('payment_type');

          $data = array(
            'order_id' => trim($orderid),
            'user_id' => $userId,
            'price' => $totalprice,
            'transaction_id' => '',
            'charge_id' => '',
            'payment_type' => $payment_type,
            'status' => '1',
            'invoice_id' => '',
            'is_deleted' => 0,
            'created_at' => date('Y-m-d H:i:s')
          );
          $this->general_model->create_general_data($data,'orders');

          // if($orderid && $status == 'succeeded'){

            $appointmentUpdate = array(
              'updated_at' => date('Y-m-d H:i:s'),
              'booking_status' => 0
            );
            $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('order_id' => trim($orderid),'is_deleted' => 0));

            // echo $orderid;exit;
            $statusMsg = '<p style="text-align: center;">Your booking is submitted. Thank you for choose our services. We will send you confirmation email. Reservation number: #'.$orderid.'</p>';

            $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('order_id' => trim($orderid), 'is_deleted' => 0));

            $user_data = $this->general_model->get_order_booking_data('reminder_alert', 'user', array('id' => $userId));

            if($user_data[0]->reminder_alert == 1){
                $emailsend_worker = $this->general_model->appointment_book_sendConfirmationEmail_worker($email_data);
                $emailsend_shop = $this->general_model->appointment_book_sendConfirmationEmail_shop($email_data);
            }

            $emailsend = $this->general_model->appointment_book_sendConfirmationEmail($email_data);
          // }else{
          //     $statusMsg = "<h4>Transaction has been failed</h4>";
          // }

        echo $statusMsg;exit;
      }
  }

  public function get_select_service_post(){
      $service_id = $_POST['id'];
      $s_id = implode(",", $service_id);
      $service_list = $this->general_model->get_select_service_data( 'services', array('services.is_deleted' => 0, 'user.u_category' => 2), $service_id);

      foreach ($service_list as $key => $value) {
        $var =  $this->url_encrypt($services->id);
        $service_list[$key]->encrypt_id = $var;
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
      }
      echo json_encode($service_list);exit;
  }

  public function get_one_worker_time(){
    $worker_id = $_POST['worker_id'];

    $worker_time = $this->general_model->get_worker_time('from_time', 'worker_available_time', array('worker_id' => $worker_id, 'is_deleted' => 0));
    $c_worker_time = date("g:i A", strtotime($worker_time[0]->from_time));
    echo json_encode($c_worker_time);
  }

  
  public function Check_promocode(){
    $promocode = $this->input->post('promocode');
    $total_price = $this->input->post('price');
    $total_services = $this->input->post('total_services');
    $orderid = $this->input->post('orderid');
    $arr_services = explode(',', $total_services);

    $New_Arr = [];
    $New_Arr1 = [];

    $offer_list = $this->general_model->check_promocode('*', 'offers`', array('code' => $promocode, 'is_deleted' => 0));
    $check_array = [];
    if($offer_list->offer_type == 1){
      $main_price1 = 0;
      $New_Arr1 = $offer_list;
      $appointment_list = $this->general_model->get_all_applointment_data('*', 'appointment', array('order_id' => trim($orderid), 'is_deleted' => 0));

      foreach ($appointment_list as $key => $value) {
        $appointment_price = $value->price;
        $promocode = $New_Arr1->code;
        $discount = $New_Arr1->price;
        if($discount <= $appointment_price){
          if($New_Arr1->discount_type == 1){
            $new_price = $appointment_price - ($appointment_price * ($New_Arr1->price / 100));
            $discount_price = round($new_price,2);
            $main_discount_price = $discount_price;
          }else if($New_Arr1->discount_type == 2){
            $main_discount_price = $appointment_price - $New_Arr1->price;
          }
        $appointmentUpdate = array(
            'promocode' => $promocode,
            'discount' => $discount,
            'discount_price' => $main_discount_price,
          );
          $main = $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('id' => $value->id));
          $main_price = $main_price1 += $main_discount_price;
          $check_main_price = '0';
        }else{
          $main_price1 = $appointment_price;
          $check_main_price = '';
        }
        if($check_main_price != ''){
          $check_array[] = $main_price1;
        }else{
          if(!empty($check_array)){
            $check_array[] = '';
          }else{
            $check_array = [];
          }
        }
      }
      // echo $main_price;exit;
      if(!empty($check_array)){
        $New_Arr[] = array('promocode'=>$New_Arr1->code, 'price'=>$main_price, 'service_name'=>'All services', 'ap_id'=>0, 'main_data'=>0);
      }else{
        $New_Arr[] = array('promocode'=>$New_Arr1->code, 'price'=>'', 'service_name'=>'', 'ap_id'=>'', 'main_data'=>1);
      }

    }else{
      foreach ($arr_services as $key => $service) {
        $offer_list = $this->general_model->check_promocode('*', 'offers`', array('code' => $promocode,'service_id' => $service, 'is_deleted' => 0));
        if(!empty($offer_list)){
            $New_Arr1 = $offer_list;
        }else{
          $appointmentUpdate = array(
            'promocode' => '',
            'discount' => '0',
            'discount_price' => '0',
          );
          $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('order_id' => trim($orderid),'service_id' => $service,'is_deleted' => 0));
        }
      }


      if(!empty($New_Arr1)){
        $appointment_list = $this->general_model->check_promocode('*', 'appointment', array('order_id' => trim($orderid),'service_id' => $New_Arr1->service_id, 'is_deleted' => 0));
        $appointment_price = $appointment_list->price;
        $promocode = $New_Arr1->code;
        $discount = $New_Arr1->price;
        if($discount <= $appointment_price){
          if($New_Arr1->discount_type == 1){
            $new_price = $appointment_price - ($appointment_price * ($New_Arr1->price / 100));
            $discount_price = round($new_price,2);
            $new_price1 = $appointment_price * ($New_Arr1->price / 100);
            $discount_price1 = round($new_price1,2);
            $main_discount_price = $total_price - $discount_price1;
          }else if($New_Arr1->discount_type == 2){
            $main_discount_price = $total_price - ($appointment_price - $New_Arr1->price);
          }
          // echo $main_discount_price;exit;
          $New_Arr[] = array('promocode'=>$New_Arr1->code, 'price'=>$main_discount_price, 'service_name'=>$appointment_list->service_name, 'ap_id'=>$appointment_list->id,   'main_data'=>0);

          $appointmentUpdate = array(
            'promocode' => $promocode,
            'discount' => $discount,
            'discount_price' => $main_discount_price,
          );
          $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('id' => $appointment_list->id,'is_deleted' => 0));
        }else{
          $New_Arr[] = array('promocode'=>$New_Arr1->code, 'price'=>'', 'service_name'=>$appointment_list->service_name, 'ap_id'=>$appointment_list->id, 'main_data'=>1);
        }
      }
    }
    echo json_encode($New_Arr);
  }

  public function cancel_promocode(){
    $ap_id = $this->input->post('ap_id');
    $orderid = $this->input->post('orderid');
    $appointmentUpdate = array(
      'promocode' => '',
      'discount' => '0',
      'discount_price' => '0',
    );
    if($ap_id != 0){
      $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('id' => $ap_id));
    }else{
      $this->general_model->update_general_data($appointmentUpdate, 'appointment', array('order_id' => trim($orderid)));
    }

    echo '1';exit;
  }

  public function send_gift_email(){
    $orderid = $this->input->post('orderid');
    $gift_email = $this->input->post('gift_email');
    $email_data = $this->general_model->get_order_booking_data('*', 'appointment', array('order_id' => trim($orderid), 'is_deleted' => 0));
    $emailsend_worker = $this->general_model->send_gift_email($email_data, $gift_email);
    if($emailsend_worker){
        echo '1';exit;
    }
    else{
      echo '0';exit;
    }
  }

  public function check_vacation_module_shop() {
    $start_date = $this->input->post('start_date');
    $start_time = $this->input->post('start_time');
    $shop_id = $this->input->post('shop_id');
    $b_f_start = date("H:i:s", strtotime($start_time));

    $parts1 = explode('-', $start_date);
    $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
    $vacation_md_start_date = date("Y-m-d", strtotime($s_date));

   $main_start_date = $vacation_md_start_date.' '.$b_f_start;

    $check_vacation_module = $this->general_model->check_vacation_module_shop('*', 'vacation_module', array('shop_id' => $shop_id, 'flag' => 1, 'is_deleted' => 0), $main_start_date);

    //print_r($check_vacation_module);

    if(!empty($check_vacation_module)){
      $main_s_date = date("d-m-Y", strtotime($check_vacation_module[0]->start_date));
      $main_e_date = date("d-m-Y", strtotime($check_vacation_module[0]->end_date));
      $main_s_time = date("g:i A", strtotime($check_vacation_module[0]->start_date));
      $main_e_time = date("g:i A", strtotime($check_vacation_module[0]->end_date));
      if($main_e_time == '11:59 PM'){
        $all_e_time = '12:00 AM';
      }else{
        $all_e_time = $main_e_time;
      }
      $check_vacation_module[0]->start_date = $main_s_date;
      $check_vacation_module[0]->end_date = $main_e_date;
      $check_vacation_module[0]->start_time = $main_s_time;
      $check_vacation_module[0]->end_time = $all_e_time;
    }
    echo json_encode($check_vacation_module);
   }

   public function check_vacation_module_worker() {
     $start_date = $this->input->post('start_date');
     $start_time = $this->input->post('start_time');
     $worker_id = $this->input->post('worker_id');
     $b_f_start = date("H:i:s", strtotime($start_time));

     $parts1 = explode('-', $start_date);
     $s_date = $parts1[1] . '-' . $parts1[0] . '-' . $parts1[2];
     $vacation_md_start_date = date("Y-m-d", strtotime($s_date));

     $main_start_date = $vacation_md_start_date.' '.$b_f_start;

     $check_vacation_module = $this->general_model->check_vacation_module_shop('*', 'vacation_module', array('shop_id' => $worker_id, 'flag' => 2, 'is_deleted' => 0), $main_start_date);

     if(!empty($check_vacation_module)){
       $main_s_date = date("d-m-Y", strtotime($check_vacation_module[0]->start_date));
       $main_e_date = date("d-m-Y", strtotime($check_vacation_module[0]->end_date));
       $main_s_time = date("g:i A", strtotime($check_vacation_module[0]->start_date));
       $main_e_time = date("g:i A", strtotime($check_vacation_module[0]->end_date));
       if($main_e_time == '11:59 PM'){
         $all_e_time = '12:00 AM';
       }else{
         $all_e_time = $main_e_time;
       }

       $check_vacation_module[0]->start_date = $main_s_date;
       $check_vacation_module[0]->end_date = $main_e_date;
       $check_vacation_module[0]->start_time = $main_s_time;
       $check_vacation_module[0]->end_time = $all_e_time;
     }

     echo json_encode($check_vacation_module);
     // echo '<pre>';print_r($check_vacation_module);exit;
    }

    public function check_shop_break_time() {
      $from_time = $this->input->post('from_time');
      $shop_id = $this->input->post('shop_id');
      $f_start = date("H:i", strtotime($from_time));

      $shop_state = $this->general_model->get_edit_shop_data('shop', array('shop.id' => $shop_id, 'shop.is_deleted' => 0));

      $check_state_time = $this->general_model->check_shop_break_time('*', 'state', array('id' => $shop_state->state, 'is_deleted' => 0), $f_start);

      echo '<pre>'; print_r($check_state_time); exit;

      if(!empty($check_state_time)){
        $main_start_time = date("g:i A", strtotime($check_state_time[0]->break_start_time));
        $main_end_time = date("g:i A", strtotime($check_state_time[0]->break_end_time));

        $check_state_time[0]->break_start_time = $main_start_time;
        $check_state_time[0]->break_end_time = $main_end_time;
      }
      echo json_encode($check_state_time);
     }

     public function check_worker_break_time() {
       $from_time = $this->input->post('from_time');
       $worker_id = $this->input->post('worker_id');
       $f_start = date("H:i", strtotime($from_time));
       $start_date = $this->input->post('start_date');
       $parts = explode('-', $start_date);
       $f_worker_date = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
       $day = date('l', strtotime($f_worker_date));

       $check_state_time = $this->general_model->check_worker_break_time('*', 'breaks', array('shop_id' => $worker_id, 'day' => $day, 'is_deleted' => 0), $f_start);

       if(!empty($check_state_time)){
         $main_start_time = date("g:i A", strtotime($check_state_time[0]->from_time));
         $main_end_time = date("g:i A", strtotime($check_state_time[0]->to_time));

         $check_state_time[0]->from_time = $main_start_time;
         $check_state_time[0]->to_time = $main_end_time;
       }
       echo json_encode($check_state_time);
      }
}
