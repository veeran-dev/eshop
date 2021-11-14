<?php
class DashInvoiceControllerCore extends DashController
{
	
	public function displayContent()
	{
			self::$smarty->display('dash/dash-invoice.tpl');	
 	}
}
?>