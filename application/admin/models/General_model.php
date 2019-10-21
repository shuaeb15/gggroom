<?php

/**
 * Copyright (c) 2016, The Shire AU
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
 * DAMAGE.
 *
 * @license     The Shire AU
 * @author      The Shire AU <info@theshire.co>
 * @copyright   The Shire AU
 * @link        https://www.theshire.co
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * General_model class.
 *
 * @extends CI_Model
 */
class General_model extends CI_Model {

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    /**
     * check_exist_data function.
     *
     * @access public
     * @param mixed $field
     * @param mixed $table_name
     * @param mixed $where_cond
     * @return object the general data
     */
    public function check_exist_data($field = "", $table_name = "", $where_cond = array()) {
      // echo '<pre>'; print_r($where_cond);exit;
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
        // echo $this->db->last_query();exit;
    }

//user
public function get_user_data($field = "", $table_name = "", $where_cond = array()) {
    $this->db->select($field);
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->order_by('id', 'desc');
    return $this->db->get()->result();
}

public function get_user_data_asc($field = "", $table_name = "", $where_cond = array()) {
    $this->db->select($field);
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->order_by('id', 'asc');
    return $this->db->get()->result();
}
    public function insert_user($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function delete_user($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function update_user_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function sendConfirmationEmail($u_data){
      $main_image = base_url()."../front/images/nochats.png";
      $receive = $u_data['email'];
      $fname = $u_data['firstname'];
      // $uname = $u_data['username'];
      $password = $u_data['password'];

      $message =
      "<html>
            <head>
              <title>Account Created</title>
            </head>
            <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <p>Hi ".$fname.",</p>
            <p>Thank you for becoming a GGGroom user. We’re excited that you’ve joined.</p>
            <p><b>Your Account:</b><br/>Email: ".$receive."<br/>Password: ".$password."</p>
            </body>
            </html>";

			$this->load->library('email');
			$this->email->initialize(array(
				'protocol' => 'mail',
				'smtp_host' => 'smtp.sendgrid.net',
				'smtp_user' => 'pratikvekariya',
				'smtp_pass' => 'pratik123#',
				'smtp_port' => 587,
				'crlf' => "\r\n",
				'newline' => "\r\n"
				));
          $this->email->set_mailtype("html");
			$this->email->from('info@gggroom.com');
			$this->email->to($receive);
			$this->email->subject('Registration');
			$this->email->message($message);
			if($this->email->send())
			{
				return true;
			}else{
				return false;
			}
		}

// dashboard
    public function get_all_general_data($field = "", $table_name = "", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "", $groupby = "") {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->order_by($order_by);
        $this->db->group_by($groupby);
        $this->db->limit($limit);
        (($order_by && $order_by != '') ? $this->db->order_by('id', 'ASC') : '');
        return $this->db->get()->result_array();
    }

    public function update_general_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        // echo $this->db->last_query();exit;
        return $this->db->affected_rows();
    }

//Category
    public function get_category($table_name = "", $where_cond = array()) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->order_by('category_id', 'desc');
        return $this->db->get()->result();
    }

    public function get_parent_category_list($field, $table_name, $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function insert_category($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function get_category_name($table_name, $where_cond = array()) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }
    public function get_category_all_data_list($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function get_category_all_data_list1($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function update_category_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        // echo $this->db->last_query();exit;
        return $this->db->affected_rows();
    }

    public function delete_category($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        // echo $this->db->last_query();exit;
        return $this->db->affected_rows();
    }

    //shops
    public function get_shops_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function active_shop($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function inactive_shop($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function get_user_by_shop($table_name, $where_cond = array()) {
        $this->db->select('firstname,lastname');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    //appointment

    public function get_appointment_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function get_user_by_appointment($field, $table_name, $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function get_shop_data($field, $table_name, $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function get_business_hours_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_appointment_data_id($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function GetAppointmentData($where_cond = array())
    {
        $start_month = date('Y-m-d');
        $end_month =  date('Y-m-d', strtotime('-1 year'));

        $this->db->select("app.*,os.price, os.id as order_main_id",false);
        $this->db->from('appointment app');
        $this->db->join('orders os', 'os.order_id = app.order_id', 'left');
        $this->db->where($where_cond);
        $this->db->where('app.ap_date <=',$start_month);
        $this->db->where('app.ap_date >=',$end_month);
        $this->db->group_by('app.order_id');
        return $this->db->get()->result_array();
    }

    //Services
    public function get_services_data_by_category($table_name = "", $where_cond = array()) {
        $this->db->select('services.*, category.parent_id');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('category', 'services.cat_id=category.category_id', 'left');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function get_services_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select('services.*, category.parent_id');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('category', 'services.cat_id=category.category_id', 'left');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function get_user_by_service($table_name, $where_cond = array()) {
        $this->db->select('firstname,lastname');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }
    public function get_shop_by_service($table_name, $where_cond = array()) {
        $this->db->select('shop_name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }
    public function get_service_by_service($table_name, $where_cond = array()) {
        $this->db->select('name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function active_service($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function inactive_service($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function get_service_data_id($field, $table_name, $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function get_collection_data($table_name = "", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "", $groupby = "") {
        $this->db->select('appointment.*, orders.price');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('orders', 'appointment.order_id=orders.order_id', 'left');
        $this->db->order_by($order_by);
        $this->db->group_by('appointment.order_id');
        $this->db->limit($limit);
        (($order_by && $order_by != '') ? $this->db->order_by('id', 'ASC') : '');
        return $this->db->get()->result_array();
    }
    public function update_shop_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function update_shop_business_hours_availability_time($data, $table_name) {
          $this->db->select('*');
          $this->db->from($table_name);
          $this->db->where('shop_id', $data['shop_id']);
          $this->db->where('hours_day', $data['hours_day']);
          $data1 =  $this->db->get()->row();
          // echo count($data);exit;
          if(count($data1) > 0){
            // echo '<pre>';print_r($data->worker_id);exit;
            $this->db->where('shop_id', $data['shop_id']);
            $this->db->where('hours_day', $data['hours_day']);
            $this->db->update($table_name, $data);
            return $this->db->affected_rows();
          }
          else{
            $this->db->insert($table_name, $data);
            return $this->db->insert_id();
          }
    }

    public function update_breaks_availability_time($data, $table_name) {

      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where('shop_id', $data['shop_id']);
      $this->db->where('day', $data['day']);
      $data1 =  $this->db->get()->row();
      // echo count($data);exit;
      if(count($data1) > 0){
        // echo '<pre>';print_r($data->worker_id);exit;
        $this->db->where('shop_id', $data['shop_id']);
        $this->db->where('day', $data['day']);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
      }
      else{
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
      }
    }

    public function get_services_data_id($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }
    public function get_worker_data1($table_name = "", $where_cond = array()) {
        $this->db->select('workers.*')
                  ->from($table_name)
                  // ->join('worker_available_time', 'workers.id=worker_available_time.worker_id', 'left')
                  // ->group_by('workers.id')
                  ->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_shop_data_by_service($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_all_general_data1($field="", $table_name="", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "",$group_by="",$where_in=array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($where_in))
      {
        $this->db->where_in($where_in['field_name'], $where_in['in_array']);
      }
      $this->db->group_by($group_by);
      $this->db->order_by($order_by);
      $this->db->limit($limit);
      return $this->db->get()->$return();
    }

    public function get_shop_data_by_cat($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function update_all_services($data, $table_name, $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
    }

    public function get_category_name1($field="", $table_name="", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
    }

    public function get_service_category1( $table_name = "", $where_cond = array()) {
        $this->db->select('category.category_id, category.cat_name, category.parent_id as cat_parent_id ');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function check_breaks_time_exists($table_name, $where_cond = array()) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
    }

    public function active_user($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function active_appointment($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function inactive_appointment($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function uncheck_hours_day_checkbox($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function check_worker_time($table_name = "", $where_cond = array()) {
       $query = $this->db->query("SELECT * FROM `worker_available_time` WHERE CONVERT(from_time,TIME) <= CONVERT('".$where_cond['from_time']."',TIME) AND CONVERT(to_time,TIME) >= CONVERT('".$where_cond['to_time']."',TIME) AND `worker_day` = '".$where_cond['worker_day']."' AND `worker_id` = ".$where_cond['worker_id']);
       return $query->result();
    }

    public function get_worker_time($field="", $table_name="", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
    }

    public function update_ap_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        // echo $this->db->last_query();exit;
        return $this->db->affected_rows();
    }

    public function get_appointment_time($field="", $table_name="", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
    }

    public function send_appointment_change_mail($email_data1){

      $email = $email_data1['user_email'];
      $date = $email_data1['ap_date'];
      $book_date = date("d-m-Y", strtotime($date));
      $from_time = $email_data1['from_time'];
      $to_time = $email_data1['to_time'];
      $worker_name = $email_data1['worker_name'];
      $service_name = $email_data1['service_name'];
      $main_image = base_url()."../front/images/nochats.png";

      $message =
      "<html>
            <head>
              <title>Appointment Changed</title>
            </head>
            <body>
              <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
              <h2>Your appointment is changed.</h2>
              <p>Your Appointment Booked on ".$book_date."</p>";

              $from_time1 = date('h:i A', strtotime($from_time));
              $to_time1 = date('h:i A', strtotime($to_time));
              $message .="<p>".$service_name." by ".$worker_name." : ".$from_time1."  to ".$to_time1."</p>";

      $message .= "</body>
            </html>";
      // echo $message;exit;
      $this->email->initialize(array(
        'protocol' => 'mail',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'pratikvekariya',
        'smtp_pass' => 'pratik123#',
        'smtp_port' => 587,
        'crlf' => "\r\n",
        'newline' => "\r\n"
      ));

      $this->email->set_mailtype("html");
      $this->email->from('info@gggroom.com');
      $this->email->to($email);
      $this->email->subject('Appointment Changed');
      $this->email->message($message);
      if($this->email->send())
      {
        return true;
      }else{
        return false;
      }
		}

    //page
    public function get_page_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }
    public function active_inactive_page($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }
    public function insert_page($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }
    public function get_page_data_id($field, $table_name, $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }
    public function update_page_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function get_service_limit_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->limit('4', '0');
        return $this->db->get()->result();
    }
    public function get_count_shop_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }
    public function get_count_shop_data1($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->group_by('shop_id');
        return $this->db->get()->result();
    }

    public function get_state_data($field = "", $table_name = "",$where_cond = array())
    {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('state', 'shop.state=state.id', 'left');
        $this->db->group_by('state');
        return $this->db->get()->result();
    }

    public function get_state_all_data($field = "", $table_name = "",$where_cond = array())
    {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_user_data1($field = "", $table_name = "", $where_cond = array(), $flag="") {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        if($flag == 1)
        {
          return $this->db->get()->result();
        }
        else
        {
          return $this->db->get()->row();
        }
    }
    public function get_worker_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }
    public function all_get_all_general_data($field="", $table_name="", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "",$group_by="",$where_in=array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($where_in))
      {
        $this->db->where_in($where_in['field_name'], $where_in['in_array']);
      }
      $this->db->group_by($group_by);
      $this->db->order_by($order_by);
      $this->db->limit($limit);
      return $this->db->get()->$return();
    }
    public function GetWorkerAppointments( $where_cond = array()) {
      $this->db->select('appointment.*, shop.shop_name, shop.addline1, shop.addline2, shop.city, shop.state, shop.zipcode, workers.image as worker_image, workers.name as worker_name, services.price, services.id as main_service_id, services.image as service_image,user.firstname,user.lastname,user.email as user_email,user.mobile as user_mobile');
      $this->db->from('appointment');
      $this->db->where($where_cond);
      $this->db->join('shop', 'appointment.shop_id=shop.id', 'left');
      $this->db->join('workers', 'appointment.worker_id=workers.id', 'left');
      $this->db->join('services', 'appointment.service_id=services.id', 'left');
      $this->db->join('user', 'user.id=appointment.user_id', 'left');
        return $this->db->get()->result();
    }
    public function active_inactive_worker($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }
    public function get_worker_data_id($table_name, $where_cond = array()) {
        $this->db->select('workers.*, shop.shop_name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('shop', 'workers.shop_id=shop.id', 'left');
        return $this->db->get()->row();
    }
    public function get_all_general_data123($field="", $table_name="", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "",$group_by="",$where_in=array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($where_in))
      {
        $this->db->where_in($where_in['field_name'], $where_in['in_array']);
      }
      $this->db->group_by($group_by);
      $this->db->order_by($order_by);
      $this->db->limit($limit);
      return $this->db->get()->$return();
    }
    public function update_worker_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }
    function delete_worker_hours_time($table_name = "", $where_cond = array())
    {
        $this->db->where($where_cond);
        $this->db->delete($table_name);
    }
    public function update_worker_business_hours_availability_time($data, $table_name) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where('worker_id', $data['worker_id']);
      $this->db->where('worker_day', $data['worker_day']);
      $data1 =  $this->db->get()->row();
      // echo count($data);exit;
      if(count($data1) > 0){
        // echo '<pre>';print_r($data->worker_id);exit;
        $this->db->where('worker_id', $data['worker_id']);
        $this->db->where('worker_day', $data['worker_day']);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
      }
      else{
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
      }
    }

    public function check_subcat_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    //state
    public function insert_state($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function get_location_state_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_location_state_data_by_id($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->row();
    }

    public function update_state_data($data, $table_name = "", $where_cond = array()) {
        $this->db->where($where_cond);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function get_all_state_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_appointment_data_main($table_name="", $where_cond = array()) {
      $this->db->select('appointment.*, services.time');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('services', 'appointment.service_id=services.id', 'left');
      return $this->db->get()->row();
    }

    public function get_edit_shop_data($table_name = "", $where_cond = array()) {
        $this->db->select('shop.*, city.name as city_name, state.name as state_name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('city', 'shop.city=city.id', 'left');
        $this->db->join('state', 'shop.state=state.id', 'left');
        return $this->db->get()->row();
    }

    public function get_services($table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
        return $this->db->get()->result();
    }

    public function get_offres_data($table_name = "", $where_cond = array()) {
        $this->db->select('offers.*, services.service_name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('services', 'offers.service_id=services.id', 'left');
        return $this->db->get()->result();
    }

    public function get_auto_services_data( $table_name="", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "",$group_by="",$where_in=array()) {
      $this->db->select('services.id,services.service_name, shop.shop_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($where_in))
      {
        $this->db->where_in($where_in['field_name'], $where_in['in_array']);
      }
      // , shop.shop_name
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      // $this->db->group_by($group_by);
      // $this->db->order_by($order_by);
      // $this->db->limit($limit);
      return $this->db->get()->$return();
    }

    function delete_user_module($table_name = "", $where_cond = array())
    {
        $this->db->where($where_cond);
        $this->db->delete($table_name);
    }

    public function get_allshop_images($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function check_vacation_module_start_time($field = "", $table_name = "", $where_cond = array(), $start_date) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->where('start_date <=', $start_date);
        $this->db->where('end_date >=', $start_date);
        return $this->db->get()->result();
    }

    public function check_vacation_module_end_time($field = "", $table_name = "", $where_cond = array(), $end_date) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->where('start_date <=', $end_date);
        $this->db->where('end_date >=', $end_date);
        return $this->db->get()->result();
    }
    public function check_vacation_module_shop($field = "", $table_name = "", $where_cond = array(), $start_date) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->where('start_date <=', $start_date);
        $this->db->where('end_date >=', $start_date);
        return $this->db->get()->result();
    }

    public function check_vacation_module_time_available($field = "", $table_name = "", $where_cond = array(), $start_date) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        // $this->db->where('start_date <=', $start_date);
        $this->db->where('end_date <=', $start_date);
        return $this->db->get()->result();
    }

    public function send_worker_permission_email($user_data){
      $firstname = $user_data['firstname'];
      $email = $user_data['email'];
      $password = $user_data['password'];
      $user_id = $user_data['user_id'];
      $worker_id = $user_data['worker_id'];

      $main_image = base_url()."../front/images/nochats.png";
      $message =
      "<html>
      <head>
        <title>Give Shop Permission</title>
      </head>
      <body>
      <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
      <p>Hi ".$firstname.",</p>
      <p><b>Your Account:</b><br/>Email: ".$email."<br/>Password: ".$password."</p>
      <p>Please click on this link for become a shop manager ".base_url().'../worker/permission/'.$user_id.'/'.$worker_id.".</p>
      </body>
      </html>";

      $this->load->library('email');
      $this->email->initialize(array(
        'protocol' => 'mail',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'pratikvekariya',
        'smtp_pass' => 'pratik123#',
        'smtp_port' => 587,
        'crlf' => "\r\n",
        'newline' => "\r\n"
        ));
        $this->email->set_mailtype("html");
      $this->email->from('info@gggroom.com');
      $this->email->to($email);
      $this->email->subject('Give Shop Permission');
      $this->email->message($message);
      if($this->email->send())
      {
        return true;
      }else{
        return false;
      }
    }

    public function sendregister_admin_user($u_data){
      $receive = $u_data['email'];
      $fname = $u_data['firstname'];
      // $uname = $u_data['username'];
      $password = $u_data['password'];
      $role = $u_data['user_promotion'];

      $message =
      "<html>
            <head>
              <title>Account Created</title>
            </head>
            <body>
            <p>Hi ".$fname.",</p>
            <p>Congratulations! Your account is created.</p>
            <p><b>Your Account Detail:</b><br/>Email: ".$receive."<br/>Password: ".$password."<br/>Role: ".$role."</p>
            </body>
            </html>";

			$this->load->library('email');
			$this->email->initialize(array(
				'protocol' => 'mail',
				'smtp_host' => 'smtp.sendgrid.net',
				'smtp_user' => 'pratikvekariya',
				'smtp_pass' => 'pratik123#',
				'smtp_port' => 587,
				'crlf' => "\r\n",
				'newline' => "\r\n"
				));
      $this->email->set_mailtype("html");
			$this->email->from('info@gggroom.com');
			$this->email->to($receive);
			$this->email->subject('Registration');
			$this->email->message($message);
			if($this->email->send())
			{
				return true;
			}else{
				return false;
			}
		}

    public function get_admin_user_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select('admin.*, role.role_name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('role', 'admin.user_promotion = role.id', 'left');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }
    public function get_module_admin_data($field = "", $table_name = "", $where_cond = array()) {
        $this->db->select('user_access.*, module.module_name');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('module', 'user_access.module_id = module.id', 'left');
        return $this->db->get()->result();
    }

    public function sendConfirmationEmail_add_shop($u_data){
      $main_image = base_url()."../front/images/nochats.png";
      $receive = $u_data['shop_email'];
      $shop_name = $u_data['shop_name'];
      $mobile = $u_data['mobile'];

      $message =
      "<html>
            <head>
              <title>Shop account Created</title>
            </head>
            <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <p>Hi,</p>
            <p>Your shop account Created.</p>
            <p><b>Shop Account Detail:</b><br/>Shop Name: ".$shop_name."<br/>Mobile No.: ".$mobile."<br/>Email: ".$receive."</p>
            </body>
            </html>";

			$this->load->library('email');
			$this->email->initialize(array(
				'protocol' => 'mail',
				'smtp_host' => 'smtp.sendgrid.net',
				'smtp_user' => 'pratikvekariya',
				'smtp_pass' => 'pratik123#',
				'smtp_port' => 587,
				'crlf' => "\r\n",
				'newline' => "\r\n"
				));
      $this->email->set_mailtype("html");
			$this->email->from('info@gggroom.com');
			$this->email->to($receive);
			$this->email->subject('Shop Account Created');
			$this->email->message($message);
			if($this->email->send())
			{
				return true;
			}else{
				return false;
			}
		}

    public function get_payment_data($field = "", $table_name = "",$where_cond = array())
    {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function get_appointment_payment_data($table_name = "",$where_cond = array())
    {
        $this->db->select('orders.price, orders.payment_type');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('orders', 'appointment.order_id = orders.order_id', 'left');
        $this->db->group_by('appointment.order_id');
        return $this->db->get()->result();
    }

    public function get_order_booking_data($field, $table_name, $where_cond = array()) {
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        return $this->db->get()->result();
    }

    public function appointment_book_sendConfirmationEmail($email_data){
      $u_id = $email_data[0]->user_id;
      $this->db->select('*');
      $this->db->from('user');
      $this->db->where('id',$u_id);
      $var = $this->db->get()->row();
      $email = $var->email;
      $date = $email_data[0]->ap_date;
      $book_date = date("d-m-Y", strtotime($date));

      $this->db->select('*');
      $this->db->from('shop');
      $this->db->where('id',$email_data[0]->shop_id);
      $shop_data = $this->db->get()->row();
      if($shop_data->addline2 != ''){
          $address2 = ', '.$shop_data->addline2;
      }else{
          $address2 = '';
      }
      $this->db->select('name');
      $this->db->from('city');
      $this->db->where('id',$shop_data->city);
      $city_name = $this->db->get()->row();
      if($city_name->name != ''){
          $city = ', '.$city_name->name;
      }else{
          $city = '';
      }
      $this->db->select('name');
      $this->db->from('state');
      $this->db->where('id',$shop_data->state);
      $state_name = $this->db->get()->row();
      if($state_name->name != ''){
          $state = ', '.$state_name->name;
      }else{
          $state  = '';
      }
      if($shop_data->zipcode != ''){
          $zipcode = ', '.$shop_data->zipcode;
      }else{
          $zipcode = '';
      }
      $site_url = base_url();
      $main_image = base_url()."front/images/nochats.png";

      $message =
      "<html>
            <head>
              <title>Your booking has been confirmed</title>
            </head>
            <body><div>
              <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
              <h2>APPOINTMENT CONFIRMED.</h2>
              <p>Your Appointment Booked on ".$book_date."<br/>
              Your Order ID: #".$email_data[0]->order_id."</p>
              <p>Shop name: ".$shop_data->shop_name."<br/> Address: ".$shop_data->addline1.$address2.$city.$state.$zipcode."<br/>";
              foreach ($email_data as $key => $val) {
                $this->db->select('name');
                $this->db->from('workers');
                $this->db->where('id',$val->worker_id);
                $worker_name = $this->db->get()->row();
                $from_time = date('h:i A', strtotime($val->from_time));
                $to_time = date('h:i A', strtotime($val->to_time));
                $message .= "Service: ".$val->service_name."<br/> Worker: ".$worker_name->name."<br/>Time : ".$from_time."  to ".$to_time."<br/>";
              }
      $message .= "</br>".$var->firstname." ".$var->lastname." has booked</p>
      <p>You don’t need to do anything else!<br/>We will send you text reminder before the appointment</p>
      </div><p>To change or cancel a booking, log into: <a href=".$site_url.">GGGroom.com</a></p>
      </body></html>";
      // echo $message;exit;
      $this->email->initialize(array(
        'protocol' => 'mail',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'pratikvekariya',
        'smtp_pass' => 'pratik123#',
        'smtp_port' => 587,
        'crlf' => "\r\n",
        'newline' => "\r\n"
      ));

      $this->email->set_mailtype("html");
      $this->email->from('info@gggroom.com');
      $this->email->to($email);
      $this->email->subject('Your booking has been confirmed');
      $this->email->message($message);
      if($this->email->send())
      {
        return true;
      }else{
        return false;
      }
    }
    public function get_poll_submissions($table_name = "", $where_cond = array()) {
        $this->db->select('poll_answer.*, user.id, user.firstname, user.lastname, user.email, user.u_category, user.poll_submit, user.image, poll_qst.qst');
        $this->db->from($table_name);
        $this->db->where($where_cond);
        $this->db->join('user', 'user.id=poll_answer.user_id', 'left');
        $this->db->join('poll_qst', 'poll_qst.qst_id=poll_answer.qst_id', 'left');
        // $this->db->order_by('id', 'desc');
        $this->db->group_by('qst_id');
        return $this->db->get()->result_array();
    }
}
