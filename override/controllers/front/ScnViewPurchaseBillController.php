<?php
class ScnViewPurchaseBillControllerCore extends BackController
{
 	public function displayContent()
	{
			self::$smarty->display('scn/scn-viewpurchasebill.tpl');	
 	}
	public function ajaxReturn()
	{
		$type = $_POST['type'];
		$search_type = $_GET['type'];
		$from_date = Tools::getValue('from_date');
		$to_date = Tools::getValue('to_date');
		$scnpurchase = new ScnVendorPurchase();
		if($type==1)
		{
			$result=$scnpurchase->getPurchaseBills();
			echo Tools::jsonEncode($result);
		}
		if($type==2)
		{
			$billno = $_POST['billno'];
			$id_vendor = $_POST['id_vendor'];
			$result=$scnpurchase->getPurchaseBillDetails($billno,$id_vendor);
			echo Tools::jsonEncode($result);
		}
		if($type==3)
		{
			$billno = $_POST['billno'];
			$id_vendor = $_POST['id_vendor'];
			$id_vendor_purchase = $_POST['id_vendor_purchase'];
			$result=$scnpurchase->deleteBill($billno,$id_vendor,$id_vendor_purchase);
			echo "1";
		}
		if($search_type==4)
		{
			$fc = Tools::getValue('id_fc');
			$result = $scnpurchase->topVendorDetails($fc, $from_date, $to_date);
			echo Tools::jsonEncode($result);
		}
		if($type==5){
			$id_vendor = $_POST['id_vendor'];
			$result=$scnpurchase->getMonthlyPerformance($id_vendor, $from_date, $to_date);
			echo Tools::jsonEncode($result);
		}
		if($search_type==6){
			$search_query = $_GET['q'];
			$result=$scnpurchase->getVendorLists($search_query);			 
			echo Tools::jsonEncode($result);
		}
		if($type==7)
		{			
			$id_vendor_purchase = $_POST['id_vendor_purchase'];
			$qty=$_POST['product_qty'];
			$tax_value=$_POST['tax'];
			$unit_price=$_POST['unit_price'];
			$billdate=$_POST['billdate'];
			$old_bill_no=$_POST['old_billno'];
			$scnpurchase->changeBill($id_vendor_purchase,$qty,$tax_value,$unit_price,$billdate,$billno,$old_bill_no);
			echo "1";
		}
		if($type==8)
		{	
			$billno = $_POST['billno'];
			$billdate=$_POST['billdate'];
			$old_bill_no=$_POST['old_billno'];
			$scnpurchase->changeBill(0,0,0,0,$billdate,$billno,$old_bill_no);
			echo "1";
		}
	}
}
?>