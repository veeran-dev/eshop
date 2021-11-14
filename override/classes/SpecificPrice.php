<?php
class SpecificPrice extends SpecificPriceCore
{
	public static function getExtremePrices($id_product){
		$query = 'SELECT max(price) as high, min(price) as low from '._DB_PREFIX_.'specific_price where id_product='.$id_product.'';
		return Db::getInstance()->ExecuteS($query);
	}

	public static function getPerksProduct()
	{
		$group = Configuration::get('perks_group');
		$query = 'select distinct(sp.id_product),cat.id_category,cat.name as c_name,cat.count as count,pl.name as p_name, pl.link_rewrite,pl.available_now,kc.amazon,kc.`flipkart`,kc.`snapdeal`,DATE_FORMAT(kc.date_upd,"%d-%m-%Y %h:%i %p") as date_upd,
			case
			   when LOCATE("current-offers", pl.description) then pl.description
			   else ""
			end description 
							from '._DB_PREFIX_.'specific_price sp 
							left join '._DB_PREFIX_.'product_lang pl on(pl.id_product = sp.id_product and pl.id_lang=1)
							left join '._DB_PREFIX_.'product p on(p.id_product = sp.id_product)
							left join '._DB_PREFIX_.'category_lang c on(c.id_category = p.id_category_default)
                            join(
                                		select cl.id_category,cl.name,count(id_category) as count from '._DB_PREFIX_.'specific_price sp                            		
                                 								left join '._DB_PREFIX_.'product p on(p.id_product = sp.id_product)
                                 								left join '._DB_PREFIX_.'category_lang cl on(cl.id_category = p.id_category_default and cl.id_lang=1)
                                 								where sp.id_group = '.$group.'	
                                		group by id_category 
                            	) as cat
							left outer join '._DB_PREFIX_.'competitor kc on kc.id_product=pl.id_product
							where sp.id_group = '.$group.'
							and p.id_category_default = cat.id_category
							order by c.id_category';
		return Db::getInstance()->ExecuteS($query);
	}

	public static function getSpecificProductPrice($id_product,$id_group)
	{
		$now = date('Y-m-d H:i:s');
		return Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'specific_price WHERE id_product='.$id_product.' AND id_group='.$id_group.' AND ((`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= `from`) AND (`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= `to`)) order by id_specific_price DESC');
	}

	public static function RmRateContract($id_group)
	{
		 
  		$now = date('Y-m-d H:i:s');
 		$sql='SELECT  sp.id_product , pl.name, product.reference, sp.price as sp_price
		FROM `'._DB_PREFIX_.'specific_price` as sp, '._DB_PREFIX_.'product as product, '._DB_PREFIX_.'product_lang pl
				WHERE sp.id_group='.$id_group.'
				AND 	sp.id_product = product.id_product
				AND 	pl.id_product = sp.id_product				
				AND     pl.`id_lang`= 1						
				AND ((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`))
				group by sp.id_product 
				ORDER BY sp.`id_specific_price`';
		 
    	$result =Db::getInstance()->ExecuteS($sql);
		/*$product =new Product();
		for($i=0; $i<sizeof($result);$i++)
		{
			$product_category = $product->getSuperParentCategoryName($result[$i]['id_product']);
			if($product_category !="")
				$result[$i]['category']= $product_category;
			else
				$result[$i]['category']= "Home";
		}*/
   		return $result;
	}
	public static function expireSpecificPrice($id_product,$id_group)//expire all specific price 
	{
		$to_date=date('Y-m-d H:i:s');	
		return Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'specific_price ksp SET ksp.to ="'.$to_date .'" WHERE ksp.id_product ='.(int)$id_product.' AND ksp.id_group = '.(int)$id_group.'
			AND ksp.id_specific_price NOT IN(SELECT kd.`id_specific_price` FROM `'._DB_PREFIX_.'deal` kd WHERE kd.`active`=1 AND kd.`id_group`='.(int)$id_group.')');
	}

	public function getSpecificPriceProductCategories($id_customer)
	{
		$now = date('Y-m-d H:i:s');
 		return  Db::getInstance()->ExecuteS('SELECT  cat_lang.`name` AS category  ,parent.id_category  
									FROM  '._DB_PREFIX_.'product product, '._DB_PREFIX_.'customer customer,'._DB_PREFIX_.'specific_price as sp,
									'._DB_PREFIX_.'category node, '._DB_PREFIX_.'category parent, '._DB_PREFIX_.'category_lang cat_lang,'._DB_PREFIX_.'product_lang pro_lang
									WHERE   customer.id_customer = '.$id_customer.'
									AND 	sp.id_group = customer.id_default_group
									AND		product.`id_product` = sp.`id_product`
									AND		product.`id_product` = pro_lang.`id_product`
									AND		product.`id_category_default` = node.`id_category`
									AND		node.nleft BETWEEN parent.nleft AND parent.nright
									AND 	parent.level_depth = 2
									AND 	parent.id_category = cat_lang.`id_category`
									AND 	parent.`active` = 1
									AND     cat_lang.`id_lang`= 1
									AND     pro_lang.`id_lang`= 1
									AND ((`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= `from`) AND (`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= `to`))
									GROUP BY parent.id_category ORDER BY category ASC');
	}

	public static function addSpecificPrice($price, $id_supplier, $id_product, $id_group, $to = NULL, $id_customer = NULL){
	    $id_customer = "";
	    if($id_customer){
	    	$q = "AND id_customer=".$id_customer;
	    }
	    else{
	    	$id_customer = "0";
	    }

	    $check = Db::getInstance()->getValue('SELECT IF(`id_product` != "", true, false) FROM '._DB_PREFIX_.'specific_price WHERE id_supplier='.$id_supplier.'  AND `id_product`='.$id_product.' AND `id_group`='.$id_group.' '.$q.'');

	    if($check){
    		$sql ="UPDATE IGNORE kob_specific_price set price=".$price.", `to`='".$to."' where id_supplier=".$id_supplier." AND id_product=".$id_product." AND id_group=".$id_group." AND id_customer=".$id_customer."";
	    }
	    else{
	    	$sql = "INSERT IGNORE INTO kob_specific_price (id_supplier, id_product, price, id_group, id_customer,  `to`) values(".$id_supplier.",".$id_product.", ".$price.", ".$id_group.", ".$id_customer.", '".$to."')";
	    }
        $result = Db::getInstance()->Execute($sql);
		return $result;
	}

	public static function ifSpecificPrice($id_product, $id_group)// check whether the product has specific price
	{
		return Db::getInstance()->getValue('SELECT count(id_specific_price) FROM `'._DB_PREFIX_.'specific_price` WHERE `id_product` = '.(int)$id_product . ' AND id_group = '.(int)$id_group);
	}

	public static function updateSpecificPrice($price, $id_product, $id_group, $to = NULL)//updates specific price of the product 
	{
		Db::getInstance()->Execute('UPDATE IGNORE '._DB_PREFIX_.'specific_price ksp SET ksp.price ='.$price .',ksp.to = "'.$to.'" WHERE ksp.id_product ='.(int)$id_product.' AND ksp.id_group = '.(int)$id_group);
	}

	public static function deleteSpecificPrice($id_product, $id_group)
	{
		Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'specific_price WHERE id_product='.$id_product.' AND id_group='.$id_group.'');
	}

	public static function isExistsSpecificPrice($id_product, $id_group){

		return Db::getInstance()->getValue('SELECT IF(`id_product` != "", true, false) FROM '._DB_PREFIX_.'specific_price WHERE `id_product`='.$id_product.' AND `id_group`='.$id_group.'');
	}

	public static function changeCategoryProductPrice($parent_ids)
	{		
 		
		$category_ids = implode(",",$parent_ids);
		
		$products =   Db::getInstance()->ExecuteS('SELECT product.`id_product`  
									FROM  '._DB_PREFIX_.'product product , '._DB_PREFIX_.'category node, '._DB_PREFIX_.'category parent 
									WHERE   product.`id_category_default` = node.`id_category`
									AND		node.nleft BETWEEN parent.nleft AND parent.nright
									AND 	parent.level_depth=1
									
									AND 	product.active = 1
									AND		product.`discontinued` = 0 
									AND 	parent.id_category IN ('.$category_ids.')');	
			
		 	
				 
		for($i = 0 ; $i < sizeof($products); $i++)		
		{

			$check = Db::getInstance()->ExecuteS('SELECT id_product,id_group, price from '._DB_PREFIX_.'specific_price where id_product='.$products[$i]['id_product'].' AND (`to` = "0000-00-00 00:00:00" OR `to` > NOW()) order by price asc LIMIT 1');
			
			if(sizeof($check)!=0)
			{	
 				if($check[0]['id_group'] != 1 )
				{
					
					$check_for_default_group = Db::getInstance()->ExecuteS('SELECT id_specific_price, id_product,id_group as default_group, price as default_group_price from '._DB_PREFIX_.'specific_price where id_product='.$products[$i]['id_product'].' AND id_group = 1 AND (`to` = "0000-00-00 00:00:00" OR `to` > NOW()) order by price asc LIMIT 1');
					
   					if(sizeof($check_for_default_group) == 0)
					{
 						$addSpecificPrice = new SpecificPrice();
						$addSpecificPrice->id_product = (int)($products[$i]['id_product']);
						$addSpecificPrice->id_shop = 1;
						$addSpecificPrice->id_currency = 0;
						$addSpecificPrice->id_country = 0;
						$addSpecificPrice->id_group =1;
						$addSpecificPrice->price = $check[0]['price'];
						$addSpecificPrice->from_quantity = 1;
						$addSpecificPrice->reduction = "0.000000";
						$addSpecificPrice->reduction_type = "amount";
						$addSpecificPrice->from = "0000-00-00 00:00:00";
						$addSpecificPrice->to = "0000-00-00 00:00:00";
						$addSpecificPrice->add();
 					
					}
					else
					{
						$addSpecificPrice = new SpecificPrice($check_for_default_group[0]['id_specific_price']);
						$addSpecificPrice->price = $check[0]['price'];						
						$addSpecificPrice->update();
					}
					
 				}
			}
			
		}
		echo "Price Updated Successfully !";
	}
	/*Send mail for Specific Price Updated */ 
	public static function specificPriceChangedNotification($content)
	{
		$employee= new Employee($content['id_employee']);
		$employee_name = ''.$employee->firstname.' '.$employee->lastname.'';
		$data='';
		
 		$price_change_details = Db::getInstance()->ExecuteS('SELECT c.`firstname`,c.`lastname`,c.email as cus_mail, e.email as rm_mail ,e.`id_employee`, p.reference,pl.name as product_name, 
									g.name as group_name 
									FROM `'._DB_PREFIX_.'customer` as c
									LEFT JOIN '._DB_PREFIX_.'employee as e
									on e.id_employee = c.`id_relationship_manager`
									LEFT JOIN '._DB_PREFIX_.'specific_price as sp
									on sp.id_group = c.id_default_group
									LEFT JOIN '._DB_PREFIX_.'product as p
									on p.id_product = sp.id_product
									LEFT JOIN '._DB_PREFIX_.'product_lang as pl
									on pl.id_product = p.id_product
									LEFT JOIN '._DB_PREFIX_.'group_lang as g
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
					Mail::Send(1, 'productpricechange', Mail::l('Product Price Changed', 1), array('{product_name}' => $price_change_details[$i]['product_name'], '{product_reference}' => $price_change_details[$i]['reference'], '{old_price}' => $content['old_price_spec'], '{new_price}' => $content['new_price']), $price_change_details[$i]['cus_mail'], 'Price Updated', 'noreply@kobzo.com');
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
					Mail::Send(1, 'productspecificpricechange', Mail::l('Product Specific Price Changed - by '.$employee_name.'', 1), $details, $price_change_details[$i]['rm_mail'], 'Price Updated', 'noreply@kobzo.com');
					$data='';
				}
				

			}
			 
			/*Specific Price Changed - send mail to price.change@kobzo.com*/
			Mail::Send(1, 'productspecificpricechange', Mail::l('Product Specific Price Changed For Customer - by '.$employee_name.'', 1), array('{groupname}' => $price_change_details[0]['group_name'], '{name}' => $price_change_details[0]['firstname'], '{email}' => $price_change_details[0]['cus_mail'], '{product_name}' => $price_change_details[0]['product_name'], '{product_reference}' => $price_change_details[0]['reference'], '{old_price}' => $content['old_price_spec'], '{new_price}' => $content['new_price']), 'price.change@kobzo.com', 'Price Updated', 'noreply@kobzo.com');
		}
	}
	/*Send mail for Normal Price Updated */ 
	public static function priceChangedNotification($content)
	{
		$employee= new Employee($content['id_employee']);
		$employee_name = ''.$employee->firstname.' '.$employee->lastname.'';
 		$product_details = Product::getProductDetail($content['id_product']);
		
		/*Normal Price Changed - send mail to price.change@kobzo.com*/
		Mail::Send(1, 'pricechange', Mail::l('General - Product Price Updated- by '.$employee_name.'', 1), array('{product_name}' => $product_details['product_name'], '{product_reference}' => $product_details['reference'], '{old_price}' => $content['old_price_spec'], '{new_price}' => $content['new_price']), 'price.change@kobzo.com', 'Price Changed', 'noreply@kobzo.com');
		
		
	}

	public static function VATChangeNotification($content)
	{
 		$product_vat_details = Product::getProductDetail($content['id_product'],$content['old_vat'],$content['new_vat']);
		$employee= new Employee($content['id_employee']);
		$employee_name = ''.$employee->firstname.' '.$employee->lastname.'';
		
		if($product_vat_details['new_vat_name'] =="")
			$product_vat_details['new_vat_name'] = 'GST 0%';
		if($product_vat_details['old_vat_name'] =="")
			$product_vat_details['old_vat_name'] = 'GST 0%';	
		
		/*Normal GST Changed - send mail to price.change@kobzo.com*/
		Mail::Send(1, 'vatchange', Mail::l('General - Product GST Updated- by '.$employee_name.'', 1), array('{Employee_name}' => $employee_name,'{product_name}' => $product_vat_details['product_name'], '{product_reference}' => $product_vat_details['reference'], '{old_vat}' => $product_vat_details['old_vat_name'], '{new_vat}' => $product_vat_details['new_vat_name']), 'price.change@kobzo.com', 'GST Changed', 'noreply@kobzo.com');
	}

	public function getDealProducts($deals_page)
    {
		$result = array();
		
		if($deals_page == false){
			
			$banners	= array(
						'hero_banner'		=> 'kobzo-store.jpg',
						'small_banner1' 	=> 'A.jpg',
						'small_banner2' 	=> 'B.jpg',
						'small_banner3' 	=> 'C.jpg',
						'small_banner4' 	=> 'D.jpg'
						);
			// Deal 1
			$deals_title['1']	= "Deals of the Week";
			$deals_hash['1'] 	= "weekly-deals";
			$deals['1']			= $this->getProducts(1, '938218,938209,938176,938163,937840,937797,937791,937789,937788,937787,937785,937782,926803,926800,926139,926125,926111,926087,926082,265025,264893,264457,264395,264394,264383,264377,264376,264374,264373,264372,264012,263985,263984,263929,262656,262655,262647,262639,262632,262624,262609,262607,262602,262586,262585,256048,256033,256024,256009,255698,255692,255680,223037,221743,221605,219784,219783,219782,219236,218939,218607,212902,212888,212878,212784');

			// Deal 2
			$deals_title['2']	= "Electrical (Starting at ₹ 129, Upto 82% Off)";
			$deals_hash['2'] 	= "Electrical-deals";
			$deals['2']			= $this->getProducts(1, '934989,937856,937477,264075,264010,219784,264048,251346,938041,926272,251348,935177,251345,219783,210509,262654,264042,219788,937491,210513,217653,926264,262624,932758,251289,262632,210518,935104,937478,937479,937480,937482,219782,210510,217652,264079,219789,219792,937488,217655,932759,932760,932761,926515,210519,936563,936564,217658,217659,938043,251278,926265,938045,251071,251071,219804,219803,219802,937504,937506,937505,265522,926266,265475,937863,265476,251084,265486');

			// Deal 3
			$deals_title['3']	= "Lighting (Upto 81% Off)";
			$deals_hash['3'] 	= "Lighting-deals";
			$deals['3']			= $this->getProducts(1, '262632,262639,262647,262624,262655,262656,223037,926218,926217,926227,926229,926216,264079,264080,264318,263984,263985,263929,264012,264244,263956,263647,263646,264245,222939,222956,223005,223009,938048,938069,222940,222944,926187,926188,929801,929802,262654,262627,262635,262643');

			// Deal 4
			$deals_title['4']	= "Plumbing Deals";
			$deals_hash['4'] 	= "Plumbing-deals";
			$deals['4']			= $this->getProducts(1, '264394,264395,221605,264383,264457,264372,264373,264374,221743,264377,264376,221718,264378,253298,207830,207827,207831,264380,207561,207829,221715,221714');
			
		}
		
		// Deal page 2
		else if ($deals_page == true && $deals_page == "2"){
			
			$banners	= array(
						'hero_banner'		=> 'kobzo-store.jpg',
						'small_banner1' 	=> 'A.jpg',
						'small_banner2' 	=> 'E.jpg',
						'small_banner3' 	=> 'F.jpg',
						'small_banner4' 	=> 'G.jpg'
						);
			// Deal 1
			$deals_title['1']	= "Deals of the Week (Starting at ₹ 129)";
			$deals_hash['1'] 	= "weekly-deals";
			$deals['1']			= SpecificPrice::getProducts(1, '262632,4,262639,262624,937792,262655,262654,937789,937783,937785,938048,938069,937788,937797,937787,262574,262588,937791,926218,926217,926216,262607,262593,937840,262608,937782,210518,210513,210509,926272,262585,262602,926264,262586,251289,251346,251345,251348,219784,219783,219788,932758,938041,937856,217653,264395,264372,264373,264457,264374,264376,264394,264378,264377,264383,264380,264318,264244,263985,263984,264080,264079,264042,264048,264010,264075,263956,937477,937478,937479,937491,207561,265025,264998,934989,935104,217970,217959,935177,207830,207827,207831,218580,218945,218607,218823,218939,218940,221605,221743,221718,253298,219239,219238');

			// Deal 2
			$deals_title['2']	= "Hand Tool &amp; Power Tool (Starting at ₹ 148)";
			$deals_hash['2'] 	= "Tool-deals";
			$deals['2']			= SpecificPrice::getProducts(1, '937844,937843,937842,937841,937840,937839,937838,937836,937835,937825,937824,937822,937821,937820,937818,937817,937815,937813,937812,937810,937809,937804,937802,937801,937800,937799,937798,937797,937796,937795,937794,937791,937789,937788,937787,937786,937785,937784,937783,937782,937781,937780,934074,934073,934072,933842,933032,933031,932992,932991,932989,932931,932928,932923,932922,932921,264993,264992,264987,264986,264985,262609,262608,262607,262603,262602,262588,262587,262586,262585,262575,262574,218045,217992,217990,217971,217970,217968');

			// Deal 3
			$deals_title['3']	= "Safety (Upto 68% off)";
			$deals_hash['3'] 	= "Safety-deals";
			$deals['3']			= SpecificPrice::getProducts(1, '256005,215914,213025,256051,262669,255699,262681,255705,213023,262664,213015,262667,212923,212891,212867,212888,255680,212902,926125,926139,926087,256024,212784,256048,255698,926800,926803,255692,926082,256033,212878,926111,256009,212993,254845,255701,212855,264972,212985,264976,255704,212998,262692,213008,212978,212882,212997,212845,256012,212994,255103,212847,213010,255624,255674');

			// Deal 4
			$deals_title['4']	= "Electronics (Upto 82% off)";
			$deals_hash['4'] 	= "Electronics-deals";
			$deals['4']			= SpecificPrice::getProducts(1, '264887,264886,938278,264890,938218,4085,938209,264893,938176,206497,4086,266036,266036,949402,938163,266040,266038,949680,949526,949544,949414,206331,264523,949686,264533,203321,207377,203364,203368');
		}

		array_push($result, $banners, $deals_title, $deals_hash, $deals);

		return $result;
	}

	public function getProducts($id_lang = 1, $product_ids)
	{
		global $cookie;
		$sql = '
		SELECT cat.link_rewrite,p.*, pa.`id_product_attribute`, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`, il.`legend`, m.`name` AS manufacturer_name, tl.`name` AS tax_name, t.`rate`, cl.`name` AS category_default, DATEDIFF(p.`date_add`, DATE_SUB(NOW(), INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY)) > 0 AS new,
			(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice, p.minimal_quantity
		FROM `'._DB_PREFIX_.'category_product` cp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
		LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND default_on = 1)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cat ON (p.`id_category_default` = cat.`id_category`)
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (p.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group`
		                                           AND tr.`id_country` = '.(int)Country::getDefaultCountryId().'
	                                           	   AND tr.`id_state` = 0)
	    LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
		LEFT JOIN `'._DB_PREFIX_.'tax_lang` tl ON (t.`id_tax` = tl.`id_tax` AND tl.`id_lang` = '.(int)($id_lang).')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
		WHERE p.`active` = 1 
		AND p.`available_for_order`=1
		AND p.`reference` IN ('.($product_ids).')
		GROUP BY cp.`id_product`
		ORDER BY p.`price` ASC';
		$result = Db::getInstance()->ExecuteS($sql);
		
		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}

	public function getProductsByCustomer($id_customer){

		$customerObj = new Customer((int)$id_customer);
		$now = date('Y-m-d H:i:s');

		return Db::getInstance()->ExecuteS('SELECT sp.`id_product` 
											FROM `'._DB_PREFIX_.'specific_price` sp
											WHERE sp.`id_group` = '.(int)$customerObj->id_default_group.' 
											AND((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
											AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`))
											GROUP BY sp.`id_product`');
	}

	public function getPurchaseListData($id_customer, $count = false) {
		
		$context = Context::getContext();
 		$productObj = new Product();

		$where_query = "";
		
		$customer = new Customer((int)($id_customer));
		$id_default_group = $customer->id_default_group;
		$where_query .=' sp.id_group = '.$id_default_group.' ';

		$now = date('Y-m-d H:i:s');
		$where_query .=' AND sp.price !=0';

		$sql = ' FROM `'._DB_PREFIX_.'specific_price` as sp
				 LEFT JOIN '._DB_PREFIX_.'product as p on p.`id_product` = sp.`id_product`
				 INNER JOIN '._DB_PREFIX_.'stock_available ksa ON ksa.`id_product` = p.`id_product` 
				 LEFT JOIN '._DB_PREFIX_.'product_lang as pl on pl.`id_product` = sp.`id_product` 
				 LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON cl.`id_category` = p.`id_category_default`
				 WHERE '.$where_query.' AND p.`active` = 1 AND ((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
				 AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`)) and  pl.`id_lang` = 1	
				 GROUP BY p.`id_product` ORDER BY pl.`name` ASC';

		$data_rows = "SELECT p.`id_product`".$sql;
		$data_result = Db::getInstance()->ExecuteS($data_rows);
		
		if($count) {
			$result = count($data_result);
		}
		else {
			$result = $data_result;
		}

		return $result;
	}

	/* CORE CLASS FUNCTIONS OVERRIDE STARTS
	* Added by Elumalai K, Web Developer
	*/

	/*Specific price add override */
	public function add($autodate = true, $nullValues = false)
    {
        if($this->id_group == 0)
            $this->id_group = 1;

        if (parent::add($autodate, $nullValues)) {
            // Flush cache when we adding a new specific price
            $this->flushCache();
            // Set cache of feature detachable to true
            Configuration::updateGlobalValue('PS_SPECIFIC_PRICE_FEATURE_ACTIVE', '1');
            return true;
        }

        return false;
    }

    /*** Format query override as private ***/
    private static function formatIntInQuery($first_value, $second_value = NULL) {
        $first_value = (int)$first_value;
        $second_value = (int)$second_value;
        if ($first_value != $second_value) {
            return 'IN ('.$first_value.', '.$second_value.')';
        } else {
            return ' = '.$first_value;
        }
    }

    /*** Get specific price override ***/
    public static function getSpecificPrice($id_product, $id_shop, $id_currency, $id_country, $id_group, $quantity, $id_product_attribute = null, $id_customer = 0, $id_cart = 0, $real_quantity = 0)
    {
        if (!SpecificPrice::isFeatureActive()) {
            return array();
        }
        /*
        ** The date is not taken into account for the cache, but this is for the better because it keeps the consistency for the whole script.
        ** The price must not change between the top and the bottom of the page
        */
        $context = Context::getContext();
        $id_state = $context->cookie->id_state;
        if($id_cart){
        	$id_supplier = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT id_supplier from `'._DB_PREFIX_.'cart_product` where id_cart='.$id_cart.' AND id_product='.$id_product)['id_supplier'];
        	$key = ((int)$id_product.'-'.(int)$id_shop.'-'.(int)$id_currency.'-'.(int)$id_country.'-'.(int)$id_group.'-'.(int)$quantity.'-'.(int)$id_product_attribute.'-'.(int)$id_cart.'-'.(int)$id_customer.'-'.(int)$real_quantity.'-'.(int)$id_supplier);


        	if (!array_key_exists($key, SpecificPrice::$_specificPriceCache)) {
	            $query_extra = self::computeExtraConditions($id_product, $id_product_attribute, $id_customer, $id_cart);
	            $query = '
				SELECT *, '.SpecificPrice::_getScoreQuery($id_product, $id_shop, $id_currency, $id_country, $id_group, $id_customer).'
					FROM `'._DB_PREFIX_.'specific_price` ksp
					LEFT JOIN `'._DB_PREFIX_.'map_specific_price` kmsp on kmsp.id_specific_price=ksp.id_specific_price
					WHERE
					kmsp.id_state='.$id_state.' AND
	                `id_shop` '.self::formatIntInQuery(0, $id_shop).' AND
	                `id_currency` '.self::formatIntInQuery(0, $id_currency).' AND
	                `id_country` '.self::formatIntInQuery(0, $id_country).' AND
	                `id_supplier` '.self::formatIntInQuery(0, $id_supplier).' AND
	                `id_group` '.self::formatIntInQuery($id_group).' '.$query_extra.'
					AND IF(`from_quantity` > 1, `from_quantity`, 0) <= ';

	            $query .= (Configuration::get('PS_QTY_DISCOUNT_ON_COMBINATION') || !$id_cart || !$real_quantity) ? (int)$quantity : max(1, (int)$real_quantity);
	            $query .= ' ORDER BY `id_product_attribute` DESC, `from_quantity` DESC, `id_specific_price_rule` ASC, `score` DESC, `to` DESC, `from` DESC';
	            SpecificPrice::$_specificPriceCache[$key] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
	        }
        }
        else{
        	$key = ((int)$id_product.'-'.(int)$id_shop.'-'.(int)$id_currency.'-'.(int)$id_country.'-'.(int)$id_group.'-'.(int)$quantity.'-'.(int)$id_product_attribute.'-'.(int)$id_cart.'-'.(int)$id_customer.'-'.(int)$real_quantity);
	        if (!array_key_exists($key, SpecificPrice::$_specificPriceCache)) {
	            $query_extra = self::computeExtraConditions($id_product, $id_product_attribute, $id_customer, $id_cart);
	            $query = '
				SELECT *, '.SpecificPrice::_getScoreQuery($id_product, $id_shop, $id_currency, $id_country, $id_group, $id_customer).'
					FROM `'._DB_PREFIX_.'specific_price` ksp
					LEFT JOIN `'._DB_PREFIX_.'map_specific_price` kmsp on kmsp.id_specific_price=ksp.id_specific_price
					WHERE kmsp.id_state='.$id_state.' AND
	                `id_shop` '.self::formatIntInQuery(0, $id_shop).' AND
	                `id_currency` '.self::formatIntInQuery(0, $id_currency).' AND
	                `id_country` '.self::formatIntInQuery(0, $id_country).' AND
	                `id_group` '.self::formatIntInQuery($id_group).' '.$query_extra.'
					AND IF(`from_quantity` > 1, `from_quantity`, 0) <= ';

	            $query .= (Configuration::get('PS_QTY_DISCOUNT_ON_COMBINATION') || !$id_cart || !$real_quantity) ? (int)$quantity : max(1, (int)$real_quantity);
	            $query .= ' ORDER BY `id_product_attribute` DESC, `from_quantity` DESC, `id_specific_price_rule` ASC, `score` DESC, `to` DESC, `from` DESC';
	            SpecificPrice::$_specificPriceCache[$key] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
	        }
        }

        return SpecificPrice::$_specificPriceCache[$key];
    }

    /* CORE CLASS FUNCTIONS OVERRIDE ENDS */

    /** CSO functions **/
    public static function getSuppliers($id_customer){
        $context = Context::getContext();
    	if($context->cookie->delivery_region){
            $id_state = $context->cookie->id_state;
    		$where = ' AND kmsp.id_state='.$id_state;
    	}
    	
    	$query = "SELECT DISTINCT(kesp.id_supplier),kes.company as name ,kes.name as x from "._DB_PREFIX_."customer kc
    					LEFT JOIN "._DB_PREFIX_."specific_price kesp on kesp.id_group=kc.id_default_group
    					LEFT JOIN "._DB_PREFIX_."map_specific_price kmsp on kmsp.id_specific_price=kesp.id_specific_price
    					LEFT JOIN "._DB_PREFIX_."elite_supplier kes on kes.id_supplier=kesp.id_supplier
    					LEFT JOIN "._DB_PREFIX_."product kp on kp.id_product = kesp.id_product
    					LEFT JOIN "._DB_PREFIX_."product_lang kpl on kpl.id_product = kp.id_product
    					WHERE kesp.id_supplier != 0 and kc.id_customer=".$id_customer."".$where;
		$result = Db::getInstance()->ExecuteS($query);
		return $result;
    }
    
    public static function getCustomerProductList($id_customer, 
        $Pagination  = NULL, 
        $selected_supplier = NULL, 
        $like_query  = NULL, 
        $id_group = NULL, 
        $employee = NULL,
    	$selected_category = 0)
    {     
        $context = Context::getContext();
        $productObj = new Product();
        $where_query = "";
        $joins_query = "";

        if($selected_category) {
			$joins_query .= 'LEFT JOIN '._DB_PREFIX_.'category node on p.`id_category_default` = node.`id_category`
			LEFT JOIN '._DB_PREFIX_.'category parent on node.nleft BETWEEN parent.nleft AND parent.nright';			
			$where_query .= 'parent.level_depth = 2 AND parent.id_category ='.$selected_category.' AND ';	
		}

        if($selected_supplier != 0) {
            $where_query .= ' sp.id_supplier ='.$selected_supplier.' AND ';  
        }
        
        if($context->cookie->id_state){
            $id_state = $context->cookie->id_state;
        	$where_query .= 'kmsp.id_state ='.$id_state.' AND ';  	
        }
        if($like_query) {
            $where_query .= ' (pl.name like "%'.$like_query.'%" OR pl.description_short like "%'.$like_query.'%" OR p.reference like "%'.$like_query.'%") AND ' ;
        }

        if($id_group) {
            $where_query .=' sp.id_group = '.$id_group.' ';
        }
        else {
            $customer = new Customer((int)($id_customer));
            $id_default_group = $customer->id_default_group;
            $where_query .=' sp.id_group = '.$id_default_group.' ';
        }

        $now = date('Y-m-d H:i:s');
        if($employee) {
            $now = '0000-00-00 00:00:00';
        }
        else {
            $where_query .=' AND sp.price !=0';
        }

        $sql = 'SELECT DISTINCT(sp.`id_specific_price`), p.`id_product`, sp.`price` AS sp_price, sp.`price` AS price_tax_exc, s.`company` AS supplier_name,
                    p.`reference`, pl.`name`, pl.`link_rewrite`, pl.`description_short`, cl.`link_rewrite` AS category_rewrite,
                    pl.`available_now` AS availability_text,
                    ksa.`out_of_stock` as allow_oosp, p.`id_category_default`, p.`minimal_quantity`, sp.`to`, sp.`date_update`
                FROM `'._DB_PREFIX_.'specific_price` as sp
                LEFT JOIN `'._DB_PREFIX_.'map_specific_price` kmsp on kmsp.id_specific_price=sp.id_specific_price
                LEFT JOIN `'._DB_PREFIX_.'elite_supplier` as s ON sp.`id_supplier` = s.`id_supplier`
                LEFT JOIN '._DB_PREFIX_.'product as p on p.`id_product` = sp.`id_product`
                INNER JOIN '._DB_PREFIX_.'elite_supplier_stock ksa ON ksa.`id_product` = p.`id_product` and sp.id_supplier=ksa.id_supplier
                LEFT JOIN '._DB_PREFIX_.'product_lang as pl on pl.`id_product` = sp.`id_product` 
                LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON cl.`id_category` = p.`id_category_default`
                '.$joins_query.'
                WHERE '.$where_query.' 
                '.(!$employee ? 'AND p.`active` = 1' : "").' 
                AND ((sp.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= sp.`from`) 
                AND (sp.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= sp.`to`)) 
                and  pl.`id_lang` = 1
                and  cl.`id_lang` = 1   
                ORDER BY pl.`name` ASC';
        $products = Db::getInstance()->ExecuteS($sql);
        
        if($context->cookie->budget_configured == 1 && $context->cookie->budget_option == 1) {
        	$budgetProducts = array();
			$purchaseOrderObj = new PurchaseOrder();
			$purchaseOrderProducts = $purchaseOrderObj->getPurchaseOrderProducts((int)($context->cookie->id_address_budget), $context->cookie->budget_option, true);
        	for ($i = 0; $i < sizeof($products); ++$i) {
	            $average_results = PurchaseList::getAverageQuantityPerOrder($products[$i]['id_product'],$id_customer);
	            $product_last_ordered = $productObj->getProductLastOrderedDate($products[$i]['id_product'], $id_customer);
	            $products[$i]['tax_value'] = Tax::getProductTaxRate($products[$i]['id_product']);
	            $products[$i]['per_month'] = rtrim($average_results, ', ');
	            $products[$i]['last_ordered_date'] = $product_last_ordered[0]['date_add'];
	            for($j = 0; $j < sizeof($purchaseOrderProducts); $j++) {
					if($products[$i]['id_product'] == $purchaseOrderProducts[$j]['id_product']) {
						$products[$i]['available_budget_quantity'] = (int)$purchaseOrderProducts[$j]['available_quantity'];
						$budgetProducts[] = $products[$i];
					}
				}
	        }

	        return $budgetProducts;  
        }

        for ($i = 0; $i < sizeof($products); ++$i)
        {
            $average_results = PurchaseList::getAverageQuantityPerOrder($products[$i]['id_product'],$id_customer);
            $product_last_ordered = $productObj->getProductLastOrderedDate($products[$i]['id_product'], $id_customer);
            $products[$i]['tax_value'] = Tax::getProductTaxRate($products[$i]['id_product']);
            $products[$i]['per_month'] = rtrim($average_results, ', ');
            $products[$i]['last_ordered_date'] = $product_last_ordered[0]['date_add'];  
            
            if (isset($products[$i]['id_product_attribute']) && Validate::isUnsignedInt($products[$i]['id_product_attribute']))
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
                
                if ($result) {
                	foreach ($result AS $k => $row) {
                        $products[$i]['attributes_small'] .= $row['attribute_name'].', ';
                    }
                }
                    
                $products[$i]['attributes_small'] = rtrim($products[$i]['attributes_small'], ', ');
                if (isset($result[0]))
                    $products[$i]['attribute_quantity'] = $result[0]['attribute_quantity'];     
            }
        }
        
        return $products;
    }
}