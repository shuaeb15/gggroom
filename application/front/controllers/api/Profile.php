<?php

 require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Profile extends REST_Controller {


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
    public function profile_detail_post() {
      
      
        $id = $this->input->post('uid');
        $userlist = $this->general_model->get_edit_user_data('user', array('user.id' => $id, 'user.is_deleted' => 0));
        $this->data['userlist'] = $userlist;

        

        $appointmentData = $this->general_model->get_all_general_data('id','appointment',array('user_id' => $id,'is_deleted'=>0));
        $favData = $this->general_model->get_all_general_data('id','favourite',array('user_id' => $id));
       
        $this->data['appointmentCount'] = count($appointmentData);
        $this->data['favCount'] = count($favData);
      

         $this->response([
                         'status' => TRUE, 
                          'data' => $userlist
                             ], REST_Controller::HTTP_OK);
      
    }

     public function edit_profile($id) {
       

       $id = $this->url_decrypt($id);
       $this->data['js_file'] = array(
           "front/js/jquery-editable-select.min.js",

       );
       $this->data['css_file'] = array(
           "front/css/jquery-editable-select.min.css"
       );

       if ($id != '') {
           $userlist = $this->general_model->get_edit_user_data('user', array('user.id' => $id, 'user.is_deleted' => 0));
           $this->data['userlist'] = $userlist;

           $city = $this->general_model->get_all_state_data('*', 'city', array('is_deleted' => 0));
           $this->data['city'] = $city;

           $state = $this->general_model->get_all_state_data('*', 'state', array('is_deleted' => 0));
           $this->data['state'] = $state;

           $this->data['title'] = 'Profile | GGG Rooms';
           $this->session->unset_userdata('setting_page');
           $this->render('edit_profile');
       } else {
           $this->session->set_flashdata('error_message', "Something went wrong!");
           redirect('profile', 'refresh');
       }
    }

    public function update_user() {
      if (!$this->session->userdata('uid')) {
        redirect(site_url());
      }
      else{
            if ($this->input->post()) {
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('fname', 'Firstname', 'required');
                $this->form_validation->set_rules('lname', 'Lastname', 'required');
                $this->form_validation->set_rules('u_email', 'Email', 'required|valid_email');

                if ($this->form_validation->run() == false) {
                  $user_id = $this->session->userdata('uid');

                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('profile/edit_profile/'.$user_id, 'refresh');
                } else {
                  $fname = $this->input->post('fname');
                  $lname = $this->input->post('lname');
                  $u_email = $this->input->post('u_email');
                  $mobile = $this->input->post('mobile');
                  $address1 = $this->input->post('address1');
                  $address2 = $this->input->post('address2');
                  $city = $this->input->post('city');
                  $state = $this->input->post('state');
                  $zipcode = $this->input->post('zipcode');
                  $radio_gender = $this->input->post('radio_gender');
                  $user_cat = $this->input->post('u_chk');
                  $user_id = $this->session->userdata('uid');

                  $image = $this->uploadImage($_FILES['imgupload']['name'], 'imgupload', 'profile_image', $user_id);

                  if($user_cat == 2){
                    $data = array(
                      'is_active' => 1,
                      'is_deleted' => 0
                    );
                    $update_id1 = $this->general_model->active_inactive_user($data, 'shop', array('user_id' => $user_id));
                    $worker_update_id = $this->general_model->active_inactive_user($data, 'workers', array('user_id' => $user_id));
                    $service_update_id = $this->general_model->active_inactive_user($data, 'services', array('user_id' => $user_id));
                  }else{
                    $data = array(
                      'is_active' => 0,
                      'is_deleted' => 1
                    );

                    $update_id1 = $this->general_model->active_inactive_user($data, 'shop', array('user_id' => $user_id));
                    $worker_update_id = $this->general_model->active_inactive_user($data, 'workers', array('user_id' => $user_id));
                    $service_update_id = $this->general_model->active_inactive_user($data, 'services', array('user_id' => $user_id));
                  }

                  $check_city = $this->general_model->check_exist_data('*', 'city', array('name' => $city, 'is_deleted' => 0));

                  $data_city = array(
                      'name' => $city,
                      'created_at' => date('Y-m-d H:i:s'),
                      'updated_at' => date('Y-m-d H:i:s'),
                      'is_active' => 1,
                      'is_deleted' => 0
                  );
                  if(empty($check_city)){
                      $inserted_city_id = $this->general_model->insert_user($data_city, 'city');
                      $city_id = $inserted_city_id;
                  }else{
                      $city_id = $check_city->id;
                  }

                  $data = array(
                      'firstname' => $fname,
                      'lastname' => $lname,
                      'email' => $u_email,
                      'mobile' => $mobile,
                      'address1' => $address1,
                      'address2' => $address2,
                      'city' => $city_id,
                      'state' => $state,
                      'zipcode' => $zipcode,
                      'image' => $image,
                      'gender' => $radio_gender,
                      'u_category' => $user_cat,
                      'updated_date' => date('Y-m-d H:i:s'),
                  );

                    $update_id = $this->general_model->update_user_data($data, 'user', array('id' => $user_id));

                    if ($update_id) {
                        $this->session->set_flashdata('success_message', "User updated successfully");
                        redirect('profile', 'refresh');
                    }
                    else {
                        $this->session->set_flashdata('success_message', "User updated successfully");
                        redirect('profile', 'refresh');
                    }
                }
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('User', 'refresh');
            }
          }
    }

    public function uploadImage($path, $imagename, $upload_path, $user_id){

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

      // echo $temp_name;exit;
      // echo $temp_name;exit;
      // $temp_name = $this->resize_image($temp_name, 485, 485);

      $config = array();
      $config['upload_path']          = FCPATH.'assets/uploads/'.$upload_path.'/';
      $config['file_name'] 						= $temp_name;
      $config['allowed_types']        = 'gif|jpg|jpeg|png';
      // $config['max_size']             = 2000;
      // $config['max_width']            = 485;
      // $config['max_height']           = 485;


      $this->upload->initialize($config);

      if($this->upload->do_upload($imagename))
      {
        // $this->resizeImage($temp_name);

        $this->db->select('image');
        $this->db->from('user');
        $this->db->where('id',$user_id);
        $count = $this->db->get()->row();
        $img = $count->image;
        $path = 'assets/uploads/'.$upload_path.'/'.$img;
        unlink($path);
        return $temp_name;
      }else{
        $this->db->select('image');
        $this->db->from('user');
        $this->db->where('id',$user_id);
        $count = $this->db->get()->row();
        return $count->image;
      }
    }

    // public function resizeImage($file_name)
  	//  {
  	// 		$this->load->library('image_lib');
  	// 	 	$config['image_library']  = 'GD2';
  	// 	 	$config['source_image']   = FCPATH. '/assets/uploads/profile_image/' . $file_name;
    //     $config['new_image']      = FCPATH. '/assets/uploads/profile_image/thumbnail/' . $file_name;
  	// 			// $config['create_thumb']   = TRUE;
  	// 	 	$config['maintain_ratio'] = TRUE;
  	// 	 	$config['width']          = 485;
  	// 	 	$config['height']         = 485;
    //
  	// 	 	$this->image_lib->initialize($config);
  	// 	 	if (! $this->image_lib->resize()) {
  	// 			 echo $this->image_lib->display_errors();exit;
  	// 	 	}
  	//  }

    public function checkUnique($table, $columnName)
   {
     $email = $_POST['u_email'];
        if(!empty($email)) {
          $uid = $this->session->userdata('uid');

             $this->db->select($columnName);
             $this->db->from($table);
             $this->db->where('id !=',$uid);
             $this->db->where('email',$email);
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

  public function change_email(){
    $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
    $this->data['footer_pages1'] = $footer_pages1;

    $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
    $this->data['footer_pages2'] = $footer_pages2;

    $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
    $this->data['footer_pages3'] = $footer_pages3;

    $id = $this->session->userdata('uid');
    $userlist = $this->general_model->get_edit_user_data('user', array('user.id' => $id, 'user.is_deleted' => 0));
    $this->data['userlist'] = $userlist;

    $uid = $this->session->userdata('uid');
    $this->db->select('email');
    $this->db->from('user');
    $this->db->where('id',$uid);
    $count = $this->db->get()->row();

    $this->data['user_email'] = $count->email;
    $this->data['title'] = 'Change Email | GGG Rooms';
    $this->render('change_email');
    }

    public function update_email(){

      if ($this->input->post()){
          $this->load->helper('form','url');
          $this->load->library('form_validation');

          $this->form_validation->set_rules('u_email', 'Email', 'required|valid_email');

          if ($this->form_validation->run() == false) {
              $this->session->set_flashdata('error_message', "Please fill all the fields");
              redirect('profile/change_email', 'refresh');
          } else {

            $uid = $this->session->userdata('uid');
            $email = $this->input->post('u_email');

              $data = array(
                'email' => $email,
              );
              $change_pwd = $this->general_model->change_user_email($data, 'user', array('id' => $uid));

              $this->session->set_flashdata('success_message', "Your email has been updated");
              redirect('setting','refresh');
            }
          }
          else {
             redirect('setting', 'refresh');
          }
        }

        public function Get_city_Data()
        {
          if($this->input->post())
          {
            $city = $this->input->post('term');
            $city_where = "is_deleted = 0 AND is_active = 1 AND name LIKE '%".$city."%'";
            $city_list = $this->general_model->get_all_general_data('id,name','city',$city_where,'result_array','','','name');
            $searchData = $city_list;
            foreach ($searchData as $value) {
              $data[] = array('value' => $value['name'] , 'id' => $value['id']);
            }
            // echo '<pre>';print_r($data);exit;
            echo json_encode($data);
          }
        }

        public function Get_zip_Data()
        {
          if($this->input->post())
          {
            $zip = $this->input->post('term');
            $zip_where = "is_deleted = 0 AND is_active = 1 AND zipcode LIKE '%".$zip."%'";
            $city_list = $this->general_model->get_all_general_data('id, zipcode','shop',$zip_where,'result_array','','','zipcode');
            $searchData = $city_list;
            foreach ($searchData as $value) {
              $data[] = array('value' => $value['zipcode'] , 'id' => $value['id']);
            }
            // echo '<pre>';print_r($data);exit;
            echo json_encode($data);
          }
        }
        public function get_poll_data()
        {
          $get_data = $this->general_model->get_all_general_data('*','poll_qst', array('display' => '0'));
          // echo json_encode($get_data);exit;
          // echo '<pre>'; print_r($get_data); exit;
          // echo '<pre>'; print_r($this->session->userdata('uid')); exit;
            echo '<form name="submit_poll" id="submit_poll" method="post" data-toggle="validator" action="'.site_url("Profile/insert_poll").'"><div id="slider" class="form">
              <ul>';
              echo '<input type="hidden" name="user_id" value="'.$this->session->userdata('uid').'">';
              foreach($get_data as $k=>$v){
                $last_slide = ($k+1 == (count($get_data)) ? 'data-id="slider_end" call-before="last_slide()"' : 'asf');
                // echo $last_slide.'<br>';
                echo '<li data-id="slider_start" '.$last_slide.'>
                <div class="col-md-12 col-xs-12">
                   <div class="item form-group">
                     <h1 for="">'.$v['qst'].'</h1>';
                     echo '<input type="hidden" name="qst_id[]" value="'.$v['qst_id'].'">';
                     if($v['textbox'] == ''){
                       for($i = 1; $i <= 4; $i++){
                         if($v['opt'.$i] && $v['opt'.$i] != ''){
                           echo '<div class="col-xs-12 inner-radioGroup'.$v['qst_id'].'">
                           <input type="radio" name="opt'.$v['qst_id'].'" id="radio'.$v['qst_id'].$i.'" class="css-checkbox radio_day" value="'.$v['opt'.$i].'" '.($i==1 ? 'checked' : '').'/>
                           <label for="radio'.$v['qst_id'].$i.'" class="css-label radGroup1 radGroup2" style="background-image: url('.base_url().'front/images/radio1.png);margin-bottom:30px;">
                             <span>'.$v['opt'.$i].'</span>
                           </label></div>';
                         }
                         // $v['opt'.$i]
                       }
                     }else{
                       echo '<textarea name="opt'.$v['qst_id'].'" cols="60" rows="5"></textarea>';
                     }
                // <li>
                //   <div class="form-group">
                //     <label for="exampleInputFile" class="sr-only" >File input</label>
                //     <input type="file" id="exampleInputFile" required data-msg="Please upload">
                //   </div>
                //   <div class="form-group">
                //     <label for="exampleInputFile" class="sr-only" >File input</label>
                //     <select required>
                //       <option value="">ggg</option>
                //       <option value="dsfd">hg</option>
                //       <option value="dsfd">hghg</option>
                //     </select>
                //   </div>
                // </li>
                // <li data-id="slider_end" call-before="last_slide()">
                //   <div class="alert alert-success"> slider ends
                //   </div>
                  echo '</div></div>';
                  // echo '<button type="button" class="btn btn-info" onclick="$("#slider").gotoSlide("slider_start")" style="margin-bottom: 10px;">Click here to go to First slide</button>';
                  echo '</li>';
          }
          echo '</ul></form>
        </div>';
        }
        public function insert_poll(){
          // echo '<pre>'; print_r($_POST['qst_id']); exit;
          foreach($_POST['qst_id'] as $k=>$v){
            $newk = $k+1;
            // echo $v.'<br>';
            $data['qst_id'][] = $v;
            $data['qst'][] = $_POST['opt'.$v];
            $data['user_id'] = $_POST['user_id'];
          }
          // exit;
          // echo count($data['qst']);exit;
          // echo '<pre>'; print_r($data); exit;
          $count = count($data['qst']);
          for($i = 0; $i < $count; $i++){
            $newData['user_id'] = $_POST['user_id'];
            $newData['qst_id'] = $data['qst_id'][$i];
            $newData['opt'] = $data['qst'][$i];
            // echo '<pre>'; print_r($newData);
            $insert_id = $this->general_model->insert_category($newData, 'poll_answer');
            // echo $insert_id;exit;
          }
          // echo '<pre>'; print_r($newData); exit;
          if($insert_id){
            $data1['poll_submit'] = '1';
            $update_id = $this->general_model->update_user_data($data1, 'user', array('id' => $_POST['user_id']));
            if ($update_id) {
                $this->session->set_flashdata('success_message', "Poll updated successfully");
                redirect('profile', 'refresh');
            }else {
                $this->session->set_flashdata('error_message', "There is a problem updating user while creating poll, please try again later.");
                redirect('profile', 'refresh');
            }
          }else{
            $this->session->set_flashdata('error_message', "There is a problem adding a poll, please contact administrator.");
            redirect('profile', 'refresh');
          }
      }
}
