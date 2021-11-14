<?php
class FinanceReportControllerCore extends BackController
{	
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$duration = Tools::getValue('duration');
		$from_date = Tools::getValue('from_date');
		$to_date = Tools::getValue('to_date');
		$month = Tools::getValue('month');
		$id_fc = Tools::getValue('id_fc');
		//$id_employee = Tools::getValue('id_employee');
		
		$mon ="01-";
		$month  = $mon.$month;
		if($type==1)// General order reports which show order id and its value	
		{
				$finance_order_report = Finance::getFinanceHistoryReport($duration,$from_date,$to_date);
 				echo Tools::jsonEncode($finance_order_report);
		}
		/*if($type==2)// Returns purchase bill for  selected month 	
		{
				$finance_purchase_bill_report = Finance::purchaseBill($id_fc, $month);
 				//echo Tools::jsonEncode($finance_purchase_bill_report);
		}
		if($type==3)// Returns sales bill for selected month 	
		{
				$finance_sales_bill_report = Finance::salesBill($id_fc, $month);
 				//echo Tools::jsonEncode($finance_sales_bill_report);
		}*/
	 
	}
	
}
 
?>