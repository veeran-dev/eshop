<?php
class RMOrderControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('rm/rm-order.tpl');	
 	}
}
?>