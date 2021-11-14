<?php
class RMPlaceOrderStepsControllerCore extends DashController
{
	
	public function displayContent()
	{
		self::$smarty->display('rm/rm-place-order-steps.tpl');	
 	}
}
?>