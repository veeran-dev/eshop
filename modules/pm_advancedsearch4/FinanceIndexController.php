<?php
class FinanceIndexControllerCore extends BackController
{
	public $php_self = 'finance-index.php';
 	public $finance_auth = true;
	public $RM_auth = false;
	public $scn_auth = false;
	 
	public function displayContent()
	{	
 		$employee =  new Employee(self::$cookie->id_employee);
		
		if($employee->id_profile != Employee::FLAG_FINANCE_TEAM)
		{
			Tools::redirect('finance-login.php');
		}
		else
		{
			parent::displayContent();
			self::$smarty->display('finance/finance-index.tpl');	
		}
 	}
	
	public function ajaxReturn()
	{
		$type = Tools::getValue('type');
		$page = Tools::getValue('page');//page =0 -> index page, 1->finance-order
		//$id_employee = Tools::getValue('id_employee');
		
		if($type==1)	
		{
				if($page == 1)
 					$finance_order_status_details= Finance::getIndexFinanceValue(1);
 				else
 					$finance_order_status_details= Finance::getIndexFinanceValue();
				
   				echo Tools::jsonEncode($finance_order_status_details);
		}
		
		if($type==2)	
  				echo Tools::jsonEncode(Finance::financeProcurementPlan());
 		
		if($type==3)
		{
			$fc = new FulfillmentCentre();
			echo Tools::jsonEncode($fc->getAllFCentres());
		}
	}
	
}
 
?>