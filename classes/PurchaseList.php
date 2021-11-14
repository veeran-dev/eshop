<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @version  Release: $Revision: 14011 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;
	
class PurchaseList extends ObjectModel
{
 	public 		$id_customer;
 	protected 	$table = 'purchase_list';
	protected 	$identifier = 'id_pur_list';
 	
	public static function getByIdCustomer($id_customer)
	{
 		$result = Db::getInstance()->ExecuteS('SELECT id_pur_list AS id_list, list_name AS listname,list_active  
												FROM '._DB_PREFIX_.'purchase_list 	
												WHERE id_customer='.(int)($id_customer).' 
												ORDER BY list_name ASC');
 		
		/*$result = Db::getInstance()->ExecuteS('
		SELECT COUNT(rclm.`id_rate_contract`) AS totalproduct, pl.id_pur_list AS id_list, pl.list_name AS listname, pl.`list_status`, pl.`list_active`  
		FROM '._DB_PREFIX_.'purchase_list AS pl
		LEFT JOIN `'._DB_PREFIX_.'rate_contract_list_mapping` AS rclm 
		ON rclm.`id_pur_list` = pl.`id_pur_list`
		WHERE pl.id_customer='.(int)($id_customer).' 
		GROUP BY  pl.id_pur_list ORDER BY pl.list_name ASC');*/
		
		
		 
 		return $result;
	}

 	/**
	 * Get Wishlist products by Customer ID
	 *
	 * @return array Results
	 */
	public static function getProductByIdCustomer($id_pur_list, $id_customer, $id_lang, $id_product = null, $quantity = false)
	{
		global $cookie;
  		if (!Validate::isUnsignedId($id_customer) OR
			!Validate::isUnsignedId($id_lang) OR
			!Validate::isUnsignedId($id_pur_list))
			die (Tools::displayError());
				
  
				$products = Db::getInstance()->ExecuteS('SELECT prl.id_pur_list, prl.`list_name`, rc.id_product,  pl.`name`, rclm.`id_rate_contract`,rclm.`product_quantity` AS product_quantity, pl.link_rewrite, 
		cl.link_rewrite AS category_rewrite, pl.`description_short`, p.`reference`,t.`rate` as tax_value
							FROM `'._DB_PREFIX_.'rate_contract` rc
							JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = rc.`id_product`
							JOIN `'._DB_PREFIX_.'product_lang` pl ON pl.`id_product` = rc.`id_product`
							JOIN `'._DB_PREFIX_.'rate_contract_list_mapping` rclm ON rc.`id_rate_contract`=rclm.`id_rate_contract`
							JOIN `'._DB_PREFIX_.'purchase_list` prl ON prl.`id_pur_list` = rclm.`id_pur_list`
							JOIN `'._DB_PREFIX_.'category_lang` cl ON cl.`id_category` = p.`id_category_default` 
							JOIN `'._DB_PREFIX_.'tax_rule` txr ON (p.`id_tax_rules_group`=txr.`id_tax_rules_group` AND txr.`id_state`=0)
							JOIN `'._DB_PREFIX_.'tax` t ON txr.`id_tax`=t.`id_tax`

							WHERE prl.`id_customer` ='.(int)($id_customer).'
							AND rclm.`active` = 1
							AND rc.`active` = 1
 							AND p.active = 1 
							AND p.discontinued = 0 
 							AND pl.`id_lang` = '.(int)($id_lang).' AND cl.id_lang='.(int)($id_lang).'
							AND rclm.`id_pur_list` = '.(int)($id_pur_list).
							
							(empty($id_product) === FALSE ? ' AND rc.`id_product` = '.(int)($id_product) : ' ORDER BY pl.`name` ASC'));
			
 		if (empty($products) === true OR !sizeof($products))
			return array();
		
		
 		for ($i = 0; $i < sizeof($products); ++$i)
		{
 			$products[$i]['per_month']='';
			//$products[$i]['per_order']='';
			$average_results = PurchaseList::getAverageQuantityPerOrder($products[$i]['id_product'],$id_customer);
 			$products[$i]['per_month'] = $average_results;
			$products[$i]['per_month'] = rtrim($products[$i]['per_month'], ', ');
			
			/*$products[$i]['per_order'] = $average_results[1];
			$products[$i]['per_order'] = rtrim($products[$i]['per_order'], ', ');*/
			
 			if (isset($products[$i]['id_product_attribute']) AND
				Validate::isUnsignedInt($products[$i]['id_product_attribute']))
			{
 				$result = Db::getInstance()->ExecuteS('
				SELECT al.`name` AS attribute_name, pa.`quantity` AS "attribute_quantity"
				  FROM `'._DB_PREFIX_.'product_attribute_combination` pac
				LEFT JOIN `'._DB_PREFIX_.'attribute` a ON (a.`id_attribute` = pac.`id_attribute`)
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON (ag.`id_attribute_group` = a.`id_attribute_group`)
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.(int)($id_lang).')
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = '.(int)($id_lang).')
				LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pac.`id_product_attribute` = pa.`id_product_attribute`)
				WHERE pac.`id_product_attribute` = '.(int)($products[$i]['id_product_attribute']));
				$products[$i]['attributes_small'] = '';
				
				if ($result)
					foreach ($result AS $k => $row)
					{
						$products[$i]['attributes_small'] .= $row['attribute_name'].', ';
					}
				
				
				$products[$i]['attributes_small'] = rtrim($products[$i]['attributes_small'], ', ');
				if (isset($result[0]))
					$products[$i]['attribute_quantity'] = $result[0]['attribute_quantity'];			
					
			}
			else
				$products[$i]['attribute_quantity'] = $products[$i]['product_quantity'];
		}
		//var_dump($products);
		return ($products);
	}
 	public static function storePurchaseListQuantity($list_id,$id_product,$qty,$listStatus,$id_customer )
	{
   		if($listStatus==0)
  			$qry='rclm.product_quantity = 0 WHERE  rc.`id_customer` ='.$id_customer.'';
 		/*if($listStatus==1)
 			$statusqry='AND id_pur_list='.$list_id.'';*/
   		if($listStatus==2)
		{
 			$qry='rclm.product_quantity = '.$qty.' WHERE  rclm.`id_pur_list` = '.$list_id.' AND rc.id_product = '.$id_product.'';
			//$statusqry='AND id_pur_list='.$list_id.'';
		}
  											
 		$status = Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'rate_contract_list_mapping` AS rclm 
											LEFT OUTER JOIN `'._DB_PREFIX_.'rate_contract` AS rc 
											ON rc.id_rate_contract = rclm.`id_rate_contract`
											SET '.$qry.'');
 	}
	public static function getStoredPurchaseListProducts($id_customer,$list_id)
	{
		return Db::getInstance()->ExecuteS('SELECT rc.id_product, rclm.id_pur_list, rclm.product_quantity, pl.`list_name`, pol.`name`
											FROM `'._DB_PREFIX_.'rate_contract_list_mapping` AS rclm
											LEFT JOIN `'._DB_PREFIX_.'rate_contract` AS rc
											ON rclm.`id_rate_contract` = rc.`id_rate_contract`
											LEFT JOIN `'._DB_PREFIX_.'purchase_list` AS pl
											ON rclm.`id_pur_list`= pl.`id_pur_list`
											LEFT JOIN `'._DB_PREFIX_.'product_lang` AS pol
											ON rc.`id_product` = pol.`id_product`
											WHERE rc.`id_customer`= '.$id_customer.' AND rclm.id_pur_list='.$list_id.' AND rclm.`product_quantity` > 0 AND pol.`id_lang`=1 ORDER BY rclm.product_quantity DESC');
		
	}
	public static function deleteProductInPurchaseList($list_id,$id_product)
	{
		Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'rate_contract_list_mapping` AS rclm 
									LEFT OUTER JOIN `'._DB_PREFIX_.'rate_contract` AS rc 
									ON rc.id_rate_contract = rclm.`id_rate_contract`
									SET rclm.product_quantity = 0 WHERE  rclm.`id_pur_list` ='.$list_id.' AND rc.id_product = '.$id_product.'');
									
		return  Db::getInstance()->getValue('SELECT COUNT(`id_rate_contract`) FROM `'._DB_PREFIX_.'rate_contract_list_mapping` WHERE `id_pur_list` = '.$list_id.' AND `product_quantity` > 0');
	}
	public static function buyProductsPurchaseList($id_customer)
	{
 		return Db::getInstance()->ExecuteS('SELECT rc.`id_product`, rclm.`product_quantity`
											FROM `'._DB_PREFIX_.'rate_contract` AS rc
											LEFT JOIN `'._DB_PREFIX_.'rate_contract_list_mapping` AS rclm
											ON rclm.`id_rate_contract` = rc.`id_rate_contract`
											WHERE rc.`id_customer` = '.$id_customer.'  AND rclm.`product_quantity` > 0 ');
	}

	public function addByCustomerId($id_customer,$list_name)
	{		
		return Db::getInstance()->ExecuteS('INSERT INTO `'._DB_PREFIX_.'purchase_list`(`id_customer`,`list_name`,`list_active`,list_added)VALUES ('.$id_customer.',"'.$list_name.'",1,NOW())');	
	}
	public function changeStatusByPurchasListId($id_pur_list,$status)
	{
		return Db::getInstance()->ExecuteS('UPDATE `'._DB_PREFIX_.'purchase_list` SET `list_active`='.(int)($status).' WHERE `id_pur_list`='.(int)($id_pur_list));
	}
		
	public static function getAverageQuantityPerOrder($id_product,$id_customer)
	{
		$from_date= "";
		$to_date= "";
		$interval= "";
  		$result =  Db::getInstance()->ExecuteS('SELECT od.`product_quantity`,od.`product_quantity_return`,o.date_add
												FROM `'._DB_PREFIX_.'order_detail` od
												LEFT JOIN `'._DB_PREFIX_.'orders` o
												ON o.id_order = od.id_order
                                                left join '._DB_PREFIX_.'order_history oh
                                                on oh.id_order= o.id_order
												WHERE o.id_customer = '.$id_customer.' AND oh.id_Order_history IN (
																		SELECT  MAX(oha.`id_order_history`)
																		FROM '._DB_PREFIX_.'order_history AS oha
																		LEFT JOIN '._DB_PREFIX_.'orders AS oa
																		ON oa.id_order = oha.id_order
																		where oa.id_customer = '.$id_customer.'
																		GROUP BY oha.id_order) 
												AND oh.id_order_state in (5,25,34,35,36,37,38,39,40 ) AND od.product_id='.$id_product);
		$qty = 0;
		$count=0;
		for($i=0; $i<sizeof($result); $i++)
		{
			$qty += $result[$i]['product_quantity'] - $result[$i]['product_quantity_return'];
			if($i==0)
				$from_date = $result[$i]['date_add'];
			if($i == sizeof($result))
				$to_date = $result[$i]['date_add'];
				$count++;
		}
		$fromdate = strtotime($from_date);
		$todate = strtotime($to_date);
		$interval = $todate - $fromdate;
		$ans = date('n',strtotime($interval));
		/*Get Average qty per month*/
		if($qty !=0)
 			$per_month = round($qty/$ans);
 		else
			$per_month=0;
		/*Get Average qty per order*/
		/*if($count!=0)
 			$per_order = round($qty/$count);
		else
			$per_order=0;
  		$results=array();
		array_push($results,$per_month,$per_order);*/
		return $per_month;
 			
	}

	public function getPurchaseLists($id_customer)
	{
		return Db::getInstance()->ExecuteS('SELECT a.`list_name`,a.`id_pur_list` FROM `'._DB_PREFIX_.'purchase_list` a WHERE a.`id_customer` = '.$id_customer.' AND a.`list_active` = 1');
	}

	public function updatePurList($id_pur_list,$list_name)
	{
		return Db::getInstance()->autoExecute(_DB_PREFIX_.'purchase_list', array('list_name' => $list_name), 'UPDATE', 'id_pur_list = '.$id_pur_list.'');
	}
}