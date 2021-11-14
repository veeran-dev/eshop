<?php
class DashPlaceOrderStepsControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-place-order-steps.tpl');	
 	}
}
?>