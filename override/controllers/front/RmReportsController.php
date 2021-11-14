<?php 
class RmReportsControllerCore extends DashController
{
	
	public function ajaxReturn()
	{
 		$customerid = Tools::getValue('customerid');
		$duration = Tools::getValue('duration');
		$addressId = Tools::getValue('addressId');
		$orderid = Tools::getValue('orderid');
		$type = Tools::getValue('type');
		$from_date = Tools::getValue('from_date');
		$to_date = Tools::getValue('to_date');

		$selected_category = Tools::getValue('selected_category_id');
		$start_memory = memory_get_usage();	
		$logger = new FileLogger();
		$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
		$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');	
		$Order = new Order();
		/*To get All reports of that particular customer*/
		if($type==1)
		{												  
			$res_report = RmReports::getHistoryReport($customerid,$duration,$addressId,$from_date,$to_date);
			$start_memory = memory_get_usage();	
			$res_json = Tools::jsonEncode($res_report);
			echo $res_json;
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		/*To get All categories of the product for a particular  customer*/
		if($type==2)
		{
 			$res_report = RmReports::getRatioHistoryReport($customerid, $orderid, $duration, $addressId, 0, $from_date, $to_date);
			$start_memory = memory_get_usage();	
 			$res_json = Tools::jsonEncode($res_report);
			echo $res_json;
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}

		if($type == 3)
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
		if($type==4)
		{
			$start_memory = memory_get_usage();	
			$order_products = RmReports::getTopOrderValueProducts($customerid,$duration,$addressId, $from_date, $to_date);
			$res_json = Tools::jsonEncode($order_products);
			echo $res_json;
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
			
		}
		if($type==5)/*To get the top 4 products of all the orders */
		{
			//$order_products = Order::getTopOrderValueProducts($customerid,$duration,0);
			$start_memory = memory_get_usage();	
			$order_products = RmReports::getTopOrderValueProducts($customerid,$duration,0);
 			$products = Product::getProductsProperties($id_lang=1, $order_products);
			$search=new CorporateUser();
			$search->getProductImageLink($products,null,null);
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		/*To get monthly category report*/
		if($type==6)
		{
			$start_memory = memory_get_usage();	
			$locationReport = RmReports::getLocationBasedReport($customerid,$duration, $from_date, $to_date);
			$res_json = Tools::jsonEncode($locationReport);
			echo $res_json;
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		if($type==7)/*To get monthly category and top products report*/
		{
			$customer=new Customer($customerid);
			$dealDetails=Deal::findDeal($customer->id_default_group);
			$topProducts=array();
			//$discounts=Discount::getVouchersToCustomerCartDisplay((int)(self::$cookie->id_lang), (isset(self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0));
			//$discounts=CartRule::getCustomerCartRules((int)(self::$cookie->id_lang), (isset(self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0));
			$test=CartRule::getCustomerCartRules((int)(self::$cookie->id_lang), (isset(self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0), true, true, true, null, false, true);
			$discounts=array();
			/*for($i=0;$i<sizeof($test);$i++)
			{
				if(sizeof($test[$i])){
					array_push($discounts,$test[$i]);
				}			
			}*/
			foreach($test as $t)
			{
				if(sizeof($t)){
					array_push($discounts,$t);
				}
			}
			
 			$current_date=strtotime(date("Y-m-d H:i:s"));
			$result=array();
			$discountArray=array();
			if(sizeof($dealDetails)>0 || sizeof($discounts)>0)
			{
				if(sizeof($dealDetails)>0)
				{
					for($a=0;$a<sizeof($dealDetails);$a++)
					{
						
						$from_date=strtotime($dealDetails[$a]['from']);
						$to_date=strtotime($dealDetails[$a]['to']);
						if(($current_date>=$from_date) && ($current_date<=$to_date) && ($dealDetails[$a]['active']==1))
						{
							
							$obj = new Product((int)($dealDetails[$a]['id_product']), false, 1);
							
							$price=$obj->getPrice(true,NULL);
							$dealDetails[$a]['price']=(string)$price;
							
							$img_cover;
							if (!Validate::isLoadedObject($obj))
							{
								continue;
							}
							else
							{
								$images = $obj->getImages(1);

								foreach ($images AS $j => $image)
								{
									if ($image['cover'])
									{
										$img_cover = $obj->id.'-'.$image['id_image'];
										break;
									}
								}

								if (!isset($img_cover))
									$img_cover = Language::getIsoById((int)(self::$cookie->id_lang)).'-default';							
							}
							$img_cover=self::$link->getImageLink($dealDetails[$a]['link_rewrite'], $img_cover, 'medium');
							$dealDetails[$a]['image']=$img_cover;
							array_push($result, $dealDetails[$a]);
						}

					}
				}
				/*if(sizeof($discounts)>0)
				{
					foreach($discounts as $disc)
					{
						if(($disc['active']==1) && ($disc['quantity']>0) && ($current_date<strtotime($disc['date_to'])))
						{
							array_push($discountArray, $disc);
						}
					}
				}*/
				if(empty($discounts) && empty($result))
				{
					$topProducts = RmReports::getTopOrderValueProducts($customerid,$duration,$addressId);	
				}
				
			}
			else
			{
				$topProducts = RmReports::getTopOrderValueProducts($customerid,$duration,$addressId);	
			}
			/*if(($current_date>=$from_date) && ($current_date<=$to_date))
			{
				for($k=0; $k<=3; $k++)
				{
					$obj = new Product((int)($dealDetails[$k]['id_product']), false, 1);
					$img_cover;
					if (!Validate::isLoadedObject($obj))
					{
						continue;
					}
					else
					{
						$images = $obj->getImages(1);
						foreach ($images AS $j => $image)
						{
							if ($image['cover'])
							{
								$img_cover = $obj->id.'-'.$image['id_image'];
								break;
							}
						}
						if (!isset($img_cover))
							$img_cover = Language::getIsoById((int)($cookie->id_lang)).'-default';
					}
					$img_cover=self::$link->getImageLink($dealDetails[$k]['link_rewrite'], $img_cover, 'medium');
					//array_push($dDetails, $img_cover);
					$dealDetails[$k]['image']=$img_cover;
				}
				$result = $dealDetails;                 
			}
			else
			{
				$topProducts = Order::getTopOrderValueProducts($customerid,$duration,$addressId);	
			}*/

			$array=array();
			$resReport = RmReports::getHistoryReport($customerid,2,$addressId);
			$categoryReport = RmReports::getRatioHistoryReport($customerid, $orderid,$duration,$addressId);
			
			array_push($array,$resReport,$categoryReport,$topProducts,$result,$discounts);
			//var_dump($res_json);
			$start_memory = memory_get_usage();	
			$array = Tools::jsonEncode($array);                 
			echo $array;
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
		if($type==8)
		{
			$start_memory = memory_get_usage();	
			//$get_top_product_category = Order::getTopProductInCategory($customerid,$duration,$selected_category);
			$get_top_product_category = RmReports::getRatioHistoryReport($customerid, 0,$duration,0,$selected_category, $from_date, $to_date);
			$res_json = Tools::jsonEncode($get_top_product_category);
			echo $res_json;
			$logger = new FileLogger();
			$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');
			$logger->logInfo("Ajax Response  :".$_SERVER['REQUEST_URI']." Type: ".$_POST['type']." Customer name: ".self::$cookie->customer_firstname." Response size : ".round((memory_get_usage() - $start_memory)/1024,2).'KB');
		}
	}
}
?>