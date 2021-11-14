<?php
class PaperOneControllerCore extends DashController
{
 
	public function displayContent()
	{
		self::$smarty->display('paper-one.tpl');	
 	}
	
	public function displayHeader($display = true)
	{
	}
	
	public function displayFooter($display = true)
	{
	}
}
?>