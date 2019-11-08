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
    public function check_exist_data($field = "", $table_name = "", $where_cond = array('is_deleted'=>0)) {
      // echo "<pre>"; print_r($where_cond); exit;
        $this->db->select($field);
        $this->db->from($table_name);
        $this->db->where($where_cond);
        // $this->db->get()->row();
        // echo $this->db->last_query();exit;
        return $this->db->get()->row();

    }
    public function display_poll()
    {
      $query = $this->db->get('poll_qst');
            return $query->row();
    }
    public function insert_user($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function sendConfirmationEmail($u_data){
      // echo '<pre>';print_r($u_data);exit;
      $email = $u_data['email'];
      // $fname = $u_data['firstname'];
      // $uname = $u_data['username'];
      $password = $u_data['password'];
      $code = $u_data['code'];
      $main_image = base_url()."front/images/nochats.png";

      $message =
      "<html>
            <head>
              <title>Verification Code</title>
            </head>
            <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <p>Hi,</p>
            <p>Thank you for becoming a GGGroom user. We’re excited that you’ve joined.</p>
            <p><b>Your Account:</b><br/>Email: ".$email."<br/>Password: ".$password."</p>
            <p><b>Your verification code:</b><br/>".$code."</p>
            </body>
            </html>";

      $this->load->library('email');
      $this->email->initialize(array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'gggroom',
        'smtp_pass' => 'Un1versa1',
        'smtp_port' => 587,
        'crlf' => "\r\n",
        'newline' => "\r\n"
        ));
        $this->email->set_mailtype("html");
      $this->email->from('info@gggroom.com');
      $this->email->to($email);
      $this->email->subject('Signup Verification Email');
      $this->email->message($message);
      if($this->email->send())
      {
        return true;
      }else{
        return false;
      }
    }

    public function getUser($user_email){
    $query = $this->db->get_where('user',array('email'=>$user_email));
    return $query->row_array();
  }

  public function activate($data, $user_email){
    $this->db->where('user.email', $user_email);
    return $this->db->update('user', $data);
  }

  public function check_data($table, $where_cond = array()) {
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where($where_cond);
      $row = $this->db->get()->result();
      return $row;
  }

  public function check_verification($table, $where_cond = array()) {
      // $this->db->select($field);
      $this->db->from($table);
      $this->db->where($where_cond);
      $row = $this->db->get()->row();
      return $row;
  }

  public function update_verification_code($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function change_password($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function password_check($pw, $uid){
      $qry = $this->db->select('*')
                      ->from('user')
                      ->where(array("password"=>$pw,"id"=>$uid))
                      ->get()->result();
      return $qry;
    }

    public function change_pwd_Email($email, $firstname){
      $main_image = base_url()."front/images/nochats.png";
      $message =
      "<html>
            <head>
              <title>Change Password</title>
            </head>
            <body>
              <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
              <p><b>You’re all set</b></p>
              <p>Hi ".$firstname.",</p>
              <p>Your GGGroom password has been updated. If you did not request a password change, please contact Customer Service</p><br/>
              <p>Sincerely,<br/>GGGroom</p>
            </body>
            </html>";

      // $emailBody = 'Your password has been updated, Try to Login with the new Password.';
      $this->load->library('email');

      $this->email->initialize(array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'gggroom',
 'smtp_pass' => 'Un1versa1',
        'smtp_port' => 587,
        'crlf' => "\r\n",
        'newline' => "\r\n"
      ));
      $this->email->set_mailtype("html");
      $this->email->from('info@gggroom.com');
      $this->email->to($email);
      $this->email->subject('GGGroom');
      $this->email->message($message);
      if($this->email->send())
      {
          return true;
      }else
      {
          return false;
      }
    }

  public function forgot_pwd_Email($email, $token){

    $main_image = base_url()."front/images/nochats.png";
    $ChangePassUrl = site_url("passwordreset/" . $token);

    $message =
    "<html>
          <head>
            <title>Forgot Password</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <p>Please click this link to reset your password :'.$ChangePassUrl</p>
          </body>
          </html>";

    // $emailBody = 'Please click this link to reset your password :'.$ChangePassUrl;
    $this->load->library('email');

    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));
    $this->email->set_mailtype("html");
    $this->email->from('info@gggroom.com');
    $this->email->to($email);
    $this->email->subject('GGGroom');
    $this->email->message($message);
    if($this->email->send())
    {
        return true;
    }else
    {
        return false;
    }
  }

  public function get_user_data($field = "", $table_name = "", $where_cond = array(), $flag="") {
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

  public function update_user_data($data, $table_name = "", $where_cond = array()) {
    // echo '<pre>';print_r($data);exit;
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      // echo $this->db->last_query();exit;
      return $this->db->affected_rows();
  }

  public function get_shop_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_shop_data_id($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function get_worker_shop_data($field = "", $table_name = "", $where_cond = array(), $all_u_id) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->where_in('user_id', $all_u_id);
      return $this->db->get()->result();
  }

  public function get_allshop_images($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_business_hours_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function insert_shop_images($data, $table_name) {
      $this->db->insert($table_name, $data);
      $id = $this->db->insert_id();
      $this->db->select('*');
      $this->db->from('shop_images');
      $this->db->where('id',$id);
      return $this->db->get()->row();
  }

  public function shop_business_hours_time_exists($table_name, $where_cond = array()) {

    $from_time = strtotime($where_cond['from_time']);
    $to_time = strtotime($where_cond['to_time']);
    $time_diff =  round(abs($to_time - $from_time) / 60,2);
    $duration = 15;
    $array_of_time = array ();

      $add_mins  = $duration * 60;

      while ($from_time <= $to_time) // loop between time
      {
         $array_of_time[] = date ("h:ia", $from_time);
         $from_time += $add_mins; // to check endtie=me
       }
        $count = 0;
       foreach($array_of_time as $item){
        $item = substr_replace($item, '', 0, min(1, strspn($item, '0')));
         $this->db->from($table_name);
         $this->db->where('from_time <', $item);
         $this->db->where('to_time >', $item);
         $this->db->where('hours_day', $where_cond['hours_day']);
         $this->db->where('shop_id', $where_cond['shop_id']);
         $row =  $this->db->get()->row();
         // echo '<pre>';print_r($row);exit;
         if($row){
           $count ++;
         }
       }
       return $count;
  }

  public function shop_breaks_time_exists($table_name, $where_cond = array()) {

    $from_time = strtotime($where_cond['from_time']);
    $to_time = strtotime($where_cond['to_time']);
    $time_diff =  round(abs($to_time - $from_time) / 60,2);
    $duration = 15;
    $array_of_time = array ();

      $add_mins  = $duration * 60;

      while ($from_time <= $to_time) // loop between time
      {
         $array_of_time[] = date ("h:ia", $from_time);
         $from_time += $add_mins; // to check endtie=me
       }
        $count = 0;
       foreach($array_of_time as $item){
        $item = substr_replace($item, '', 0, min(1, strspn($item, '0')));
         $this->db->from($table_name);
         $this->db->where('from_time <', $item);
         $this->db->where('to_time >', $item);
         $this->db->where('day', $where_cond['day']);
         $this->db->where('shop_id', $where_cond['shop_id']);
         $row =  $this->db->get()->row();
         // echo '<pre>';print_r($row);exit;
         if($row){
           $count ++;
         }
       }
       return $count;
  }

  public function update_shop_data($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      // echo $this->db->last_query();exit;
      return $this->db->affected_rows();
  }
  public function update_business_hours_availability_time($data, $table_name) {
      $this->db->insert($table_name, $data);
      return $this->db->insert_id();
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

  public function delete_shop($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function get_worker_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_worker_data1($table_name = "", $where_cond = array()) {
      $this->db->select('workers.*')
                ->from($table_name)
                // ->join('worker_available_time', 'workers.id=worker_available_time.worker_id', 'left')
                // ->group_by('workers.id')
                ->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_worker_business_hours_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_worker_data_id($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function update_worker_data($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      // echo $this->db->last_query();exit;
      return $this->db->affected_rows();
  }

  public function worker_business_hours_time_exists($table_name, $where_cond = array()) {

    $from_time = strtotime($where_cond['from_time']);
    $to_time = strtotime($where_cond['to_time']);
    $time_diff =  round(abs($to_time - $from_time) / 60,2);
    $duration = 15;
    $array_of_time = array ();

      $add_mins  = $duration * 60;

      while ($from_time <= $to_time) // loop between time
      {
         $array_of_time[] = date ("h:ia", $from_time);
         $from_time += $add_mins; // to check endtie=me
       }
        $count = 0;
       foreach($array_of_time as $item){
        $item = substr_replace($item, '', 0, min(1, strspn($item, '0')));
         $this->db->from($table_name);
         $this->db->where('from_time <', $item);
         $this->db->where('to_time >', $item);
         $this->db->where('worker_day', $where_cond['worker_day']);
         $this->db->where('worker_id', $where_cond['worker_id']);
         $row =  $this->db->get()->row();
         // echo '<pre>';print_r($row);exit;
         if($row){
           $count ++;
         }
       }
       return $count;
  }

  public function insert_shop_data($data, $table_name) {
      $this->db->insert($table_name, $data);
      return $this->db->insert_id();
  }

  public function insert_worker_data($data, $table_name) {
      $this->db->insert($table_name, $data);
      return $this->db->insert_id();
  }

  public function get_worker_data_by_id($table_name = "", $where_cond = array()) {
    // echo '<pre>'; print_r($where_cond['workers.id']); exit;
    $this->db->select('workers.*, vacation_module.id as vacation_id, vacation_module.all_day as all_day, vacation_module.flag as flag, vacation_module.start_date as vacation_start,vacation_module.end_date as vacation_end');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->join('vacation_module', 'vacation_module.user_id=workers.id', 'left');
    return $this->db->get()->row();
  }

  public function get_worker_hours($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_main_category($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }
  public function get_all_category($field = "", $table_name = "", $where_cond = array(), $permission, $user_id){
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if($permission == 2){
        $this->db->where('user_id', $user_id);
      }else{
        $this->db->where('permission', 1);
      }
      return $this->db->get()->row();
  }

  public function get_cat_subcat_data($cat_id) {
      $this->db->select('services.*, shop.shop_name, shop.id as shop_id, category.parent_id');
      $this->db->from('category');
      $this->db->where(array('category.parent_id' => $cat_id, 'category.is_deleted' => 0));
      $this->db->join('services', 'services.cat_id=category.category_id');
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      // $this->db->group_by('category.parent_id');

      return $this->db->get()->result();
  }

  public function insert_services_data($data, $table_name) {
      $this->db->insert($table_name, $data);
      return $this->db->insert_id();
  }

  public function get_service_data_id($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function delete_service($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function update_service_data($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      // echo $this->db->last_query();exit;
      return $this->db->affected_rows();
  }

  public function get_service_all_data( $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }

  public function get_service_category1( $table_name = "", $where_cond = array()) {
      $this->db->select('category.cat_name, category.parent_id as cat_parent_id ');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function get_service_data_id_shop_name1( $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name, shop.cancel_policy as shop_cancel_policy, shop.image as shop_image, shop.description as shop_description, workers.name as worker_name, workers.image as worker_image');
      $this->db->from($table_name);
      $this->db->where($where_cond);
     // $this->db->join('shop', 'services.shop_id=shop.id', 'left');
       $this->db->join('shop', 'shop.id=1', 'left');
      //$this->db->join('workers', 'services.worker_id=workers.id', 'left');
      // $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->row();
  }

  public function get_service_data_id_shop_name( $table_name = "", $where_cond = array(),$shop_id) {
      $this->db->select('services.*, shop.shop_name,shop.start_time,shop.end_time, shop.cancel_policy as shop_cancel_policy, shop.image as shop_image, shop.description as shop_description');
      $this->db->from($table_name);
      $this->db->where($where_cond);
     // $this->db->join('shop', 'services.shop_id=shop.id', 'left');
       $this->db->join('shop', 'shop.id='.$shop_id, 'left');
      //$this->db->join('workers', 'services.worker_id=workers.id', 'left');
      // $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->row();
  }
 
  public function get_service_all_data_category( $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      // $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      //$this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }
  public function get_worker_data_id_appointment( $table_name = "", $where_cond = array(), $service_id) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where_in('services.id', $service_id);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_sub_category_data_exist( $table_name = "", $service_id) {
    // echo trim($service_id, "''");exit;
    // echo $service_id;exit;
      // print_r(explode(',',$service_id));exit;
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->join('category', 'category.category_id = services.cat_id', 'left');
      $this->db->where_in('services.id', explode(',',$service_id));
      // $this->db->get()->result();
      // echo $this->db->last_query();exit;
      return $this->db->get()->result();
  }

  public function get_workers_category1( $table_name = "", $where_cond = array()) {
      $this->db->select('workers.id as worker_id, workers.name as worker_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      // $this->db->where('workers.id', $w_id);
      return $this->db->get()->result();
  }

    public function check_worker_time($table_name = "", $where_cond = array()) {
       $query = $this->db->query("SELECT * FROM `worker_available_time` WHERE CONVERT(from_time,TIME) <= CONVERT('".$where_cond['from_time']."',TIME) AND CONVERT(to_time,TIME) > CONVERT('".$where_cond['to_time']."',TIME) AND `worker_day` = '".$where_cond['worker_day']."' AND `worker_id` = ".$where_cond['worker_id']);
       return $query->result();
    }
    public function check_worker_appointment_time($table_name = "", $where_cond = array()) {

       $query = $this->db->query("SELECT * FROM `appointment` WHERE CONVERT(from_time,TIME) <= CONVERT('".$where_cond['from_time']."',TIME) AND CONVERT(to_time,TIME) >= CONVERT('".$where_cond['to_time']."',TIME) AND `ap_date` = '".$where_cond['ap_date']."' AND `user_id` = '".$where_cond['user_id']."' AND `shop_id` = '".$where_cond['shop_id']."' AND `service_id` = '".$where_cond['service_id']."' AND `worker_id` = ".$where_cond['worker_id']);

       return $query->result();
    }

    public function insert_appointment($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

  //bhargav
  public function GetChatsData($where_cond=array(),$senderId="",$receiverId="",$user_id="")
  {
      if(!empty($senderId) && !empty($receiverId))
      {
        $userIdsData = $receiverId.','.$senderId;
      }
      elseif(!empty($senderId))
      {
        $userIdsData = $senderId;
      }
      elseif(!empty($receiverId))
      {
        $userIdsData = $receiverId;
      }
      $this->db->select("
      c.sender_id,
      c.receiver_id,
      c.msg,
      c.date,
      c.type,
      CONCAT(u1.firstname,' ',u1.lastname) as sender_name,
      CONCAT(u2.firstname,' ',u2.lastname) as receiver_name,
      u1.image as sender_image,
      u2.image as receiver_image
          ",false);
      $this->db->from('chat c');
      $this->db->join('user u1', 'u1.id = c.sender_id', 'left');
      $this->db->join('user u2', 'u2.id = c.receiver_id', 'left');
      if(!empty($user_id))
      {
        $this->db->where('c.sender_id IN ('.$user_id.')');
        $this->db->where('c.receiver_id IN ('.$user_id.')');
      }
      else
      {
        $this->db->where('c.sender_id IN ('.$userIdsData.')');
        $this->db->where('c.receiver_id IN ('.$userIdsData.')');
      }
      $this->db->where($where_cond);
      $this->db->order_by('c.date ASC');
      return $this->db->get()->result_array();
  }

  /**
   * create_category function.
   *
   * @access public
   * @param mixed $data
   * @param mixed $table_name
   * @return bool true on success, false on failure
   */
  public function create_general_data($data,$table_name) {
    $this->db->insert($table_name, $data);
    $insert_id = $this->db->insert_id();
    return $insert_id;
  }

  /**
   * get_all_general_data function.
   *
   * @access public
   * @param mixed $field
   * @param mixed $table_name
   * @param mixed $where_cond
   * @param mixed $return result_array or row
   * @param mixed $order_by
   * @param mixed $limit
   * @return object array of the data
   */
  public function get_all_general_data($field="", $table_name="", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "",$group_by="",$where_in=array()) {
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

  /**
   * delete_physical_data function.
   *
   * @access public
   * @param mixed $data
   * @param mixed $table_name
   * @param mixed $where_cond
   * @return bool true on success, false on failure
   */
  public function delete_physical_data($where_cond = array(), $table_name="")
  {
    $this->db->where($where_cond);
    return $this->db->delete($table_name);
  }

  public function GetUserFavouriteData($where_cond = array(),$limit,$start) {
      $this->db->select('services.*, shop.shop_name, category.parent_id');
      $this->db->from('favourite as fv');
      $this->db->where($where_cond);
      $this->db->join('services', 'services.id=fv.service_id', 'left');
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'fv.user_id=user.id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function appointment_book_sendConfirmationEmail($email_data){
    $u_id = $this->session->userdata('uid');
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
    }
    $site_url = base_url();
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Your booking has been pending</title>
          </head>
          <body><div>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>APPOINTMENT</h2>
            <p>Your Appointment Date: ".$book_date."<br/>
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
    <p>You don’t need to do anything else!<br/>We will send you confirmation email as soon as possible and text reminder before the appointment</p>
    </div><p>To change or cancel a booking, log into: <a href=".$site_url.">GGGroom.com</a></p>
    </body></html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
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
  public function get_order_booking_data($field, $table_name, $where_cond = array()) {
    // echo $where_cond;exit;
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
      // return $this->db->last_query();
  }

  public function get_appointment_all_data( $table_name = "", $where_cond = array(),$limit,$start) {
    // echo $where_cond;exit;
    $this->db->select('appointment.*, shop.shop_name, shop.mobile as shop_mobile, shop.addline1, shop.addline2, shop.city, shop.state, shop.zipcode, shop.image as shop_image, workers.image as worker_image, workers.name as worker_name, services.price, services.id as main_service_id, services.image as service_image,shop.user_id as mainuser');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->join('shop', 'appointment.shop_id=shop.id', 'left');
    $this->db->join('workers', 'appointment.worker_id=workers.id', 'left');
    $this->db->join('services', 'appointment.service_id=services.id');
    // $this->db->join('user', 'appointment.user_id=user.id', 'left');
    $this->db->order_by('appointment.created_at','DESC');
    $this->db->group_by('appointment.id');
    $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function insert_all_services($data, $table_name) {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where('cat_id', $data['cat_id']);
        $this->db->where('shop_id', $data['shop_id']);
        $this->db->where('is_deleted', 0);
        $data1 =  $this->db->get()->row();

        if(count($data1) > 0){
          $result = '';
          return $result;
        }
        else{
          $this->db->insert($table_name, $data);
          return $this->db->insert_id();
        }
  }

  public function update_all_services($data, $table_name, $where_cond = array()) {
    $this->db->where($where_cond);
    $this->db->update($table_name, $data);
    return $this->db->affected_rows();
  }

  /**
   * update_general_data function.
   *
   * @access public
   * @param mixed $data
   * @param mixed $table_name
   * @param mixed $where_cond
   * @return bool true on success, false on failure
   */
  public function update_general_data($data, $table_name="", $where_cond = array())
  {
    $this->db->where($where_cond);
    return $this->db->update($table_name, $data);
    // echo $this->db->last_query();exit;
  }
  public function count_rating_review( $table_name = "", $where_cond = array()) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      // $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function GetWorkerAppointments( $where_cond = array()) {
    $this->db->select('appointment.*, shop.shop_name, shop.addline1, shop.addline2, shop.city, shop.state, shop.zipcode, workers.image as worker_image, workers.name as worker_name, services.price, services.id as main_service_id, services.image as service_image,user.firstname,user.lastname');
    $this->db->from('appointment');
    $this->db->where($where_cond);
    $this->db->join('shop', 'appointment.shop_id=shop.id', 'left');
    $this->db->join('workers', 'appointment.worker_id=workers.id', 'left');
    $this->db->join('services', 'appointment.service_id=services.id', 'left');
    $this->db->join('user', 'user.id=appointment.user_id', 'left');
      return $this->db->get()->result();
  }

  public function get_top_rated_services( $table_name = "", $where_cond = array()) {
      $this->db->select('rating_review.*, shop.shop_name, shop.id as shop_id, category.parent_id, services.cat_id, services.service_name, services.worker_id, services.id as main_service_id, services.image, services.price');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'rating_review.shop_id=shop.id', 'left');
      $this->db->join('services', 'rating_review.service_id=services.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'rating_review.user_id=user.id', 'left');
      $this->db->order_by('rating_review.star', 'DESC');
      // $this->db->order_by('rating_review.created_date', 'DESC');
      $this->db->limit('5');

      // $this->db->join('category', 'rating_review.cat_id=category.category_id', 'left');
       return $this->db->get()->result();
      // echo $this->db->last_query();exit;
  }

  public function get_top_rated_user( $table_name = "", $where_cond = array()) {
      $this->db->select('rating_review.*, user.firstname, user.lastname, user.image, services.service_name, shop.shop_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('user', 'rating_review.user_id=user.id', 'left');
      $this->db->join('services', 'rating_review.service_id=services.id', 'left');
      $this->db->join('shop', 'rating_review.shop_id=shop.id', 'left');
      // $this->db->group_by('user.id');
      $this->db->order_by('rating_review.star', 'DESC');
      // $this->db->order_by('rating_review.created_date', 'DESC');
      $this->db->limit('4');

      // $this->db->join('category', 'rating_review.cat_id=category.category_id', 'left');
       return $this->db->get()->result();
      // echo $this->db->last_query();exit;
  }

  public function get_shop_business_hours($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_day_by_week($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function get_filter_service_data( $table_name = "", $where_cond = array()) {
      $this->db->select('id, service_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->group_by('service_name');
      return $this->db->get()->result();
  }

  public function get_filter_shop_data( $table_name = "", $where_cond = array()) {
      $this->db->select('id, shop_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      // $this->db->group_by('shop_name');
      return $this->db->get()->result();
  }

  public function get_filter_data_list( $table_name = "", $where_cond = array(), $filter_services,$filter_shops,$filter_sorting, $filter_date, $filter_min_price, $filter_max_price, $filter_location, $limit, $start) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, shop.latitude, shop.longitude, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($filter_location))
      {
        $this->db->like('shop.city', $filter_location);
      }
      if(!empty($filter_services))
      {
          $this->db->like('services.service_name', $filter_services);
      }
      // if(!empty($filter_shops))
      // {
      //     $this->db->where('services.shop_id', $filter_shops);
      // }
      if(!empty($filter_date))
      {
          $this->db->where('services.created_at', $filter_date);
      }

      if(!empty($filter_min_price) && !empty($filter_max_price)){
        $this->db->where("services.price BETWEEN $filter_min_price AND $filter_max_price");
      }
      elseif(!empty($filter_min_price)){
        $this->db->where('services.price <=', $filter_min_price);
      }
      elseif(!empty($filter_max_price)){
        $this->db->where('services.price >=', $filter_max_price);
      }
      //$this->db->join('shop', 'services.shop_id=shop.id', 'left');
     if(!empty($filter_shops))
     {
       //$this->db->join('shop', 'shop.id='.$filter_shops, 'left');
        $this->db->where('shop.id', $filter_shops);
     }
     
     
      $this->db->join('shop',("FIND_IN_SET(services.id ,shop.service_id )"), 'inner');
    
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      //$this->db->join('user', 'services.user_id=user.id', 'left');
      // $this->db->join('workers',("FIND_IN_SET(workers.id , services.worker_id)"), 'inner');
      if(!empty($filter_sorting))
      {
          $this->db->order_by('services.price '.$filter_sorting);
      }
      $this->db->limit($limit,$start);
      return $this->db->get()->result();

      // echo $this->db->last_query();exit;
  }

  public function get_filter_data_list_main( $table_name = "", $where_cond = array(), $filter_services,$filter_shops,$filter_sorting, $filter_date, $filter_min_price, $filter_max_price, $filter_location) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, shop.latitude, shop.longitude, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($filter_location))
      {
        $this->db->like('shop.city', $filter_location);
      }
      if(!empty($filter_services))
      {
          $this->db->like('services.service_name', $filter_services);
      }
      if(!empty($filter_shops))
      {
          $this->db->where('shop.id', $filter_shops);
      }
      if(!empty($filter_date))
      {
          $this->db->where('services.created_at', $filter_date);
      }

      if(!empty($filter_min_price) && !empty($filter_max_price)){
        $this->db->where("services.price BETWEEN $filter_min_price AND $filter_max_price");
      }
      elseif(!empty($filter_min_price)){
        $this->db->where('services.price <=', $filter_min_price);
      }
      elseif(!empty($filter_max_price)){
        $this->db->where('services.price >=', $filter_max_price);
      }

      $this->db->join('shop',("FIND_IN_SET(services.id ,shop.service_id )"), 'inner');
     // $this->db->join('shop', 'services.shop_id=shop.id', 'left');

      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      //$this->db->join('user', 'services.user_id=user.id', 'left');
      // $this->db->join('workers',("FIND_IN_SET(workers.id , services.worker_id)"), 'inner');
      if(!empty($filter_sorting))
      {
          $this->db->order_by('services.price '.$filter_sorting);
      }
      return $this->db->get()->result();

      // echo $this->db->last_query();exit;
  }

  public function get_related_services( $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name, shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }
   public function get_related_services_new( $table_name = "", $where_cond = array(),$shop_id) {
      $this->db->select('services.*, shop.shop_name, shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'shop.id='.$shop_id, 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }
  public function get_other_services( $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name, shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }
    public function get_other_services_new( $table_name = "", $where_cond = array(),$shop_id) {
      $this->db->select('services.*, shop.shop_name, shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'shop.id='.$shop_id, 'left');
     // $this->db->join('shop', $shop_id='shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      //$this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }
  public function get_services_data( $table_name = "", $where_cond = array(), $limit, $start) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function delete_profile($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function update_notification($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function update_card_details($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function get_all_city_name($field="", $table_name="", $where_cond = array()) {
    $this->db->select($field);
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->group_by('city');
    return $this->db->get()->result();
  }

  public function get_category_name($field="", $table_name="", $where_cond = array()) {
    $this->db->select($field);
    $this->db->from($table_name);
    $this->db->where($where_cond);
    return $this->db->get()->row();
  }

  public function get_worker_time($field="", $table_name="", $where_cond = array()) {
    $this->db->select($field);
    $this->db->from($table_name);
    $this->db->where($where_cond);
    return $this->db->get()->result();
  }

  public function search_shop_get_data( $table_name = "", $where_cond = array(), $limit, $start) {
      $this->db->select('shop.*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('user', 'shop.user_id=user.id', 'left');
      // $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      // $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function search_shop_get_data_all( $table_name = "", $where_cond = array()) {
      $this->db->select('shop.*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('user', 'shop.user_id=user.id', 'left');
      return $this->db->get()->result();
  }

  public function search_service_get_data( $table_name = "", $where_cond = array(), $limit, $start) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function search_service_get_data_new( $table_name = "", $total_service_list, $limit, $start,$shop_id) {

   
     $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from('services');
      $this->db->where_in('services.id', $total_service_list);
      $this->db->join('shop', 'shop.id='.$shop_id, 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function search_service_get_data1( $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      // $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function search_service_get_data2( $table_name = "", $where_cond = array(), $limit, $start) {
      $this->db->select('services.*,  category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function search_shop_get_data1( $table_name = "", $where_cond = array()) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('user', 'shop.user_id=user.id', 'left');
      // $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      // $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      // $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  

  public function get_all_shop_data( $table_name = "", $where_cond = array()) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      // $this->db->group_by('shop_name');
      return $this->db->get()->result();
  }

  public function get_service_by_shop_id($shop_id_Arr, $table_name = "", $where_cond = array(), $limit, $start) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->where_in('services.shop_id',$shop_id_Arr);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      $this->db->limit($limit,$start);
      return $this->db->get()->result();
  }

  public function get_service_by_shop_id_all($shop_id_Arr, $table_name = "", $where_cond = array()) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->where_in('services.shop_id',$shop_id_Arr);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }

  public function get_filter_data_list1($shop_id_Arr, $table_name = "", $where_cond = array(), $filter_services,$filter_shops,$filter_sorting, $filter_date, $filter_min_price, $filter_max_price, $filter_location, $limit, $start) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, shop.latitude, shop.longitude, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($filter_location))
      {
        $this->db->like('shop.city', $filter_location);
      }
      if(!empty($filter_services))
      {
          $this->db->like('services.service_name', $filter_services);
      }
      // if(!empty($filter_shops))
      // {
      //     $this->db->where('services.shop_id', $filter_shops);
      // }
      if(!empty($filter_date))
      {
          $this->db->where('services.created_at', $filter_date);
      }

      if(!empty($filter_min_price) && !empty($filter_max_price)){
        $this->db->where("services.price BETWEEN $filter_min_price AND $filter_max_price");
      }
      elseif(!empty($filter_min_price)){
        $this->db->where('services.price <=', $filter_min_price);
      }
      elseif(!empty($filter_max_price)){
        $this->db->where('services.price >=', $filter_max_price);
      }
      //$this->db->where_in('services.shop_id',$shop_id_Arr);
      //$this->db->join('shop', 'services.shop_id=shop.id', 'left');
       $this->db->join('shop',("FIND_IN_SET(services.id ,shop.service_id )"), 'inner');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      //$this->db->join('user', 'services.user_id=user.id', 'left');
      if(!empty($filter_sorting))
      {
          $this->db->order_by('services.price '.$filter_sorting);
      }
      $this->db->limit($limit,$start);
      return $this->db->get()->result();

      // echo $this->db->last_query();exit;
  }

  public function get_filter_data_list_all($shop_id_Arr, $table_name = "", $where_cond = array(), $filter_services,$filter_shops,$filter_sorting, $filter_date, $filter_min_price, $filter_max_price, $filter_location) {
      $this->db->select('services.*, shop.shop_name , shop.id as shop_id, shop.latitude, shop.longitude, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      if(!empty($filter_location))
      {
        $this->db->like('shop.city', $filter_location);
      }
      if(!empty($filter_services))
      {
          $this->db->like('services.service_name', $filter_services);
      }
      if(!empty($filter_shops))
      {
          $this->db->where('services.shop_id', $filter_shops);
      }
      if(!empty($filter_date))
      {
          $this->db->where('services.created_at', $filter_date);
      }

      if(!empty($filter_min_price) && !empty($filter_max_price)){
        $this->db->where("services.price BETWEEN $filter_min_price AND $filter_max_price");
      }
      elseif(!empty($filter_min_price)){
        $this->db->where('services.price <=', $filter_min_price);
      }
      elseif(!empty($filter_max_price)){
        $this->db->where('services.price >=', $filter_max_price);
      }
      $this->db->where_in('services.shop_id',$shop_id_Arr);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      if(!empty($filter_sorting))
      {
          $this->db->order_by('services.price '.$filter_sorting);
      }
      return $this->db->get()->result();
  }

  public function check_breaks_time_exists($table_name, $where_cond = array()) {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    return $this->db->get()->row();
  }

  public function uncheck_hours_day_checkbox($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  function delete_worker_hours_time($table_name = "", $where_cond = array())
  {
      $this->db->where($where_cond);
      $this->db->delete($table_name);
  }

  public function change_user_email($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function get_page_data_id($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function get_footer_page_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function get_service_data_by_worker_shopid( $table_name = "", $where_cond = array(),$shop_id) {
    $this->db->select('services.*,shop_images.image as shop_image, category.parent_id, shop.shop_name,shop.id as shop_id');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    //$this->db->join('shop', 'services.shop_id=shop.id', 'left');
     $this->db->join('shop', 'shop.id='.$shop_id, 'left');
    $this->db->join('shop_images', 'services.shop_id=shop_images.shop_id', 'left');
    $this->db->join('category', 'services.cat_id=category.category_id', 'left');
   // $this->db->join('user', 'services.user_id=user.id', 'left');
   // $this->db->join('workers',("FIND_IN_SET(workers.id , services.worker_id)"), 'inner');
      return $this->db->get()->row();
  }
  

   public function get_service_data_by_worker_shopid_new1( $table_name = "", $where_cond = array(),     $shop_id = "") {
  
    $this->db->select('services.*,shop_images.image as shop_image, category.parent_id, shop.shop_name');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->join('shop', 'shop.id='.$shop_id, 'left');
    $this->db->join('shop_images', 'shop_images.shop_id='.$shop_id, 'left');
    $this->db->join('category', 'services.cat_id=category.category_id', 'left');
    //$this->db->join('user', 'services.user_id=user.id', 'left');
    //$this->db->join('workers',("FIND_IN_SET(workers.id , services.worker_id)"), 'inner');
      return $this->db->get()->row();
  }

  public function get_service_data_by_worker_shopid_new( $table_name = "", $where_cond = array(),$shop_id) {
      $this->db->select('services.*,shop_images.image as shop_image, category.parent_id,
        shop.shop_name,shop.id as shop_id');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->join('shop', 'shop.id='.$shop_id, 'left');
    $this->db->join('shop_images', 'shop_images.shop_id='.$shop_id, 'left');
    $this->db->join('category', 'services.cat_id=category.category_id', 'left');
   // $this->db->join('user', 'services.user_id=user.id', 'left');
    //$this->db->join('workers',("FIND_IN_SET(workers.id , services.worker_id)"), 'inner');
      return $this->db->get()->row();
  }

  public function get_select_service_data( $table_name = "", $where_cond = array(), $service_id) {
      $this->db->select('services.*,shop.shop_name, category.parent_id');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->where_in('services.id', $service_id);
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'services.user_id=user.id', 'left');
      return $this->db->get()->result();
  }

  public function get_appointment_all_data1( $table_name = "", $where_cond = array()) {
    $this->db->select('appointment.*, shop.shop_name, shop.mobile as shop_mobile, shop.addline1, shop.addline2, shop.city, shop.state, shop.zipcode, workers.image as worker_image, workers.name as worker_name, services.price, services.id as main_service_id, services.image as service_image,shop.user_id as mainuser');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->join('shop', 'appointment.shop_id=shop.id', 'left');
    $this->db->join('workers', 'appointment.worker_id=workers.id', 'left');
    $this->db->join('services', 'appointment.service_id=services.id');
    // $this->db->join('user', 'appointment.user_id=user.id', 'left');
    $this->db->order_by('appointment.created_at','DESC');
      return $this->db->get()->result();
  }
  public function GetUserFavouriteData1($where_cond = array()) {
      $this->db->select('services.*, shop.shop_name, category.parent_id');
      $this->db->from('favourite as fv');
      $this->db->where($where_cond);
      $this->db->join('services', 'services.id=fv.service_id', 'left');
      $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      $this->db->join('category', 'services.cat_id=category.category_id', 'left');
      $this->db->join('user', 'fv.user_id=user.id', 'left');
      return $this->db->get()->result();
  }

  public function get_all_state_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function active_inactive_user($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function get_all_appointment_data($field="", $table_name = "", $where_cond = array()) {
    $this->db->select($field);
    $this->db->from($table_name);
    $this->db->where($where_cond);
    return $this->db->get()->result();
  }

  public function update_appointment_status($data, $table_name = "", $where_cond = array()) {
      $this->db->where($where_cond);
      $this->db->update($table_name, $data);
      return $this->db->affected_rows();
  }

  public function appointment_book_sendConfirmationEmail_worker($email_data){
    // echo '<pre>';print_r($appointment_data);exit;
    $u_id = $email_data[0]->worker_id;
    $this->db->select('email');
    $this->db->from('workers');
    $this->db->where('id',$u_id);
    $var = $this->db->get()->row();
    $email = $var->email;
    $date = $email_data[0]->ap_date;
    $book_date = date("d-m-Y", strtotime($date));
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Appointment Confirm</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>Booking details.</h2>
            <p>Appointment Booked on ".$book_date."</p>
            <p>Order ID: #".$email_data[0]->order_id."</p>";

            foreach ($email_data as $key => $val) {
              // echo $val->worker_id;exit;
              $this->db->select('name');
              $this->db->from('workers');
              $this->db->where('id',$val->worker_id);
              $worker_name = $this->db->get()->row();
              $from_time = date('h:i A', strtotime($val->from_time));
              $to_time = date('h:i A', strtotime($val->to_time));
              $message .="<p>".$val->service_name." : ".$from_time."  to ".$to_time."</p>";
            }

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from('info@gggroom.com');
    $this->email->to($email);
    $this->email->subject('Appointment Booked');
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
  }

  public function appointment_book_sendConfirmationEmail_shop($email_data){
    // echo '<pre>';print_r($appointment_data);exit;
    $u_id = $email_data[0]->shop_id;
    $this->db->select('shop_email');
    $this->db->from('shop');
    $this->db->where('id',$u_id);
    $var = $this->db->get()->row();
    $email = $var->shop_email;
    $date = $email_data[0]->ap_date;
    $book_date = date("d-m-Y", strtotime($date));
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Appointment Confirm</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>Booking details.</h2>
            <p>Appointment Booked on ".$book_date."</p>
            <p>Order ID: #".$email_data[0]->order_id."</p>";

            foreach ($email_data as $key => $val) {
              // echo $val->worker_id;exit;
              $this->db->select('name');
              $this->db->from('workers');
              $this->db->where('id',$val->worker_id);
              $worker_name = $this->db->get()->row();
              $from_time = date('h:i A', strtotime($val->from_time));
              $to_time = date('h:i A', strtotime($val->to_time));
              $message .="<p>".$val->service_name." by ".$worker_name->name." : ".$from_time."  to ".$to_time."</p>";
            }

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from('info@gggroom.com');
    $this->email->to($email);
    $this->email->subject('Appointment Booked');
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
  }

//Cancel appointment
public function cancel_appointment_sendemail_client($email_data){
  $u_id = $this->session->userdata('uid');
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
  $shop_name = $this->db->get()->row();
  $main_image = base_url()."front/images/nochats.png";

  $message =
  "<html>
        <head>
          <title>Appointment Cancel</title>
        </head>
        <body>
          <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
          <h2>Appointment Cancel.</h2>";
          if($var->u_category == "2"){
                $message .="<p>We’re sorry you had to cancel your booking with ".$shop_name->shop_name.".</p>
                <p>Thank you for choosing GGGroom.</p>";
          }
          else if($var->u_category == "1"){
                $message .="<p>Hi ".$shop_name->shop_name.",</p>
                <p>We regret to inform you that your client ".$var->firstname." ".$var->lastname." has cancelled the booking. Per your cancellation policy, your payout has been updated.</p>
                <p>Thank you for being a GGGroom provider.</p>";
          }
  $message .= "</body>
        </html>";
  // echo $message;exit;
  $this->email->initialize(array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.sendgrid.net',
     'smtp_user' => 'gggroom',
    'smtp_pass' => 'Un1versa1',
    'smtp_port' => 587,
    'crlf' => "\r\n",
    'newline' => "\r\n"
  ));

  $this->email->set_mailtype("html");
  $this->email->from('info@gggroom.com');
  $this->email->to($email);
  $this->email->subject('Appointment Cancel');
  $this->email->message($message);
  if($this->email->send())
  {
    return true;
  }else{
    return false;
  }
}

  public function cancel_appointment_sendemail_worker($email_data){
    // echo '<pre>';print_r($appointment_data);exit;
    $u_id = $email_data[0]->worker_id;
    $this->db->select('email');
    $this->db->from('workers');
    $this->db->where('id',$u_id);
    $var = $this->db->get()->row();
    $email = $var->email;
    $date = $email_data[0]->ap_date;
    $book_date = date("d-m-Y", strtotime($date));
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Appointment Cancel</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>Appointment Cancel.</h2>
            <p>Appointment has been cancelled for Order Id : #".$email_data[0]->order_id."</p>
            <p>Booking Date : ".$book_date."</p>";

            foreach ($email_data as $key => $val) {
              // echo $val->worker_id;exit;
              $this->db->select('name');
              $this->db->from('workers');
              $this->db->where('id',$val->worker_id);
              $worker_name = $this->db->get()->row();
              $from_time = date('h:i A', strtotime($val->from_time));
              $to_time = date('h:i A', strtotime($val->to_time));
              $message .="<p>".$val->service_name." : ".$from_time."  to ".$to_time."</p>";
            }

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
       'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from('info@gggroom.com');
    $this->email->to($email);
    $this->email->subject('Appointment Cancel');
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
  }

  public function cancel_appointment_sendemail_shop($email_data){
    // echo '<pre>';print_r($appointment_data);exit;
    $u_id = $email_data[0]->shop_id;
    $this->db->select('shop_email');
    $this->db->from('shop');
    $this->db->where('id',$u_id);
    $var = $this->db->get()->row();
    $email = $var->shop_email;
    $date = $email_data[0]->ap_date;
    $book_date = date("d-m-Y", strtotime($date));
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Appointment Cancel</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>Appointment Cancel.</h2>
            <p>Appointment has been cancelled for Order Id : #".$email_data[0]->order_id."</p>
            <p>Booking Date : ".$book_date."</p>";

            foreach ($email_data as $key => $val) {
              // echo $val->worker_id;exit;
              $this->db->select('name');
              $this->db->from('workers');
              $this->db->where('id',$val->worker_id);
              $worker_name = $this->db->get()->row();
              $from_time = date('h:i A', strtotime($val->from_time));
              $to_time = date('h:i A', strtotime($val->to_time));
              $message .="<p>".$val->service_name." by ".$worker_name->name." : ".$from_time."  to ".$to_time."</p>";
            }

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
       'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from('info@gggroom.com');
    $this->email->to($email);
    $this->email->subject('Appointment Cancel');
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
  }

  public function get_edit_user_data( $table_name = "", $where_cond = array(), $flag="") {
      $this->db->select('user.*, city.name as city_name, state.name as state_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('city', 'user.city=city.id', 'left');
      $this->db->join('state', 'user.state=state.id', 'left');
      return $this->db->get()->row();
  }

  public function get_edit_shop_data($table_name = "", $where_cond = array()) {
      $this->db->select('shop.*, city.name as city_name');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->join('city', 'shop.city=city.id', 'left');
      return $this->db->get()->row();
  }

  public function check_promocode($field, $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->row();
  }

  public function send_reminder_email_appointment($email_data){
    $u_id = $email_data[0]->user_id;
    $this->db->select('email');
    $this->db->from('user');
    $this->db->where('id',$u_id);
    $var = $this->db->get()->row();
    $email = $var->email;
    $date = $email_data[0]->ap_date;
    $book_date = date("d-m-Y", strtotime($date));
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Appointment Reminder</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>You have an appointment after 2 hours.</h2>
            <p>Appointment Date: ".$book_date."</p>
            <p>Your Order ID: #".$email_data[0]->order_id."</p>";

            foreach ($email_data as $key => $val) {
              $this->db->select('name');
              $this->db->from('workers');
              $this->db->where('id',$val->worker_id);
              $worker_name = $this->db->get()->row();
              $from_time = date('h:i A', strtotime($val->from_time));
              $to_time = date('h:i A', strtotime($val->to_time));
              $message .="<p>".$val->service_name." by ".$worker_name->name." : ".$from_time."  to ".$to_time."</p>";
            }

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
     'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from('info@gggroom.com');
    $this->email->to($email);
    $this->email->subject('Appointment Reminder');
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
  }

  public function get_all_applointment_data($field = "", $table_name = "", $where_cond = array()) {
      $this->db->select($field);
      $this->db->from($table_name);
      $this->db->where($where_cond);
      return $this->db->get()->result();
  }

  public function send_gift_email($email_data, $gift_email){
    $u_id = $this->session->userdata('uid');
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('id',$u_id);
    $var = $this->db->get()->row();
    $email = $var->email;
    $date = $email_data[0]->ap_date;
    $book_date = date("d-m-Y", strtotime($date));

    $this->db->select('shop_name');
    $this->db->from('shop');
    $this->db->where('id',$email_data[0]->shop_id);
    $shop_name = $this->db->get()->row();
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Appointment Confirm</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>Congratulation!, You have a gift from ".$var->firstname." ".$var->lastname.".</h2>
            <p>Shop Name: ".$shop_name->shop_name."</p>
            <p>Your Appointment Booked on ".$book_date."</p>
            <p>Your Order ID: #".$email_data[0]->order_id."</p>";

            foreach ($email_data as $key => $val) {
              $this->db->select('name');
              $this->db->from('workers');
              $this->db->where('id',$val->worker_id);
              $worker_name = $this->db->get()->row();
              $from_time = date('h:i A', strtotime($val->from_time));
              $to_time = date('h:i A', strtotime($val->to_time));
              $message .="<p>".$val->service_name." by ".$worker_name->name." : ".$from_time."  to ".$to_time."</p>";
            }

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from($email);
    $this->email->to($gift_email);
    $this->email->subject('Appointment Booked');
    $this->email->message($message);
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
  }

  public function send_chat_email($sender_data, $reciever_email, $userMsg, $flag, $senderId){
    $firstname = $sender_data->firstname;
    $lastname = $sender_data->lastname;
    $sender_email = $sender_data->email;
    $subject = $firstname. " ".$lastname." sent you a message";
    $main_image = base_url()."front/images/nochats.png";

    $message =
    "<html>
          <head>
            <title>Chat</title>
          </head>
          <body>
            <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
            <h2>You have 1 new message</h2>";
            if($flag == "1"){
              $message .= "<p>".$userMsg."</p>";
           }
           $message .= "<p>Please click on this link for see message ".base_url()."chat/send_message/".$senderId."</p>";

    $message .= "</body>
          </html>";
    // echo $message;exit;
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
      'smtp_port' => 587,
      'crlf' => "\r\n",
      'newline' => "\r\n"
    ));

    $this->email->set_mailtype("html");
    $this->email->from($sender_email);
    $this->email->to($reciever_email);
    $this->email->subject($subject);
    $this->email->message($message);
    if($flag == "2"){
      $this->email->attach($userMsg);
    }
    if($this->email->send())
    {
      return true;
    }else{
      return false;
    }
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
      $this->db->where('end_date >', $start_date);
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
  //category
  public function get_category($table_name = "", $where_cond = array()) {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($where_cond);
      $this->db->order_by('category_id', 'asc');
      return $this->db->get()->result();
  }

  public function insert_category($data, $table_name) {
      $this->db->insert($table_name, $data);
      return $this->db->insert_id();
  }

  public function send_worker_permission_email($user_data){
    $firstname = $user_data['firstname'];
    $email = $user_data['email'];
    $password = $user_data['password'];
    $user_id = $user_data['user_id'];
    $worker_id = $user_data['worker_id'];

    $main_image = base_url()."front/images/nochats.png";
    $message =
    "<html>
    <head>
      <title>Give Shop Permission</title>
    </head>
    <body>
    <div style=text-align:center;><img src=".$main_image." width=200 height=100 /></div>
    <p>Hi ".$firstname.",</p>
    <p><b>Your Account:</b><br/>Email: ".$email."<br/>Password: ".$password."</p>
    <p>Please click on this link for become a shop manager ".base_url().'worker/permission/'.$user_id.'/'.$worker_id.".</p>
    </body>
    </html>";

    $this->load->library('email');
    $this->email->initialize(array(
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.sendgrid.net',
      'smtp_user' => 'gggroom',
      'smtp_pass' => 'Un1versa1',
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

  public function get_auto_services_data( $table_name="", $where_cond = array(), $return = "result_array", $order_by = "", $limit = "",$group_by="",$where_in=array()) {
    $this->db->select('services.id,services.service_name, shop.shop_name');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    if(!empty($where_in))
    {
      $this->db->where_in($where_in['field_name'], $where_in['in_array']);
    }
    $this->db->join('shop', 'services.shop_id=shop.id', 'left');
    return $this->db->get()->$return();
  }

  public function get_services($table_name = "", $where_cond = array()) {
    $this->db->select('services.*, shop.shop_name');
    $this->db->from($table_name);
    $this->db->where($where_cond);
    $this->db->join('shop', 'services.shop_id=shop.id', 'left');
      return $this->db->get()->result();
  }

  public function sendsms($number, $message_body){
         $return = '0';
         $sender = 'SEDEMO';  // Need to change
         $smsGatewayUrl = 'http://springedge.com';
         $apikey = '62q3z3hs49xxxxxx'; // Change

         $textmessage = urlencode($message_body);
         $api_element = '/api/web/send/';
         $api_params = $api_element.'?apikey='.$apikey.'&sender='.$sender.'&to='.$number.'&message='.$message_body;
         $smsgatewaydata = $smsGatewayUrl.$api_params;
         $url = $smsgatewaydata;
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_POST, false);
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $output = curl_exec($ch);
         curl_close($ch);
         if(!$output){
            $output =  file_get_contents($smsgatewaydata);
         }
         if($return == '1'){
             return $output;
         }else{
             echo "Sent";
         }
     }

     public function check_shop_break_time($field = "", $table_name = "", $where_cond = array(), $start_time) {
         $this->db->select($field);
         $this->db->from($table_name);
         $this->db->where($where_cond);
         $this->db->where('break_start_time <=', $start_time);
         $this->db->where('break_end_time >', $start_time);
         return $this->db->get()->result();
     }
     public function check_worker_break_time($field = "", $table_name = "", $where_cond = array(), $start_time) {
         $this->db->select($field);
         $this->db->from($table_name);
         $this->db->where($where_cond);
         $this->db->where('from_time <=', $start_time);
         $this->db->where('to_time >', $start_time);
         return $this->db->get()->result();
     }

     public function shop_varification_email($email, $token, $shop_id){
       // $main_image = base_url()."front/images2/logo.png";
       $main_image = "http://myswprojects.com/ggg/front/images2/logo.png";
       $ChangePassUrl = site_url("shop/verification/".$token."/".$shop_id);
       $message =
       "<html>
             <head>
               <title>Shop Verification</title>
             </head>
             <body>
               <div style='width: 100%; background-color: rgb(41, 148, 148); margin: 0px auto;'>
                 <div style=text-align:center;><img src=$main_image /></div>
                 <p style='font-family:Roboto, sans-serif !important; text-align:center; color:#000;'><strong>Please click below link to verification</strong> :<br> <span style='color:#fff !important;'>$ChangePassUrl</span></p>
               </div>
             </body>
         </html>";
             // echo $message;exit;
       $this->load->library('email');
       $this->email->initialize(array(
         'protocol' => 'smtp',
         'smtp_host' => 'smtp.sendgrid.net',
         'smtp_user' => 'gggroom',
         'smtp_pass' => 'Un1versa1',
         'smtp_port' => 587,
         'crlf' => "\r\n",
         'newline' => "\r\n"
       ));
       $this->email->set_mailtype("html");
       $this->email->from('info@gggroom.com');
       $this->email->to($email);
       $this->email->subject('GGGroom');
       $this->email->message($message);
       if($this->email->send())
       {
          return true;
       }else
       {
          return false;
       }
     }

     public function get_filter_data_all_list( $table_name = "", $where_cond = array(), $filter_services,$filter_shops,$filter_sorting, $filter_date, $filter_min_price, $filter_max_price, $filter_location) {
         $this->db->select('shop.id as shop_id');
         $this->db->from($table_name);
         $this->db->where($where_cond);
         if(!empty($filter_location))
         {
           $this->db->like('shop.city', $filter_location);
         }
         if(!empty($filter_services))
         {
             $this->db->like('services.service_name', $filter_services);
         }
         // if(!empty($filter_shops))
         // {
         //     $this->db->where('services.shop_id', $filter_shops);
         // }
         if(!empty($filter_date))
         {
             $this->db->where('services.created_at', $filter_date);
         }

         if(!empty($filter_min_price) && !empty($filter_max_price)){
           $this->db->where("services.price BETWEEN $filter_min_price AND $filter_max_price");
         }
         elseif(!empty($filter_min_price)){
           $this->db->where('services.price <=', $filter_min_price);
         }
         elseif(!empty($filter_max_price)){
           $this->db->where('services.price >=', $filter_max_price);
         }
         //$this->db->join('shop', 'services.shop_id=shop.id', 'left');
         // $this->db->join('shop', 'shop.id='.$filter_shops, 'left');
         $this->db->join('shop',("FIND_IN_SET(services.id ,shop.service_id )"), 'inner');
         $this->db->join('category', 'services.cat_id=category.category_id', 'left');
         //$this->db->join('user', 'services.user_id=user.id', 'left');
         // $this->db->join('workers',("FIND_IN_SET(workers.id , services.worker_id)"), 'inner');
         if(!empty($filter_sorting))
         {
             $this->db->order_by('services.price '.$filter_sorting);
         }
         //$this->db->group_by('services.shop_id');
         return $this->db->get()->result();

         // echo $this->db->last_query();exit;
     }

     public function get_shop_list_data( $table_name = "", $where_cond = array()) {
         $this->db->select('shop.*, state.name as state_name, city.name as city_name');
         $this->db->from($table_name);
         $this->db->where($where_cond);
         $this->db->join('state', 'shop.state=state.id', 'left');
         $this->db->join('city', 'shop.city=city.id', 'left');
         return $this->db->get()->result();
     }

     public function get_filter_data_shop_list( $table_name = "", $where_cond = array()) {
         $this->db->select('id as shop_id');
         $this->db->from($table_name);
         $this->db->where($where_cond);
        return $this->db->get()->result();
     }

     public function get_shop_list_data_by_user( $table_name = "", $where_cond = array(), $all_u_id) {
         $this->db->select('shop.*, state.name as state_name, city.name as city_name');
         $this->db->from($table_name);
         $this->db->where($where_cond);
         //$this->db->where_in('shop.user_id', $all_u_id);
         $this->db->join('state', 'shop.state=state.id', 'left');
         $this->db->join('city', 'shop.city=city.id', 'left');
         return $this->db->get()->result();
     }

     public function get_shop_list_data_by_user_list( $table_name = "", $where_cond = array(), $all_u_id) {
         $this->db->select('shop.*, state.name as state_name, city.name as city_name');
         $this->db->from($table_name);
         $this->db->where($where_cond);
         $this->db->where('shop.user_id', $all_u_id);
         $this->db->join('state', 'shop.state=state.id', 'left');
         $this->db->join('city', 'shop.city=city.id', 'left');
         return $this->db->get()->result();
     }

     public function count_rating_review_with_user( $table_name = "", $where_cond = array()) {
         $this->db->select('rating_review.*, user.firstname, user.lastname, shop.shop_name, services.service_name');
         $this->db->from($table_name);
         $this->db->where($where_cond);
         $this->db->join('user', 'rating_review.user_id=user.id', 'left');
         $this->db->join('shop', 'rating_review.shop_id=shop.id', 'left');
         $this->db->join('services', 'rating_review.service_id=services.id', 'left');
         return $this->db->get()->result();
     }
}
