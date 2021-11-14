<?php
class FinanceViewPurchaseBillControllerCore extends BackController
{
	public function displayContent()
	{
		$this->context->smarty->display('finance/finance-viewpurchasebill.tpl');	
 	}

	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$id_vendor = Tools::getValue('id_vendor');
		$billno = Tools::getValue('billno');
		$id_vendor_purchase = Tools::getValue('id_vendor_purchase');
		$qty = Tools::getValue('product_qty');
		$tax_value = Tools::getValue('tax');
		$unit_price = Tools::getValue('unit_price');
		$billdate = Tools::getValue('billdate');
		$old_bill_no = Tools::getValue('old_billno');
		$search_query = Tools::getValue('q');
		$from = Tools::getValue('from');
		$to = Tools::getValue('to');
		
		if($type == 1) 
		{
			$result = ScnVendorPurchase::getPurchaseBills($id_vendor, $from, $to);
			$this->context->smarty->assign('purchaseBill', $result);
		 	$this->context->smarty->display('finance/finance-viewpurchasebill.tpl');
		}
		else if($type == 2)
		{
			$result = ScnVendorPurchase::getPurchaseBillDetails($billno, $id_vendor);
			array_push($result[0], Tax::getTaxes(true));
			echo Tools::jsonEncode($result);
		}
		else if($type == 3)
		{
			if(ScnVendorPurchase::deleteBill($billno, $id_vendor, $id_vendor_purchase)) {
				echo "1";
			}
		}
		else if($type == 4) 
		{
			$result = ScnVendorPurchase::topVendorDetails();
			echo Tools::jsonEncode($result);
		}
		else if($type == 5) 
		{
			$result = ScnVendorPurchase::getMonthlyPerformance($id_vendor);
			echo Tools::jsonEncode($result);
		}
		else if($type==6){
			$result = ScnVendorPurchase::getVendorLists($search_query);			 
			echo Tools::jsonEncode($result);
		}
		else if($type == 7)
		{			
			if(ScnVendorPurchase::changeBill($id_vendor_purchase, $qty, $tax_value, $unit_price, $billdate, $billno, $old_bill_no)) {
				echo "1";
			}
		}
		else if($type == 8)
		{			
			if(ScnVendorPurchase::changeBill(0, 0, 0, 0, $billdate, $billno, $old_bill_no)) {
				echo "1";
			}
		}
	}
}