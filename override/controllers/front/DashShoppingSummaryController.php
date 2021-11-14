<?php
class DashShoppingSummaryControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-shoppingsummary.tpl');	
 	}
}


?>