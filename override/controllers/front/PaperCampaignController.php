<?php
class PaperCampaignControllerCore extends FrontController
{
 
	public function displayContent()
	{
		self::$smarty->display('paper-one.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>