<?php

class OrderDeliveryCore extends ObjectModel
{
	/** @var integer */
	public $id_order_delivery;
	
	/** @var integer */
	public $id_order;

	/** @var integer */
	public $id_delivery;


	protected	$fieldsRequired = array ('id_order', 'id_delivery');	
	protected	$fieldsValidate = array ('id_order' => 'isUnsignedId', 'id_delivery' => 'isUnsignedId');

	protected 	$table = 'order_delivery';
	protected 	$identifier = 'id_order_delivery';
	
	public function getFields()
	{
		parent::validateFields();

		$fields['id_order_delivery'] = (int)($this->id_order_delivery);
		$fields['id_order'] = (int)($this->id_order);
		$fields['id_delivery'] = (int)($this->id_delivery);

		
		return $fields;
	}	
	
	public static function getByDeliveryId($id_delivery){
		
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow(
		'SELECT id_order 
		FROM `'._DB_PREFIX_.'order_delivery` od
		WHERE od.id_delivery = '.(int)$id_delivery);
		
		return $result['id_order'];
	}
}

