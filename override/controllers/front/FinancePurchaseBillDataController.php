<?php 
class FinancePurchaseBillDataControllerCore extends BackController
{
	public function ajaxReturn()
	{	 
		$type = Tools::getValue('type');
		$bill_no = Tools::getValue('bill_no');
		$bill_date = Tools::getValue('bill_date');
		$id_vendor = Tools::getValue('id_vendor');
		$id_product = Tools::getValue('id_product');
		$payment_type = Tools::getValue('payment_type');
		$product_qty = Tools::getValue('product_qty');
		$unit_price = Tools::getValue('unit_price');
		$tax = Tools::getValue('tax');
 		
  		if($type == 1)
		{
			$purchase_bill = new ScnVendorPurchase();
			$purchase_bill->id_vendor = $id_vendor;
			$purchase_bill->id_bill_no = $bill_no;
			$purchase_bill->id_product = $id_product;
			$purchase_bill->bill_date = date("Y-m-d", strtotime($bill_date));
			$purchase_bill->product_qty = $product_qty;
			$purchase_bill->unit_price = $unit_price;
			$purchase_bill->tax = $tax;
			$purchase_bill->id_payment = $payment_type;
			$purchase_bill->active = 1;
			if($purchase_bill->add()) {
				echo 1;
			}
		}
	}
}