<?php
class FinanceOrderBlocksControllerCore extends BackController
{
	public function displayContent()
	{
		$group=new Group();
		$groups=$group->getGroups(1);
		$this->context->smarty->assign('groups', $groups);
		
		$type = Tools::getValue('type');
		if($type == 1){
			$id_group = Tools::getValue('id_group');
			$this->context->smarty->assign('orders', Finance::getAllCustomerOrders($id_group));
		}
		
		self::$smarty->display('finance/finance-release-orders.tpl');
	}

	public function ajaxReturn(){
		$type = Tools::getValue('type');
		$this->context->smarty->assign('type',$type);
		// if($type == 1){
		// 	$id_group = Tools::getValue('id_group');
		// 	$this->context->smarty->assign('orders', Finance::getAllCustomerOrders($id_group));
		// 	$this->displayContent();
		// }
		if($type == 2){
			$orders = Tools::getValue('ro_checkbox');
			$id_employee = self::$cookie->id_employee;
			echo json_encode(Finance::releaseOrders($orders, $id_employee));
		}
	}
}
?>