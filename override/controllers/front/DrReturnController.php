<?php
class DrReturnControllerCore extends BackController
{
	public $php_self = 'dr-index';

 	public function postProcess()
	{
		echo "1";
	}

	public function displayHeader($display=true) {}

	public function displayFooter($display=true) {}

	public function displayContent()
	{
		echo "1";
 	}
}