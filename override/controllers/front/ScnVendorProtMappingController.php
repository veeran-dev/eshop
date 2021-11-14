<?php
class ScnVendorProtMappingControllerCore extends BackController
{
	
	public function displayContent()
	{
		$tpl=$_POST['data'];
			self::$smarty->display($tpl);	
 	}
}
?>