<?php defined('BASEPATH') OR exit('No direct script access allowed');	
class MY_Controller extends CI_Controller
{
	protected $data = array();
	function __construct()
	{
		parent::__construct();
		$this->data['before_head'] = '';
		$this->data['before_body'] = '';
	}

	protected function render($the_view = NULL, $template = 'main')
	{
		if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view,$this->data, TRUE);;
			$this->load->view('templates/'.$template.'_view', $this->data);
		}
	}
	
	/**
	 * url_encrypt()
	 *
	 * @param mixed $string
	 * @return
	 */
	public static function url_encrypt($string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		//pls set your unique hashing key
		$secret_key = 'TouchWorld';
		$secret_iv = 'RWwrRPRsdUJmYUTPKzMkdnQXMEF9QT16';

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		//do the encyption given text/string/number
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);

		return $output;
	}

	/**
	 * url_decrypt()
	 *
	 * @param mixed $string
	 * @return
	 */
	public static function url_decrypt($string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		//pls set your unique hashing key
		$secret_key = 'TouchWorld';
		$secret_iv = 'RWwrRPRsdUJmYUTPKzMkdnQXMEF9QT16';

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

		return $output;
	}

	/**
	 * getExtention()
	 *
	 * @param mixed $string
	 * @return
	 */
	public static function getExtention($FileName)
	{
		$extation = substr(strrchr($FileName,"."),1);
		return $extation;
	}

	/**
	 * getFileName()
	 *
	 * @param mixed $string
	 * @return
	 */
	public static function getFileName($FileName)
	{
		$extation 	= substr(strrchr($FileName,"."),1);
		$name 		= str_replace(".".$extation,'',$FileName);
		return $name;
	}
}
