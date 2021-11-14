<?php
/*
Created By Sreeni
Procurement Engine 
Return data of daily procurement details
*/
class ProcurementCore extends ObjectModel
{
	/*Stage 1 -> get products from order*/
	public static function generatePurchasePlan($id_fc)
	{
			$result = DB::getInstance()->ExecuteS( '
					SELECT op.id_product, pl.name as product_name, op.reference, sum(od.product_quantity-od.product_quantity_delivered) as product_quantity,om.name, 
						    GROUP_CONCAT(o.id_order SEPARATOR ",") as id_order ,avg(od.product_price) as selling_price
							FROM `'._DB_PREFIX_.'orders` o, `'._DB_PREFIX_.'order_detail` od, `'._DB_PREFIX_.'product_lang` pl, 
							`'._DB_PREFIX_.'product` op LEFT OUTER JOIN `'._DB_PREFIX_.'manufacturer` om  
							ON op.id_manufacturer=om.id_manufacturer
							WHERE o.id_fc = '.$id_fc.' AND o.id_order IN (SELECT t.id_order
												 FROM   '._DB_PREFIX_.'order_history t
												 INNER JOIN (
														SELECT id_order, max(date_add) as MaxDate
														FROM '._DB_PREFIX_.'order_history
														GROUP BY id_order
													) tm ON t.id_order = tm.id_order AND 
															t.date_add = tm.MaxDate AND
															t.id_order_state in (18,19,21,22,24)
												)
								   and o.id_order=od.id_order and od.product_id=op.id_product 
								   and pl.id_product = od.product_id
								   and pl.id_lang=1
							GROUP BY op.reference order by product_name,om.name ASC	');
			
			/*Stage 2 => get the vendors according to products*/
 
			for($i=0;$i < sizeof($result);$i++)
			{
				if($result[$i]['product_quantity'] > 0)
				{
					$result[$i]['vendor'] =  Procurement::getTwoLeastSellingVendor($result[$i]['id_product'],$id_fc);
					 
					if(sizeof($result[$i]['vendor']) == 0)
					{
						$result[$i]['vendor'] = Procurement::getVendorFromMappingTable($result[$i]['id_product'], $id_fc);
					}
				}
			}

 			return $result;
 			
	}
	public static function getTwoLeastSellingVendor($id_product,$id_fc)
	{
		 
		return DB::getInstance()->ExecuteS('SELECT v.name AS vendor_name,pom.Payment_Name,va.address1,va.city,state.name,country.name,v.comments,va.pincode,v.phone, vpb.unit_price,v.id_vendor
											FROM '._DB_PREFIX_.'vendor v
											LEFT JOIN '._DB_PREFIX_.'vendor_purchase_bill vpb ON vpb.id_vendor = v.id_vendor
											LEFT JOIN '._DB_PREFIX_.'vendor_address va ON va.id_vendor = v.id_vendor
											LEFT JOIN '._DB_PREFIX_.'payment_option_master pom ON pom.id_payment = v.id_payment
											LEFT JOIN '._DB_PREFIX_.'state as  state ON state.id_state = va.id_state
											LEFT JOIN '._DB_PREFIX_.'country_lang as  country ON country.id_country = 110
											WHERE vpb.id_product ='.$id_product.'
											AND country.id_lang = 1
											AND v.id_fulfillment_centre ='.$id_fc.'
											AND vpb.date_add >= NOW( ) - INTERVAL 6
											MONTH ORDER BY vpb.unit_price ASC
											LIMIT 2 ');	
 	}

	public static function getVendorFromMappingTable($id_product, $id_fc)
	{
		return DB::getInstance()->ExecuteS('SELECT v.name as vendor_name,0 as unit_price, va.address1,va.city,s.name as state, va.pincode, va.phone,v.id_vendor,pom.Payment_Name,v.comments,country.name
											FROM `'._DB_PREFIX_.'product_vendor_mapping` pvm
											left join '._DB_PREFIX_.'vendor_address va on va.id_address = pvm.id_address
											left join '._DB_PREFIX_.'product p on pvm.id_product = p.id_product
											left join '._DB_PREFIX_.'state as s on va.id_state = s.id_state
											left join '._DB_PREFIX_.'vendor as v on v.id_vendor = pvm.id_vendor
											LEFT JOIN '._DB_PREFIX_.'payment_option_master pom ON pom.id_payment = v.id_payment
											LEFT JOIN '._DB_PREFIX_.'country_lang as  country ON country.id_country = 110
											WHERE p.`id_product` = '.$id_product.' AND v.id_fulfillment_centre = '.$id_fc.' 
											AND v.`active` = 1 AND country.id_lang = 1 order by v.name asc limit 2');									 
	}

	public static function structurePurchasePlan($purchase_plan_array)
	{
		if(sizeof($purchase_plan_array)!=0)
			{
				
				for($i=0; $i<sizeof($purchase_plan_array); $i++)
				{
					if(sizeof($purchase_plan_array[$i]['vendor'])!=0)
					{
						if(sizeof($purchase_plan_array[$i]['vendor'])!=2)
						{
							$purchase_plan_array[$i]['buying_vendor1_id'] = $purchase_plan_array[$i]['vendor']['0']['id_vendor'];
							$purchase_plan_array[$i]['buying_vendor1_name'] = $purchase_plan_array[$i]['vendor']['0']['vendor_name'];
							$purchase_plan_array[$i]['buying_vendor1_price'] = $purchase_plan_array[$i]['vendor']['0']['unit_price'];$purchase_plan_array[$i]['buying_vendor2_name'] = "Other";
							$purchase_plan_array[$i]['buying_vendor2_price'] = 0;
						}
						else
						{
							$purchase_plan_array[$i]['buying_vendor1_id'] = $purchase_plan_array[$i]['vendor']['0']['id_vendor'];
							$purchase_plan_array[$i]['buying_vendor1_name'] = $purchase_plan_array[$i]['vendor']['0']['vendor_name'];
							$purchase_plan_array[$i]['buying_vendor1_price'] = $purchase_plan_array[$i]['vendor']['0']['unit_price'];$purchase_plan_array[$i]['buying_vendor2_id'] = $purchase_plan_array[$i]['vendor']['1']['id_vendor'];;
							$purchase_plan_array[$i]['buying_vendor1_price'] = $purchase_plan_array[$i]['vendor']['0']['unit_price'];$purchase_plan_array[$i]['buying_vendor2_name'] = $purchase_plan_array[$i]['vendor']['1']['vendor_name'];;
							$purchase_plan_array[$i]['buying_vendor2_price'] = $purchase_plan_array[$i]['vendor']['1']['unit_price'];
							
						}
					}
					else
					{
						$purchase_plan_array[$i]['buying_vendor1_id'] = 0;
						$purchase_plan_array[$i]['buying_vendor1_name'] = "Other";
						$purchase_plan_array[$i]['buying_vendor1_price'] = 0;
						$purchase_plan_array[$i]['buying_vendor1_id'] = 0;
						$purchase_plan_array[$i]['buying_vendor2_name'] = "Other";
						$purchase_plan_array[$i]['buying_vendor2_price'] = 0;
					}
				}
			}
			
			
			$tmp = array();
			$purchase_plan_array_array = array();
			foreach($purchase_plan_array as $arg)
			{
				$tmp[$arg['buying_vendor1_name']][] = $arg;
			}

			$output = array();
			foreach($tmp as $vendor => $details)
			{
				
				$output[] = array(
					'name_vendor' => $vendor,
					'details' => $details
				);
				
			}

			ksort($output, SORT_NUMERIC);
			return $output;
	}

	public static function getNewPurchasePlan($id_fc) {
		$sql = 'SELECT od.`id_order`, p.`reference`, od.`product_name`, od.`product_quantity`, 
				od.`unit_price_tax_excl` AS selling_tax_exclusive, ROUND(t.`rate`) AS gst_rate
				FROM `'._DB_PREFIX_.'orders` o
				LEFT JOIN `'._DB_PREFIX_.'order_detail` od ON o.`id_order` = od.`id_order`
				LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = od.`product_id`
				INNER JOIN `'._DB_PREFIX_.'product_shop` ps ON (p.`id_product` = ps.`id_product` AND ps.`id_shop` = 1)
				LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON o.`id_order` = oh.`id_order`
				LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON ps.`id_tax_rules_group` = tr.`id_tax_rules_group`
				LEFT JOIN `'._DB_PREFIX_.'tax` t ON (tr.`id_tax` = t.`id_tax` AND t.`active` = 1 AND t.`deleted` = 0)
				WHERE o.`id_fc` = '.$id_fc.' AND oh.`id_order_history` = (
					SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh 
					WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`
				) AND oh.`id_order_state` = '.OrderState::FLAG_BEING_PROCESSED.'
				GROUP BY o.`id_order`, od.`product_id`';
		return Db::getInstance()->executeS($sql);
	}
	
}