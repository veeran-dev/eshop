<?php
class TecnotreeControllerCore extends DashController
{
	public $php_self = 'tecnotree.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/tecnotree.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>