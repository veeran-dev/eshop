<?php 
class priceChangeCore
{
	/*Send mail for Specific Price Updated */ 
	public static function specificPriceChangedNotification($content)
	{
		$employee= new Employee($content['id_employee']);
		$employee_name = ''.$employee->firstname.' '.$employee->lastname.'';
		$data='';
		
 		$price_change_details = Db::getInstance()->ExecuteS('SELECT c.`firstname`,c.`lastname`,c.email as cus_mail, e.email as rm_mail ,e.`id_employee`, p.reference,pl.name as product_name, 
									g.name as group_name 
									FROM `'._DB_PREFIX_.'customer` as c
									left join '._DB_PREFIX_.'employee as e
									on e.id_employee = c.`id_relationship_manager`
									left join '._DB_PREFIX_.'specific_price as sp
									on sp.id_group = c.id_default_group
									left join '._DB_PREFIX_.'product as p
									on p.id_product = sp.id_product
									left join '._DB_PREFIX_.'product_lang as pl
									on pl.id_product = p.id_product
									left join '._DB_PREFIX_.'group_lang as g
									on sp.id_group = g.id_group
									where sp.id_group = '.$content['id_group'].' and pl.id_lang=1 and sp.id_product = '.$content['id_product'].' and g.id_lang=1 and c.id_default_group NOT IN(0,1) group by c.email ORDER BY c.`id_relationship_manager` ');

 		if($price_change_details)
		{
			for($i=0;$i<sizeof($price_change_details);$i++)
			{
				if(($price_change_details[$i]['id_employee']==$price_change_details[$i+1]['id_employee']) || ($price_change_details[$i]['id_employee']==$price_change_details[$i-1]['id_employee']) || ($price_change_details[$i+1]['id_employee']=='')) 
				{
					$data .='<tr>
										<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.($i+1).'</span></div></td>
										<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$price_change_details[$i]['firstname'].'</span></div></td>
										<td class="text_color mailTableTD" align="center" valign="middle"><div style=" line-height: 22px;" class="editable_text"><span class="text_container">'.$price_change_details[$i]['cus_mail'].'</span></div></td>			
										</tr>';
					
					/*Specific Price Changed - send mail to Respected Customer*/
					Mail::Send(1, 'productpricechange', Mail::l('Product Price Changed', 1), array('{product_name}' => $price_change_details[$i]['product_name'], '{product_reference}' => $price_change_details[$i]['reference'], '{old_price}' => $content['old_price_spec'], '{new_price}' => $content['new_price']), $price_change_details[$i]['cus_mail'], 'Price Updated', 'noreply@kobster.com');
				}
				$j=$i+1;
				if(($price_change_details[$i]['id_employee']!=$price_change_details[$j]['id_employee']))
				{
					$details = array(
						'{groupname}' => $price_change_details[$i]['group_name'],					
						'{name}'=>$price_change_details[$i]['firstname'],
						'{email}' => $price_change_details[$i]['cus_mail'],
						'{product_name}' => $price_change_details[$i]['product_name'],
						'{product_reference}' => $price_change_details[$i]['reference'], 
						'{old_price}' => $content['old_price_spec'], 
						'{new_price}' => $content['new_price'],
						'{data}' => $data);
 					/*Specific Price Changed - send mail to Respected Rm*/
					Mail::Send(1, 'productspecificpricechange', Mail::l('Product Specific Price Changed - by '.$employee_name.'', 1), $details, $price_change_details[$i]['rm_mail'], 'Price Updated', 'noreply@kobster.com');
					$data='';
				}
				

			}
			 
			/*Specific Price Changed - send mail to price.change@kobster.com*/
			Mail::Send(1, 'productspecificpricechange', Mail::l('Product Specific Price Changed For Customer - by '.$employee_name.'', 1), array('{groupname}' => $price_change_details[0]['group_name'], '{name}' => $price_change_details[0]['firstname'], '{email}' => $price_change_details[0]['cus_mail'], '{product_name}' => $price_change_details[0]['product_name'], '{product_reference}' => $price_change_details[0]['reference'], '{old_price}' => $content['old_price_spec'], '{new_price}' => $content['new_price']), 'price.change@kobster.com', 'Price Updated', 'noreply@kobster.com');
		}
	}
	/*Send mail for Normal Price Updated */ 
	public static function priceChangedNotification($content)
	{
		$employee= new Employee($content['id_employee']);
		$employee_name = ''.$employee->firstname.' '.$employee->lastname.'';
 		$product_details = Product::getProductDetail($content['id_product']);
		
		/*Normal Price Changed - send mail to price.change@kobster.com*/
		Mail::Send(1, 'pricechange', Mail::l('General - Product Price Updated- by '.$employee_name.'', 1), array('{product_name}' => $product_details['product_name'], '{product_reference}' => $product_details['reference'], '{old_price}' => $content['old_price_spec'], '{new_price}' => $content['new_price']), 'price.change@kobster.com', 'Price Changed', 'noreply@kobster.com');
		
		
	}
	public static function VATChangeNotification($content)
	{
 		$product_vat_details = Product::getProductDetail($content['id_product'],$content['old_vat'],$content['new_vat']);
		$employee= new Employee($content['id_employee']);
		$employee_name = ''.$employee->firstname.' '.$employee->lastname.'';
		
		if($product_vat_details['new_vat_name'] =="")
			$product_vat_details['new_vat_name'] = 'VAT 0%';
		if($product_vat_details['old_vat_name'] =="")
			$product_vat_details['old_vat_name'] = 'VAT 0%';	
		
		/*Normal VAT Changed - send mail to price.change@kobster.com*/
		Mail::Send(1, 'vatchange', Mail::l('General - Product GST Updated- by '.$employee_name.'', 1), array('{Employee_name}' => $employee_name,'{product_name}' => $product_vat_details['product_name'], '{product_reference}' => $product_vat_details['reference'], '{old_vat}' => $product_vat_details['old_vat_name'], '{new_vat}' => $product_vat_details['new_vat_name']), 'price.change@kobster.com', 'VAT Changed', 'noreply@kobster.com');
	}
	
}
?>