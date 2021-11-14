<?php
class ShopControllerCore extends FrontController
{
	public $php_self = 'shop';
	public $auth = false;
 
 	public function initContent()
 	{
 		parent::initContent();
 		$this->context->smarty->assign(array('HOOK_SHOP' => Hook::exec('displayShop')));
 		$this->setTemplate(_PS_THEME_DIR_.'shop.tpl'); 
 	}
	public function displayContent()
	{
		
 	}
	
	public function displayHeader($display=true)
	{
	}
	
	public function displayFooter($display=true)
	{
	}
}