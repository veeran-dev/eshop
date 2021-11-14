<?php
class FinanceIndexControllerCore extends BackController
{
	public $php_self = 'finance-index.php';
 	public $finance_auth = true;
	 
	public function displayContent()
	{	
 		$employee =  new Employee(self::$cookie->id_employee);
		if(!$employee->canLogin(Employee::FLAG_FINANCE_TEAM) || self::$cookie->logged_as != 'finance') {
			$employee->logout();
			Tools::redirect('finance-login.php');
		}
		else
		{			
			$currency = Tools::setCurrency($this->context->cookie);
			$this->context->smarty->assign(array(
				'finance_order_status_details'=> Finance::getIndexFinanceValue(),
				'purchaseBill'=>Finance::getMonthlyPurchaseBillTotal(),
				'currency' => $currency,
			));
    		
			parent::displayContent();
			self::$smarty->display('finance/finance-index.tpl');	
		}
 	}
	
	public function ajaxReturn()
	{
		parent::ajaxReturn();

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
		
		if($type==2){
  				self::$smarty->assign('financeProcurementPlan', Finance::financeProcurementPlan());
  				self::$smarty->display('finance/finance-procurement.tpl');
  			}
 		
		if($type==3)
		{
			$fc = new FulfillmentCentre();
			echo Tools::jsonEncode($fc->getAllFCentres());
		}
	}
	
}
 
?>