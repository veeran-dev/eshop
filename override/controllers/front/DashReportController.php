<?php 
class DashReportControllerCore extends DashController
{
	public function ajaxReturn()
	{
		require_once (_PS_ROOT_DIR_.'/classes/PHPExcel/Classes/PHPExcel.php');

 		$customerid = Tools::getValue('customerid');
		$duration = Tools::getValue('duration');
		$addressId = Tools::getValue('addressId');
		$orderid = Tools::getValue('orderid');
		$type = Tools::getValue('type');
		$from_date = Tools::getValue('from_date');
		$to_date = Tools::getValue('to_date');
		$location = Tools::getValue('location');
		$selected_category = Tools::getValue('selected_category_id');
		$start_memory = memory_get_usage();	

		$logger = new FileLogger();
		$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
		$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	

		$orderObj = new Order();

		
		/*To get All reports of that particular customer*/
		if($type == 1)
		{												  
			$res_report = Order::getHistoryReport(
													$customerid, 
													$duration, 
													$addressId, 
													$from_date, 
													$to_date, 
													$location
												);
			$start_memory = memory_get_usage();	
			
			echo Tools::jsonEncode($res_report);

			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		/*To get All categories of the product for a particular  customer*/
		else if($type == 2)
		{
 			$res_report = Order::getRatioHistoryReport(
 														$customerid, 
 														$orderid, 
 														$duration, 
 														$addressId, 
 														0, 
 														$from_date, 
 														$to_date, 
 														$location
 													);
			$start_memory = memory_get_usage();	
 			
 			echo Tools::jsonEncode($res_report);

			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		/*To get all orders id and other details*/
		else if($type == 3)
		{
			$start_memory = memory_get_usage();	
			$res_json = array();
			
			$order_details = Order::getAllOrders($customerid);
			$aliasAddress = Address::getAliasAddress($customerid);
			
			array_push($res_json,$order_details,$aliasAddress);
			
			echo Tools::jsonEncode($res_json);

			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
 		}
		/*To get the top 10 products of all the orders */
		else if($type == 4)
		{
			$start_memory = memory_get_usage();	
			$order_products = Order::getTopOrderValueProducts(
																$customerid, 
																$duration, 
																$addressId, 
																$from_date, 
																$to_date
															);
			echo Tools::jsonEncode($order_products);

			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
			
		}
		else if($type == 5)/*To get the top 4 products of all the orders */
		{
			$start_memory = memory_get_usage();	
			$products = Order::getTopOrderValueProducts($customerid, $duration, 0, $from_date, $to_date);

			if($this->context->cookie->budget_configured == 1) {
				$purchaseOrderObj = new PurchaseOrder();
				$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($this->context->cookie->id_address_budget), $this->context->cookie->budget_option, true);
				for ($i = 0; $i < sizeof($products); $i++) {
					for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
						if($products[$i]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
							$products[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
							$products[$i]['budget_product'] = 1;
						}
					}
				}
			}

 			$result = Product::getProductsProperties($id_lang = 1, $products);
			echo Tools::jsonEncode($result);
		}
		/*To get location based report*/
		else if($type == 6)
		{
			$start_memory = memory_get_usage();	
			$locationArray = array();
			$locationReportAll = Order::getLocationBasedReport(
																$customerid, 
																$duration, 
																$from_date, 
																$to_date, 
																$location
															);
			$locationReportGroupByState = Order::getLocationBasedReport(
																		 $customerid, 
																		 $duration, 
																		 $from_date, 
																		 $to_date, 
																		 $location, 
																		 $state = true
																	);

			array_push($locationArray, $locationReportAll, $locationReportGroupByState);
			
			echo Tools::jsonEncode($locationArray);

			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		else if($type == 7)/*To get monthly category and top products report*/
		{
			$customer = new Customer($customerid);
			$dealDetails = Deal::findDeal($customer->id_default_group);
			$topProducts = array();
			$test = CartRule::getCustomerCartRules((int)(self::$cookie->id_lang), (isset(self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0));

			$discounts = array();
			for($i = 0; $i < sizeof($test); $i++)
			{
				if(sizeof($test[$i])){
					array_push($discounts, $test[$i]);
				}			
			}
			
 			$current_date = strtotime(date("Y-m-d H:i:s"));
			$result = array();
			$discountArray = array();

			if(sizeof($dealDetails) > 0 || sizeof($discounts) > 0)
			{
				if(sizeof($dealDetails) > 0)
				{
					for($a = 0; $a < sizeof($dealDetails); $a++)
					{
						$from_date = strtotime($dealDetails[$a]['from']);
						$to_date = strtotime($dealDetails[$a]['to']);
						if(($current_date >= $from_date) && ($current_date <= $to_date) && ($dealDetails[$a]['active'] == 1))
						{
							$obj = new Product((int)($dealDetails[$a]['id_product']), false, 1);
							$price=$obj->getPrice(true,NULL);
							$dealDetails[$a]['price']=(string)$price;
							
							$img_cover;
							if (!Validate::isLoadedObject($obj)){
								continue;
							}
							else{
								$images = $obj->getImages(1);
								foreach ($images AS $j => $image)
								{
									if ($image['cover']){
										$img_cover = $obj->id.'-'.$image['id_image'];
										break;
									}
								}

								if (!isset($img_cover))
									$img_cover = Language::getIsoById((int)(self::$cookie->id_lang)).'-default';							
							}

							$img_cover = self::$link->getImageLink($dealDetails[$a]['link_rewrite'], $img_cover, 'medium');
							$dealDetails[$a]['image'] = $img_cover;
							array_push($result, $dealDetails[$a]);
						}

					}
				}

				if(empty($discounts) && empty($result))
					$topProducts = Order::getTopOrderValueProducts($customerid, $duration, $addressId);	
			}
			else
			{
				$topProducts = Order::getTopOrderValueProducts($customerid, $duration, $addressId);	
			}	

			$array=array();
			$resReport = Order::getHistoryReport($customerid,2,$addressId);
			$categoryReport = Order::getRatioHistoryReport($customerid, $orderid, $duration, $addressId, NULL, $from_date, $to_date);
			
			array_push($array,$resReport,$categoryReport,$topProducts,$result,$discounts);

			$start_memory = memory_get_usage();	
			echo Tools::jsonEncode($array);                 
			
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		else if($type == 8)
		{
			$start_memory = memory_get_usage();	
			$get_top_product_category = Order::getRatioHistoryReport(
																		$customerid, 
																		0,
																		$duration,
																		0,
																		$selected_category, 
																		$from_date, 
																		$to_date
																	);
			echo Tools::jsonEncode($get_top_product_category);
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$type." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
	}

	public function generatePurchaseReport() 
	{
		$reportObj = new EliteExcelReports();
		$reportObj->customerid = Tools::getValue('customerid');
		$reportObj->duration = Tools::getValue('duration');
		$reportObj->orderid = Tools::getValue('orderid');
		$reportObj->from_date = Tools::getValue('from_date');
		$reportObj->to_date = Tools::getValue('to_date');
		$reportObj->location = Tools::getValue('location');
		$reportObj->addressId = Tools::getValue('addressId');
		$reportObj->sendMail = Tools::getValue('sendMail');
		$reportObj->mailTo = Tools::getValue('mailTo');
		$reportObj->message = Tools::getValue('message');
		$reportObj->generatePurchaseReport();
	}

	public function generateCategoryReport() 
	{
		$reportObj = new EliteExcelReports();
		$reportObj->customerid = Tools::getValue('customerid');
		$reportObj->duration = Tools::getValue('duration');
		$reportObj->orderid = Tools::getValue('orderid');
		$reportObj->from_date = Tools::getValue('from_date');
		$reportObj->to_date = Tools::getValue('to_date');
		$reportObj->location = Tools::getValue('location');
		$reportObj->addressId = Tools::getValue('addressId');
		$reportObj->sendMail = Tools::getValue('sendMail');
		$reportObj->mailTo = Tools::getValue('mailTo');
		$reportObj->message = Tools::getValue('message');
		$reportObj->generateCategoryReport();	
	}

	public function generateLocationReport() 
	{
		$reportObj = new EliteExcelReports();
		$reportObj->customerid = Tools::getValue('customerid');
		$reportObj->duration = Tools::getValue('duration');
		$reportObj->orderid = Tools::getValue('orderid');
		$reportObj->from_date = Tools::getValue('from_date');
		$reportObj->to_date = Tools::getValue('to_date');
		$reportObj->location = Tools::getValue('location');
		$reportObj->addressId = Tools::getValue('addressId');
		$reportObj->sendMail = Tools::getValue('sendMail');
		$reportObj->mailTo = Tools::getValue('mailTo');
		$reportObj->message = Tools::getValue('message');
		$reportObj->generateLocationReport();
	}
}