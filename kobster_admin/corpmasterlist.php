<?php 
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); 

include(PS_ADMIN_DIR.'/../config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');
 
	$q=$_GET['q'];
	$my_data=mysql_real_escape_string($q);
	$customerid = Tools::getValue('customerid');
	$product_codes = Tools::getValue('product_codes');
 	$type=Tools::getValue('type');

	 if($type==1)
	{
		$productcode=explode(",",$product_codes);
		for($i=0; $i<sizeof($productcode);$i++)
		{
			$prod_code= Db::getInstance()->getValue('
			SELECT id_product FROM '._DB_PREFIX_.'product WHERE reference ="'.$productcode[$i].'"');
			if($prod_code!="")
			{
			$responds=Db::getInstance()->Execute('INSERT INTO  `'._DB_PREFIX_.'ratecontract` (
									`id_customer` ,
									`id_product` )
									VALUES ("'.$customerid.'","'.$prod_code.'")');
			}
			else 
			{ 
				$responds=0;
			}
		}
		
		echo $responds;
	}
	 if($type==2)
	{
		$cus_name = Db::getInstance()->ExecuteS('
			SELECT id_customer,company, firstname, email FROM '._DB_PREFIX_.'customer WHERE id_buyer=3 AND  firstname LIKE "%'.$my_data.'%" OR email LIKE "%'.$my_data.'%" OR company LIKE "%'.$my_data.'%" ORDER BY firstname');
		 echo Tools::jsonEncode($cus_name);
		 flush();
	}
 	
	
	
		
	