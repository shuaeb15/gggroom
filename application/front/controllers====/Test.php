<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 *
 * @extends CI_Controller
 */
class Test extends MY_Controller {
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
        $this->data['title'] = 'Shop Verification';
        $emailsend = $this->general_model->shop_varification_email('rahulparmar56@gmail.com', "asdfasdfas2212asdf", 2);
        $this->render('test_view');
      // }
    }
}
