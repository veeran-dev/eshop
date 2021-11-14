<?php
class AdobeControllerCore extends DashController
{
	public $php_self = 'adobe.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/adobe.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>