<?php
class ScnVendorBillControllerCore extends BackController
{
	
	public function displayContent()
	{
			self::$smarty->display('scn/scn-vendorbill.tpl');	
 	}
}
?>