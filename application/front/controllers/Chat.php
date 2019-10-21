<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Chat class.
 *
 * @extends CI_Controller
 */
class Chat extends MY_Controller {
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
      // print_r($_GET);exit;
      // echo $id;exit;
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      $userId = $this->session->userdata('uid');
      // echo $userId;exit;
      $receiverId = @$_GET['id'];
      if(!empty($userId))
      {
        $id = $this->session->userdata('uid');
        $user_list = $this->general_model->get_user_data('*', 'user', array('id' => $id, 'is_deleted' => 0));
        $this->data['userlist'] = $user_list;
        
        $_SESSION['chatId'] = "";
        $UserData = $this->general_model->get_user_data('*', 'user', array('id' => $userId, 'is_deleted' => 0));
        // print_r($UserData);exit;
        $ChatsData = $this->general_model->GetChatsData([],$userId,$receiverId,$userId);
        $ConvData = $this->general_model->check_exist_data('GROUP_CONCAT(sender_id) as senderIds, GROUP_CONCAT(receiver_id) as receverIds','chat',"sender_id = '".$userId."' OR receiver_id = '".$userId."'");
        /*echo "<pre>";print_r($ConvData->senderIds);
        echo "<pre>";print_r($ConvData->receverIds);*/
        $send = explode(',', $ConvData->senderIds);
        $sendarray = [];
        for ($i=0; $i <= count($send); $i++) {
          if (@$userId != @$send[$i])
          {
            if(!empty($send[$i]))
            {
              $sendarray[] = $send[$i];
            }
          }
        }
        // echo "<pre>";print_r($new);exit;
        $receive = explode(',', $ConvData->receverIds);
        $receivearray = [];
        for ($i=0; $i <= count($receive); $i++) {
          if (@$userId != @$receive[$i])
          {
            if(!empty($receive[$i]))
            {
              $receivearray[] = $receive[$i];
            }
          }
        }
        // echo "<pre>";print_r($send);exit;
        $UserIdArray = array_merge($sendarray,$receivearray);
        if (!in_array($receiverId, $UserIdArray))
        {
          $UserIdArray[] = $receiverId;
        }
        $UserIdArray = array_filter($UserIdArray);
        // echo "<pre>";print_r(array_unique($UserIdArray));exit;
        $Userids = implode(',', array_unique($UserIdArray));
        // echo "<pre>";print_r($Userids);exit;
        if(!empty($Userids))
        {
          $ChatUserData = $this->general_model->get_all_general_data('id,username,image','user','id IN  ('.$Userids.') AND is_deleted = 0');
          rsort($ChatUserData);
        }
        else
        {
          $ChatUserData = [];
        }
        // echo "<pre>";print_r($ChatUserData);exit;
        // echo $receiverId;exit;
        // echo $this->db->last_query();exit;
        $image = !empty($UserData->image) ? base_url('assets/uploads/profile_image/'.$UserData->image) : base_url('front/images/user.png');
        if(empty($receiverId) || empty($ChatUserData))
        {
          $ChatsData = $this->general_model->GetChatsData([],$userId,$ChatUserData[0]['id'],$userId);
          $receiverId = $ChatUserData[0]['id'];
        }
        $this->data['js_file'] = array(
          "front/js/chat.js"
        );
        $this->data['ChatsData'] = $ChatsData;
        $this->data['ChatUserData'] = $ChatUserData;
        $this->data['senderId'] = $userId;
        $this->data['receiverId'] = $receiverId;
        $this->data['UserData'] = $UserData;
        $this->data['UserImage'] = $image;
        $this->data['title'] = 'Chat | GGG Rooms';
        $this->render('message_us_view');
      }
      else
      {
        $_SESSION['appointmentId'] = "";
        $_SESSION['chatId'] = $receiverId;
        redirect('login', 'refresh');
      }
    }
    public function send_message($senderId1) {
      $senderId1_data = $this->url_decrypt($senderId1);
      $footer_pages1 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 1, 'is_deleted' => 0));
      $this->data['footer_pages1'] = $footer_pages1;

      $footer_pages2 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 2, 'is_deleted' => 0));
      $this->data['footer_pages2'] = $footer_pages2;

      $footer_pages3 = $this->general_model->get_footer_page_data('*', 'page', array('flag' => 3, 'is_deleted' => 0));
      $this->data['footer_pages3'] = $footer_pages3;

      $userId = $this->session->userdata('uid');
      if($userId == $senderId1_data){
        redirect('chat', 'refresh');
      }else{
      // echo $userId;exit;
      $receiverId = @$_GET['id'];
      if(!empty($userId))
      {
        $_SESSION['chatId'] = "";
        $UserData = $this->general_model->get_user_data('*', 'user', array('id' => $userId, 'is_deleted' => 0));
        // print_r($UserData);exit;
        $ChatsData = $this->general_model->GetChatsData([],$userId,$receiverId,$userId);
        $ConvData = $this->general_model->check_exist_data('GROUP_CONCAT(sender_id) as senderIds, GROUP_CONCAT(receiver_id) as receverIds','chat',"sender_id = '".$userId."' OR receiver_id = '".$userId."'");
        /*echo "<pre>";print_r($ConvData->senderIds);
        echo "<pre>";print_r($ConvData->receverIds);*/
        $send = explode(',', $ConvData->senderIds);
        $sendarray = [];
        for ($i=0; $i <= count($send); $i++) {
          if (@$userId != @$send[$i])
          {
            if(!empty($send[$i]))
            {
              $sendarray[] = $send[$i];
            }
          }
        }
        // echo "<pre>";print_r($new);exit;
        $receive = explode(',', $ConvData->receverIds);
        $receivearray = [];
        for ($i=0; $i <= count($receive); $i++) {
          if (@$userId != @$receive[$i])
          {
            if(!empty($receive[$i]))
            {
              $receivearray[] = $receive[$i];
            }
          }
        }
        // echo "<pre>";print_r($send);exit;
        $UserIdArray = array_merge($sendarray,$receivearray);
        if (!in_array($receiverId, $UserIdArray))
        {
          $UserIdArray[] = $receiverId;
        }
        $UserIdArray = array_filter($UserIdArray);
        // echo "<pre>";print_r(array_unique($UserIdArray));exit;
        $Userids = implode(',', array_unique($UserIdArray));
        // echo "<pre>";print_r($Userids);exit;
        if(!empty($Userids))
        {
          $ChatUserData = $this->general_model->get_all_general_data('id,username,image','user','id IN  ('.$Userids.') AND is_deleted = 0');
          rsort($ChatUserData);
        }
        else
        {
          $ChatUserData = [];
        }
        // echo "<pre>";print_r($ChatUserData);exit;
        // echo $receiverId;exit;
        // echo $this->db->last_query();exit;
        $image = !empty($UserData->image) ? base_url('assets/uploads/profile_image/'.$UserData->image) : base_url('front/images/user.png');
        if(empty($receiverId) || empty($ChatUserData))
        {
          $ChatsData = $this->general_model->GetChatsData([],$userId,$ChatUserData[0]['id'],$userId);
          $receiverId = $ChatUserData[0]['id'];
        }
        $this->data['js_file'] = array(
          "front/js/chat.js"
        );
        $this->data['ChatsData'] = $ChatsData;
        $this->data['ChatUserData'] = $ChatUserData;
        $this->data['senderId'] = $userId;
        $this->data['receiverId'] = $senderId1_data;
        $this->data['UserData'] = $UserData;
        $this->data['UserImage'] = $image;
        $this->data['title'] = 'Chat | GGG Rooms';
        $this->render('message_us_view');
      }
      else
      {
        $_SESSION['appointmentId'] = "";
        $_SESSION['chatId_main'] = $senderId1;
        redirect('login', 'refresh');
      }
    }
    }

    public function selectSaloon()
    {
      $userId = $this->session->userdata('uid');
      $UserData = $this->general_model->get_user_data('*', 'user', array('id' => $userId, 'is_deleted' => 0));
      if($UserData->u_category != '2')
      {
        $AllProfessionalUser = $this->general_model->get_user_data('*', 'user', array('id !='=> $userId,'u_category' => 2, 'is_deleted' => 0),1);
      }
      else
      {
        $AllProfessionalUser = $this->general_model->get_user_data('*', 'user', array('id !='=> $userId,'u_category' => 1, 'is_deleted' => 0),1);
      }
      // echo $this->db->last_query();exit;
      // echo "<pre>"; print_r($AllProfessionalUser);exit;
      foreach ($AllProfessionalUser as $value) {
        // echo "<pre>"; print_r($value->username);//exit;
        echo "Chat with <a href=".base_url('chat?id='.$value->id).">".$value->username."</a><br>";
      }
    }

    public function SendMessage()
    {
      if($this->input->post())
      {
        $senderId = $this->input->post('senderId');
        $receiverId = $this->input->post('receiverId');
        $userMsg = $this->input->post('userMsg');
        $data = array(
          'sender_id' => $senderId,
          'receiver_id' => $receiverId,
          'msg' => $userMsg,
          'type' => 'Text'
        );
        // echo "<pre>";print_r($data);exit;

        $sender_data = $this->general_model->get_user_data('*', 'user', array('id'=> $senderId, 'is_deleted' => 0));
        $reciever_email_data = $this->general_model->get_user_data('email', 'user', array('id'=> $receiverId, 'is_deleted' => 0));
        $reciever_email = $reciever_email_data->email;
        $flag = "1";
        $senderId_data =  $this->url_encrypt($senderId);
        $send_email = $this->general_model->send_chat_email($sender_data, $reciever_email, $userMsg, $flag, $senderId_data);

        if($this->general_model->create_general_data($data,'chat'))
        {
          return true;
        }
        else
        {
          return false;
        }
      }
    }

    public function LoadMessage($senderid="",$receiverid="")
    {
      $userId = $this->session->userdata('uid');
      $ChatsData = $this->general_model->GetChatsData([],$senderid,$receiverid);
      // echo $this->db->last_query();exit;
      // print_r($ChatsData);exit;
      $UserData = $this->general_model->get_user_data('*', 'user', array('id' => $userId, 'is_deleted' => 0));
      foreach ($ChatsData as $chat) {
        $class = ($senderid == $chat['sender_id']) ? 'rightside-right-chat' : 'rightside-left-chat';
        if($senderid == $chat['sender_id'])
        {
          $image = !empty($chat['sender_image']) ? base_url('assets/uploads/profile_image/'.$chat['sender_image']) : base_url('front/images/user.png');
        }
        else
        {
          $image = !empty($chat['sender_image']) ? base_url('assets/uploads/profile_image/'.$chat['sender_image']) : base_url('front/images/user.png');
        }
        if($chat['type'] == 'Image')
        {
          // $chatMsg = '<p>'.$chat['msg'].' </p>';
          $chatMsg = '<div class="chatimgdiv"><img class="chatimg" src="'.base_url('assets/uploads/chats/'.$chat['msg']).'"></div>';
        }
        else
        {
          $chatMsg = '<p>'.$chat['msg'].' </p>';
        }

        echo '<li><div class="'.$class.'"><div class="chat-icon-img"><img src="'.$image.'"></div><div class="text">'.$chatMsg.'</div></div></li>';
        // echo '<li><div class="'.$class.'"><div class="chat-icon-img"><img src="'.$image.'"></div><div class="text"><p>'.$chat['msg'].' <i class="fa fa-smile-o"  style="color: #a5da26;"></i></p></div></div></li>';
      }
    }

    public function uploadChatImage()
    {
      // echo "<pre>"; print_r($_REQUEST);
      // echo "<pre>"; print_r($_FILES);exit;
      if($this->input->post())
      {

        $senderId = $this->input->post('senderId');
        $receiverId = $this->input->post('receiverId');
        $image = $this->uploadImage($_FILES['file']['name'], 'file', 'chats');
        $data = array(
          'sender_id' => $senderId,
          'receiver_id' => $receiverId,
          'msg' => $image,
          'type' => 'Image'
        );
        // echo "<pre>";print_r($data);exit;
        $main_image = FCPATH."assets/uploads/chats/".$image;
        $sender_data = $this->general_model->get_user_data('*', 'user', array('id'=> $senderId, 'is_deleted' => 0));
        $reciever_email_data = $this->general_model->get_user_data('email', 'user', array('id'=> $receiverId, 'is_deleted' => 0));
        $reciever_email = $reciever_email_data->email;
        $flag = "2";
        $senderId_data =  $this->url_encrypt($senderId);
        $send_email = $this->general_model->send_chat_email($sender_data, $reciever_email, $main_image, $flag, $senderId_data);

        if($this->general_model->create_general_data($data,'chat'))
        {
          echo '1';
        }
        else
        {
          echo '0';
        }
        // echo $image;
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
      $config['file_name']            = $temp_name;
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

}
