<?php

class CustomerParentCore extends ObjectModel
{
	/** @var integer Customer id  */
	public		$id_customer;

	/** @var integer parent id  */
	public		$id_parent;


	protected 	$table = 'Customer_parent';
	protected 	$identifier = 'id_customer';
	protected 	$fieldsRequired = array('id_customer', 'id_parent');
	protected 	$fieldsValidate = array('id_customer' => 'isUnsignedId', 'id_parent' => 'isUnsignedId');

	public	function getFields()
	{
	 	parent::validateFields();

		$fields['id_customer'] = (int)$this->id_customer;
		$fields['id_parent'] = (int)$this->id_parent;
		return $fields;
	}
}