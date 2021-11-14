<?php

class DeliveryDetails extends ObjectModel
{
	/** @var integer */
	public $id_delivery_details;
	
	/** @var integer */
	public $id_order;

	/** @var integer */
	public $id_delivery;

	/** @var integer */
	public $id_product;

	/** @var integer */
	public $id_product_attribute;

	/** @var integer */	
	public $quantity;

	/** @var string Object last modification date */
	public $date_generated;

	protected	$fieldsRequired = array ('id_order', 'id_delivery', 'id_product','id_product_attribute', 'quantity');	
	protected	$fieldsValidate = array ('id_order' => 'isUnsignedId', 'id_delivery' => 'isUnsignedId', 
	'quantity' => 'isUnsignedId');

	protected 	$table = 'delivery_details';
	protected 	$identifier = 'id_delivery_details';

	
	public function getFields()
	{
		parent::validateFields();

		$fields['id_order'] = (int)($this->id_order);
		$fields['id_delivery'] = (int)($this->id_delivery);
		$fields['id_product'] = (int)($this->id_product);
		$fields['id_product_attribute'] = (int)($this->id_product_attribute);
		$fields['quantity'] = (int)($this->quantity);		
		return $fields;
	}
	public function getDeliveryDetails($id_delivery)	
	{
		$result=Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'delivery_details` WHERE id_delivery='.$id_delivery.' ');
		return $result;
	}
}

