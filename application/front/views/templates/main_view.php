<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $this->load->model('general_model');
	$this->load->view('templates/_include/header_view');

 echo $the_view_content;

	$this->load->view('templates/_include/footer_view');
