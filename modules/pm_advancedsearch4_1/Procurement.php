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
								   and product_quantity > 0
							GROUP BY op.reference order by product_name,om.name ASC	');
			
			/*Stage 2 => get the vendors according to products*/
 
			for($i=0;$i<sizeof($result);$i++)
			{
				if($result[$i]['product_quantity'] > 0)
				{
					$result[$i]['1'] =  Procurement::getTwoLeastSellingVendor($result[$i]['id_product'],$id_fc);
					 
					if(sizeof($result[$i]['1']) == 0)
					{
						$result[$i]['1'] = Procurement::getVendorFromMappingTable($result[$i]['id_product']);
					}
				}
			}
			
 			echo Tools::jsonEncode($result);
			
	}
	public static function getTwoLeastSellingVendor($id_product,$id_fc)
	{
		
		/*return DB::getInstance()->ExecuteS('select v.name as vendor_name, va.address1,va.city,s.name as state,va.phone , vpb.unit_price from '._DB_PREFIX_.'vendor v,'._DB_PREFIX_.'vendor_address va,'._DB_PREFIX_.'vendor_purchase_bill vpb,'._DB_PREFIX_.'product p,'._DB_PREFIX_.'state as s   where v.id_vendor = va.id_vendor and v.id_default_address = va.id_address and vpb.id_vendor = v.id_vendor and vpb.id_product = '.$id_product.' AND va.id_fc = '.$id_fc.' and p.id_product = vpb.id_product  AND va.id_state = s.id_state AND vpb.date_add >= NOW()-INTERVAL 6 MONTH order by vpb.unit_price asc limit 2');*/
		return DB::getInstance()->ExecuteS('SELECT v.name AS vendor_name, vpb.unit_price
											FROM '._DB_PREFIX_.'vendor v
											LEFT JOIN '._DB_PREFIX_.'vendor_purchase_bill vpb ON vpb.id_vendor = v.id_vendor
											WHERE vpb.id_product ='.$id_product.'
											AND v.id_fulfillment_centre ='.$id_fc.'
											AND vpb.date_add >= NOW( ) - INTERVAL 6
											MONTH ORDER BY vpb.unit_price ASC
											LIMIT 2 ');		
	}
	public static function getVendorFromMappingTable($id_product)
	{
		return DB::getInstance()->ExecuteS('SELECT v.name as vendor_name,0 as unit_price, va.address1,va.city,s.name as state, va.pincode, va.phone
											FROM `'._DB_PREFIX_.'product_vendor_mapping` pvm
											left join '._DB_PREFIX_.'vendor_address va on va.id_address = pvm.id_address
											left join '._DB_PREFIX_.'product p on pvm.id_product = p.id_product
											left join '._DB_PREFIX_.'state as s on va.id_state = s.id_state
											left join '._DB_PREFIX_.'vendor as v on v.id_vendor = pvm.id_vendor
											WHERE p.`id_product` = '.$id_product.' order by v.name asc limit 2');
	}
}