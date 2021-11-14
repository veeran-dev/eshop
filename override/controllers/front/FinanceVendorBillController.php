<?php
class FinanceVendorBillControllerCore extends BackController
{
	
	public function displayContent()
	{
			self::$smarty->display('finance/finance-vendorbill.tpl');	
 	}
}
?>