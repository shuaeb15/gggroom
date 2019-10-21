
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Feedback extends MY_Controller {
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

        // $this->data['js_file'] = array(
        //     "front/js/favourite.js"
        // );
        $this->data['title'] = 'Feedback | GGG Rooms';
        $this->data['UserId'] = $id;
        $this->render('feedback');
      }
      else
      {
        redirect(site_url());
      }
    }
}
