<?php
class EbsExecutionControllerCore extends FrontController
{
	public function displayContent()
	{	
        $check = $_GET['check'];
		$table 	= "static_order";
		$dbData = array(
			'first_name' 			=> $_GET['firstName'],
			'last_name' 				=> $_GET['lastName'],
			'address' 				=> $_GET['address'],
			'company' 				=> $_GET['company'],
			'mobile' 				=> $_GET['phone'],
			'email' 				=> $_GET['email'],
			'city' 					=> $_GET['city'],
			'state' 				=> $_GET['state'],
			'pincode' 				=> $_GET['zip'],
			'note'   				=> $_GET['note'],
			'id_product' 			=> $_GET['product_id'],
			'product_name' 			=> $_GET['product_name'],
			'unit_price' 			=> $_GET['unit_price'],
			'quantity' 				=> $_GET['quantity'],
		);

		$result = Db::getInstance()->insert($table, $dbData);
		$last_id = (int)Db::getInstance()->Insert_ID();
        $logger->logError($result);
        
        $unit_price = $_GET['unit_price'];
        $quantity   = $_GET['quantity'];
		$key = Configuration::get('EBS_SECRET');
		$account_id = Configuration::get('EBS_ACC_ID');
		$return_url="https://www.kobzo.com/get_eliteResponse2.php?success=1&DR={DR}";
		$finalamount = $unit_price*$quantity;
		$mode = 'TEST';
		$reference = sprintf('%06d', $last_id);

		$hash = $key."|".$account_id."|".$finalamount."|".$reference."|".$return_url."|".$mode; 
		$logger->logError($hash);
		$secure_hash = md5($hash); 
		
		$url = 'www.secure.ebs.in/pg/ma/payment/request';
		$data =array(
			'ebsurl'		=> $url,
		    'account_id'    => $account_id, 
		    'return_url'    => $return_url,
		    'mode'          => $mode,
		    'reference_no'  => $reference,
		    'description'   => $reference,
		    'name'          => $_GET['firstName'],
		    'address'       => $_GET['address'],
		    'city'          => $_GET['city'],
		    'state'         => $_GET['state'],
		    'postal_code'   => $_GET['zip'],
		    'country'       => 'IND',
		    'phone'         => $_GET['phone'],
		    'email'         => $_GET['email'],
		    'secure_hash'   => $secure_hash,
		    'total'        => $finalamount,
		    );

	    $result = json_encode($data);
	    echo $result;
	 //    if($check == 1){
		//     $this->context->smarty->assign($data);
		//     $this->context->smarty->display('home/payment_execution.tpl');
		// }
		// else{
		// 	$first_name 			=> $_GET['firstName'];
		// 	$last_name 				=> $_GET['lastName'];
		// 	$address				=> $_GET['address'];
		// 	$company 				=> $_GET['company'];
		// 	$mobile 				=> $_GET['phone'];
		// 	$email 					=> $_GET['email'];
		// 	$city 					=> $_GET['city'];
		// 	$state 					=> $_GET['state'];
		// 	$pincode 				=> $_GET['zip'];
		// 	$note   				=> $_GET['note'];
		// 	$id_product 			=> $_GET['product_id'];
		// 	$product_name 			=> $_GET['product_name'];
		// 	$unit_price				=> $_GET['unit_price'];
		// 	$quantity 				=> $_GET['quantity'];

		// 	Tools::redirect("https://www.kobzo.com/get_eliteResponse2.php?&getSecret=1&product_id=".$id_product."&product_name=".$product_name."&unit_price=".$unit_price."&quantity=".$quantity."&firstName=".$first_name."&lastName=".$last_name."&company=".$company."&address=".$address."&city=".$city."&state=".$state."&zip=".$zip."&email=".$email."&phone=".$mobile);
		// }
		
	}
}