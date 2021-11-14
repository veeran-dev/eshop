<?php
class DashCODControllerCore extends DashController
{
	public function displayContent()
	{
		
		self::$smarty->display('dash/dash-cashondelivery.tpl');	
		
			
 	}
}
?>