<?php 
require_once(dirname(__FILE__).'/config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');
require_once(dirname(__FILE__).'/classes/Order.php');



$customerid = Tools::getValue('customerid');
$duration = Tools::getValue('duration');
$orderid = Tools::getValue('orderid');
$type = Tools::getValue('type');

if ($cookie->isLogged())
{		
		if($type==1)
		{
 															  
			$res_report = Order::getHistoryReport($customerid,$duration);
			$res_json = Tools::jsonEncode($res_report);
 			echo $res_json;
			
		}
		if($type==2)
		{
			$res_report = Order::getRatioHistoryReport($customerid, $orderid,$duration);
  			$res_json = Tools::jsonEncode($res_report);
 			echo $res_json;
			
		}
		if($type==3)
		{
			$order_details = Order::getAllOrders($customerid);
			$res_json = Tools::jsonEncode($order_details);
 			echo $res_json;
		}
		if($type==4)
		{
			$order_products = Order::getTopOrderValueProducts($customerid,$duration);
			$res_json = Tools::jsonEncode($order_products);
 			echo $res_json;
		}
 }
