<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class ElectronicsCampaignControllerCore extends FrontController 
{
	public $php_self = 'electronicscampaign';

	public function display() {
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/electronics.tpl');
	}
}