<?php
class RmPurchaseListControllerCore extends BackController
{
	public function ajaxreturn()
	{
		global $cookie;
		$id_customer=$_POST["id_customer"];
	 	$id_product=$_POST["id_product"];
		$purchaseListId=$_POST['id_list'];
		$custPrice=$_POST['specific_price'];
		$old_Price=$_POST['productPrice'];
		$id_employee=$_POST['id_employee'];
		$type=$_POST['type'];
		
		$customer=new Customer($id_customer);
		if($customer->id_default_group==1)
		{
			echo "";
		}
		if($type==1)
		{
			if($custPrice)
			{
				$checkDeal=Deal::checkProductInDeal($customer->id_default_group,$id_product);
				if($checkDeal[0]['active']==0)//if specific price available and no deal ,expire all specific price
				{
					$check_old_price_spec = SpecificPrice::getSpecificProductPrice($id_product,$customer->id_default_group);
 
					if($check_old_price_spec['price'] != "" && $check_old_price_spec['price'] != $custPrice)
					{
 						Product::saveOldPrice($id_product,$check_old_price_spec['price'],$custPrice,$customer->id_default_group,$id_employee);				
						$content=array("id_product" => $id_product, "old_price_spec" => $check_old_price_spec['price'], "new_price"=> $custPrice, "id_group" => $customer->id_default_group,"id_employee" => self::$cookie->id_employee);						
						SpecificPrice::specificPriceChangedNotification($content);
					}
					SpecificPrice::expireSpecificPrice($id_product,$customer->id_default_group);//expire all specific price					
					if(RateContract::productAvailable($id_product,$id_customer,$purchaseListId))
					{
						SpecificPrice::addSpecificPrice($custPrice,$id_product,$customer->id_default_group);
						echo "4";
					}
					else
					{
						SpecificPrice::addSpecificPrice($custPrice,$id_product,$customer->id_default_group);
						$rate=new RateContract();
						$addtolist=$rate->addratecontract($id_product,$id_customer,$purchaseListId,1);
						echo "3";
					}

				}
				else
				{
					if(!RateContract::productAvailable($id_product,$id_customer,$purchaseListId))
					{
						$rate=new RateContract();
						$addtolist=$rate->addratecontract($id_product,$id_customer,$purchaseListId,1);
					}
					echo "101";
				}
			}
			else
			{
				if(RateContract::productAvailable($id_product,$id_customer,$purchaseListId))
				{
					echo "1";
				}
				else
				{
					$rate=new RateContract();
					$addtolist=$rate->addratecontract($id_product,$id_customer,$purchaseListId,1);
					echo "2";
				}
			}
		}
		else if($type==2)
		{
			$checkDeal=Deal::checkProductInDeal($customer->id_default_group,$id_product);
			$deal=new Deal($checkDeal[0]['id_deal']);
			$deal->deactive();

			SpecificPrice::expireSpecificPrice($id_product,$customer->id_default_group);//expire all specific price

			$reduction = 0;
			$reduction_type = 'amount';

			if($custPrice)
				{
					$specificPrice = new SpecificPrice();
					$specificPrice->id_product = $id_product;
					$specificPrice->id_shop = (int)($id_shop);
					$specificPrice->id_currency = (int)($id_currency);
					$specificPrice->id_country = (int)Country::getDefaultCountryId();
					$specificPrice->id_group = (int)$customer->id_default_group;
					$specificPrice->price = $custPrice;
					$specificPrice->from_quantity = (int)($from_quantity);
					$specificPrice->reduction = (float)($reduction_type == 'percentage' ? $reduction / 100 : $reduction);
					$specificPrice->reduction_type = $reduction_type;
					$specificPrice->from = !$from ? '0000-00-00 00:00:00' : $from;
					$specificPrice->to = !$to ? '0000-00-00 00:00:00' : $to;
					$specificPrice->add();	
				}
			echo "3";
		}
		else if($type==3)
		{
			$rate=new RateContract();
			$addtolist=$rate->addratecontract($id_product,$id_customer,$purchaseListId,1);
			echo $addtolist;
		}

	}
}
?>