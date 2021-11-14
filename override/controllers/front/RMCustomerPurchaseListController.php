<?php
class RMCustomerPurchaseListControllerCore extends BackController
{
	
	public function displayContent()
	{
			self::$smarty->display('rm/rm-customerpurchaselist.tpl');	
 	}
	
	public function ajaxReturn()
	{
		$list_name =$_POST['list_name'];
		$type =$_POST['type'];
		$cus_id =$_POST['id_customer'];
		$id_pur_list=$_POST['id_pur_list'];
		$status=$_POST['status'];
		if($type==4)
			{
				$result = PurchaseList::addByCustomerId($cus_id,$list_name);
			}
		if($type==1)
			{
				$result = PurchaseList::getByIdCustomer($cus_id);
				echo Tools::jsonEncode($result);
			}
		if($type==2)
		{
			$result=PurchaseList::changeStatusByPurchasListId($id_pur_list,$status);
		}
	}
}
?>