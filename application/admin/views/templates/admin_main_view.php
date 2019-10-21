<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $this->load->model('general_model');
if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != "")
{
	$this->load->view('templates/_include/admin_main_header_view'); 
}
 echo $the_view_content; 
 if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != "")
{
	$this->load->view('templates/_include/admin_main_footer_view');
}