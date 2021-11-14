<?php
class DashDisplayAddressControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-address.tpl');	
 	}
}
?>