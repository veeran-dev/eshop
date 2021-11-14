<?php
class FinanceAgingSheetControllerCore extends BackController
{
	public function displayContent()
	{
		$agingData=Finance::agingData();
		//var_dump($agingData);
		$this->context->smarty->assign('agingData',$agingData);
		self::$smarty->display('finance/finance-aging-sheet.tpl');
	}
}