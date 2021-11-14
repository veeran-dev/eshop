<?php

class CustomerAddressCore extends ObjectModel
{
	/** @var integer Customer id which address belongs */
	public		$id_customer;

	/** @var integer address id which address belongs */
	public		$id_address;

/** @var integer address id which address belongs */
	public		$id_parent;


	protected 	$table = 'customer_address';
	protected 	$identifier = 'id_customer_address';
	protected 	$fieldsRequired = array('id_customer', 'id_address');
	protected 	$fieldsValidate = array('id_customer' => 'isUnsignedId', 'id_address' => 'isUnsignedId', 'id_parent' => 'isUnsignedId');

	public	function getFields()
	{
	 	parent::validateFields();

		$fields['id_customer'] = (int)$this->id_customer;
		$fields['id_address'] = (int)$this->id_address;
		$fields['id_parent'] = (int)$this->id_parent;
		return $fields;
	}
	
	public function mapId($id_customer,$id_address)
	{
		return Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'customer_address`(`id_customer`,`id_parent`,`id_address`) 
											VALUES('.$id_customer.','.$id_customer.','.$id_address.')');
	}
}