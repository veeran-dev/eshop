<?php
class ScnVendorFormControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('scn/scn-vendor-form.tpl');	
 	}
 	public function ajaxReturn()
 	{
 		$centre=FulfillmentCentre::getAllFCentres();
 		echo json_encode($centre);
 	}
}
?>