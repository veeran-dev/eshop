<?php
class MosambeeControllerCore extends DashController
{
	public $php_self = 'mosambee.php';
	public $auth = false;
 
	public function displayContent()
	{
		self::$smarty->display('dash/mosambee.tpl');	
 	}
	
	public function displayHeader()
	{
	}
	
	public function displayFooter()
	{
	}
}
?>