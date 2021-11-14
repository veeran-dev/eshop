<?php
class DashEBSControllerCore extends DashController
{
	public function displayContent()
	{
		
		self::$smarty->display('dash/dash-EBS.tpl');	
		/*self::$smarty->display('modules/EBS/EBS.tpl');*/
			
 	}
}
?>