<?php
class TMFooterlinks extends Module
{
	public function __construct()
	{
		$this->name = 'tmfooterlinks';
		$this->tab = 'front_office_features';
		$this->version = 1.4;
		$this->author = 'TM';
		parent::__construct();
		$this->displayName = $this->l('TM Footer Links');
		$this->description = $this->l('Adds a block to display a footer links menu.');
	}
	public function install()
	{
		if (!parent::install() OR !$this->registerHook('footer'))
			return false;
		return true;
	}
	function hookFooter($params)
	{
		global $smarty;
		return $this->display(__FILE__, 'tmfooterlinks.tpl');
	}
}