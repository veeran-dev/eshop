<?php
class RmCustomerOrderControllerCore extends DashController
{
	
	public function displayContent()
	{
		self::$smarty->display('rm/rm-customer-order.tpl');	
 	}
	public function ajaxReturn()
	{
		
	}
}
?>