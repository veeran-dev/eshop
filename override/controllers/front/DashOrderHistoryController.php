<?php
class DashOrderHistoryControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-orderhistory.tpl');	
 	}
}
?>