<?php
class FinanceRateContractControllerCore extends BackController
{
	public function displayContent()
	{
		$companies = Group::getGroups($this->context->cookie->id_lang);
		$this->context->smarty->assign('groups',$companies);
		$this->context->smarty->display('finance/finance-rate-contract.tpl');
	}
}