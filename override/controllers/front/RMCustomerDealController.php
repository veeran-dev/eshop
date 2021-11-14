<?php
class RMCustomerDealControllerCore extends DashController
{
	public function ajaxReturn()
	{
		global $cookie;
		$type=$_POST['type'];
		$id_customer=$_POST['id_customer'];
		$id_employee=$_POST['id_employee'];
		$id_product=$_POST['id_product'];
		$sprice=$_POST['sprice'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		$reduction=$_POST['reduction'];
		$reduction_type=$_POST['reduction_type'];
		$spId=$_POST['spId'];
		$dealId=$_POST['id_deal'];
		$expiryDate=$_POST['expiryDate'];
		$id_specific_price=$_POST['id_specific_price'];
				
		if($type==1)
		{
			$customer=new Customer($id_customer);
			$check=Deal::checkProductInDeal($customer->id_default_group,$id_product);
			
			if($check[0]['id_deal'])
			{
				echo "2";
			}
			else
			{
				$specificPrice = new SpecificPrice();
				$specificPrice->id_product = $id_product;
				$specificPrice->id_shop = 0;
				$specificPrice->id_currency = 0;
				$specificPrice->id_country = 0;
				$specificPrice->id_group = (int)($customer->id_default_group);
				$specificPrice->price = 0.00;
				$specificPrice->from_quantity =0;
				$specificPrice->reduction = ($reduction_type == 'percentage' ? $reduction / 100 : $reduction);				
				$specificPrice->reduction_type = $reduction_type;
				$specificPrice->from = !$from ? '0000-00-00 00:00:00' : $from;
				$specificPrice->to = !$to ? '0000-00-00 00:00:00' : $to;
				$specificPrice->save();
				
					
				
				$deal =new Deal();
				$deal->id_group=$customer->id_default_group;
				$deal->id_specific_price=$specificPrice->id;
				$deal->id_employee=$id_employee;
				$deal->date_add=date('Y-m-d H:i:s');
				$deal->save();
				if($specificPrice->id && $deal->id)
				{
					$this->dealMail();
				}
				echo "1";	
			}
			
			
		}
		if($type==2)
		{
			$customer=new Customer($id_customer);
			$getDeals=Deal::findDeal($customer->id_default_group);
			$ProductDetails=array();
			
			for($i=0;$i<sizeof($getDeals);$i++)
			{
				/*$ProductDetails[$i]=Product::getProductProperties(1,$getDeals[$i]);
				$product=new Product($ProductDetails[$i]['id_product']);				
				$name=$product->name;				
				$ProductDetails[$i]['name']=$name[1];
				$ProductDetails[$i]['active']=$getDeals[$i]['active'];*/
				$productPrice=new Product((int)$getDeals[$i]['id_product']);
				$tax_rate = Tax::getProductTaxRateViaRules((int)$getDeals[$i]['id_product'],110,0,0);
				if ($tax_rate === false)
					$tax_rate = 0;

				// Add country Tax and round the price
				$getDeals[$i]['orginalMrp'] = Tools::ps_round($productPrice->price * (1 + ($tax_rate / 100)), 6);
				$getDeals[$i]['name']=$productPrice->name;
				//$getDeals[$i]['price']=Product::getPriceStatic((int)$getDeals[$i]['id_product'], true, 6);
			}
			echo json_encode($getDeals);
		}
		if($type==3)
		{
			$specificPrice = new SpecificPrice($spId);
			$deal =new Deal($dealId);
			$specificPrice->delete();
			$deal->delete();
		}
		if($type==4)
		{
			$specificPrice = new SpecificPrice($id_specific_price);
			$specificPrice->price = 0.00;
			$specificPrice->reduction = ($reduction_type == 'percentage' ? $reduction / 100 : $reduction);				
			$specificPrice->reduction_type = $reduction_type;
			$specificPrice->from = !$from ? '0000-00-00 00:00:00' : $from;
			$specificPrice->to = !$to ? '0000-00-00 00:00:00' : $to;			
			$specificPrice->update();
			$deal=new Deal($dealId);
			$deal->id_employee=$id_employee;
			$deal->date_upd=date('Y-m-d H:i:s');
			$deal->update();
		}
		if($type==5)
		{
			$specificPrice = new SpecificPrice($id_specific_price);//expires the special price and deactivate the deal
			
			$result=0;
			$deal =new Deal($dealId);
			if($deal->active==1)			
			{
				$deal->active=0;
				$specificPrice->to=date('Y-m-d H:i:s');
				$specificPrice->update();
				$result=1;
			}
			else
			{
				$specificPriceNew = new SpecificPrice();
				$specificPriceNew->id_product = $specificPrice->id_product;
				$specificPriceNew->id_shop = 0;
				$specificPriceNew->id_currency = 0;
				$specificPriceNew->id_country = 0;
				$specificPriceNew->id_group = $specificPrice->id_group;
				$specificPriceNew->price = 0.00;
				$specificPriceNew->from_quantity =0;
				$specificPriceNew->reduction = $specificPrice->reduction;
				$specificPriceNew->reduction_type = $specificPrice->reduction_type;
				$specificPriceNew->from = $specificPrice->from;
				$specificPriceNew->to = $expiryDate;
				$specificPriceNew->save();
				$deal->active=1;
				$deal->id_specific_price=$specificPriceNew->id;
				$result=$specificPriceNew->id;
			}
			$deal->date_upd=date('Y-m-d H:i:s');
			$deal->update();
			echo $result;
		}
	}

	public function displayContent()
	{
			self::$smarty->display('rm/rm-customerlist.tpl');	
 	}
	public function dealMail()
	{
		global $cookie;
		$customer=new Customer($cookie->id_customer);
		$getDeals=Deal::findDeal($customer->id_default_group);
		
		$ProductDetails=array();
		$str='';
		$j=1;
		$count=1;
		for($i=0;$i<sizeof($getDeals);$i++)
		{
			$ProductDetails[$i]=Product::getProductProperties(1,$getDeals[$i]);

			$product=new Product($ProductDetails[$i]['id_product']);				
			$name=$product->name;				
			if($getDeals[$i]['active']==0 || $getDeals[$i]['to']<date('Y-m-d H:i:s'))
			{
				continue;
			}
			
			if (!Validate::isLoadedObject($product))
				continue;
			else
			{
				$images = $product->getImages(1);
				foreach ($images AS $k => $image)
				{
					if ($image['cover'])
					{
						$ProductDetails[$i]['cover'] = $product->id.'-'.$image['id_image'];
						break;
					}
				}
				if (!isset($ProductDetails[$i]['cover']))
					$ProductDetails[$i]['cover'] = Language::getIsoById((int)($cookie->id_lang)).'-default';
			}		
			$discountDetails;
			//var_dump($ProductDetails[$i]);
			if($ProductDetails[$i]['specific_prices']['reduction_type']=='amount')
			{
				$discountDetails="Rs.".round($ProductDetails[$i]['specific_prices']['reduction'],2)."/- OFF";
			}
			else if($ProductDetails[$i]['specific_prices']['reduction_type']=='percentage')
			{
				$discountDetails=($ProductDetails[$i]['specific_prices']['reduction']*100)."% OFF";
			}			
			/*$str .= '<tr style="background-color: '.($key % 2 ? '#DDE2E6' : '#EBECEE').';" ><td style="width:10%; padding: 0.6em 0;">'.($j).'</td><td style="width:50%; padding: 0.6em 0;"> <img src='.(self::$link->getImageLink($ProductDetails[$i]['link_rewrite'], $ProductDetails[$i]['cover'], 'medium')).'></td><td style="width:40%; padding: 0.6em 0;">'.$name[1].'<br>'.$discountDetails.'</td></tr>';*/
			
			if($count==1){
				$str.='<tr style="background-color:#fff; width: 100%;">';
			}

			/*$str.='<td style="background-color:#fff;border:1em solid #ccc;width:32%;" align="center"> <img src='.(self::$link->getImageLink($ProductDetails[$i]['link_rewrite'], $ProductDetails[$i]['cover'], 'medium')).'><p style="width:50%">'.$name[1].'</p><p style="color:##c32e59; font-weight:bold;">'.$discountDetails.'</p></td>';*/
			$str .='<td align="center" style="padding: 0.6em 0px; border: 1px solid #ccc; width: 33%;"><img src='.(self::$link->getImageLink($ProductDetails[$i]['link_rewrite'], $ProductDetails[$i]['cover'], 'medium')).'><p style="width: 80%;">'.$name[1].'</p><p style="color:#f64747; font-weight: bold;">'.$discountDetails.'</p></td>';

			if($count==3 || (($i+1)-sizeof($getDeals))==0)
			{
				$str.='</tr>';
				$count=0;
			}
			$count++;
			$j++;
		}
		$data = array('{str}' => $str);
		$em_sub = 'Special Offers';
		$customerMailIds=Customer::getCustomerInGroups($customer->id_default_group);
		
		foreach($customerMailIds as $mail)
		{
			Mail::Send((int)$cookie->id_lang, 'specialOffer', Mail::l($em_sub, (int)$cookie->id_lang), $data, $mail['email'], 'Special Offers', 'noreply@kobster.com');
		}
		
		
	}
}
?>