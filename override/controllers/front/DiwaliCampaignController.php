<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class DiwaliCampaignControllerCore extends FrontController 
{
	public $php_self = 'diwalicampaign';

	public function display() {
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/diwali.tpl');
	}
}