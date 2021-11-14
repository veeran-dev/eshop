
<?php 
/*type1=>Add and update vendor address
type2=>autocomplete for vendor address
type3=>auto complete for vendor product mapping
type4=>add the product vendor mapping
type5=>to check exist email
type6=>to get product code and productid
type7=>to get reference code of productid
type8=>get all value for edit product vendor mapping
type9=>delete the vendor product mapping
type10=>get all the vendors who are in active
type11=>delete the vendor
*/
define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); 

include(PS_ADMIN_DIR.'/../config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');

 $logger = new FileLogger();
 $logger->setFilename('log-files/'.self::$cookie->id_customer.'-'.self::$cookie->customer_firstname.'.txt');	
 
	$q=$_GET['q'];
	$my_data=mysql_real_escape_string($q);
	$vendor_id = Tools::getValue('vendor_id');
	$vendorname = Tools::getValue('vendorname');
	$address = Tools::getValue('address');
	$email = Tools::getValue('email');
	$mobile = Tools::getValue('mobile');
	$tinno = Tools::getValue('tinno');
	$cstno = Tools::getValue('cstno');
	$rating = Tools::getValue('rating');
	$credit = Tools::getValue('credit');
	$delivery = Tools::getValue('delivery');
	$prod_code = Tools::getValue('prod_code');
	$prod_id = Tools::getValue('product_id');
	$prod_price = Tools::getValue('prod_price');
	$prod_edit = Tools::getValue('prod_edit');
 	$type=Tools::getValue('type');
	
 	/*for add and update to vendors */
	 if($type==1)
	{
		if($vendor_id != "")
		{
			$responds=Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'vendors` SET
												`vendor_name` = "'.$vendorname.'",
												`vendor_address`= "'.$address.'",
												`vendor_email` = "'.$email.'",
												`vendor_mobile`= "'.$mobile.'",
												`vendor_tin_no`= "'.$tinno.'",
												`vendor_cst_no`= "'.$cstno.'",
												`vendor_preference` = "'.$rating.'",
												`vendor_credit`= "'.$credit.'",
												`vendor_delivery` = "'.$delivery.'"
												WHERE `id_vendor` = "'.$vendor_id.'"');
				if($responds==1)
				{	
 					$updated_values=  Db::getInstance()->ExecuteS('SELECT id_vendor,`vendor_name`,`vendor_address`,`vendor_email`,`vendor_mobile`,
					 											  `vendor_credit`,`vendor_delivery`,`vendor_tin_no`,`vendor_cst_no`,
																  `vendor_preference` 
											  					   FROM '._DB_PREFIX_.'vendors WHERE vendor_active=1 AND id_Vendor="'.$vendor_id.'"');
													 
					$status=array( "result" => 1);
					$final_result=array_merge($updated_values + $status);
					$responds = Tools::jsonEncode($final_result);	
 				}
  		}
		else
		{
				$responds=Db::getInstance()->Execute('INSERT INTO  `'._DB_PREFIX_.'vendors` (
													`vendor_name` ,
													`vendor_address`,
													`vendor_email`,
													`vendor_mobile`,
													`vendor_tin_no`,
													`vendor_cst_no`,
													`vendor_preference`,
													`vendor_credit`,
													`vendor_delivery`,
													`vendor_active` )
													VALUES ("'.$vendorname.'","'.$address.'","'.$email.'","'.$mobile.'","'.$tinno.'","'.$cstno.'","'.$rating.'","'.$credit.'","'.$delivery.'",1)');
													
  				if($responds==1)
				{
					$lastAddedvendor=Db::getInstance()->ExecuteS('SELECT * FROM ps_vendors ORDER BY id_vendor DESC LIMIT 0,1');
					 
					$status=array("result" => 2);
					$final_result=array_merge($lastAddedvendor + $status);
					$responds = Tools::jsonEncode($final_result);
 				}
					
 		}
		
		echo $responds;
   	}
	
	/*for autocomplete to vendor editing*/
	 if($type==2)
	{
		 $ven_details = Db::getInstance()->ExecuteS('SELECT id_vendor,`vendor_name`,`vendor_address`,`vendor_email`,
													 `vendor_mobile`,`vendor_credit`,
													 `vendor_delivery`,`vendor_tin_no`,`vendor_cst_no`,`vendor_preference` 
											  		 FROM '._DB_PREFIX_.'vendors WHERE vendor_active=1 AND id_Vendor="'.$vendor_id.'"');
		echo Tools::jsonEncode($ven_details);
	}
	
	/*for autocomplete to vendor product mapping*/
 	 if($type==3)
	{
		$ven_name = Db::getInstance()->ExecuteS('SELECT id_vendor, vendor_name
												 FROM '._DB_PREFIX_.'vendors WHERE vendor_active=1 AND  vendor_name LIKE "%'.$my_data.'%" ORDER BY vendor_name');
		 echo Tools::jsonEncode($ven_name);
		 flush();
	}
	/*for add vendor product mapping*/
	if($type==4)
	{
		if($prod_edit == 0)
		{
		$prodcode= Db::getInstance()->getValue('SELECT id_product 
												FROM '._DB_PREFIX_.'product WHERE reference ="'.$prod_code.'"');
			if($prodcode!="")
			{
			$responds=Db::getInstance()->Execute('INSERT INTO  `'._DB_PREFIX_.'vendor_product_mapping` (
												`id_product_reference` ,
												`id_vendor`,
												`product_price` )
												VALUES ("'.$prod_code.'","'.$vendor_id.'","'.$prod_price.'")');
				if($responds !=0)
				{
					$lastadd = Db::getInstance()->ExecuteS('SELECT a.product_price, a.`id_product_reference`, b.vendor_name, b.id_vendor, b.vendor_preference 
															FROM '._DB_PREFIX_.'vendor_product_mapping AS a  
															LEFT JOIN '._DB_PREFIX_.'vendors AS b ON a.`id_vendor`= b.`id_vendor` 
															WHERE a.status=1 AND b.`id_vendor`= (SELECT id_vendor FROM '._DB_PREFIX_.'vendor_product_mapping ORDER BY id DESC  LIMIT 0,1  ) ');
					$responds = Tools::jsonEncode($lastadd);
  				}
			}
			else 
			{ 
				$responds=0;
 			}
		}
		else
		{
			$responds=Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'vendor_product_mapping` SET
												 `product_price` = "'.$prod_price.'"
												  WHERE `id_vendor` = "'.$vendor_id.'" AND `id_product_reference`="'.$prod_code.'" AND `status` = 1 ');
				
				if( $responds != 0 )
 					$responds = $prod_price;
 		}
		echo $responds;
	}
	
	/*Check the existing Email*/
	if($type==5)
	{
		$email_result= Db::getInstance()->getValue('SELECT COUNT(vendor_email) 
													FROM '._DB_PREFIX_.'vendors WHERE vendor_email ="'.$email.'" AND vendor_Active=1');
		echo $email_result;
	}
	
	/*get the product code and  prod_id */
	if($type==6)
	{
		$ven_product = Db::getInstance()->ExecuteS('SELECT a.vendor_name , a.`vendor_preference`, b.id_vendor, b.`id_product_reference`,b.`product_price` FROM '._DB_PREFIX_.'vendors AS a  
													LEFT JOIN '._DB_PREFIX_.'vendor_product_mapping  AS b
													LEFT JOIN  '._DB_PREFIX_.'product AS c ON c.reference= b.`id_product_reference`
													ON a.`id_vendor`=b.`id_vendor` WHERE b.status = 1 AND c.`id_product`="'.$prod_id.'" ORDER BY b.`product_price`');
													
		echo Tools::jsonEncode($ven_product);
	}
	
	/*just to select the reference code from product id */
	if($type==7)
	{
		$pro_cod = Db::getInstance()->ExecuteS('SELECT reference 
												FROM ps_product WHERE id_product="'.$prod_id.'"  AND active=1');
													
		echo Tools::jsonEncode($pro_cod);										
	}
	
	/*use to get the value for edit*/
	if($type==8)
	{
		$edit_mapping = Db::getInstance()->ExecuteS('SELECT a.vendor_name ,  b.id_vendor, b.`id_product_reference`,b.`product_price` 
													FROM '._DB_PREFIX_.'vendors AS a  
													LEFT JOIN '._DB_PREFIX_.'vendor_product_mapping  AS b
													ON a.`id_vendor`=b.`id_vendor` WHERE b.`id_vendor`= "'.$vendor_id.'" AND b.id_product_reference = "'.$prod_code.'" AND b.status = 1');
													
		echo Tools::jsonEncode($edit_mapping);										
			
	}
	
	/*delete the product vendor pricing*/
	if($type==9)
	{
		$delete_mapping = Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'vendor_product_mapping` SET
													 `status` = 0
													  WHERE `id_vendor` = "'.$vendor_id.'" AND `id_product_reference`="'.$prod_code.'" AND `status` = 1 ');
		echo $delete_mapping ;										
 	}
	
	/*To get all the vendors details who are in active */
	if($type==10)
	{
		
		$vendordetails = Db::getInstance()->ExecuteS('SELECT id_vendor,`vendor_name`,`vendor_address`,`vendor_email`,`vendor_mobile`,
													 `vendor_credit`,`vendor_delivery`,`vendor_tin_no`,`vendor_cst_no`,`vendor_preference` 
											  		 FROM '._DB_PREFIX_.'vendors WHERE vendor_active=1 ');
		$responds = Tools::jsonEncode($vendordetails);
		echo $responds;
	}
	
	/*to delete the vendor */
	if($type==11)
	{
		$delete_vendor = Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'vendors` SET
													`vendor_active` = 0
													WHERE `id_vendor` = "'.$vendor_id.'" AND `vendor_active` = 1 ');
				
 								
		echo $delete_vendor ;										
			
 	}
	 