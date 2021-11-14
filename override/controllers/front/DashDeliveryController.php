<?php
class DashDeliveryControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-delivery.tpl');	
 	}
}
?>