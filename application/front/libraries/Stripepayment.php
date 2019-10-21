<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
// echo APPPATH."third_party/mollie-api-php-master/src/Mollie/API/Autoloader.php";exit;
require_once APPPATH."third_party/stripe/init.php";
class Stripepayment {
	public function create_token($data)
	{
		
		try 
		{
			\Stripe\Stripe::setApiKey('sk_test_UHvBy0FY92aS3lNnOopQsbHx00dsPm5eFN');
			$token = \Stripe\Token::create(array(
			  "card" => $data
			));
		}
		catch (Exception $e) 
		{
		    $token = $e->getMessage();
		}
		return $token;
	}

	public function create_charge($data)
	{
		try 
		{
			\Stripe\Stripe::setApiKey('sk_test_UHvBy0FY92aS3lNnOopQsbHx00dsPm5eFN');
			$charge = \Stripe\Charge::create($data);
		}
		catch (Exception $e) 
		{
		    $charge = $e->getMessage();
		}
		return $charge;
		
		
		
    // 	$refund = \Stripe\Refund::create([
    //     'charge' => 'ch_6tlEJnMhMef0DfOOUNre',
    // ]);

	}

	public function create_user($data)
	{
		try 
		{
			\Stripe\Stripe::setApiKey('sk_test_UHvBy0FY92aS3lNnOopQsbHx00dsPm5eFN');
			$customer = \Stripe\Customer::create($data);
		}
		catch (Exception $e) 
		{
		    $customer = $e->getMessage();
		}
		return $customer;
	}

}
?>