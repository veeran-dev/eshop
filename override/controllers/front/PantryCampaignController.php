<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class PantryCampaignControllerCore extends FrontController 
{
	public $php_self = 'pantrycampaign';

	public function display() {
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/pantry.tpl');
	}
}