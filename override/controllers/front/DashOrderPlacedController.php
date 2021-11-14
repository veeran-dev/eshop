<?php
class DashOrderPlacedControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-orderplaced.tpl');	
 	}
}
?>