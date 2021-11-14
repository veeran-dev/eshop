<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14850 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class ScnVendorInfoCore extends BackController
{
	/** @var int vendor id */
	public $id;

	/** @var String vendor name */
	public $name;

	/** @var String vendor GST No */
	public $gst;

	/** @var string vendor website url */
	public $website;

	/** @var int vendor credit days */
	public $credit_days;

	/** @var int vendor FC */
	public $id_fulfillment_centre;

	/** @var int vendor id_payment */
	public $id_payment;

	/** @var int vendor replacement */
	public $replacement;

	/** @var text vendor comments */
	public $comments;

	/** @var int vendor delivery */
	public $delivery;

	/** @var string vendor PAN No */
	public $pan;

	/** @var bigint vendor phone */
	public $phone;

	/** @var datetime vendor date added */
	public $date_add;

	public function __construct()
    {
    	parent::__construct();
    }

	public function addVendor()
	{
		Db::getInstance()->autoExecute(_DB_PREFIX_.'vendor', array(
			'name' => $this->name, 
			'gst' => $this->gst, 
			'id_payment' => $this->id_payment,
			'credit_days' => $this->credit_days,
			'website' => $this->website,
			'replacement' => $this->replacement,
			'comments' => $this->comments,
			'delivery' => $this->delivery,
			'pan' => $this->pan,
			'phone' => $this->phone,
			'id_fulfillment_centre' => $this->id_fulfillment_centre,
			'date_add' => $this->date_add
		), 'INSERT');

		return Db::getInstance()->getValue('SELECT MAX(id_vendor) FROM '._DB_PREFIX_.'vendor');	
	}
	
	public function updateVendor()
	{
		return Db::getInstance()->autoExecute(_DB_PREFIX_.'vendor', array(
			'name' => $this->name, 
			'gst' => $this->gst, 
			'id_payment' => $this->id_payment,
			'credit_days' => $this->credit_days,
			'website' => $this->website,
			'replacement' => $this->replacement,
			'comments' => $this->comments,
			'delivery' => $this->delivery,
			'pan' => $this->pan,
			'phone' => $this->phone,
			'id_fulfillment_centre' => $this->id_fulfillment_centre
		), 'UPDATE', 'id_vendor = '.$this->id.'');
	}
	 
	public static function addVendorAddress($addressAlise,$address,$city,$state,$country,$pincode,$landmark,$phone,$fax,$workingHours,$addressdelivery,$workingDays,$addressComment,$vendorId)
	{
		
		Db::getInstance()->ExecuteS('INSERT INTO '._DB_PREFIX_.'vendor_address
		(`id_vendor`,`alise`,`address1`,`city`,`id_state`,`country`,`pincode`,`landmark`,`phone`,`fax`,`delivery`,`working_hour`,`working_days`,`comments`,`date_add`)
		VALUES("'.$vendorId.'","'.$addressAlise.'","'.$address.'","'.$city.'","'.$state.'","'.$country.'","'.$pincode.'","'.$landmark.'","'.$phone.'","'.$fax.'","'.$addressdelivery.'","'.$workingHours.'","'.$workingDays.'","'.$addressComment.'",NOW())');
		
		return Db::getInstance()->getValue('SELECT MAX(id_address) FROM '._DB_PREFIX_.'vendor_address');	
	}
	
	public static function updateVendorAddress($addressAlise,$address,$city,$state,$country,$pincode,$landmark,$phone,$fax,$workingHours,$addressdelivery,$workingDays,$addressComment,$vendorId,$addressId)
	{
 		Db::getInstance()->ExecuteS('UPDATE '._DB_PREFIX_.'vendor_address SET alise="'.$addressAlise.'", address1="'.$address.'",city="'.$city.'",id_state="'.$state.'",country="'.$country.'",pincode="'.$pincode.'",landmark="'.$landmark.'",phone="'.$phone.'",fax="'.$fax.'",working_hour="'.$workingHours.'",delivery="'.$addressdelivery.'",working_days="'.$workingDays.'",comments="'.$addressComment.'"
									 WHERE id_address='.$addressId);
	 	return $addressId;
	}
	
	public static function deleteVendorAddress($addressId)
	{
		Db::getInstance()->ExecuteS('UPDATE '._DB_PREFIX_.'vendor_address SET active="0" WHERE id_address='.$addressId);
	}
	
	public static function addVendorPoc($pocName,$designation,$pocMobile1,$pocMobile2,$pocLang,$pocEmail,$pocSmartPhone,$pocComment,$vendorId,$pocAddress)//address id changes
	{
		Db::getInstance()->ExecuteS('INSERT INTO '._DB_PREFIX_.'vendor_poc
										(`id_vendor`,`firstname`,`designation`,`phone1`,`phone2`,`email`,`smart_phone`,`comments`,`date_add`,`id_address`)
										VALUES("'.$vendorId.'","'.$pocName.'","'.$designation.'","'.$pocMobile1.'","'.$pocMobile2.'","'.$pocEmail.'","'.$pocSmartPhone.'","'.$pocComment.'",NOW(),"'.$pocAddress.'")');

		return  Db::getInstance()->getValue('SELECT MAX(id_poc) FROM '._DB_PREFIX_.'vendor_poc');	
	}
		
	public static function updateVendorPoc($pocName,$designation,$pocMobile1,$pocMobile2,$pocLang,$pocEmail,$pocSmartPhone,$pocComment,$pocId,$pocAddress)//address id changes	
	{
	
		Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'vendor_poc SET firstname="'.$pocName.'",designation="'.$designation.'", phone1="'.$pocMobile1.'",phone2="'.$pocMobile2.'",email="'.$pocEmail.'",smart_phone="'.$pocSmartPhone.'",comments="'.$pocComment.'",id_address="'.$pocAddress.'"
									 WHERE id_poc='.$pocId);
 		
	 	return $pocId;
	}
	
	public static function deleteVendorPoc($pocId)
	{
		return Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'vendor_poc SET active="0" WHERE id_poc='.$pocId);
	}
	
	public static function defaultAddress($vendorId,$vendorAddressAdd)
	{

		Db::getInstance()->ExecuteS('UPDATE '._DB_PREFIX_.'vendor SET id_default_address='.$vendorAddressAdd.' WHERE id_vendor='.$vendorId);
	}
	
	public static function defaultPoc($vendorId,$vendorPocAdd)
	{
		return Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'vendor SET id_default_poc='.$vendorPocAdd.' WHERE id_vendor='.$vendorId);
	}
	public static function addLang($pocId,$languageId)
	{
 		Db::getInstance()->ExecuteS('INSERT INTO '._DB_PREFIX_.'poc_lang (`id_poc`,`id_lang`) VALUES ("'.$pocId.'","'.$languageId.'")');
		
		return Db::getInstance()->ExecuteS('SELECT l.id_lang,l.name 
											FROM `'._DB_PREFIX_.'lang` AS l
											LEFT JOIN `'._DB_PREFIX_.'poc_lang` AS pl
											ON pl.`id_lang`=l.`id_lang`
											WHERE pl.`id_poc`='.$pocId.' AND l.`active`= 1 AND pl.`id`=(SELECT MAX(id) FROM '._DB_PREFIX_.'poc_lang WHERE id_poc='.$pocId.')');
		

	}
	/*Return all the vendors*/
	public static function getVendorList()
	{
 		return Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'vendor WHERE active=1');
	}
	/*delete particular vendor*/
	public static function deletVendor($vendorid)
	{
 		$delete = Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'vendor SET active = 0  WHERE id_vendor= '.$vendorid);
		echo $delete;
 	}
	public static function getVendor($vendorName)
	{
		// $useSSL = true;
	// $q=trim($q);
	// $customerid=$id_customer;
	//$my_data=mysql_real_escape_string($vendorName);
	$my_data=$vendorName;
	$matchedVendor = Db::getInstance()->ExecuteS('SELECT kv.name ,kv.id_vendor 
											FROM `'._DB_PREFIX_.'vendor` AS kv
											WHERE kv.name like "%'.$vendorName.'%" and active=1');
	// $matchedVendor = Db::getInstance()->ExecuteS('SELECT kv.name ,kv.id_vendor, MATCH(kv.`name`) AGAINST ("'.$my_data.'*") AS Relevance 
	// 										FROM `'._DB_PREFIX_.'vendor` AS kv
	// 										WHERE MATCH(kv.`name`) AGAINST("'.$my_data.'*" IN BOOLEAN MODE) 
	// 										ORDER BY Relevance DESC');
		echo Tools::jsonEncode($matchedVendor);
 	}
	public static function getProduct($productName)
	{
		$useSSL = true;
		$productName=trim($productName);
		$my_data=$productName;
		$matchedProducts = Db::getInstance()->ExecuteS('SELECT DISTINCT kp.id_product, kpl.name, c.id_image, kcl.link_rewrite,kp.`reference`,((20*MATCH(kp.`reference`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+(10*MATCH(kpl.`name`)
														AGAINST ("'.$my_data.'*" IN BOOLEAN MODE)) 
														+ (5*MATCH(kcl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))+
																	(2*MATCH(km.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))) AS Relevance
														FROM `'._DB_PREFIX_.'product_lang` AS kpl, 
														`'._DB_PREFIX_.'image` AS c , 
														`'._DB_PREFIX_.'category_product` AS kcp,
														`'._DB_PREFIX_.'category_lang` AS kcl,
														`'._DB_PREFIX_.'product` AS kp,
														`'._DB_PREFIX_.'manufacturer` AS km
														WHERE (MATCH(kp.`reference`,km.`name`,kcl.`name`,kpl.`name`) AGAINST ("'.$my_data.'*" IN BOOLEAN MODE))
														AND c.`id_product`= kp.`id_product`
														AND kpl.`id_product`= kp.`id_product`
														AND kcp.`id_product`= kp.`id_product`
														AND kcl.`id_category`= kcp.`id_category`
														AND km.`id_manufacturer`=kp.`id_manufacturer`
														AND c.cover=1
														AND kp.active=1
														AND kpl.id_lang=1 AND kcl.id_lang=1
														GROUP BY kp.id_product
														ORDER BY Relevance DESC');

		$products = Product::getProductsProperties($id_lang=1, $matchedProducts);

		$getImages=new CorporateUser();												
		$getImages->getProductImageLink($products,null,null);

	}

	public static function getCategory($categoryName)
	{
		$useSSL = true;
		$categoryName = trim($categoryName);
		$my_data = $categoryName;
		$matchedCategory = Db::getInstance()->ExecuteS('SELECT kvl.name ,kvl.id_category, MATCH(kvl.`name`) AGAINST ("'.$my_data.'*") AS Relevance 
														FROM `'._DB_PREFIX_.'category_lang` AS kvl
														WHERE MATCH(kvl.`name`) AGAINST("'.$my_data.'*" IN BOOLEAN MODE) 
														AND kvl.id_lang=1
														ORDER BY Relevance DESC');
		echo Tools::jsonEncode($matchedCategory);
	}

	public static function getManufacture($brandName)
	{
		$useSSL = true;
		$brandName = trim($brandName);
		$my_data = $brandName;
		$matchedBrand = Db::getInstance()->ExecuteS('SELECT km.name ,km.id_manufacturer, MATCH(km.`name`) AGAINST ("'.$my_data.'*") AS Relevance 
													 FROM `'._DB_PREFIX_.'manufacturer` AS km
													 WHERE MATCH(km.`name`) AGAINST("'.$my_data.'*" IN BOOLEAN MODE) 
													 AND km.active = 1 ORDER BY Relevance DESC');
		echo Tools::jsonEncode($matchedBrand);
	}

	public static function getCategoryProducts($categoryId)
	{
		$matchedCategory = Db::getInstance()->ExecuteS('SELECT kvl.name ,kvl.id_category, MATCH(kvl.`name`) AGAINST ("'.$my_data.'*") AS Relevance 
														FROM `'._DB_PREFIX_.'category_lang` AS kvl
														WHERE MATCH(kvl.`name`) AGAINST("'.$my_data.'*" IN BOOLEAN MODE) 
														AND kvl.id_lang=1
														ORDER BY Relevance DESC');
		echo Tools::jsonEncode($matchedCategory);
	}

	public static function getManufacturerProducts($brandId)
	{
		return Db::getInstance()->ExecuteS('SELECT p.`id_product`,  pl.`name`
											FROM `'._DB_PREFIX_.'product` p
											LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = 1)
											WHERE p.`id_manufacturer` = '.(int)($brandId).' AND p.active=1');			
	}

	public static function getVendorAddressPoc($vendorId)
	{
		$result = array();

		$address = Db::getInstance()->ExecuteS('SELECT kva.alise ,kva.id_address,kv.id_vendor,kv.name,kv.id_default_poc,kv.id_default_address
												FROM `'._DB_PREFIX_.'vendor_address` AS kva,`'._DB_PREFIX_.'vendor` AS kv
												WHERE kv.id_vendor='.$vendorId.'
												AND kva.`id_vendor`= kv.`id_vendor`');

		$poc = Db::getInstance()->ExecuteS('SELECT kvp.firstname ,kvp.id_poc,kv.id_vendor,kv.name,kv.id_default_poc,kv.id_default_address
											FROM `'._DB_PREFIX_.'vendor_poc` AS kvp,`'._DB_PREFIX_.'vendor` AS kv
											WHERE kv.id_vendor='.$vendorId.'
											AND kvp.`id_vendor`= kv.`id_vendor`');

		$result[]=array_push($result,$address,$poc);

		echo Tools::jsonEncode($result);
 	}

	public static function mapVendorProduct($data)
	{
		$sql = array();

		foreach($data AS $category){
			foreach($category['data'] AS $products){
				$sql[] = '("'.$products['id_product'].'", "'.$category['vendorId'].'", "'.$category['addressId'].'", "'.$category['pocId'].'", "'.$category['vendorType'].'", "'.$category['categoryId'].'")';
			}
		}

		$insertValue = Db::getInstance()->Execute('INSERT IGNORE  INTO '._DB_PREFIX_.'product_vendor_mapping (`id_product`,`id_vendor`,`id_address`,`id_poc`,`id_vendor_category`,`id_category`)
										 		   VALUES '.implode(',', $sql));
 		echo $insertValue;			 
	}

	public static function mapMultipleProducts($data)
	{
		$sql = array();

		foreach($data AS $products)
		{
			$sql[] = '("'.$products['productId'].'", "'.$products['vendorId'].'", "'.$products['addressId'].'", "'.$products['pocId'].'", "'.$products['vendorType'].'")';
		}
		
		$insertValue= Db::getInstance()->Execute('INSERT IGNORE  INTO '._DB_PREFIX_.'product_vendor_mapping (`id_product`,`id_vendor`,`id_address`,`id_poc`,`id_vendor_category`)
										 		  VALUES '.implode(',', $sql));
 		echo $insertValue;	
	}

	public static function getVendorAddress($vendorId)
	{
			return Db::getInstance()->ExecuteS('SELECT id_address,alise 
												FROM '._DB_PREFIX_.'vendor_address 
												WHERE id_vendor='.$vendorId.' AND active = 1');
	}
	
	public static function getAddress($addressId,$vendorId)
	{
		return Db::getInstance()->ExecuteS('SELECT va.*, v.`id_default_address`
											FROM '._DB_PREFIX_.'vendor_address AS va 
											LEFT JOIN '._DB_PREFIX_.'vendor AS v
											ON va.`id_vendor`= v.`id_vendor`
											WHERE va.id_vendor = '.$vendorId.' AND va.active = 1 AND va.id_address = '.$addressId );
	}
	
	public static function getVendorPOC($vendorId)
	{
		return Db::getInstance()->ExecuteS('SELECT id_poc, firstname, email FROM '._DB_PREFIX_.'vendor_poc WHERE  id_vendor='.$vendorId.' AND active = 1');	
	}

	public static function getPOCDetail($poc,$vendorId)
	{
		return Db::getInstance()->ExecuteS('SELECT vp.*,v.id_default_poc
											FROM `'._DB_PREFIX_.'vendor_poc` AS vp
											LEFT JOIN '._DB_PREFIX_.'vendor AS v
											ON vp.`id_vendor`= v.`id_vendor`
											WHERE vp.id_vendor = '.$vendorId.' AND vp.active = 1 AND vp.id_poc='.$poc );
	}

	public static function getPOCLang($poc)
	{
		return Db::getInstance()->ExecuteS('SELECT l.id_lang,l.name 
											FROM `'._DB_PREFIX_.'lang` AS l
											LEFT JOIN `'._DB_PREFIX_.'poc_lang` AS pl
											ON pl.`id_lang`=l.`id_lang`
											WHERE pl.`id_poc`='.$poc.' AND l.`active`= 1');
	}

	public static function deletePocLang($poc,$language)
	{
		return Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'poc_lang` WHERE id_poc='.$poc.' AND id_lang='.$language);
	}

	public static function getPaymentMode()
	{
		return Db::getInstance()->ExecuteS('SELECT id_payment, `payment_name` as paymentMode FROM `'._DB_PREFIX_.'payment_option_master`');
	}

	public static function addBankDetails($bankName,$bankBranch,$bankAddress,$accountName,$accountType,$accountNumber,$ifsccode,$selectVendor,$vendorAddress)
	{
		$result = Db::getInstance()->ExecuteS('INSERT INTO '._DB_PREFIX_.'vendor_bank_details (`id_vendor`,`id_address`,`bank_name`,`branch`,`branch_address`,`account_no`,`account_type`,`account_name`,`ifsc_code`,`date_add`)
										  	   VALUES("'.$selectVendor.'","'.$vendorAddress.'","'.$bankName.'","'.$bankBranch.'","'.$bankAddress.'","'.$accountNumber.'","'.$accountType.'","'.$accountName.'","'.$ifsccode.'",NOW())');	
		return Db::getInstance()->getValue('SELECT MAX(id_bank) FROM `'._DB_PREFIX_.'vendor_bank_details` WHERE id_vendor="'.$selectVendor.'" ');
	}

	public static function updateBankDetails($bankId,$bankName,$bankBranch,$bankAddress,$accountName,$accountType,$accountNumber,$ifsccode,$selectVendor,$vendorAddress)
	{
		 
		$updatebank = Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'vendor_bank_details SET 
									`bank_name`="'.$bankName.'",
									`branch`="'.$bankBranch.'",
									`branch_address`="'.$bankAddress.'",
									`account_name`="'.$accountName.'",
									`account_no`="'.$accountNumber.'",
									`account_type`="'.$accountType.'",
									`ifsc_code`="'.$ifsccode.'",
									`id_address`="'.$vendorAddress.'"
 									 WHERE id_bank="'.$bankId.'" AND active=1' );
 		return $updatebank;
	}

	public static function deleteBank($bankId)
	{
  		$deleteBank=Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'vendor_bank_details SET 
									`active`=0 WHERE id_bank='.$bankId);
 		return $deleteBank;
	}
	
	public static function getBankName($vendorId)
	{
		return Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'vendor_bank_details` WHERE id_vendor='.$vendorId.' AND active=1');
	}

	public static function getBankDetails($bankId,$vendorId)
	{
		$bank_id='';
		$vendor='';
		if($bankId)
			$bank_id = 'AND vbd.id_bank='.$bankId.' ';
		
		if($vendorId)
			$vendor='vbd.id_vendor='.$vendorId.' AND ';
	
		return Db::getInstance()->ExecuteS('SELECT vbd.*, v.`name`, va.`alise`
											FROM `'._DB_PREFIX_.'vendor_bank_details` AS vbd
											LEFT JOIN `'._DB_PREFIX_.'vendor` AS v
											ON vbd.`id_vendor` = v.`id_vendor` 
											LEFT JOIN `'._DB_PREFIX_.'vendor_address` AS va
											ON vbd.`id_address` = va.`id_address`
											WHERE '.$vendor.'vbd.active=1 '.$bank_id.'');
	}

	public function getProductHistory($id_product, $id_fc = NULL)
	{
		$query = "";
		$query .= $id_fc && $id_fc != "" ? ' AND v.`id_fulfillment_centre` = '.$id_fc.'' : '';

		return Db::getInstance()->ExecuteS('SELECT vpb.`id_bill_no`,vpb.`bill_date`,vpb.`product_qty`,vpb.`unit_price`,v.`name` 
											FROM `'._DB_PREFIX_.'vendor_purchase_bill` as vpb 
											LEFT JOIN `'._DB_PREFIX_.'vendor` v ON vpb.`id_vendor` = v.`id_vendor` 
											WHERE v.`id_vendor` = vpb.`id_vendor` AND vpb.`id_product` =  '.$id_product.' '.$query.' 
											AND vpb.`active` = 1 ORDER BY vpb.`bill_date`');
	}

	public static function getVendorDetails($id_vendor)
	{
		$vendor='';
		if($id_vendor)
			$vendor='WHERE a.`id_vendor` = '.$id_vendor;
		return Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'vendor` a '.$vendor);
	}
}
