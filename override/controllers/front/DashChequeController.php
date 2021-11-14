<?php
class DashChequeControllerCore extends DashController
{
	public function displayContent()
	{
		
		self::$smarty->display('dash/dash-cheque.tpl');	
		
			
 	}
}
?>