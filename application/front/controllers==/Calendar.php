<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Calendar class.
 *
 * @extends CI_Controller
 */
class Calendar extends MY_Controller {
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
      $userId = $this->session->userdata('uid');
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      if(!empty($userId))
      {
        $id = $this->session->userdata('uid');
        $UserData = $this->general_model->get_user_data('*', 'user', array('id' => $userId, 'is_deleted' => 0));
        $this->data['userlist'] = $UserData;

        if($UserData->u_category == 2 || $UserData->u_category == 3){
          $image = !empty($UserData->image) ? base_url('assets/uploads/profile_image/'.$UserData->image) : base_url('front/images/upload_img.png');
          $WorkersData = $this->general_model->get_worker_data('*', 'workers', array('user_id' => $userId, 'is_deleted' => 0));
          $ShopData = $this->general_model->get_all_general_data("*",'shop',array('is_active'=>1,'is_deleted'=>0,'user_id'=>$userId));
          $this->data['WorkersData'] = $WorkersData;
          $this->data['ShopData'] = $ShopData;
          $this->data['UserImage'] = $image;
          $this->data['title'] = 'Calendar | GGG Rooms';
          $this->data['js_file'] = array(
              "front/js/moment.min.js",
              "front/js/fullcalendar.min.js",
              "front/js/calendar.js"
          );
          $this->data['css_file'] = array(
              "front/css/fullcalendar.min.css",
              "front/css/fullcalendar.print.min.css",
              "front/css/calendar.css",
          );

          $this->render('calendar_view');
        }else{
          redirect('profile', 'refresh');
        }
      }
      else
      {
        redirect(site_url());
      }
    }

    public function GetWorkerAppointmentsData()
    {
      if($this->input->post())
      {
        $workerId = $this->input->post('workerid');
        $WorkerAppointmentData = $this->general_model->GetWorkerAppointments(array('appointment.worker_id'=>$workerId));
        $arr = [];
        foreach ($WorkerAppointmentData as $key => $value)
        {
          $fromtime = substr($value->from_time,0,8);
          $totime = substr($value->to_time,0,8);
          $f_start = date('g:i A',strtotime($fromtime));
          $t_start = date('g:i A',strtotime($totime));
          $startDate = $value->ap_date.'T'.$fromtime;
          $endDate = $value->ap_date.'T'.$totime;
          $arr[] = array('title'=>$value->firstname.' '.$f_start.' - '.$t_start,'start'=>$startDate,'end'=>$endDate);
        }
        echo json_encode($arr);exit;
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
        }
        else
        {
          $WorkersData = $this->general_model->get_all_general_data('*', 'workers', array('user_id' => $userId,'is_deleted' => 0));
        }
        // echo "<pre>";print_r($WorkersData);exit;
        foreach ($WorkersData as $key => $value) {
          $workerHtml .= '<button type="button" class="btn WorkerData full-width-btn" data-id="'.$value['id'].'">'.$value['name'].'</button>';
        }
        echo $workerHtml;exit;
      }
    }
}
