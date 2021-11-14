<?php
class EliteControllerCore extends DashController
{
	public $php_self = 'elite';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('elite.tpl');	
 	}
	
	public function displayHeader($display=true)
	{
	}
	
	public function displayFooter($display=true)
	{
	}
	
	public function ajaxReturn()
	{	
	
		$form = trim(Tools::getValue('form'));
		$newOrder = trim($_POST['newOrder']);
		$getSecret = trim($_POST['getSecret']);
		$logger = new FileLogger();
		$logger->setFilename('test_lead_form.txt');
		$logger->logError("=======");
		$logger->logError($_GET);
		$logger->logError($_POST);
    	

        $razorpay = $_GET['pay'];
        if($razorpay == 1){
            require_once (_PS_ROOT_DIR_.'/classes/razorpay.php');
            $api_key = 'rzp_test_7OBALkfN0UCIHW';
            $api_secret = 'G6cLaixO6coM1whZu1IzQuHs';
            $api = new Api($api_key, $api_secret);

            $order = $api->order->create(array(
              'receipt' => '123',
              'amount' => 100,
              'payment_capture' => 1,
              'currency' => 'INR'
              )
            );
            var_dump($order);
            return true;
        }

    	if($getSecret == 1){

    		$table 	= "static_order";
    		$dbData = array(
    			'firstname' 			=> $_POST['firstname'],
    			'lastname' 				=> $_POST['lastname'],
    			'address' 				=> $_POST['address'],
    			'company' 				=> $_POST['company_name'],
    			'mobile' 				=> $_POST['mobile'],
    			'email' 				=> $_POST['email'],
    			'city' 					=> $_POST['city'],
    			'state' 				=> $_POST['state'],
    			'pincode' 				=> $_POST['pincode'],
    			'notes' 				=> $_POST['order_note'],
    			'id_product' 			=> $_POST['id_product'],
    			'product_name' 			=> $_POST['product_name'],
    			'unit_price' 			=> $_POST['unit_price'],
    			'quantity' 				=> $_POST['quantity'],
    		);

    		if(Db::getInstance()->insert($table, $dbData)){
    		}

    		$key = Configuration::get('EBS_SECRET');
    		$account_id = Configuration::get('EBS_ACC_ID');
    		$return_url="https://www.kobzo.com/get_eliteResponse2.php?success=1&DR={DR}";
    		$finalamount = $_POST['amount'];
    		$mode = 'TEST';
    		$reference = rand(0, 5000);

    		$hash = $key."|".$account_id."|".$finalamount."|".$reference."|".$return_url."|".$mode; 
			$secure_hash = md5($hash); 
    		$result = json_encode(
						array(
 							'secret'=> $secure_hash, 
						));
 			echo $result;
 			return true;
    	}
    	if(isset($form) && $from != undefined){
    		if ($form == 1){
    			$recievedData = array(
    				'cust_name' 		=> trim(Tools::getValue('cust_name1')),
    				'email' 			=> trim(Tools::getValue('email1')),
    				'company_name' 		=> trim(Tools::getValue('company_name1')),
    				'mobile' 			=> trim(Tools::getValue('mobile1')),
    				'city' 				=> trim(Tools::getValue('city1')),
    				'customer_type' 	=> trim(Tools::getValue('customer_type1')),
    				'page'				=> trim(Tools::getValue('page'))
    			);
    		}
    		else if ($form == 2){
    			$recievedData = array(
    				'cust_name' 		=> trim(Tools::getValue('cust_name2')),
    				'email' 			=> trim(Tools::getValue('email2')),
    				'company_name' 		=> trim(Tools::getValue('company_name2')),
    				'mobile' 			=> trim(Tools::getValue('mobile2')),
    				'city' 				=> trim(Tools::getValue('city2')),
    				'customer_type' 	=> trim(Tools::getValue('customer_type2')),
    				'page'				=> trim(Tools::getValue('page'))
    			);
    			$logger->logError($recievedData);
    		}		
    		else if($form == 3){
    			$recievedData = array(
    				'cust_name' 		=> trim(Tools::getValue('cust_name2')),
    				'email' 			=> trim(Tools::getValue('email2')),
    				'company_name' 		=> trim(Tools::getValue('company_name2')),
    				'mobile' 			=> trim(Tools::getValue('mobile2')),
    				'page'				=> trim(Tools::getValue('page')),
    				'city' 				=> trim(Tools::getValue('city2')),
    				'customer_type' 	=> trim(Tools::getValue('customer_type2'))
    			);
    		}
    		else if($form == 4){
    			$recievedData = array(
    				'cust_name' 		=> trim(Tools::getValue('cust_name')),
    				'email' 			=> trim(Tools::getValue('email')),
    				'company_name' 		=> 'unknown',
    				'mobile' 			=> trim(Tools::getValue('mobile')),
    				'page'				=> 0,
    				'city' 				=> 0,
    				'customer_type' 	=> 'Corporate Admin',
                    'place'             => trim(Tools::getValue('place')),
    			);
    		}
    		$rec_email 	= $recievedData['email'];
    		$sell_name 	='Relationship Manager from Kobster';
    		
    		if($recievedData['city'] == 1) $city = "Chennai";
    		else if($recievedData['city'] == 2) $city = "Mumbai";
    		else if($recievedData['city'] == 3) $city = "Hyderabad";
    		else if($recievedData['city'] == 4) $city = "Bengaluru";
    		else if($recievedData['city'] == 5) $city = "Delhi";
    		else if($recievedData['city'] == 6) $city = "Others";
    		else if($recievedData['city'] == 0) $city = "NA";
    		
    		if($recievedData['page'] == ''){
    			$recievedData['page'] = 0;
    		}
    
    		$mailData = array(
    			'{cust_name}' 		=> $recievedData['cust_name'],
    			'{email}' 			=> $recievedData['email'],
    			'{company_name}' 	=> $recievedData['company_name'],
    			'{mobile}' 			=> $recievedData['mobile'],
    			'{city}' 			=> $city,
    			'{customer_type}' 	=> $recievedData['customer_type']
    		);
    		
    		$table = "elite_lead";
    		$dbData = array(
    			'firstname' 			=> $recievedData['cust_name'],
    			'company' 				=> $recievedData['company_name'],
    			'mobile' 				=> $recievedData['mobile'],
    			'email' 				=> $recievedData['email'],
    			'id_fulfilmentcenter' 	=> $recievedData['city'],
    			'customer_type'			=> $recievedData['customer_type'],
    			'page'					=> $recievedData['page']
    		);
    	
    		if(Db::getInstance()->insert($table, $dbData)){
    			// Mail sent to Registerer
    			$to			= $recievedData['email'];
    			$toName 	= $recievedData['cust_name'];
    
    			$from		= "marketing@kobster.com";
    			$fromName 	= "From Kobster";
    // 			$subject 	= 'Kobster E1lite, the best Procurement Tool for your business';
                $subject 	= "Thank you for your interest.";
    			Mail::Send(1, 'elite_lead_external', $subject, $mailData, $to, $toName, $from, $fromName);
    			
    			// Mail sent to Marketing team
    			$to			= "marketing@kobster.com";
    // 			$to			= "vijayashanthi@kobster.com";
    			$toName 	= "Marketing";
    
    			$from		= "noreply@kobster.com";
    			$fromName 	= $recievedData['cust_name']. ' from '. $recievedData['company_name'];
                $place      = $recievedData['place'];
    			//subject
    			if($recievedData['page'] == 1)
    				$subject 	= 'A Potential Elite Application from '. $recievedData['cust_name'].' through SumHR';
    			else if($form == 3)
    				$subject 	= 'A Potential Perks Application from '. $recievedData['cust_name'];
    			else if($place == '/employee-super-store')
    				$subject 	= 'A Potential Application from '. $recievedData['cust_name'];
                else
                    $subject    = 'A Potential Elite Application from '. $recievedData['cust_name'];
    
    			Mail::Send(1, 'elite_lead_internal', $subject, $mailData, $to, $toName, $from, $fromName);
    			
    			echo "success";
    			
    		}
    		else {
    			echo "failed";
    		}
    	}
    	if($newOrder == 1){
    	    //place order
    	    $firstname		= $_POST['firstname'];
    	    $lastname 		= $_POST['lastname'];
    	    $email 			= $_POST['email'];
    	    $company 		= $_POST['company'];
    	    $address 		= $_POST['address'];
    	    $city 			= $_POST['city'];
    	    $state 			= $_POST['state'];
    	    $pincode 		= $_POST['pincode'];
    	    $mobile 		= $_POST['mobile'];
    	    $order_note 	= $_POST['order_note'];
    	    $id_product 	= $_POST['id_product'];
    	    $product_name 	= $_POST['product_name'];
    	    $unit_price 	= $_POST['price'];
    	    $quantity 		= $_POST['quantity'];

    	    $url = 'https://secure.ebs.in/pg/ma/payment/request';
			$myvars = 'account_id=10878&address='.$address.'&phone='.$mobile.'&postal_code='.$pincode.'&return_url=https://www.kobzo.com/get_eliteResponse2.php?success=1&amount='.$amount.'&channel=0&city='.$city.'&country=IND&currency=INR&description=Test Order Description&email='.$email.'&mode=TEST&name='.$name.'&page_id=15041';
			$logger->logError($myvars);

			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt( $ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec( $ch );
			$logger->logError($response);
    	}
	}
	
}
?>