<?php
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); 

include(PS_ADMIN_DIR.'/../config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');



$type = Tools::getValue('type');
$cus_id= Tools::getValue('cus_id');
$cus_wish_id= Tools::getValue('cus_wish_id');
$product_code= Tools::getValue('product_code');
$logger = new FileLogger();
$logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');


if($type==1)
{
	$cus_details = Db::getInstance()->ExecuteS('SELECT id_customer, firstname, email FROM `'._DB_PREFIX_.'customer` WHERE id_buyer=3 AND active=1');
	echo Tools::jsonEncode($cus_details);
}

if($type==2)
{
	$cus_wish_list = Db::getInstance()->ExecuteS('SELECT id_wishlist, name FROM `'._DB_PREFIX_.'wishlist` WHERE id_customer="'.$cus_id.'"');
	echo Tools::jsonEncode($cus_wish_list);
}
if($type==3)
{
 	$product_id=Db::getInstance()->getValue('SELECT id_product FROM `'._DB_PREFIX_.'product` WHERE reference = "'.$product_code.'" AND active=1');
	$logger->logError($product_id);
	
	$count=Db::getInstance()->getValue('SELECT COUNT(id_product) FROM `'._DB_PREFIX_.'wishlist_product` WHERE id_wishlist="'.$cus_wish_id.'" AND id_product="'.$product_id.'"');
	$logger->logError($count);
 	if($count==0)
	{
		$responds=Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'wishlist_product` (`id_wishlist`,`id_product`,`id_product_attribute`,`quantity`,`priority`,`totalprice`) VALUES ("'.$cus_wish_id.'","'.$product_id.'",0,0,0,0)');
		$responds = 1 ;
	}
	 elseif($product_id =="")
	 {
		 $responds = 2 ;
	 }
	else 
	{
		$responds = 0 ;
	}
	
	echo  $responds;
}
?>