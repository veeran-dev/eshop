<?php
class EdgeControllerCore extends BackController
{
	/*public function displayHeader()
	{
		
	}
	public function displayFooter()
	{
		
	}*/
	
  	public function displayContent()
	{	
 		parent::displayContent();
		
		self::$smarty->display('edge/edge.tpl');	
 	}
	
}
 
?>