<?php
class RmWaterDeliveryControllerCore extends BackController
{
	public function displayContent()
	{
		$group=new Group();
		$groups=$group->getGroups(1);
		$fcs = FulfillmentCentre::getAllFCentres();
		$this->context->smarty->assign('groups', $groups);
		$this->context->smarty->assign('fcs', $fcs);
		$id_group = Tools::getValue('id_group');
		$id_fc = Tools::getValue('id_fc');
		$period = Tools::getValue('period');
		$period = explode("-", $period);
		$this->context->smarty->assign('waterDeliveries', WaterDelivery::getAllCustomerOrders($id_group, $id_fc, $period[0], $period[1]));
		self::$smarty->display('rm/rm-waterDelivery.tpl');
	}
}
?>