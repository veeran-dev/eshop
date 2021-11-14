<?php
class RmPurchaseListControllerCore extends BackController
{
	public function ajaxreturn()
	{
		$id_customer=$_POST["id_customer"];
	 	$id_product=$_POST["id_product"];
		$purchaseListId=$_POST['id_list'];
		$custPrice=$_POST['specific_price'];
		$old_Price=$_POST['productPrice'];
		
		 if(!empty($custPrice)){
					//Add Specific Price
					$id_product = (int)$id_product;
					$id_shop = 1;
					$id_currency = 0;
					$id_country = 0;
					$cust = new Customer($id_customer);
					$id_group = $cust->id_default_group;
					$price = $custPrice;
					$from_quantity = 1;
					$reduction = 0;
					$reduction_type = 'amount';
					
					$specificPrice = new SpecificPrice();
					$specificPrice->id_product = $id_product;
					$specificPrice->id_shop = (int)($id_shop);
					$specificPrice->id_currency = (int)($id_currency);
					$specificPrice->id_country = (int)($id_country);
					$specificPrice->id_group = (int)($id_group);
					$specificPrice->price = (float)($price);
					$specificPrice->from_quantity = (int)($from_quantity);
					$specificPrice->reduction = (float)($reduction_type == 'percentage' ? $reduction / 100 : $reduction);
					$specificPrice->reduction_type = $reduction_type;
					$specificPrice->from = !$from ? '0000-00-00 00:00:00' : $from;
					$specificPrice->to = !$to ? '0000-00-00 00:00:00' : $to;
					
					$displayspecificPrice = $specificPrice->ifSpecificPrice($id_product,$id_group);
					if($displayspecificPrice != 0)
					{
							
						$updateSpecificPrice=$specificPrice->updateSpecificPrice($price,$id_product,$id_group);
						/*Product::saveOldPrice($id_product,$old_Price,$custPrice,$id_group,$cookie->id_employee);
						$content=array("id_product" => $id_product, "old_price_spec" => $old_Price, "new_price"=> $custPrice, "id_group" => $id_group));
						PriceChange::specificPriceChangedNotification($content);*/
					}
					else
					{
						$specificPrice->add();
					}
					
				}
	
		$rate=new RateContract();
		$addtolist=$rate->addratecontract($id_product,$id_customer,$purchaseListId,1);	
		echo $addtolist;

	}
}
?>