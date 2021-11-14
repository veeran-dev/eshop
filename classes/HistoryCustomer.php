<?php
/*
*
*  @author Karthik R
*  International Registered Trademark & Property of PrestaShop SA
*/

class HistoryCustomerCore extends ObjectModel
{
	public 		$id_order_history;

	public 		$id_customer;

	protected 	$table = 'order_history_customer';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_order_history'] = (int)($this->id_order_history);
		$fields['id_customer'] = (int)($this->id_customer);
		return $fields;
	}
}

