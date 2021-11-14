<?php
class landingPage extends Module
{
	private $_html = '';
	private $_postErrors = array();
	function __construct()
	{
		$this->name = 'landingPage';
		$this->tab = 'front_office_features';
		$this->version = '0.0.0';
		parent::__construct(); // The parent construct is required for translations
		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Brand New Home Page');
		$this->description = $this->l('Brand New Home Page');
	}
	public function install()
	{
	  
		if (!parent::install() 
			|| !$this->registerHook('displayHome') 
			|| !$this->registerHook('header')
			|| !Configuration::updateValue('MYMODULE_NAME', 'landingPage')
			)
		{
			return false;
		}
		return true;
	}
	public function uninstall()
	{
		if (!parent::uninstall() ||
		!Configuration::deleteByName('MYMODULE_NAME')
		)
		return false;

		return true;
	}
		
	public function hookDisplayHome($params)
	{
		global $smarty;
		$this->context->controller->addCSS($this->_path.'landingPage.css', 'all');				
		return $this->display(__FILE__, 'public/');
	}

	public function displayHeader($display = false)
    {

    }

    public function displayFooter($display = false)
    {
    	
    }
	// public function hookHeader($params)
	// {
	// 	global $smarty;
	// 	// $this->context->controller->addJS(_PS_MODULE_DIR_.'landingPage/landingPage.js', 'all');		
	// 	// $this->context->controller->addCSS($this->_path.'landingPage.css', 'all');
	// }
	// public function hookDisplayHeader($params)
	// {
	// 	global $smarty;
	// 	// $this->context->controller->addJS(_PS_MODULE_DIR_.'landingPage/landingPage.js', 'all');		
	// 	// $this->context->controller->addCSS($this->_path.'landingPage.css', 'all');
	// }
}
?>