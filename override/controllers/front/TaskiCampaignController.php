<?php
/*
* Pantry campaign controller added by Elumalai K
*/
class TaskiCampaignControllerCore extends FrontController 
{
	public $php_self = 'taskicampaign';

	public function display() {
		$this->context->smarty->display(_PS_THEME_DIR_.'campaigns/taski.tpl');
	}
}