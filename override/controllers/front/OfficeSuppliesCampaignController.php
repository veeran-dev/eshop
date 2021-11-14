<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class OfficeSuppliesCampaignControllerCore extends FrontController 
{
	public $php_self = 'officesuppliescampaign';

	public function display() {
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/office-supplies.tpl');
	}
}