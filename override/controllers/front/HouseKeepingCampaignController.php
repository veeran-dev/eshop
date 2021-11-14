<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class HouseKeepingCampaignControllerCore extends FrontController 
{
	public $php_self = 'housekeepingcampaign';

	public function display() {
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/house-keeping.tpl');
	}
}