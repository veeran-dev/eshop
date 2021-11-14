<?php

class InventoryCore extends ObjectModel
{
	/** @var integer Customer id  */
	public		$id_fc;
	public		$id_product;
	public		$quantity;
	public		$added;
	public		$removed;
	public 		$date_add;



	public static $definition = array(
        'table' => 'Inventory',
        'primary' => 'id_inventory',
        'fields' => array(
            'id_fc' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_product' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'quantity' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'added' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'removed' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'date_add()' =>	array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
        ),
    );
}