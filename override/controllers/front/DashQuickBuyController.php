<?php
class DashQuickBuyControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-quickbuy.tpl');	
 	}
}
?>