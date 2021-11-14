<?php

class ConcordedigitalControllerCore extends DashController

{

	public $php_self = 'concordedigital.php';

	public $auth = false;

 

	public function displayContent()

	{

		self::$smarty->display('dash/concordedigital.tpl');	

 	}

	

	public function displayHeader()

	{

	}

	

	public function displayFooter()

	{

	}

}

?>