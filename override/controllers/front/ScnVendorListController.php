<?php
class ScnVendorListControllerCore extends BackController
{
	
	public function displayContent()
	{
			self::$smarty->display('scn/scn-vendorList.tpl');	
 	}
}
?>