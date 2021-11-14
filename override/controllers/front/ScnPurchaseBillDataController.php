<?php 
class ScnPurchaseBillDataControllerCore extends BackController
{
	public function ajaxReturn()
	{	 
		$type = $_POST['type'];
		$bill_no = $_POST['bill_no'];
		$bill_date = $_POST['bill_date'];
		$id_vendor = $_POST['id_vendor'];
		$id_product = $_POST['id_product'];
		$payment_type = $_POST['payment_type'];
		$product_qty = $_POST['product_qty'];
		$unit_price = $_POST['unit_price'];
		$tax = $_POST['tax'];
 		
  		if($type==1)
		{
 			$result = ScnVendorPurchase::addPurchaseBillDetails($bill_no,$bill_date,$id_vendor,$id_product,$product_qty,$unit_price,$tax,$payment_type);
			echo "1";
		}
	}
}
 ?>